@extends('layouts.app')
@section('title','Checkout')
@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <h1 class="text-4xl font-playfair text-[#1d2e24] mb-10">Checkout</h1>
    <div class="flex flex-col lg:flex-row gap-10">
        {{-- Form --}}
        <div class="flex-1">
            <form action="{{ route('checkout.process') }}" method="POST" class="space-y-6">
                @csrf
                <div class="bg-white border border-gray-100 p-8">
                    <h2 class="font-playfair text-xl text-[#1d2e24] mb-6">Data Penerima</h2>
                    <div class="space-y-5">
                        <div>
                            <label class="block text-[10px] font-bold uppercase tracking-widest text-gray-600 mb-2">Nama Lengkap *</label>
                            <input type="text" name="customer_name" value="{{ old('customer_name') }}" required class="w-full border @error('customer_name') border-red-400 @else border-gray-300 @enderror px-4 py-3 text-sm focus:outline-none focus:border-[#1d2e24] transition">
                            @error('customer_name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold uppercase tracking-widest text-gray-600 mb-2">Nomor WhatsApp *</label>
                            <input type="text" name="customer_phone" value="{{ old('customer_phone') }}" required class="w-full border border-gray-300 px-4 py-3 text-sm focus:outline-none focus:border-[#1d2e24] transition">
                            @error('customer_phone')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold uppercase tracking-widest text-gray-600 mb-2">Email (Opsional)</label>
                            <input type="email" name="customer_email" value="{{ old('customer_email') }}" class="w-full border border-gray-300 px-4 py-3 text-sm focus:outline-none focus:border-[#1d2e24] transition">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold uppercase tracking-widest text-gray-600 mb-2">Kota *</label>
                            <input type="text" name="city" value="{{ old('city') }}" required class="w-full border border-gray-300 px-4 py-3 text-sm focus:outline-none focus:border-[#1d2e24] transition">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold uppercase tracking-widest text-gray-600 mb-2">Alamat Pengiriman Lengkap *</label>
                            <textarea name="shipping_address" rows="3" required class="w-full border border-gray-300 px-4 py-3 text-sm focus:outline-none focus:border-[#1d2e24] transition resize-none">{{ old('shipping_address') }}</textarea>
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold uppercase tracking-widest text-gray-600 mb-2">Catatan (Opsional)</label>
                            <textarea name="notes" rows="2" class="w-full border border-gray-300 px-4 py-3 text-sm focus:outline-none focus:border-[#1d2e24] transition resize-none" placeholder="Contoh: Tolong beri ucapan Happy Birthday">{{ old('notes') }}</textarea>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn-primary w-full text-center">
                    <i class="ph ph-credit-card mr-2"></i> Lanjut ke Pembayaran
                </button>
            </form>
        </div>

        {{-- Summary --}}
        <div class="w-full lg:w-80 shrink-0">
            <div class="bg-white border border-gray-100 p-6 sticky top-28">
                <h3 class="font-playfair text-xl text-[#1d2e24] mb-6">Ringkasan</h3>
                <div class="space-y-3 text-sm mb-6">
                    @foreach($cart as $item)
                    <div class="flex gap-3 items-start">
                        <img src="{{ str_starts_with($item['image'], 'http') ? $item['image'] : asset('storage/products/' . $item['image']) }}" class="w-12 h-14 object-cover bg-gray-100 shrink-0">
                        <div class="flex-1">
                            <p class="text-xs font-medium text-gray-800 leading-snug">{{ $item['name'] }}</p>
                            <p class="text-[10px] text-gray-400 mt-0.5">× {{ $item['qty'] }}</p>
                        </div>
                        <p class="text-xs font-semibold text-gray-800 shrink-0">Rp {{ number_format($item['price'] * $item['qty'], 0, ',', '.') }}</p>
                    </div>
                    @endforeach
                </div>
                <div class="border-t border-gray-100 pt-4 flex justify-between items-center">
                    <span class="text-[11px] font-bold uppercase tracking-widest text-gray-700">Total</span>
                    <span class="font-playfair text-xl font-semibold text-[#1d2e24]">Rp {{ number_format($total, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
