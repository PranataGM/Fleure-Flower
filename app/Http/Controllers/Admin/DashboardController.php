<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;

use Carbon\Carbon;

class DashboardController extends Controller {
    public function index() {
        $stats = [
            'buket'        => Product::where('category', 'buket')->where('status', 'available')->count(),
            'fresh_flower' => Product::where('category', 'fresh_flower')->where('status', 'available')->count(),
            'amplop'       => Product::where('category', 'amplop')->where('status', 'available')->count(),
            'sold_out'     => Product::where('status', 'sold_out')->count(),
            'total_orders' => Order::count(),
            'paid_orders'  => Order::where('status', 'paid')->count(),
        ];
        
        $revenues = [
            'daily' => Order::whereIn('status', ['paid', 'processing', 'shipped', 'completed'])->whereDate('created_at', Carbon::today())->sum('total_amount'),
            'weekly' => Order::whereIn('status', ['paid', 'processing', 'shipped', 'completed'])->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->sum('total_amount'),
            'monthly' => Order::whereIn('status', ['paid', 'processing', 'shipped', 'completed'])->whereMonth('created_at', Carbon::now()->month)->whereYear('created_at', Carbon::now()->year)->sum('total_amount'),
        ];

        // Chart Data (Last 7 Days)
        $chartDates = [];
        $chartRevenues = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $chartDates[] = $date->format('d M');
            $chartRevenues[] = Order::whereIn('status', ['paid', 'processing', 'shipped', 'completed'])->whereDate('created_at', $date)->sum('total_amount');
        }
        $chartData = [
            'labels' => $chartDates,
            'data' => $chartRevenues
        ];

        $latestOrders = Order::latest()->take(5)->get();
        return view('admin.dashboard', compact('stats', 'latestOrders', 'revenues', 'chartData'));
    }
}
