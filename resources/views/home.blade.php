@extends('layouts.app')
@section('title','Beranda')
@section('content')

{{-- HERO --}}
<section class="relative h-[calc(100vh-96px)] min-h-[560px] overflow-hidden shadow-[0_20px_50px_rgba(0,0,0,0.15)] z-10">
    <img src="https://images.unsplash.com/photo-1520763185298-1b434c919102?q=80&w=2000" alt="Hero" class="absolute inset-0 w-full h-full object-cover">
    <div class="absolute inset-0 bg-gradient-to-r from-black/60 via-black/30 to-transparent"></div>
    <div class="relative h-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center">
        <div class="max-w-xl text-white">
            <p class="text-[10px] tracking-[0.3em] uppercase font-semibold text-green-200 mb-6">Toko Bunga Premium</p>
            <h1 class="text-5xl md:text-6xl lg:text-7xl font-playfair leading-[1.08] mb-8">
                Bunga Indah<br>
                <span class="italic font-light text-4xl md:text-5xl lg:text-6xl text-green-100">untuk Momen Spesial</span>
            </h1>
            <p class="text-sm font-light leading-relaxed mb-10 text-gray-200 max-w-md">Rangkaian buket bunga segar yang dipilih dan dirangkai dengan penuh perhatian. Hadir untuk menemani setiap momen berharga dalam hidup Anda.</p>
            <div class="flex flex-col sm:flex-row gap-4">
                <a href="{{ route('koleksi') }}" class="btn-primary text-center">Lihat Koleksi</a>
                @if($settings)
                <a href="https://wa.me/{{ ltrim($settings->whatsapp,'0') }}" target="_blank" class="btn-outline !border-white !text-white hover:!bg-white hover:!text-[#1d2e24] text-center flex items-center justify-center gap-2">
                    <i class="ph ph-whatsapp-logo text-base"></i> Pesan via WhatsApp
                </a>
                @endif
            </div>
        </div>
    </div>
    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex flex-col items-center gap-2 text-white/50">
        <span class="text-[9px] uppercase tracking-widest">Gulir ke bawah</span>
        <div class="w-px h-8 bg-white/40 animate-pulse"></div>
    </div>
</section>

{{-- DESAIN TERBARU --}}
@if($newProducts->count() > 0)
<section class="py-20 bg-white relative z-0">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-end justify-between mb-10">
            <div>
                <p class="text-[10px] tracking-[0.25em] text-gray-400 uppercase font-semibold mb-2">Baru Tiba</p>
                <h2 class="text-3xl md:text-4xl font-playfair text-[#1d2e24]">Desain Terbaru</h2>
            </div>
            <a href="{{ route('koleksi') }}" class="hidden md:inline-flex items-center gap-1 text-[10px] font-bold uppercase tracking-widest text-[#1d2e24] hover:opacity-60 transition group shrink-0">
                Lihat Semua <i class="ph ph-arrow-right group-hover:translate-x-1 transition-transform"></i>
            </a>
        </div>
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-5">
            @foreach($newProducts as $p)
            @php
                $waMsg  = urlencode("Halo, saya tertarik dengan:\n\nNama Produk: {$p->name}\nHarga: {$p->formatted_price}\n\nApakah masih tersedia?");
                $waLink = "https://wa.me/" . ($settings ? ltrim($settings->whatsapp,'0') : '') . "?text=" . $waMsg;
            @endphp
            <div class="group bg-white flex flex-col">
                <div class="overflow-hidden aspect-square img-wrap bg-gray-100 relative">
                    <img src="{{ $p->image_url }}" alt="{{ $p->name }}" class="w-full h-full object-cover img-zoom" loading="lazy">
                    <span class="absolute top-3 left-3 bg-[#1d2e24] text-white text-[9px] font-bold uppercase tracking-widest px-2.5 py-1">Baru</span>
                </div>
                <div class="p-4 flex flex-col flex-grow">
                    <span class="text-[9px] uppercase tracking-widest text-gray-400 font-semibold mb-1">{{ $p->category_label }}</span>
                    <h3 class="font-playfair text-base text-gray-900 mb-1 group-hover:text-[#1d2e24] transition">{{ $p->name }}</h3>
                    <p class="text-xs text-gray-500 font-light leading-relaxed mb-4 line-clamp-2 flex-grow">{{ $p->description }}</p>
                    <div class="flex items-center justify-between border-t border-gray-100 pt-3 mt-auto gap-2">
                        <span class="text-sm font-bold text-[#1d2e24] shrink-0">{{ $p->formatted_price }}</span>
                        <div class="flex gap-2">
                            <form action="{{ route('cart.add', $p) }}" method="POST">
                                @csrf
                                <button type="submit" class="flex items-center gap-1 text-[9px] font-bold uppercase tracking-widest text-gray-500 hover:text-[#1d2e24] transition border border-gray-200 hover:border-[#1d2e24] px-2 py-1">
                                    <i class="ph ph-shopping-bag text-xs"></i> Beli
                                </button>
                            </form>
                            <a href="{{ $waLink }}" target="_blank" class="flex items-center gap-1 text-[9px] font-bold uppercase tracking-widest text-[#1d2e24] hover:opacity-70 transition border border-[#1d2e24] px-2 py-1">
                                <i class="ph ph-whatsapp-logo text-xs"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="mt-8 text-center md:hidden">
            <a href="{{ route('koleksi') }}" class="inline-flex items-center gap-1 text-[10px] font-bold uppercase tracking-widest text-[#1d2e24]">Lihat Semua <i class="ph ph-arrow-right"></i></a>
        </div>
    </div>
