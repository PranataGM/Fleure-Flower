@extends('layouts.app')
@section('title','Pembayaran — ' . $order->order_code)
@section('content')
<div class="max-w-2xl mx-auto px-4 py-20 text-center">
    <div class="mb-8">
        <i class="ph-light ph-credit-card text-5xl text-[#1d2e24] block mb-4"></i>
        <h1 class="text-3xl font-playfair text-[#1d2e24] mb-2">Selesaikan Pembayaran</h1>
        <p class="text-sm text-gray-500 font-light">Kode Pesanan: <strong class="text-[#1d2e24]">{{ $order->order_code }}</strong></p>
    </div>

    <div class="bg-white border border-gray-100 p-6 mb-8 text-left">
        <h3 class="font-playfair text-lg text-[#1d2e24] mb-4">Ringkasan Pesanan</h3>
        @foreach($order->items as $item)
        <div class="flex justify-between text-sm py-2 border-b border-gray-50">
            <span class="text-gray-600 font-light">{{ $item->product_name }} × {{ $item->quantity }}</span>
            <span class="font-medium text-gray-800">{{ $item->formatted_subtotal }}</span>
        </div>
        @endforeach
        <div class="flex justify-between mt-4 pt-2">
            <span class="font-bold uppercase tracking-widest text-xs text-gray-700">Total</span>
            <span class="font-playfair text-xl text-[#1d2e24] font-semibold">{{ $order->formatted_total }}</span>
        </div>
    </div>

    <button id="pay-btn" onclick="snap.pay('{{ $snapToken }}', {
        onSuccess: function(result){ window.location.href = '{{ route('order.success', $order->order_code) }}'; },
        onPending: function(result){ window.location.href = '{{ route('order.success', $order->order_code) }}'; },
        onError: function(result){ alert('Pembayaran gagal. Silakan coba lagi.'); },
        onClose: function(){ console.log('Ditutup tanpa pembayaran.'); }
    })" class="btn-primary w-full text-center text-base py-5">
        <i class="ph ph-lock-key mr-2"></i> Bayar Sekarang — {{ $order->formatted_total }}
    </button>
    <p class="text-xs text-gray-400 mt-4 font-light">Pembayaran diproses dengan aman oleh Midtrans. Mendukung transfer bank, e-wallet, kartu kredit, dan QRIS.</p>
</div>

@push('scripts')
<script src="{{ config('midtrans.snap_url') }}" data-client-key="{{ config('midtrans.client_key') }}"></script>
@endpush
@endsection
