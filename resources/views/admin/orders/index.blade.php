@extends('admin.layouts.app')
@section('title','Daftar Pesanan')
@section('content')
<div class="flex flex-col mb-6">
    <form method="GET" class="flex flex-wrap items-center gap-3 w-full">
        <select name="status" class="border border-gray-300 px-4 py-2.5 text-sm focus:outline-none focus:border-[#1d2e24] transition w-full md:w-auto">
            <option value="">Semua Status</option>
            @foreach(['pending'=>'Menunggu Pembayaran','paid'=>'Sudah Dibayar','processing'=>'Diproses','shipped'=>'Dikirim','completed'=>'Selesai','cancelled'=>'Dibatalkan'] as $v=>$l)
            <option value="{{ $v }}" @selected(request('status')===$v)>{{ $l }}</option>
            @endforeach
        </select>
        <div class="flex gap-3 w-full md:w-auto">
            <button type="submit" class="bg-[#1d2e24] text-white px-5 py-2.5 text-xs font-bold uppercase tracking-widest hover:bg-[#2a4334] transition flex-1 md:flex-none">Filter</button>
            <a href="{{ route('admin.orders.index') }}" class="flex items-center text-xs text-gray-400 hover:text-gray-700 uppercase tracking-widest font-semibold px-2">Reset</a>
        </div>
    </form>
</div>

<div class="bg-white border border-gray-200 overflow-x-auto w-full">
    <table class="w-full text-left min-w-[700px]">
        <thead><tr class="bg-gray-50 border-b border-gray-200">
            <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-gray-500">Kode Pesanan</th>
            <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-gray-500">Pelanggan</th>
            <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-gray-500">Total</th>
            <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-gray-500">Status</th>
            <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-gray-500">Tanggal</th>
            <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-gray-500 text-right">Aksi</th>
        </tr></thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($orders as $o)
            <tr class="hover:bg-gray-50 transition">
                <td class="px-6 py-4 font-mono text-xs text-[#1d2e24] font-semibold">{{ $o->order_code }}</td>
                <td class="px-6 py-4">
                    <p class="text-sm font-medium text-gray-800">{{ $o->customer_name }}</p>
                    <p class="text-xs text-gray-400 font-light">{{ $o->customer_phone }}</p>
                </td>
                <td class="px-6 py-4 text-sm font-semibold whitespace-nowrap text-gray-800">{{ $o->formatted_total }}</td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <span class="text-[9px] font-bold uppercase tracking-widest px-2 py-1 {{ in_array($o->status,['paid','completed']) ? 'bg-green-50 text-green-700 border border-green-200' : ($o->status==='cancelled' ? 'bg-red-50 text-red-600 border border-red-200' : 'bg-yellow-50 text-yellow-700 border border-yellow-200') }}">{{ $o->status_label }}</span>
                </td>
                <td class="px-6 py-4 text-xs text-gray-500 whitespace-nowrap">{{ $o->created_at->format('d M Y') }}</td>
                <td class="px-6 py-4 text-right">
                    <a href="{{ route('admin.orders.show',$o) }}" class="inline-flex items-center gap-1 text-xs text-[#1d2e24] font-semibold hover:underline"><i class="ph ph-eye"></i> Detail</a>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="px-6 py-16 text-center text-gray-400 text-sm"><i class="ph-light ph-shopping-bag text-4xl mb-3 block"></i> Belum ada pesanan.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@if($orders->hasPages()) <div class="mt-6">{{ $orders->links() }}</div> @endif
@endsection