</section>
@endif

{{-- TENTANG KAMI --}}
<section id="tentang" class="bg-[#FAFAFA] border-y border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="flex flex-col md:flex-row items-stretch">
            <div class="w-full md:w-1/2 img-wrap h-72 md:h-[520px]">
                <img src="https://images.unsplash.com/photo-1572454591674-2739f30d8c40?q=80&w=900" alt="Tentang Kami" class="w-full h-full object-cover img-zoom">
            </div>
            <div class="w-full md:w-1/2 px-8 md:px-16 py-14 bg-white flex flex-col justify-center border border-gray-100 md:border-l-0">
                <p class="text-[10px] tracking-[0.25em] uppercase text-gray-400 font-semibold mb-5">Tentang Kami</p>
                <h2 class="text-3xl md:text-4xl font-playfair text-[#1d2e24] mb-6 leading-snug">Lebih dari Sekadar<br>Toko Bunga</h2>
                <p class="text-gray-600 font-light leading-relaxed mb-5 text-sm">Kami percaya bunga adalah bahasa universal untuk cinta, terima kasih, dan harapan. Setiap tangkai dipilih dengan seksama dan dirangkai dengan sepenuh hati oleh florist kami.</p>
                <div class="grid grid-cols-3 gap-6 mb-10 border-t border-gray-100 pt-8">
                    @foreach([['500+','Pelanggan'],['100%','Segar'],['5★','Rating']] as [$n,$l])
                    <div class="text-center {{ !$loop->first ? 'border-l border-gray-100' : '' }}">
                        <p class="font-playfair text-3xl text-[#1d2e24] font-semibold">{{ $n }}</p>
                        <p class="text-[10px] uppercase tracking-widest text-gray-400 mt-1">{{ $l }}</p>
                    </div>
                    @endforeach
                </div>
                @if($settings)
                <a href="https://wa.me/{{ ltrim($settings->whatsapp,'0') }}" target="_blank" class="inline-flex items-center gap-2 text-[10px] font-bold uppercase tracking-widest text-[#1d2e24] hover:opacity-60 transition group self-start">
                    Hubungi Kami <i class="ph ph-arrow-right group-hover:translate-x-1 transition-transform"></i>
                </a>
                @endif
            </div>
        </div>
    </div>
</section>

{{-- USP BAR --}}
<section class="border-b border-gray-200 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 divide-y-2 md:divide-y-0 md:divide-x divide-gray-100">
            @foreach([['ph-light ph-flower','Bunga Segar','Dipilih langsung setiap hari dari petani terbaik.'],['ph-light ph-truck','Pengiriman Cepat','Pesan pagi, terima di hari yang sama.'],['ph-light ph-leaf','Dirangkai Sendiri','Dibuat secara manual oleh florist kami.'],['ph-light ph-envelope-open','Kartu Gratis','Kartu ucapan personal tanpa biaya tambahan.']] as [$ic,$title,$desc])
            <div class="flex flex-col items-center text-center px-4 pt-6 md:pt-0">
                <i class="{{ $ic }} text-3xl text-[#1d2e24] mb-4"></i>
                <h3 class="text-[10px] font-bold uppercase tracking-widest text-[#1d2e24] mb-2">{{ $title }}</h3>
                <p class="text-xs text-gray-500 leading-relaxed font-light">{{ $desc }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- KOLEKSI PILIHAN --}}
