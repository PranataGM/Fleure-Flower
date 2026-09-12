<?php
namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Setting;

class KoleksiController extends Controller {
    public function index() {
        $settings = Setting::getSetting();
        $products = Product::available()->latest()->get();
        return view('koleksi', compact('settings', 'products'));
    }
}
