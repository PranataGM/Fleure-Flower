@extends('admin.layouts.app')
@section('title','Edit Produk')
@section('content')
<div class="max-w-2xl">
    <div class="flex items-center gap-3 mb-8">
        <a href="{{ route('admin.products.index') }}" class="text-gray-400 hover:text-[#1d2e24] transition"><i class="ph ph-arrow-left text-xl"></i></a>
        <div>
            <p class="text-[10px] uppercase tracking-widest text-gray-400 font-semibold mb-0.5">Kelola Produk</p>
            <h2 class="font-playfair text-2xl text-[#1d2e24]">Edit Produk</h2>
        </div>
    </div>
    <div class="bg-white border border-gray-200 p-8">
        <form action="{{ route('admin.products.update',$product) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf @method('PUT')
            <div>
                <label class="block text-[10px] font-bold uppercase tracking-widest text-gray-600 mb-2">Nama Produk *</label>
                <input type="text" name="name" value="{{ old('name',$product->name) }}" required class="w-full border border-gray-300 px-4 py-3 text-sm focus:outline-none focus:border-[#1d2e24] transition">
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-gray-600 mb-2">Kategori *</label>
                    <select name="category" required class="w-full border border-gray-300 px-4 py-3 text-sm focus:outline-none focus:border-[#1d2e24] transition">
                        <option value="buket" {{ old('category',$product->category)=='buket'?'selected':'' }}>Buket Bunga</option>
                        <option value="fresh_flower" {{ old('category',$product->category)=='fresh_flower'?'selected':'' }}>Fresh Flower</option>
                        <option value="amplop" @selected(old('category',$product->category)=='amplop')>Amplop / Kartu</option>
                    </select>
                </div>
                <div>
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-gray-600 mb-2">Harga (Rp) *</label>
                    <input type="number" name="price" value="{{ old('price',intval($product->price)) }}" min="0" required class="w-full border border-gray-300 px-4 py-3 text-sm focus:outline-none focus:border-[#1d2e24] transition">
                </div>
            </div>
            <div>
                <label class="block text-[10px] font-bold uppercase tracking-widest text-gray-600 mb-2">Deskripsi *</label>
                <textarea name="description" rows="3" required class="w-full border border-gray-300 px-4 py-3 text-sm focus:outline-none focus:border-[#1d2e24] transition resize-none">{{ old('description',$product->description) }}</textarea>
            </div>
            <div>
                <label class="block text-[10px] font-bold uppercase tracking-widest text-gray-600 mb-3">Foto Saat Ini</label>
                <img src="{{ $product->image_url }}" class="w-36 h-40 object-cover border border-gray-200 mb-4">
                <label class="block text-[10px] font-bold uppercase tracking-widest text-gray-600 mb-2">Ganti Foto (Opsional)</label>
                <div class="border-2 border-dashed border-gray-300 p-5 text-center hover:border-[#1d2e24] transition cursor-pointer relative">
                    <i class="ph-light ph-upload-simple text-2xl text-gray-400 mb-1 block"></i>
                    <p class="text-xs text-gray-500">Biarkan kosong jika tidak ingin mengubah foto</p>
                    <input type="file" name="image" accept="image/jpeg,image/png,image/webp" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                </div>
            </div>
            <div>
                <label class="block text-[10px] font-bold uppercase tracking-widest text-gray-600 mb-2">Status</label>
                <select name="status" class="w-full border border-gray-300 px-4 py-3 text-sm focus:outline-none focus:border-[#1d2e24] transition">
                    <option value="available" @selected(old('status',$product->status)=='available')>✅ Tersedia (Tampil di Website)</option>
                    <option value="sold_out" @selected(old('status',$product->status)=='sold_out')>❌ Sold Out (Disembunyikan)</option>
                </select>
            </div>
            <button type="submit" class="w-full bg-[#1d2e24] text-white py-3.5 text-xs font-bold uppercase tracking-widest hover:bg-[#2a4334] transition">Simpan Perubahan</button>
        </form>
    </div>
</div>
@endsection
