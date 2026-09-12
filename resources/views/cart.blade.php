@extends('layouts.app')
@section('title','Keranjang Belanja')
@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <h1 class="text-4xl font-playfair text-[#1d2e24] mb-2">Keranjang Belanja</h1>
    <p class="text-sm text-gray-500 font-light mb-10">{{ count($cart) }} produk dalam keranjang Anda</p>

    @if(empty($cart))
    <div class="text-center py-24 border border-gray-100 bg-white">
        <i class="ph-light ph-shopping-bag text-6xl text-gray-200 block mb-4"></i>
        <h2 class="font-playfair text-2xl text-[#1d2e24] mb-3">Keranjang Kosong</h2>
        <p class="text-sm text-gray-500 font-light mb-8">Belum ada produk yang ditambahkan ke keranjang.</p>
        <a href="{{ route('koleksi') }}" class="btn-primary">Mulai Belanja</a>
    </div>
    @else
    <div class="flex flex-col lg:flex-row gap-10">
        {{-- Items --}}
        <div class="flex-1 space-y-4">
            @foreach($cart as $id => $item)
            <div class="bg-white border border-gray-100 p-5 flex gap-5 items-start">
                <img src="{{ str_starts_with($item['image'], 'http') ? $item['image'] : asset('storage/products/' . $item['image']) }}" class="w-24 h-28 object-cover shrink-0 bg-gray-100" alt="{{ $item['name'] }}">
                <div class="flex-1">
                    <span class="text-[9px] uppercase tracking-widest text-gray-400 font-semibold">{{ $item['category'] }}</span>
                    <h3 class="font-playfair text-lg text-[#1d2e24] mt-1">{{ $item['name'] }}</h3>
                    <p class="text-sm font-bold text-gray-800 mt-1">Rp {{ number_format($item['price'], 0, ',', '.') }}</p>
                    <div class="flex items-center gap-3 mt-4">
                        <form action="{{ route('cart.update', $id) }}" method="POST" class="flex items-center gap-2">
                            @csrf @method('PATCH')
                            <button type="submit" name="qty" :value="item.qty-1" onclick="this.value=Math.max(0,parseInt(this.form.qty_display.value||1)-1)" class="w-8 h-8 border border-gray-300 flex items-center justify-center text-gray-600 hover:border-[#1d2e24] transition text-lg font-light">−</button>
                            <input type="number" name="qty" id="qty-{{ $id }}" value="{{ $item['qty'] }}" min="0" class="w-12 text-center border border-gray-200 py-1 text-sm focus:outline-none focus:border-[#1d2e24]" onchange="this.form.submit()">
                            <button type="submit" name="qty" onclick="this.value=parseInt(this.form.qty.value||1)+1;this.form.submit()" class="w-8 h-8 border border-gray-300 flex items-center justify-center text-gray-600 hover:border-[#1d2e24] transition text-lg font-light">+</button>
                        </form>
                        <form action="{{ route('cart.remove', $id) }}" method="POST" class="ml-2">
                            @csrf @method('DELETE')
                            <button class="text-[10px] uppercase tracking-widest text-red-400 hover:text-red-600 transition font-semibold"><i class="ph ph-trash mr-1"></i>Hapus</button>
                        </form>
                    </div>
                </div>
                <p class="text-sm font-bold text-[#1d2e24] shrink-0">Rp {{ number_format($item['price'] * $item['qty'], 0, ',', '.') }}</p>
            </div>
            @endforeach
            <div class="flex justify-end mt-2">
                <form action="{{ route('cart.clear') }}" method="POST">
                    @csrf @method('DELETE')
                    <button class="text-[10px] uppercase tracking-widest text-gray-400 hover:text-red-500 transition font-semibold"><i class="ph ph-trash mr-1"></i> Kosongkan Keranjang</button>
                </form>
            </div>
        </div>

        {{-- Summary --}}
        <div class="w-full lg:w-80 shrink-0">
            <div class="bg-white border border-gray-100 p-6 sticky top-28">
                <h3 class="font-playfair text-xl text-[#1d2e24] mb-6">Ringkasan Pesanan</h3>
                <div class="space-y-3 text-sm mb-6">
                    @foreach($cart as $item)
                    <div class="flex justify-between text-gray-600">
                        <span class="font-light truncate pr-3">{{ $item['name'] }} × {{ $item['qty'] }}</span>
                        <span class="shrink-0 font-medium">Rp {{ number_format($item['price'] * $item['qty'], 0, ',', '.') }}</span>
                    </div>
                    @endforeach
                </div>
                <div class="border-t border-gray-100 pt-4 flex justify-between items-center mb-6">
                    <span class="text-[11px] font-bold uppercase tracking-widest text-gray-700">Total</span>
                    <span class="font-playfair text-xl font-semibold text-[#1d2e24]">Rp {{ number_format($total, 0, ',', '.') }}</span>
                </div>
                <a href="{{ route('checkout') }}" class="btn-primary block text-center w-full">Lanjut ke Checkout</a>
                <a href="{{ route('koleksi') }}" class="text-center block mt-4 text-[10px] uppercase tracking-widest text-gray-400 hover:text-[#1d2e24] transition font-semibold">
                    <i class="ph ph-arrow-left mr-1"></i> Lanjut Belanja
                </a>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
