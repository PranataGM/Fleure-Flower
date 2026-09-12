@extends('admin.layouts.app')
@section('title','Kelola Produk')
@section('content')
<div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
    <form method="GET" class="flex flex-wrap gap-3 items-center flex-1">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama produk..." class="border border-gray-300 px-4 py-2.5 text-sm focus:outline-none focus:border-[#1d2e24] transition w-48">
        <select name="category" class="border border-gray-300 px-4 py-2.5 text-sm focus:outline-none focus:border-[#1d2e24] transition">
            <option value="">Semua Kategori</option>
            <option value="buket" @selected(request('category')=='buket')>Buket</option>
            <option value="fresh_flower" @selected(request('category')=='fresh_flower')>Fresh Flower</option>
            <option value="amplop" @selected(request('category')=='amplop')>Amplop / Kartu</option>
        </select>
        <select name="status" class="border border-gray-300 px-4 py-2.5 text-sm focus:outline-none focus:border-[#1d2e24] transition">
            <option value="">Semua Status</option>
            <option value="available" @selected(request('status')=='available')>Tersedia</option>
            <option value="sold_out" @selected(request('status')=='sold_out')>Sold Out</option>
        </select>
        <button type="submit" class="bg-[#1d2e24] text-white px-5 py-2.5 text-xs font-bold uppercase tracking-widest hover:bg-[#2a4334] transition">Filter</button>
        <a href="{{ route('admin.products.index') }}" class="text-xs text-gray-400 hover:text-gray-700 uppercase tracking-widest font-semibold">Reset</a>
    </form>
    <a href="{{ route('admin.products.create') }}" class="flex items-center gap-2 bg-[#1d2e24] text-white px-5 py-2.5 text-xs font-bold uppercase tracking-widest hover:bg-[#2a4334] transition shrink-0"><i class="ph ph-plus"></i> Tambah Produk</a>
</div>

<div class="bg-white border border-gray-200 overflow-hidden">
    <table class="w-full text-left">
        <thead><tr class="bg-gray-50 border-b border-gray-200">
            <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-gray-500">Foto</th>
            <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-gray-500">Nama & Kategori</th>
            <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-gray-500">Harga</th>
            <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-gray-500">Status</th>
            <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-gray-500 text-right">Aksi</th>
        </tr></thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($products as $p)
            <tr class="hover:bg-gray-50 transition">
                <td class="px-6 py-4"><img src="{{ $p->image_url }}" class="w-14 h-14 object-cover" alt=""></td>
                <td class="px-6 py-4">
                    <p class="font-semibold text-gray-900 text-sm">{{ $p->name }}</p>
                    <p class="text-xs text-gray-400 uppercase tracking-wider mt-0.5">{{ $p->category_label }}</p>
                </td>
                <td class="px-6 py-4 text-sm font-semibold text-gray-800 whitespace-nowrap">{{ $p->formatted_price }}</td>
                <td class="px-6 py-4 whitespace-nowrap">
                    @if($p->status==='available')
                    <span class="px-3 py-1 text-[9px] font-bold uppercase tracking-widest bg-green-50 text-green-700 border border-green-200">Tersedia</span>
                    @else
                    <span class="px-3 py-1 text-[9px] font-bold uppercase tracking-widest bg-red-50 text-red-600 border border-red-200">Sold Out</span>
                    @endif
                </td>
                <td class="px-6 py-4 text-right whitespace-nowrap">
                    <a href="{{ route('admin.products.edit',$p) }}" class="inline-flex items-center gap-1 text-xs text-[#1d2e24] font-semibold hover:underline mr-4"><i class="ph ph-pencil-simple"></i> Edit</a>
                    <form action="{{ route('admin.products.destroy',$p) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="inline-flex items-center gap-1 text-xs text-red-500 font-semibold hover:underline"><i class="ph ph-trash"></i> Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" class="px-6 py-16 text-center text-gray-400 text-sm"><i class="ph-light ph-magnifying-glass text-4xl mb-3 block"></i> Tidak ada produk ditemukan.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@if($products->hasPages())
<div class="mt-6">{{ $products->links() }}</div>
@endif
@endsection
