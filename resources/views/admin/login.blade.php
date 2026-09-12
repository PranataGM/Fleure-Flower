<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>Login Admin — {{ config('app.name') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600&family=Montserrat:wght@400;500;600&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <style> body { font-family:'Montserrat',sans-serif; } .font-playfair { font-family:'Playfair Display',serif; } </style>
</head>
<body class="bg-[#F4F1EA] flex items-center justify-center min-h-screen">
    <div class="bg-white p-10 w-full max-w-md border border-gray-200 shadow-sm">
        <div class="text-center mb-10">
            <i class="ph-light ph-flower-lotus text-5xl text-[#1d2e24] block mb-4"></i>
            <h1 class="font-playfair text-3xl text-[#1d2e24] mb-1">Panel Admin</h1>
            <p class="text-xs text-gray-400 uppercase tracking-widest">{{ config('app.name') }}</p>
        </div>
        @if($errors->any())
        <div class="flex items-center gap-3 bg-red-50 border border-red-200 text-red-600 px-4 py-3 text-sm mb-6">
            <i class="ph ph-warning-circle text-xl"></i> {{ $errors->first() }}
        </div>
        @endif
        <form action="{{ route('admin.login.post') }}" method="POST" class="space-y-5">
            @csrf
            <div>
                <label class="block text-[10px] font-bold uppercase tracking-widest text-gray-600 mb-2">Username</label>
                <input type="text" name="username" value="{{ old('username') }}" required autofocus class="w-full border border-gray-300 px-4 py-3 text-sm focus:outline-none focus:border-[#1d2e24] transition">
            </div>
            <div>
                <label class="block text-[10px] font-bold uppercase tracking-widest text-gray-600 mb-2">Password</label>
                <input type="password" name="password" required class="w-full border border-gray-300 px-4 py-3 text-sm focus:outline-none focus:border-[#1d2e24] transition">
            </div>
            <button type="submit" class="w-full bg-[#1d2e24] text-white py-3.5 text-xs font-bold uppercase tracking-widest hover:bg-[#2a4334] transition">Masuk</button>
        </form>
    </div>
</body>
</html>