@if($featuredProducts->count() > 0)
<section class="py-24 bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14">
            <p class="text-[10px] tracking-[0.25em] text-gray-400 uppercase font-semibold mb-3">Pilihan Kami</p>
            <h2 class="text-4xl md:text-5xl font-playfair text-[#1d2e24]">Rangkaian untuk Setiap Momen</h2>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-12">
            @foreach($featuredProducts as $p)
            @php $waLink = "https://wa.me/" . ($settings ? ltrim($settings->whatsapp,'0') : '') . "?text=" . urlencode("Halo, saya tertarik dengan:\n\nNama Produk: {$p->name}\nHarga: {$p->formatted_price}\n\nApakah masih tersedia?"); @endphp
            <div class="group flex flex-col">
                <div class="img-wrap aspect-[4/5] bg-gray-100">
                    <img src="{{ $p->image_url }}" alt="{{ $p->name }}" class="w-full h-full object-cover img-zoom" loading="lazy">
                </div>
                <div class="mt-4 text-center">
                    <span class="text-[9px] uppercase tracking-widest text-gray-400 font-semibold">{{ $p->category_label }}</span>
                    <h3 class="font-playfair text-sm mt-1 group-hover:text-[#1d2e24] transition">{{ $p->name }}</h3>
                    <p class="text-xs text-gray-500 font-light mt-1">{{ $p->formatted_price }}</p>
                    <div class="flex gap-2 justify-center mt-3 opacity-0 group-hover:opacity-100 transition-opacity">
                        <form action="{{ route('cart.add', $p) }}" method="POST">
                            @csrf
                            <button class="btn-primary !px-4 !py-2 !text-[9px]"><i class="ph ph-shopping-bag"></i> Beli</button>
                        </form>
                        <a href="{{ $waLink }}" target="_blank" class="btn-outline !px-4 !py-2 !text-[9px]"><i class="ph ph-whatsapp-logo"></i></a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="text-center">
            <a href="{{ route('koleksi') }}" class="btn-primary">Lihat Semua Koleksi</a>
        </div>
    </div>
</section>
@endif

{{-- FLORIST KAMI --}}
<section class="bg-[#FAFAFA] border-b border-gray-100 py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row items-stretch">
            <div class="w-full md:w-1/2 px-8 md:px-16 py-14 bg-white flex flex-col justify-center border border-gray-100 md:border-r-0">
                <p class="text-[10px] tracking-[0.25em] uppercase text-gray-400 font-semibold mb-5">Florist Utama Kami</p>
                <h2 class="text-3xl md:text-4xl font-playfair text-[#1d2e24] mb-6 leading-snug">Sentuhan Personal<br>di Setiap Rangkaian</h2>
                <p class="text-gray-600 font-light leading-relaxed mb-8 text-sm">Dengan pengalaman lebih dari 10 tahun di dunia floristry, tim kami yang dipimpin oleh florist ahli memastikan setiap tangkai bunga dipilih secara teliti. Kami memadukan teknik klasik dan estetika modern untuk menciptakan buket yang tidak hanya indah, tetapi juga penuh makna untuk merayakan hari spesial Anda.</p>
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-gray-200 rounded-full overflow-hidden shrink-0">
                        <img src="https://images.unsplash.com/photo-1544005313-94ddf0286df2?q=80&w=200" alt="Sarah" class="w-full h-full object-cover">
                    </div>
                    <div>
                        <p class="font-playfair text-lg text-[#1d2e24] font-medium leading-none">Sarah Amalia</p>
                        <p class="text-[10px] uppercase tracking-widest text-gray-400 mt-1">Head Florist</p>
                    </div>
                </div>
            </div>
            <div class="w-full md:w-1/2 img-wrap h-72 md:h-[520px]">
                <img src="https://images.unsplash.com/photo-1581078426770-6d336e5de7bf?q=80&w=900" alt="Florist merangkai bunga" class="w-full h-full object-cover img-zoom">
            </div>
        </div>
    </div>
</section>

