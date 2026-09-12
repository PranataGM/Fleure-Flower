@extends('layouts.app')
@section('title', 'Daftar - ' . config('app.name'))

@section('content')
<div class="max-w-md mx-auto px-4 py-20">
    <div class="bg-white p-8 border border-gray-100 shadow-sm">
        <h2 class="text-3xl font-playfair text-[#1d2e24] mb-2 text-center">Daftar Akun</h2>
        <p class="text-xs text-gray-500 text-center mb-8">Buat akun untuk mempermudah pesanan Anda</p>

        <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf
            <div>
                <label class="block text-[10px] font-bold uppercase tracking-widest text-gray-600 mb-2">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name') }}" required autofocus class="w-full border @error('name') border-red-400 @else border-gray-300 @enderror px-4 py-3 text-sm focus:outline-none focus:border-[#1d2e24] transition">
                @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-[10px] font-bold uppercase tracking-widest text-gray-600 mb-2">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required class="w-full border @error('email') border-red-400 @else border-gray-300 @enderror px-4 py-3 text-sm focus:outline-none focus:border-[#1d2e24] transition">
                @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-[10px] font-bold uppercase tracking-widest text-gray-600 mb-2">Password</label>
                <input type="password" name="password" required class="w-full border @error('password') border-red-400 @else border-gray-300 @enderror px-4 py-3 text-sm focus:outline-none focus:border-[#1d2e24] transition">
                @error('password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-[10px] font-bold uppercase tracking-widest text-gray-600 mb-2">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" required class="w-full border border-gray-300 px-4 py-3 text-sm focus:outline-none focus:border-[#1d2e24] transition">
            </div>

            <button type="submit" class="btn-primary w-full text-center py-3">Daftar Sekarang</button>
        </form>

        <div class="mt-6 flex items-center justify-between">
            <span class="border-b w-1/5 lg:w-1/4"></span>
            <span class="text-xs text-center text-gray-400 uppercase tracking-widest font-bold">Atau Daftar Dengan</span>
            <span class="border-b w-1/5 lg:w-1/4"></span>
        </div>

        <a href="{{ route('auth.google') }}" class="mt-6 w-full bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 font-semibold py-3 px-4 flex items-center justify-center gap-2 transition text-sm">
            <img src="https://www.svgrepo.com/show/475656/google-color.svg" alt="Google" class="w-5 h-5">
            Google
        </a>

        <p class="text-center text-xs text-gray-500 mt-8">
            Sudah punya akun? <a href="{{ route('login') }}" class="font-bold text-[#1d2e24] hover:underline">Masuk</a>
        </p>
    </div>
</div>
@endsection
