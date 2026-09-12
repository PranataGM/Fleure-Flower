<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title','Admin') — {{ config('app.name') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600&family=Playfair+Display:wght@400;600&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <style>
        body { font-family:'Montserrat',sans-serif; }
        .font-playfair { font-family:'Playfair Display',serif; }
        .nav-link { display:flex; align-items:center; gap:10px; padding:10px 16px; font-size:11px; letter-spacing:.1em; text-transform:uppercase; font-weight:600; color:#a0b0a5; border-left:3px solid transparent; transition:all .2s; }
        .nav-link:hover, .nav-link.active { color:#fff; background:rgba(255,255,255,.06); border-left-color:#a3ad9d; }
        .nav-link i { font-size:18px; }
    </style>
    @stack('styles')
</head>
<body class="bg-[#F4F1EA] flex h-screen overflow-hidden">

{{-- Sidebar --}}
<div class="w-64 bg-[#1d2e24] text-white flex flex-col h-full flex-shrink-0">
    <div class="p-8 border-b border-white/10">
        <div class="flex items-center gap-3">
            <i class="ph-light ph-flower-lotus text-3xl text-[#a3ad9d]"></i>
            <div>
                <p class="font-playfair text-lg leading-none">{{ config('app.name') }}</p>
                <p class="text-[8px] tracking-widest text-gray-400 uppercase mt-1">Panel Pengelola</p>
            </div>
        </div>
    </div>
    <nav class="flex-1 py-6 px-2 space-y-1">
        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><i class="ph ph-squares-four"></i> Dashboard</a>
        <a href="{{ route('admin.products.index') }}" class="nav-link {{ request()->routeIs('admin.products*') ? 'active' : '' }}"><i class="ph ph-flower"></i> Kelola Produk</a>
        <a href="{{ route('admin.orders.index') }}" class="nav-link {{ request()->routeIs('admin.orders*') ? 'active' : '' }}"><i class="ph ph-shopping-bag"></i> Pesanan</a>
        <a href="{{ route('admin.settings') }}" class="nav-link {{ request()->routeIs('admin.settings') ? 'active' : '' }}"><i class="ph ph-gear"></i> Pengaturan</a>
    </nav>
    <div class="p-4 border-t border-white/10">
        <div class="mb-3 px-4 py-2">
            <p class="text-[9px] uppercase tracking-widest text-gray-500">Login sebagai</p>
            <p class="text-sm text-white font-semibold">{{ session('admin_username','Admin') }}</p>
        </div>
        <form action="{{ route('admin.logout') }}" method="POST">
            @csrf
            <button type="submit" class="nav-link w-full text-left hover:!text-red-400 !border-0">
                <i class="ph ph-sign-out"></i> Keluar
            </button>
        </form>
    </div>
</div>

{{-- Main --}}
<div class="flex-1 flex flex-col overflow-hidden">
    <header class="bg-white border-b border-gray-200 px-8 py-4 flex justify-between items-center flex-shrink-0">
        <h2 class="font-playfair text-xl text-[#1d2e24]">@yield('title','Dashboard')</h2>
        <a href="{{ route('home') }}" target="_blank" class="flex items-center gap-2 text-xs text-gray-500 hover:text-[#1d2e24] uppercase tracking-widest font-semibold transition">
            <i class="ph ph-arrow-square-out text-base"></i> Lihat Website
        </a>
    </header>

    @if(session('success'))<div class="mx-8 mt-6 flex items-center gap-3 bg-green-50 border border-green-200 text-green-700 px-5 py-3 text-sm"><i class="ph ph-check-circle text-xl"></i>{{ session('success') }}</div>@endif
    @if(session('error'))<div class="mx-8 mt-6 flex items-center gap-3 bg-red-50 border border-red-200 text-red-600 px-5 py-3 text-sm"><i class="ph ph-warning-circle text-xl"></i>{{ session('error') }}</div>@endif

    <main class="flex-1 overflow-y-auto p-8">
        @yield('content')
    </main>
</div>
@stack('scripts')
</body>
</html>
