<?php
namespace App\Http\Controllers;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CheckoutController extends Controller {
    public function index() {
        $cart = session('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart')->with('error', 'Keranjang Anda masih kosong.');
        }
        $settings = Setting::getSetting();
        $total    = array_sum(array_map(fn($i) => $i['price'] * $i['qty'], $cart));
        return view('checkout', compact('settings', 'cart', 'total'));
    }

    public function process(Request $request) {
        $validated = $request->validate([
            'customer_name'    => 'required|string|max:100',
            'customer_phone'   => 'required|string|max:20',
            'customer_email'   => 'nullable|email|max:100',
            'shipping_address' => 'required|string',
            'city'             => 'required|string|max:100',
            'notes'            => 'nullable|string|max:500',
        ]);

        $validated['customer_name'] = strip_tags($validated['customer_name']);
        $validated['shipping_address'] = strip_tags($validated['shipping_address']);
        $validated['notes'] = strip_tags($validated['notes'] ?? '');

        $cart = session('cart', []);
        if (empty($cart)) return redirect()->route('cart');

        $total = array_sum(array_map(fn($i) => $i['price'] * $i['qty'], $cart));

        // Generate unique order code
        do {
            $orderCode = 'FF-' . strtoupper(Str::random(8));
        } while (Order::where('order_code', $orderCode)->exists());

        $order = Order::create([
            'order_code'       => $orderCode,
            'customer_name'    => $validated['customer_name'],
            'customer_phone'   => $validated['customer_phone'],
            'customer_email'   => $validated['customer_email'] ?? null,
            'shipping_address' => $validated['shipping_address'],
            'city'             => $validated['city'],
            'total_amount'     => $total,
            'notes'            => $validated['notes'],
        ]);

        foreach ($cart as $item) {
            OrderItem::create([
                'order_id'     => $order->id,
                'product_id'   => $item['id'],
                'product_name' => $item['name'],
                'price'        => $item['price'],
                'quantity'     => $item['qty'],
                'subtotal'     => $item['price'] * $item['qty'],
            ]);
        }

        // Midtrans Snap Token
        \Midtrans\Config::$serverKey    = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = config('midtrans.is_production');
        \Midtrans\Config::$isSanitized  = true;
        \Midtrans\Config::$is3ds        = true;

        $itemDetails = array_values(array_map(fn($item) => [
            'id'       => (string) $item['id'],
            'price'    => (int) $item['price'],
            'quantity' => $item['qty'],
            'name'     => substr(strip_tags($item['name']), 0, 50),
        ], $cart));

        $params = [
            'transaction_details' => [
                'order_id'     => $order->order_code,
                'gross_amount' => (int) $total,
            ],
            'customer_details' => [
                'first_name' => $validated['customer_name'],
                'phone'      => $validated['customer_phone'],
                'email'      => $validated['customer_email'] ?? 'noemail@example.com',
            ],
            'item_details' => $itemDetails,
        ];

        try {
            $snapToken = \Midtrans\Snap::getSnapToken($params);
            $order->update(['snap_token' => $snapToken]);
            session()->forget('cart');
        } catch (\Exception $e) {
            // Jika midtrans error/lag, pesanan dibatalkan agar user bisa checkout ulang
            $order->update(['status' => 'cancelled']);
            return redirect()->route('cart')->with('error', 'Terjadi gangguan pada server pembayaran, silakan coba beberapa saat lagi.');
        }

        return view('payment', [
            'settings'  => Setting::getSetting(),
            'order'     => $order,
            'snapToken' => $snapToken,
        ]);
    }

    public function callback(Request $request) {
        \Midtrans\Config::$serverKey    = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = config('midtrans.is_production');

        try {
            $notif = new \Midtrans\Notification();
        } catch (\Exception $e) {
            return response()->json(['message' => 'Invalid notification payload'], 400);
        }

        $orderCode         = $notif->order_id;
        $transactionStatus = $notif->transaction_status;
        $statusCode        = $notif->status_code;
        $grossAmount       = $notif->gross_amount;
        $signatureKey      = $notif->signature_key;
        $paymentType       = $notif->payment_type;

        $mySignature = hash('sha512', $orderCode . $statusCode . $grossAmount . config('midtrans.server_key'));

        if ($mySignature !== $signatureKey) {
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        \Illuminate\Support\Facades\DB::transaction(function () use ($orderCode, $transactionStatus, $paymentType, $notif) {
            // lockForUpdate mencegah race conditions jika Midtrans mengirim webhook dobel di milidetik yang sama
            $order = Order::where('order_code', $orderCode)->lockForUpdate()->first();
            
            if (!$order) return;
            // Abaikan jika sudah dibayar sebelumnya
            if (in_array($order->status, ['paid', 'processing', 'shipped', 'completed'])) return;

            if (in_array($transactionStatus, ['capture', 'settlement'])) {
                $order->update([
                    'status'         => 'paid',
                    'payment_type'   => $paymentType,
                    'transaction_id' => $notif->transaction_id ?? null,
                ]);
            } elseif (in_array($transactionStatus, ['cancel', 'deny', 'expire'])) {
                $order->update(['status' => 'cancelled']);
            }
        });

        return response()->json(['message' => 'OK']);
    }

    public function success($code) {
        $order    = Order::where('order_code', $code)->with('items')->firstOrFail();
        $settings = Setting::getSetting();
        return view('order-success', compact('settings', 'order'));
    }
}
