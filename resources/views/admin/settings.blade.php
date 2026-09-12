@extends('admin.layouts.app')
@section('title','Pengaturan Toko')
@section('content')
<div class="max-w-2xl">
    <div class="mb-8">
        <p class="text-[10px] uppercase tracking-widest text-gray-400 font-semibold mb-1">Konfigurasi</p>
        <h2 class="font-playfair text-2xl text-[#1d2e24]">Pengaturan Toko</h2>
    </div>
    <div class="bg-white border border-gray-200 p-8">
        <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-6">
            @csrf @method('PUT')
            <div>
                <label class="block text-[10px] font-bold uppercase tracking-widest text-gray-600 mb-2">Nama Toko</label>
                <input type="text" name="store_name" value="{{ old('store_name',$setting->store_name ?? '') }}" required class="w-full border border-gray-300 px-4 py-3 text-sm focus:outline-none focus:border-[#1d2e24] transition">
            </div>
            <div>
                <label class="block text-[10px] font-bold uppercase tracking-widest text-gray-600 mb-2">Nomor WhatsApp</label>
                <input type="text" name="whatsapp" value="{{ old('whatsapp',$setting->whatsapp ?? '') }}" required class="w-full border border-gray-300 px-4 py-3 text-sm focus:outline-none focus:border-[#1d2e24] transition" placeholder="628123456789">
                <p class="text-xs text-gray-400 mt-1">Gunakan format 62 (kode negara). Digunakan untuk semua tombol pemesanan.</p>
            </div>
            <div>
                <label class="block text-[10px] font-bold uppercase tracking-widest text-gray-600 mb-2">Username Instagram</label>
                <input type="text" name="instagram" value="{{ old('instagram',$setting->instagram ?? '') }}" class="w-full border border-gray-300 px-4 py-3 text-sm focus:outline-none focus:border-[#1d2e24] transition" placeholder="@namatoko">
            </div>
            <div>
                <label class="block text-[10px] font-bold uppercase tracking-widest text-gray-600 mb-2">Alamat Toko</label>
                <textarea name="address" rows="3" required class="w-full border border-gray-300 px-4 py-3 text-sm focus:outline-none focus:border-[#1d2e24] transition resize-none">{{ old('address',$setting->address ?? '') }}</textarea>
            </div>
            <div>
                <label class="block text-[10px] font-bold uppercase tracking-widest text-gray-600 mb-2">Google Maps Embed (opsional)</label>
                <textarea name="maps_embed" rows="3" class="w-full border border-gray-300 px-4 py-3 text-sm focus:outline-none focus:border-[#1d2e24] transition resize-none font-mono text-xs" placeholder="<iframe src=&quot;https://www.google.com/maps/embed?...&quot; ...></iframe>">{{ old('maps_embed',$setting->maps_embed ?? '') }}</textarea>
                <p class="text-xs text-gray-400 mt-1">Salin kode embed dari Google Maps → Bagikan → Sematkan peta.</p>
            </div>
            <button type="submit" class="w-full bg-[#1d2e24] text-white py-3.5 text-xs font-bold uppercase tracking-widest hover:bg-[#2a4334] transition">Simpan Pengaturan</button>
        </form>
    </div>
</div>
@endsection
