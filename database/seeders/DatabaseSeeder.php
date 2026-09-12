<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Product;
use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Setup Admin
        Admin::firstOrCreate(
            ['username' => 'admin'],
            ['password' => Hash::make('admin123')]
        );

        // Setup Settings
        Setting::firstOrCreate(
            ['id' => 1],
            [
                'store_name' => 'Fleure Flower',
                'whatsapp' => '6281234567890',
                'instagram' => '@fleure.flower',
                'address' => 'Jl. Mawar Indah No. 123, Yogyakarta',
                'maps_embed' => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d17893.25846237197!2d110.31692326068877!3d-7.747202083637462!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a59db7be5b001%3A0x1c68e90a1a6658b2!2sAlifia%20florist!5e1!3m2!1sid!2sid!4v1789251980723!5m2!1sid!2sid" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="strict-origin-when-cross-origin"></iframe>'
            ]
        );

        // Make sure products directory exists in storage
        if (!Storage::disk('public')->exists('products')) {
            Storage::disk('public')->makeDirectory('products');
        }

        // Dummy Products with Brighter Images from Unsplash
        $dummyProducts = [
            [
                'name' => 'Sweet Peony Elegance',
                'category' => 'buket',
                'description' => 'Buket peony pink cerah yang dirangkai elegan, sempurna untuk hari spesial atau sekadar kejutan manis.',
                'price' => 350000,
                'image' => 'https://images.unsplash.com/photo-1582794543139-8ac9cb0f7b11?q=80&w=800',
                'status' => 'available'
            ],
            [
                'name' => 'Sunburst Daisy Mix',
                'category' => 'buket',
                'description' => 'Paduan daisy dan bunga liar kuning-oranye cerah, memancarkan keceriaan dan energi positif.',
                'price' => 275000,
                'image' => 'https://images.unsplash.com/photo-1526047932273-341f2a7631f9?q=80&w=800',
                'status' => 'available'
            ],
            [
                'name' => 'Classic White Roses',
                'category' => 'fresh_flower',
                'description' => 'Mawar putih premium segar yang melambangkan kemurnian dan ketulusan, cocok untuk dekorasi rumah minimalis.',
                'price' => 400000,
                'image' => 'https://images.unsplash.com/photo-1513619574244-a0eb867ee656?q=80&w=800',
                'status' => 'available'
            ],
            [
                'name' => 'Spring Blossom Box',
                'category' => 'buket',
                'description' => 'Bunga-bunga musim semi berwarna pastel cerah yang dirangkai dalam kotak premium elegan.',
                'price' => 450000,
                'image' => 'https://images.unsplash.com/photo-1591886960571-74d43a9d4166?q=80&w=800',
                'status' => 'available'
            ],
            [
                'name' => 'Vibrant Tulip Bouquet',
                'category' => 'buket',
                'description' => 'Tulip segar dengan warna-warni cerah yang memukau, diimpor langsung dari Belanda.',
                'price' => 320000,
                'image' => 'https://images.unsplash.com/photo-1520763185298-1b434c919102?q=80&w=800',
                'status' => 'available'
            ],
            [
                'name' => 'Kartu Ucapan Gold Foil',
                'category' => 'amplop',
                'description' => 'Kartu ucapan kosong dengan tulisan gold foil yang mewah dan amplop berbahan tebal.',
                'price' => 25000,
                'image' => 'https://images.unsplash.com/photo-1586075010923-2dd4570fb338?q=80&w=800',
                'status' => 'available'
            ],
            [
                'name' => 'Lavender Dream Bundle',
                'category' => 'fresh_flower',
                'description' => 'Ikatan bunga lavender kering yang harum dan menenangkan, cocok untuk diletakkan di vas sudut ruangan.',
                'price' => 150000,
                'image' => 'https://images.unsplash.com/photo-1496062031456-07b8f162a322?q=80&w=800',
                'status' => 'available'
            ],
            [
                'name' => 'Romantic Red Roses',
                'category' => 'buket',
                'description' => 'Buket mawar merah klasik yang dirangkai mewah dengan kertas wrapping hitam eksklusif.',
                'price' => 425000,
                'image' => 'https://images.unsplash.com/photo-1518621736915-f3b1c41bfd00?q=80&w=800',
                'status' => 'available'
            ]
        ];

        foreach ($dummyProducts as $productData) {
            Product::firstOrCreate(
                ['name' => $productData['name']],
                $productData
            );
        }
    }
}
