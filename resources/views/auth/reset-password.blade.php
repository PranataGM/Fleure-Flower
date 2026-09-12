@extends('layouts.app')
@section('title', 'Reset Password - ' . config('app.name'))

@section('content')
<div class="max-w-md mx-auto px-4 py-20">
    <div class="bg-white p-8 border border-gray-100 shadow-sm">
        <h2 class="text-3xl font-playfair text-[#1d2e24] mb-2 text-center">Kata Sandi Baru</h2>
        <p class="text-xs text-gray-500 text-center mb-8">Silakan buat kata sandi baru untuk akun Anda.</p>

        <form method="POST" action="{{ route('password.update') }}" class="space-y-5">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <div>
                <label class="block text-[10px] font-bold uppercase tracking-widest text-gray-600 mb-2">Email</label>
                <input type="email" name="email" value="{{ $email ?? old('email') }}" required readonly class="w-full border @error('email') border-red-400 @else border-gray-300 @enderror bg-gray-50 px-4 py-3 text-sm focus:outline-none focus:border-[#1d2e24] transition text-gray-500">
                @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-[10px] font-bold uppercase tracking-widest text-gray-600 mb-2">Password Baru</label>
                <input type="password" name="password" required autofocus class="w-full border @error('password') border-red-400 @else border-gray-300 @enderror px-4 py-3 text-sm focus:outline-none focus:border-[#1d2e24] transition">
                @error('password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-[10px] font-bold uppercase tracking-widest text-gray-600 mb-2">Konfirmasi Password Baru</label>
                <input type="password" name="password_confirmation" required class="w-full border border-gray-300 px-4 py-3 text-sm focus:outline-none focus:border-[#1d2e24] transition">
            </div>

            <button type="submit" class="btn-primary w-full text-center py-3">Simpan Kata Sandi</button>
        </form>
    </div>
</div>
@endsection
