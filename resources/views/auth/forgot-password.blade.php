@extends('layouts.app')
@section('title', 'Lupa Password - ' . config('app.name'))

@section('content')
<div class="max-w-md mx-auto px-4 py-20">
    <div class="bg-white p-8 border border-gray-100 shadow-sm">
        <h2 class="text-3xl font-playfair text-[#1d2e24] mb-2 text-center">Lupa Password</h2>
        <p class="text-xs text-gray-500 text-center mb-8">Masukkan email Anda dan kami akan mengirimkan tautan untuk mereset kata sandi.</p>

        @if(session('status'))
            <div class="bg-green-50 text-green-700 p-3 mb-6 text-xs">{{ session('status') }}</div>
        @endif

        <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
            @csrf
            <div>
                <label class="block text-[10px] font-bold uppercase tracking-widest text-gray-600 mb-2">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus class="w-full border @error('email') border-red-400 @else border-gray-300 @enderror px-4 py-3 text-sm focus:outline-none focus:border-[#1d2e24] transition">
                @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <button type="submit" class="btn-primary w-full text-center py-3">Kirim Tautan Reset</button>
        </form>

        <p class="text-center text-xs text-gray-500 mt-8">
            <a href="{{ route('login') }}" class="font-bold text-[#1d2e24] hover:underline">Kembali ke halaman Login</a>
        </p>
    </div>
</div>
@endsection
