<?php
namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Setting;

class HomeController extends Controller {
    public function index() {
        $settings        = Setting::getSetting();
        $newProducts     = Product::available()->latest()->take(4)->get();
        $featuredProducts = Product::available()->inRandomOrder()->take(4)->get();
        return view('home', compact('settings', 'newProducts', 'featuredProducts'));
    }
}
