@extends('layouts.app')
@section('title','Koleksi Kami')
@section('content')

<div class="bg-[#FAFAFA] pt-20 pb-16 text-center px-4 border-b border-gray-200">
    <p class="text-[10px] tracking-[0.25em] text-gray-400 uppercase font-semibold mb-4">Temukan Pilihan Anda</p>
    <h1 class="text-4xl md:text-5xl font-playfair text-[#1d2e24] mb-6">Semua Koleksi</h1>
    <p class="text-gray-600 font-light text-sm leading-relaxed max-w-lg mx-auto">Jelajahi seluruh koleksi buket, fresh flower, dan kartu ucapan kami yang dirangkai khusus untuk setiap momen spesial.</p>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    {{-- Filter --}}
    <div class="flex flex-wrap justify-center gap-8 mb-14 border-b border-gray-200 pb-6">
        @foreach([['all','Semua'],['buket','Buket Bunga'],['fresh_flower','Fresh Flower'],['amplop','Kartu & Amplop']] as [$v,$l])
        <button class="filter-btn text-[11px] font-semibold tracking-widest uppercase border-b-2 pb-2 transition-all {{ $v === 'all' ? 'text-[#1d2e24] border-[#1d2e24] active' : 'text-gray-400 border-transparent' }}" data-filter="{{ $v }}">{{ $l }}</button>
        @endforeach
    </div>

    @if($products->count() > 0)
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-x-6 gap-y-14" id="product-grid">
        @foreach($products as $p)
        @php
            $waLink = "https://wa.me/" . ($settings ? ltrim($settings->whatsapp,'0') : '') . "?text=" . urlencode("Halo, saya tertarik dengan:\n\nNama Produk: {$p->name}\nHarga: {$p->formatted_price}\n\nApakah masih tersedia?");
        @endphp
        <div class="product-item group flex flex-col" data-category="{{ $p->category }}">
            <div class="img-wrap aspect-[3/4] bg-gray-100 relative">
                <img src="{{ $p->image_url }}" alt="{{ $p->name }}" class="w-full h-full object-cover img-zoom" loading="lazy">
                <div class="absolute inset-0 bg-black/0 group-hover:bg-black/8 transition-all duration-500 flex items-end justify-center pb-4 opacity-0 group-hover:opacity-100">
                    <div class="flex gap-2">
                        <form action="{{ route('cart.add', $p) }}" method="POST">
                            @csrf
                            <button class="bg-white text-[#1d2e24] text-[9px] font-bold uppercase tracking-widest px-3 py-2 hover:bg-[#1d2e24] hover:text-white transition flex items-center gap-1"><i class="ph ph-shopping-bag"></i> Beli</button>
                        </form>
                        <a href="{{ $waLink }}" target="_blank" class="bg-[#1d2e24] text-white text-[9px] font-bold uppercase tracking-widest px-3 py-2 hover:bg-white hover:text-[#1d2e24] transition flex items-center gap-1"><i class="ph ph-whatsapp-logo"></i> Pesan</a>
                    </div>
                </div>
            </div>
            <div class="mt-5 px-1">
                <span class="text-[9px] uppercase tracking-widest text-gray-400 font-semibold block mb-1">{{ $p->category_label }}</span>
                <h3 class="font-playfair text-sm text-gray-900 group-hover:text-[#1d2e24] transition">{{ $p->name }}</h3>
                <p class="text-xs text-gray-500 font-light mt-1">{{ $p->formatted_price }}</p>
            </div>
        </div>
        @endforeach
    </div>
    <div id="empty-state" class="hidden text-center py-20">
        <i class="ph-light ph-magnifying-glass text-5xl text-gray-300 mb-4 block"></i>
        <p class="font-playfair text-2xl text-[#1d2e24] mb-2">Produk Tidak Ditemukan</p>
        <p class="text-sm font-light text-gray-500">Kategori ini belum memiliki produk yang tersedia.</p>
    </div>
    @else
    <div class="text-center py-32 border border-gray-100 bg-white">
        <p class="font-playfair text-2xl text-[#1d2e24] mb-2">Koleksi Kosong</p>
        <p class="text-sm font-light text-gray-500">Belum ada produk yang tersedia saat ini.</p>
    </div>
    @endif
</div>

@push('scripts')
<script>
(function(){
    const btns = document.querySelectorAll('.filter-btn');
    const items = document.querySelectorAll('.product-item');
    const empty = document.getElementById('empty-state');
    const urlParams = new URLSearchParams(location.search);
    const init = urlParams.get('filter') || 'all';

    function applyFilter(f) {
        let cnt = 0;
        items.forEach(el => {
            const show = f === 'all' || el.dataset.category === f;
            el.style.display = show ? 'flex' : 'none';
            el.style.flexDirection = 'column';
            if (show) cnt++;
        });
        if (empty) empty.classList.toggle('hidden', cnt > 0);
        btns.forEach(b => {
            const active = b.dataset.filter === f;
            b.classList.toggle('text-[#1d2e24]', active);
            b.classList.toggle('border-[#1d2e24]', active);
            b.classList.toggle('text-gray-400', !active);
            b.classList.toggle('border-transparent', !active);
        });
        const url = new URL(location);
        f === 'all' ? url.searchParams.delete('filter') : url.searchParams.set('filter', f);
        history.pushState({}, '', url);
    }

    applyFilter(init);
    btns.forEach(b => b.addEventListener('click', () => applyFilter(b.dataset.filter)));
})();
</script>
@endpush
@endsection
