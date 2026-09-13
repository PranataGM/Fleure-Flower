@extends('admin.layouts.app')
@section('title','Detail Pesanan — ' . $order->order_code)
@section('content')
<div class="max-w-3xl">
    <div class="flex items-center gap-3 mb-8">
        <a href="{{ route('admin.orders.index') }}" class="text-gray-400 hover:text-[#1d2e24] transition"><i class="ph ph-arrow-left text-xl"></i></a>
        <div>
            <p class="text-[10px] uppercase tracking-widest text-gray-400 font-semibold mb-0.5">Daftar Pesanan</p>
            <h2 class="font-playfair text-2xl text-[#1d2e24]">{{ $order->order_code }}</h2>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div class="bg-white border border-gray-200 p-6">
            <h3 class="font-playfair text-lg text-[#1d2e24] mb-4">Info Pelanggan</h3>
            <div class="space-y-3 text-sm">
                <div><span class="text-[9px] uppercase tracking-widest text-gray-400 font-semibold block">Nama</span><p class="font-medium text-gray-800">{{ $order->customer_name }}</p></div>
                <div><span class="text-[9px] uppercase tracking-widest text-gray-400 font-semibold block">WhatsApp</span><a href="https://wa.me/{{ $order->customer_phone }}" class="text-[#1d2e24] hover:underline">{{ $order->customer_phone }}</a></div>
                @if($order->customer_email)<div><span class="text-[9px] uppercase tracking-widest text-gray-400 font-semibold block">Email</span><p class="text-gray-700">{{ $order->customer_email }}</p></div>@endif
                <div><span class="text-[9px] uppercase tracking-widest text-gray-400 font-semibold block">Kota</span><p class="text-gray-700">{{ $order->city }}</p></div>
                <div><span class="text-[9px] uppercase tracking-widest text-gray-400 font-semibold block">Alamat</span><p class="text-gray-700 leading-relaxed">{{ $order->shipping_address }}</p></div>
                @if($order->notes)<div><span class="text-[9px] uppercase tracking-widest text-gray-400 font-semibold block">Catatan</span><p class="text-gray-700">{{ $order->notes }}</p></div>@endif
            </div>
        </div>

        <div class="bg-white border border-gray-200 p-6">
            <h3 class="font-playfair text-lg text-[#1d2e24] mb-4">Status Pesanan</h3>
            <p class="mb-4">
                <span class="text-[9px] font-bold uppercase tracking-widest px-3 py-1 {{ in_array($order->status,['paid','completed']) ? 'bg-green-50 text-green-700 border border-green-200' : ($order->status==='cancelled' ? 'bg-red-50 text-red-600 border border-red-200' : 'bg-yellow-50 text-yellow-700 border border-yellow-200') }}">{{ $order->status_label }}</span>
            </p>
            <form action="{{ route('admin.orders.status',$order) }}" method="POST" class="space-y-3">
                @csrf @method('PATCH')
                <select name="status" class="w-full border border-gray-300 px-4 py-3 text-sm focus:outline-none focus:border-[#1d2e24] transition">
                    @foreach(['pending'=>'Menunggu Pembayaran','paid'=>'Sudah Dibayar','processing'=>'Diproses','shipped'=>'Dikirim','completed'=>'Selesai','cancelled'=>'Dibatalkan'] as $v=>$l)
                    <option value="{{ $v }}" @selected($order->status===$v)>{{ $l }}</option>
                    @endforeach
                </select>
                <button type="submit" class="w-full bg-[#1d2e24] text-white py-3 text-xs font-bold uppercase tracking-widest hover:bg-[#2a4334] transition">Perbarui Status</button>
            </form>
            @if($order->transaction_id)<p class="text-xs text-gray-400 mt-3 font-light">ID Transaksi: {{ $order->transaction_id }}</p>@endif
        </div>
    </div>

    <div class="bg-white border border-gray-200 p-6 overflow-x-auto">
        <h3 class="font-playfair text-lg text-[#1d2e24] mb-4">Item Pesanan</h3>
        <table class="w-full text-sm min-w-[500px]">
            <thead><tr class="border-b border-gray-100">
                <th class="pb-3 text-left text-[10px] font-bold uppercase tracking-widest text-gray-400">Produk</th>
                <th class="pb-3 text-right text-[10px] font-bold uppercase tracking-widest text-gray-400">Harga</th>
                <th class="pb-3 text-right text-[10px] font-bold uppercase tracking-widest text-gray-400">Qty</th>
                <th class="pb-3 text-right text-[10px] font-bold uppercase tracking-widest text-gray-400">Subtotal</th>
            </tr></thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($order->items as $item)
                <tr>
                    <td class="py-4 font-medium text-gray-800">{{ $item->product_name }}</td>
                    <td class="py-4 text-right text-gray-600">{{ $item->formatted_price }}</td>
                    <td class="py-4 text-right text-gray-600">{{ $item->quantity }}</td>
                    <td class="py-4 text-right font-semibold text-gray-800">{{ $item->formatted_subtotal }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot><tr class="border-t border-gray-200">
                <td colspan="3" class="pt-4 text-right text-[11px] font-bold uppercase tracking-widest text-gray-700">Total</td>
                <td class="pt-4 text-right font-playfair text-xl font-semibold text-[#1d2e24]">{{ $order->formatted_total }}</td>
            </tr></tfoot>
        </table>
    </div>
</div>
@endsection
