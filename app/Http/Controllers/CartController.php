<?php
namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Setting;
use Illuminate\Http\Request;

class CartController extends Controller {
    public function index() {
        $settings = Setting::getSetting();
        $cart     = session('cart', []);
        $total    = array_sum(array_map(fn($i) => $i['price'] * $i['qty'], $cart));
        return view('cart', compact('settings', 'cart', 'total'));
    }

    public function add(Request $request, Product $product) {
        if ($product->status !== 'available') {
            if ($request->expectsJson()) return response()->json(['error' => 'Produk ini sudah tidak tersedia.'], 400);
            return back()->with('error', 'Produk ini sudah tidak tersedia.');
        }
        $cart = session('cart', []);
        $id   = $product->id;
        if (isset($cart[$id])) {
            $cart[$id]['qty']++;
        } else {
            $cart[$id] = [
                'id'       => $product->id,
                'name'     => $product->name,
                'price'    => (float) $product->price,
                'image'    => $product->image,
                'category' => $product->category_label,
                'qty'      => 1,
            ];
        }
        session(['cart' => $cart]);
        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => '"' . $product->name . '" ditambahkan ke keranjang.', 'cartCount' => count($cart)]);
        }
        return back()->with('success', '"' . $product->name . '" ditambahkan ke keranjang.');
    }

    public function update(Request $request, $id) {
        $cart = session('cart', []);
        if (isset($cart[$id])) {
            $qty = max(0, (int) $request->qty);
            if ($qty === 0) {
                unset($cart[$id]);
            } else {
                $cart[$id]['qty'] = $qty;
            }
            session(['cart' => $cart]);
        }
        return back();
    }

    public function remove($id) {
        $cart = session('cart', []);
        unset($cart[$id]);
        session(['cart' => $cart]);
        return back()->with('success', 'Produk dihapus dari keranjang.');
    }

    public function clear() {
        session()->forget('cart');
        return back()->with('success', 'Keranjang berhasil dikosongkan.');
    }
}