{{-- KENAPA PILIH KAMI --}}
<section class="py-24 bg-white">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <p class="text-[10px] tracking-[0.25em] text-gray-400 uppercase font-semibold mb-4">Keunggulan Kami</p>
        <h2 class="text-4xl font-playfair text-[#1d2e24] mb-16">Mengapa Memilih Kami?</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-10">
            @foreach([['ph-light ph-heart','Kualitas Terjamin','Bunga segar pilihan terbaik yang bertahan lebih lama.'],['ph-light ph-hands-clapping','Dibuat dengan Tangan','Dirangkai manual dengan sentuhan profesional.'],['ph-light ph-plant','Ramah Lingkungan','Mendukung petani lokal dan produk eco-friendly.'],['ph-light ph-smiley','Layanan Ramah','Tim kami siap membantu kebutuhan floral Anda.']] as [$ic,$t,$d])
            <div>
                <i class="{{ $ic }} text-2xl text-[#1d2e24] mb-4"></i>
                <h3 class="text-[10px] font-bold uppercase tracking-widest text-[#1d2e24] mb-3">{{ $t }}</h3>
                <p class="text-xs text-gray-500 font-light leading-relaxed">{{ $d }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- KONTAK & MAPS --}}
<section id="kontak" class="py-24 bg-white border-t border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <p class="text-[10px] tracking-[0.25em] text-gray-400 uppercase font-semibold mb-4">Temukan & Hubungi Kami</p>
            <h2 class="text-4xl font-playfair text-[#1d2e24]">Kontak & Lokasi</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-12 items-start">
            <div class="space-y-8">
                @if($settings)
                <div><p class="text-[10px] font-bold uppercase tracking-widest text-[#1d2e24] mb-3">Alamat</p><p class="text-gray-600 font-light text-sm leading-relaxed">{{ $settings->address }}</p></div>
                <div><p class="text-[10px] font-bold uppercase tracking-widest text-[#1d2e24] mb-3">Jam Buka</p><p class="text-gray-600 font-light text-sm leading-relaxed">Senin – Sabtu: 08.00 – 19.00 WIB<br>Minggu: 09.00 – 15.00 WIB</p></div>
                <div>
                    <p class="text-[10px] font-bold uppercase tracking-widest text-[#1d2e24] mb-3">Kontak</p>
                    <a href="https://wa.me/{{ ltrim($settings->whatsapp,'0') }}" class="flex items-center gap-2 text-sm text-gray-600 hover:text-[#1d2e24] mb-2"><i class="ph ph-whatsapp-logo text-base text-[#1d2e24]"></i> {{ $settings->whatsapp }}</a>
                    <a href="https://instagram.com/{{ ltrim($settings->instagram,'@') }}" class="flex items-center gap-2 text-sm text-gray-600 hover:text-[#1d2e24]"><i class="ph ph-instagram-logo text-base text-[#1d2e24]"></i> {{ $settings->instagram }}</a>
                </div>
                <a href="https://wa.me/{{ ltrim($settings->whatsapp,'0') }}" target="_blank" class="btn-primary block text-center">Pesan via WhatsApp</a>
                @endif
            </div>
            <div class="md:col-span-2 h-[300px] md:h-[420px] border border-gray-200 w-full overflow-hidden [&>iframe]:w-full [&>iframe]:h-full">
                @if($settings && $settings->maps_embed)
                    {!! $settings->maps_embed !!}
                @else
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1m2!1s0x2e7a5787bd5b6bc5%3A0x217d87bd75ebbb1!2sYogyakarta!5e0!3m2!1sen!2sid!4v1689304928372!5m2!1sen!2sid" style="border:0" allowfullscreen loading="lazy"></iframe>
                @endif
            </div>
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="bg-[#18231d] py-20 relative overflow-hidden">
    <div class="absolute inset-0 opacity-10" style="background-image:url('https://images.unsplash.com/photo-1518531933037-91b2f5f229cc?q=80&w=2000');background-size:cover;background-position:center;"></div>
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 flex flex-col md:flex-row items-center justify-between gap-10">
        <div class="text-white text-center md:text-left">
            <h2 class="text-3xl font-playfair mb-4">Hadirkan Keindahan<br>ke Kehidupan Sehari-hari</h2>
            <p class="text-gray-300 font-light text-sm">Hubungi kami untuk pesanan custom atau konsultasi kebutuhan floral Anda.</p>
        </div>
        @if($settings)
        <a href="https://wa.me/{{ ltrim($settings->whatsapp,'0') }}" target="_blank" class="inline-flex items-center gap-2 bg-[#a3ad9d] text-[#18231d] px-10 py-4 font-bold text-xs uppercase tracking-widest hover:bg-white transition shrink-0">
            <i class="ph ph-whatsapp-logo text-lg"></i> Hubungi via WhatsApp
        </a>
        @endif
    </div>
</section>
@endsection
