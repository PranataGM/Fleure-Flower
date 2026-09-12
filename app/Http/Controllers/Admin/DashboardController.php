<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;

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
        $latestOrders = Order::latest()->take(5)->get();
        return view('admin.dashboard', compact('stats', 'latestOrders'));
    }
}
