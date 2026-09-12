<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', config('app.name'))</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600&family=Playfair+Display:ital,wght@0,400;0,500;0,600;1,400;1,500&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <script>
        tailwind.config = {
            theme: { extend: {
                colors: { 'dg': '#1d2e24', 'mg': '#2a4334', 'cr': '#FAFAFA' },
                fontFamily: { playfair: ['"Playfair Display"', 'serif'], sans: ['"Montserrat"', 'sans-serif'] }
            }}
        }
    </script>
    <style>
        html { scroll-behavior:smooth; }
        body { font-family:'Montserrat',sans-serif; background:#FFFFFF; color:#333; overflow-x:hidden; }
        h1,h2,h3,h4 { font-family:'Playfair Display',serif; }
        .btn-primary { display:inline-block; background:#1d2e24; color:#fff; padding:14px 32px; font-size:.72rem; letter-spacing:.12em; text-transform:uppercase; font-weight:600; transition:background .3s; }
        .btn-primary:hover { background:#2a4334; }
        .btn-outline { display:inline-block; border:1.5px solid #1d2e24; color:#1d2e24; padding:13px 31px; font-size:.72rem; letter-spacing:.12em; text-transform:uppercase; font-weight:600; transition:all .3s; }
        .btn-outline:hover { background:#1d2e24; color:#fff; }
        .img-wrap { overflow:hidden; }
        .img-zoom { transition:transform .8s ease; }
        .img-wrap:hover .img-zoom { transform:scale(1.05); }
        ::-webkit-scrollbar { width:5px; } ::-webkit-scrollbar-thumb { background:#1d2e24; }
    </style>
    @stack('styles')
</head>
<body class="flex flex-col min-h-screen">

{{-- NAVBAR --}}
@php $s = \App\Models\Setting::getSetting(); $cartCount = count(session('cart',[])); @endphp
<nav class="bg-white sticky top-0 z-50 border-b border-gray-200 transition-shadow duration-300" id="navbar">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-24">
            <a href="{{ route('home') }}" class="flex flex-col leading-none">
                <span class="font-playfair text-2xl uppercase tracking-wide text-[#1d2e24]">{{ config('app.name') }}</span>
                <span class="text-[8px] tracking-[0.22em] uppercase text-gray-400 mt-1 font-sans">Toko Bunga Premium</span>
            </a>
            <div class="hidden md:flex items-center gap-10">
                @foreach([['home','Beranda'],['koleksi','Koleksi']] as [$r,$l])
                <a href="{{ route($r) }}" class="text-[11px] tracking-[0.14em] uppercase font-semibold {{ request()->routeIs($r) ? 'text-[#1d2e24] border-b-2 border-[#1d2e24]' : 'text-gray-600 border-b-2 border-transparent' }} hover:text-[#1d2e24] hover:border-[#1d2e24] py-2 transition-all">{{ $l }}</a>
                @endforeach
                <a href="{{ route('home') }}#tentang" class="text-[11px] tracking-[0.14em] uppercase font-semibold text-gray-600 border-b-2 border-transparent hover:text-[#1d2e24] hover:border-[#1d2e24] py-2 transition-all">Tentang Kami</a>
                <a href="{{ route('home') }}#kontak" class="text-[11px] tracking-[0.14em] uppercase font-semibold text-gray-600 border-b-2 border-transparent hover:text-[#1d2e24] hover:border-[#1d2e24] py-2 transition-all">Kontak</a>
            </div>
            <div class="hidden md:flex items-center gap-5">
                @auth
                    <a href="{{ route('profile') }}" class="text-gray-600 hover:text-[#1d2e24] transition flex items-center" title="Profil">
                        @if(Str::startsWith(auth()->user()->avatar, 'http'))
                            <img src="{{ auth()->user()->avatar }}" alt="Avatar" class="w-6 h-6 rounded-full object-cover border border-gray-200" referrerpolicy="no-referrer" onerror="this.outerHTML='<i class=\'ph ph-user text-xl\'></i>'">
                        @elseif(auth()->user()->avatar)
                            <i class="ph {{ auth()->user()->avatar }} text-xl"></i>
                        @else
                            <i class="ph ph-user text-xl"></i>
                        @endif
                    </a>
                @else
                    <a href="{{ route('login') }}" class="text-gray-600 hover:text-[#1d2e24] transition" title="Login"><i class="ph ph-user text-xl"></i></a>
                @endauth
                
                <a href="{{ route('cart') }}" class="relative text-gray-600 hover:text-[#1d2e24] transition" id="cart-icon-container">
                    <i class="ph ph-shopping-bag text-xl" id="cart-icon" style="transition: transform 0.3s ease;"></i>
                    <span id="cart-badge" class="absolute -top-2 -right-2 bg-[#1d2e24] text-white text-[9px] font-bold w-4 h-4 rounded-full flex items-center justify-center {{ $cartCount > 0 ? '' : 'hidden' }}">{{ $cartCount }}</span>
                </a>
                @if($s)
                <a href="https://instagram.com/{{ ltrim($s->instagram,'@') }}" target="_blank" class="text-gray-600 hover:text-[#1d2e24] transition"><i class="ph ph-instagram-logo text-xl"></i></a>
                @endif
            </div>
            <button id="mob-btn" class="md:hidden text-gray-700 p-2"><i class="ph ph-list text-2xl" id="ic-o"></i><i class="ph ph-x text-2xl hidden" id="ic-c"></i></button>
        </div>
    </div>
    <div id="mob-menu" class="hidden md:hidden bg-white border-t border-gray-100 absolute w-full shadow-lg">
        <div class="px-4 py-5 space-y-1">
            <a href="{{ route('home') }}" class="flex items-center gap-3 px-4 py-3 text-[11px] tracking-widest uppercase font-semibold text-gray-700 hover:text-[#1d2e24] hover:bg-gray-50 rounded"><i class="ph ph-house"></i> Beranda</a>
            <a href="{{ route('koleksi') }}" class="flex items-center gap-3 px-4 py-3 text-[11px] tracking-widest uppercase font-semibold text-gray-700 hover:text-[#1d2e24] hover:bg-gray-50 rounded"><i class="ph ph-flower"></i> Koleksi</a>
            <a href="{{ route('home') }}#tentang" class="flex items-center gap-3 px-4 py-3 text-[11px] tracking-widest uppercase font-semibold text-gray-700 hover:text-[#1d2e24] hover:bg-gray-50 rounded"><i class="ph ph-info"></i> Tentang Kami</a>
            <a href="{{ route('home') }}#kontak" class="flex items-center gap-3 px-4 py-3 text-[11px] tracking-widest uppercase font-semibold text-gray-700 hover:text-[#1d2e24] hover:bg-gray-50 rounded"><i class="ph ph-map-pin"></i> Kontak</a>
            <a href="{{ route('cart') }}" class="flex items-center gap-3 px-4 py-3 text-[11px] tracking-widest uppercase font-semibold text-gray-700 hover:text-[#1d2e24] hover:bg-gray-50 rounded"><i class="ph ph-shopping-bag"></i> Keranjang @if($cartCount > 0)({{ $cartCount }})@endif</a>
            @if($s)<div class="pt-3"><a href="https://wa.me/{{ ltrim($s->whatsapp,'0') }}" class="flex items-center justify-center gap-2 bg-[#1d2e24] text-white py-3 text-[11px] font-bold uppercase tracking-widest"><i class="ph ph-whatsapp-logo"></i> Hubungi Kami</a></div>@endif
        </div>
    </div>
</nav>

<div id="toast-container" class="fixed top-28 right-4 z-[100] flex flex-col gap-2 pointer-events-none">
    @if(session('success'))
    <div class="toast-message bg-green-600 text-white px-4 py-3 text-sm rounded shadow-lg flex items-center gap-2 transform transition-all duration-300 translate-x-full opacity-0 pointer-events-auto">
        <i class="ph ph-check-circle text-lg"></i> {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="toast-message bg-red-600 text-white px-4 py-3 text-sm rounded shadow-lg flex items-center gap-2 transform transition-all duration-300 translate-x-full opacity-0 pointer-events-auto">
        <i class="ph ph-warning-circle text-lg"></i> {{ session('error') }}
    </div>
    @endif
</div>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const toasts = document.querySelectorAll('.toast-message');
        toasts.forEach(toast => {
            // Animate in
            setTimeout(() => {
                toast.classList.remove('translate-x-full', 'opacity-0');
            }, 100);
            
            // Disappear after 1 second (1000ms)
            setTimeout(() => {
                toast.classList.add('translate-x-full', 'opacity-0');
                setTimeout(() => toast.remove(), 300);
            }, 1500); // Wait 1.5 seconds total so user can read it
        });
    });
</script>

<main class="flex-1">@yield('content')</main>

{{-- FOOTER --}}
@if($s)
<footer class="bg-[#1d2e24] text-white pt-16 pb-8 border-t-8 border-[#2a4334]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-12">
            <div>
                <p class="font-playfair text-xl uppercase tracking-wider mb-1">{{ config('app.name') }}</p>
                <p class="text-[8px] tracking-[0.2em] text-gray-400 mb-5">Toko Bunga Premium</p>
                <p class="text-gray-400 text-xs font-light leading-relaxed mb-5">Melayani pesanan bunga untuk seluruh momen spesial Anda dengan dedikasi penuh setiap harinya.</p>
                <div class="flex gap-4">
                    <a href="https://instagram.com/{{ ltrim($s->instagram,'@') }}" class="text-gray-400 hover:text-white transition"><i class="ph ph-instagram-logo text-xl"></i></a>
                    <a href="https://wa.me/{{ ltrim($s->whatsapp,'0') }}" class="text-gray-400 hover:text-white transition"><i class="ph ph-whatsapp-logo text-xl"></i></a>
                </div>
            </div>
            <div>
                <h4 class="text-xs font-bold tracking-[0.15em] uppercase mb-6">Katalog</h4>
                <ul class="space-y-3 text-gray-400 text-xs">
                    <li><a href="{{ route('koleksi') }}?filter=buket" class="hover:text-white transition">Buket Bunga</a></li>
                    <li><a href="{{ route('koleksi') }}?filter=fresh_flower" class="hover:text-white transition">Fresh Flower</a></li>
                    <li><a href="{{ route('koleksi') }}?filter=amplop" class="hover:text-white transition">Kartu & Amplop</a></li>
                    <li><a href="{{ route('koleksi') }}" class="hover:text-white transition">Semua Koleksi</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-xs font-bold tracking-[0.15em] uppercase mb-6">Pembelian</h4>
                <ul class="space-y-3 text-gray-400 text-xs">
                    <li><a href="{{ route('cart') }}" class="hover:text-white transition">Keranjang Belanja</a></li>
                    <li><a href="{{ route('checkout') }}" class="hover:text-white transition">Checkout</a></li>
                    <li><a href="{{ route('home') }}#kontak" class="hover:text-white transition">Kontak & Lokasi</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-xs font-bold tracking-[0.15em] uppercase mb-6">Kontak</h4>
                <ul class="space-y-4 text-gray-400 text-xs">
                    <li class="flex items-start gap-3"><i class="ph ph-whatsapp-logo text-lg mt-0.5 text-[#1d2e24] bg-white/10 p-0.5"></i><a href="https://wa.me/{{ ltrim($s->whatsapp,'0') }}" class="hover:text-white">{{ $s->whatsapp }}</a></li>
                    <li class="flex items-start gap-3"><i class="ph ph-map-pin text-lg mt-0.5"></i><span class="leading-relaxed">{{ $s->address }}</span></li>
                </ul>
            </div>
        </div>
        <div class="mt-14 pt-8 border-t border-[#2a4334] text-center text-xs text-gray-500">
            <p>&copy; 2026 {{ config('app.name') }}. Seluruh hak cipta dilindungi.</p>
        </div>
    </div>
</footer>
@endif

<script>
(function(){
    const btn=document.getElementById('mob-btn'),menu=document.getElementById('mob-menu'),iO=document.getElementById('ic-o'),iC=document.getElementById('ic-c');
    if(btn) {
        btn.addEventListener('click',()=>{ const h=menu.classList.contains('hidden'); menu.classList.toggle('hidden',!h); iO.classList.toggle('hidden',h); iC.classList.toggle('hidden',!h); });
    }
    window.addEventListener('scroll',()=>{ document.getElementById('navbar').classList.toggle('shadow-md',scrollY>10); },{passive:true});

    // AJAX Cart Add
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    const cartBadge = document.getElementById('cart-badge');
    const cartIcon = document.getElementById('cart-icon');

    document.querySelectorAll('form[action*="/cart/add"]').forEach(form => {
        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            const btn = form.querySelector('button');
            const originalHTML = btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = '<i class="ph ph-spinner animate-spin"></i>';

            try {
                const res = await fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    }
                });
                const data = await res.json();
                
                if (res.ok) {
                    // Update count
                    if (cartBadge) {
                        cartBadge.textContent = data.cartCount;
                        cartBadge.classList.remove('hidden');
                    }

                    // Fly animation
                    if (cartIcon && window.innerWidth >= 768) { // Only animate on desktop where icon is visible
                        const btnRect = btn.getBoundingClientRect();
                        const targetRect = cartIcon.getBoundingClientRect();
                        
                        const flyingIcon = document.createElement('div');
                        flyingIcon.innerHTML = '<i class="ph ph-shopping-bag text-white text-xs"></i>';
                        flyingIcon.className = 'fixed z-[100] bg-[#1d2e24] w-8 h-8 rounded-full flex items-center justify-center shadow-lg transition-all duration-700 ease-in-out pointer-events-none';
                        flyingIcon.style.left = btnRect.left + 'px';
                        flyingIcon.style.top = btnRect.top + 'px';
                        document.body.appendChild(flyingIcon);

                        // Trigger reflow
                        void flyingIcon.offsetWidth;

                        flyingIcon.style.left = targetRect.left + 'px';
                        flyingIcon.style.top = targetRect.top + 'px';
                        flyingIcon.style.transform = 'scale(0.2)';
                        flyingIcon.style.opacity = '0';

                        setTimeout(() => {
                            flyingIcon.remove();
                            cartIcon.style.transform = 'scale(1.3)';
                            cartIcon.style.color = '#1d2e24';
                            setTimeout(() => {
                                cartIcon.style.transform = 'scale(1)';
                            }, 300);
                        }, 700);
                    }
                } else {
                    alert(data.error || 'Terjadi kesalahan.');
                }
            } catch (err) {
                alert('Terjadi kesalahan koneksi.');
            } finally {
                btn.disabled = false;
                btn.innerHTML = originalHTML;
            }
        });
    });
})();
</script>
@stack('scripts')
</body>
</html>
