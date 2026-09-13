@extends('admin.layouts.app')
@section('title','Dashboard')
@section('content')

<div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-8">
    @foreach([
        ['Buket Tersedia', $stats['buket'], 'ph-flower', 'green'],
        ['Fresh Flower', $stats['fresh_flower'], 'ph-leaf', 'green'],
        ['Amplop / Kartu', $stats['amplop'], 'ph-envelope', 'green'],
        ['Sold Out', $stats['sold_out'], 'ph-x-circle', 'red'],
        ['Total Pesanan', $stats['total_orders'], 'ph-shopping-bag', 'blue'],
        ['Pesanan Dibayar', $stats['paid_orders'], 'ph-check-circle', 'emerald'],
    ] as [$label, $count, $icon, $color])
    <div class="bg-white border border-gray-200 p-5 relative overflow-hidden">
        <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400 mb-1">{{ $label }}</p>
        <p class="font-playfair text-4xl font-semibold text-[#1d2e24]">{{ $count }}</p>
        <i class="ph-light {{ $icon }} absolute -right-2 -bottom-2 text-7xl text-gray-100"></i>
    </div>
    @endforeach
</div>

<!-- REVENUE STATS -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    @foreach([
        ['Pendapatan Hari Ini', $revenues['daily']],
        ['Pendapatan Minggu Ini', $revenues['weekly']],
        ['Pendapatan Bulan Ini', $revenues['monthly']],
    ] as [$label, $amount])
    <div class="bg-white border border-gray-200 p-6 flex flex-col justify-center text-center">
        <p class="text-[11px] font-bold uppercase tracking-widest text-gray-500 mb-2">{{ $label }}</p>
        <p class="font-playfair text-3xl font-semibold text-[#1d2e24]">Rp {{ number_format($amount, 0, ',', '.') }}</p>
    </div>
    @endforeach
</div>

<!-- REVENUE CHART -->
<div class="bg-white border border-gray-200 p-6 mb-8">
    <h3 class="font-playfair text-xl text-[#1d2e24] mb-4">Grafik Pendapatan (7 Hari Terakhir)</h3>
    <div class="w-full h-80">
        <canvas id="revenueChart"></canvas>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="bg-white border border-gray-200 p-6">
        <h3 class="font-playfair text-lg text-[#1d2e24] mb-4">Aksi Cepat</h3>
        <div class="space-y-3">
            <a href="{{ route('admin.products.create') }}" class="flex items-center gap-3 bg-[#1d2e24] text-white px-5 py-3 text-xs font-bold uppercase tracking-widest hover:bg-[#2a4334] transition"><i class="ph ph-plus"></i> Tambah Produk Baru</a>
            <a href="{{ route('admin.products.index') }}" class="flex items-center gap-3 border border-[#1d2e24] text-[#1d2e24] px-5 py-3 text-xs font-bold uppercase tracking-widest hover:bg-[#1d2e24] hover:text-white transition"><i class="ph ph-list"></i> Kelola Produk</a>
            <a href="{{ route('admin.orders.index') }}" class="flex items-center gap-3 border border-gray-300 text-gray-600 px-5 py-3 text-xs font-bold uppercase tracking-widest hover:border-[#1d2e24] hover:text-[#1d2e24] transition"><i class="ph ph-shopping-bag"></i> Lihat Pesanan</a>
        </div>
    </div>

    <div class="bg-white border border-gray-200 p-6 md:col-span-2">
        <h3 class="font-playfair text-lg text-[#1d2e24] mb-4">5 Pesanan Terbaru</h3>
        @if($latestOrders->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead><tr class="border-b border-gray-100">
                    <th class="pb-3 text-[10px] font-bold uppercase tracking-widest text-gray-400">Kode</th>
                    <th class="pb-3 text-[10px] font-bold uppercase tracking-widest text-gray-400">Nama</th>
                    <th class="pb-3 text-[10px] font-bold uppercase tracking-widest text-gray-400">Total</th>
                    <th class="pb-3 text-[10px] font-bold uppercase tracking-widest text-gray-400">Status</th>
                </tr></thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($latestOrders as $o)
                    <tr class="hover:bg-gray-50">
                        <td class="py-3 font-mono text-xs text-[#1d2e24]"><a href="{{ route('admin.orders.show',$o) }}" class="hover:underline">{{ $o->order_code }}</a></td>
                        <td class="py-3 text-gray-700 font-light">{{ $o->customer_name }}</td>
                        <td class="py-3 font-semibold text-gray-800 whitespace-nowrap">{{ $o->formatted_total }}</td>
                        <td class="py-3">
                            <span class="text-[9px] font-bold uppercase tracking-widest px-2 py-1 {{ $o->status==='paid'||$o->status==='completed' ? 'bg-green-50 text-green-700 border border-green-200' : ($o->status==='cancelled' ? 'bg-red-50 text-red-600 border border-red-200' : 'bg-yellow-50 text-yellow-700 border border-yellow-200') }}">{{ $o->status_label }}</span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <p class="text-sm text-gray-400 font-light py-6 text-center">Belum ada pesanan.</p>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('revenueChart').getContext('2d');
    const chartData = @json($chartData);
    
    // Reverse the arrays so the oldest date is on the left
    const labels = chartData.labels.reverse();
    const data = chartData.data.reverse();

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Pendapatan (Rp)',
                data: data,
                borderColor: '#1d2e24',
                backgroundColor: 'rgba(29, 46, 36, 0.1)',
                borderWidth: 2,
                pointBackgroundColor: '#1d2e24',
                pointRadius: 4,
                fill: true,
                tension: 0.3
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + value.toLocaleString('id-ID');
                        }
                    }
                }
            }
        }
    });
});
</script>
@endpush
