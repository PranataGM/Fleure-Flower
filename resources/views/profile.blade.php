@extends('layouts.app')
@section('title', 'Profil Saya - ' . config('app.name'))

@section('content')
<div class="max-w-4xl mx-auto px-4 py-16">
    <div class="bg-white border border-gray-100 shadow-sm p-8">
        
        <div class="flex items-center justify-between mb-8 border-b pb-4">
            <h2 class="text-3xl font-playfair text-[#1d2e24]">Profil Saya</h2>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="text-xs font-bold text-red-600 uppercase tracking-widest hover:text-red-800 transition flex items-center gap-2">
                    <i class="ph ph-sign-out text-lg"></i> Keluar
                </button>
            </form>
        </div>


        @if($errors->any())
            <div class="bg-red-50 text-red-700 p-4 mb-8 text-sm">
                <ul class="list-disc pl-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('profile.update') }}" method="POST" class="grid md:grid-cols-2 gap-12">
            @csrf
            
            <!-- Avatar Selection -->
            <div>
                <h3 class="text-[11px] font-bold uppercase tracking-widest text-gray-600 mb-4">Pilih Avatar</h3>
                
                <div class="flex items-center gap-6 mb-6">
                    <div class="w-20 h-20 rounded-full bg-gray-50 border border-gray-200 flex items-center justify-center overflow-hidden" id="current-avatar-preview">
                        @if(Str::startsWith($user->avatar, 'http'))
                            <img src="{{ $user->avatar }}" alt="Avatar" class="w-full h-full object-cover" referrerpolicy="no-referrer" onerror="this.outerHTML='<i class=\'ph ph-user text-4xl text-gray-400\'></i>'">
                        @elseif($user->avatar)
                            <i class="ph {{ $user->avatar }} text-4xl text-gray-600"></i>
                        @else
                            <i class="ph ph-user text-4xl text-gray-400"></i>
                        @endif
                    </div>
                    <div class="text-xs text-gray-500">
                        Pilih ikon di bawah untuk mengganti avatar Anda.
                    </div>
                </div>

                <div class="grid grid-cols-5 gap-3">
                    @foreach($avatars as $icon)
                        <label class="cursor-pointer">
                            <input type="radio" name="avatar" value="{{ $icon }}" class="peer hidden" {{ $user->avatar === $icon ? 'checked' : '' }}>
                            <div class="w-12 h-12 flex items-center justify-center border border-gray-200 rounded-lg hover:bg-gray-50 peer-checked:border-[#1d2e24] peer-checked:bg-[#1d2e24] peer-checked:text-white transition text-gray-600 text-2xl" onclick="document.getElementById('current-avatar-preview').innerHTML = '<i class=\'ph {{ $icon }} text-4xl\'></i>';">
                                <i class="ph {{ $icon }}"></i>
                            </div>
                        </label>
                    @endforeach
                    @if(Str::startsWith($user->avatar, 'http'))
                        <label class="cursor-pointer">
                            <input type="radio" name="avatar" value="{{ $user->avatar }}" class="peer hidden" checked>
                            <div class="w-12 h-12 flex items-center justify-center border border-gray-200 rounded-lg hover:bg-gray-50 peer-checked:border-[#1d2e24] peer-checked:bg-[#1d2e24] transition overflow-hidden p-1" onclick="document.getElementById('current-avatar-preview').innerHTML = '<img src=\'{{ $user->avatar }}\' class=\'w-full h-full object-cover\' referrerpolicy=\'no-referrer\'>';">
                                <img src="{{ $user->avatar }}" referrerpolicy="no-referrer" class="w-full h-full object-cover rounded">
                            </div>
                        </label>
                    @endif
                </div>
            </div>

            <!-- Profile Info -->
            <div class="space-y-6">
                <div>
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-gray-600 mb-2">Email (Tidak dapat diubah)</label>
                    <input type="email" value="{{ $user->email }}" readonly class="w-full border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-500 outline-none">
                </div>

                <div>
                    <div class="flex justify-between items-end mb-2">
                        <label class="block text-[10px] font-bold uppercase tracking-widest text-gray-600">Nama Lengkap</label>
                        @if(!$canChangeName)
                            <span class="text-[9px] text-orange-600 bg-orange-50 px-2 py-1 rounded">Limit: Coba lagi dalam {{ $nameRemainingHours }} jam</span>
                        @endif
                    </div>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" {{ !$canChangeName ? 'readonly' : '' }} required class="w-full border border-gray-300 {{ !$canChangeName ? 'bg-gray-50 text-gray-500' : '' }} px-4 py-3 text-sm focus:outline-none focus:border-[#1d2e24] transition">
                </div>

                <div>
                    <div class="flex justify-between items-end mb-2">
                        <label class="block text-[10px] font-bold uppercase tracking-widest text-gray-600">Bio Singkat</label>
                        <span class="text-[9px] text-gray-400" id="bio-counter">0/150</span>
                    </div>
                    <textarea name="bio" rows="3" maxlength="150" class="w-full border border-gray-300 px-4 py-3 text-sm focus:outline-none focus:border-[#1d2e24] transition resize-none" oninput="document.getElementById('bio-counter').innerText = this.value.length + '/150'">{{ old('bio', $user->bio) }}</textarea>
                </div>
                
                <button type="submit" class="btn-primary w-full py-4 text-sm mt-4">Simpan Perubahan</button>
            </div>
            
        </form>
    </div>
</div>

<script>
    // Set initial bio counter
    const bioTextarea = document.querySelector('textarea[name="bio"]');
    if(bioTextarea) {
        document.getElementById('bio-counter').innerText = bioTextarea.value.length + '/150';
    }
</script>
@endsection
