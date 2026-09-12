@extends('layouts.app')
@section('title','Pesanan Berhasil')
@section('content')
<div class="max-w-2xl mx-auto px-4 py-20 text-center">
    <div class="mb-10">
        <div class="w-20 h-20 bg-green-50 border-2 border-green-200 rounded-full flex items-center justify-center mx-auto mb-6">
            <i class="ph ph-check text-4xl text-green-600"></i>
        </div>
        <h1 class="text-4xl font-playfair text-[#1d2e24] mb-3">Terima Kasih!</h1>
        <p class="text-gray-500 font-light text-sm">Pesanan Anda telah diterima. Kami akan segera memproses pesanan Anda.</p>
    </div>

    <div class="bg-white border border-gray-100 p-8 text-left mb-8">
        <div class="grid grid-cols-2 gap-6 mb-6">
            <div>
                <p class="text-[10px] uppercase tracking-widest text-gray-400 font-semibold mb-1">Kode Pesanan</p>
                <p class="font-playfair text-lg text-[#1d2e24] font-semibold">{{ $order->order_code }}</p>
            </div>
            <div>
                <p class="text-[10px] uppercase tracking-widest text-gray-400 font-semibold mb-1">Status</p>
                <span class="text-xs font-bold uppercase tracking-widest px-3 py-1 {{ $order->status === 'paid' ? 'bg-green-50 text-green-700 border border-green-200' : 'bg-yellow-50 text-yellow-700 border border-yellow-200' }}">{{ $order->status_label }}</span>
            </div>
            <div>
                <p class="text-[10px] uppercase tracking-widest text-gray-400 font-semibold mb-1">Nama</p>
                <p class="text-sm font-medium text-gray-800">{{ $order->customer_name }}</p>
            </div>
            <div>
                <p class="text-[10px] uppercase tracking-widest text-gray-400 font-semibold mb-1">Total Pembayaran</p>
                <p class="font-playfair text-lg font-semibold text-[#1d2e24]">{{ $order->formatted_total }}</p>
            </div>
        </div>
        <div class="border-t border-gray-100 pt-6">
            <p class="text-[10px] uppercase tracking-widest text-gray-400 font-semibold mb-4">Detail Pesanan</p>
            @foreach($order->items as $item)
            <div class="flex justify-between text-sm py-2 border-b border-gray-50">
                <span class="text-gray-600 font-light">{{ $item->product_name }} × {{ $item->quantity }}</span>
                <span class="font-medium text-gray-800">{{ $item->formatted_subtotal }}</span>
            </div>
            @endforeach
        </div>
    </div>

    <p class="text-sm text-gray-500 font-light mb-6">Tim kami akan menghubungi Anda melalui WhatsApp untuk konfirmasi pengiriman.</p>
    <div class="flex flex-col sm:flex-row gap-4 justify-center">
        <a href="{{ route('home') }}" class="btn-outline">Kembali ke Beranda</a>
        <a href="{{ route('koleksi') }}" class="btn-primary">Belanja Lagi</a>
    </div>
</div>
@endsection
