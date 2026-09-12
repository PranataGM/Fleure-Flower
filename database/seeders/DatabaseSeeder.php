<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder {
    public function run(): void {
        DB::table('admins')->insertOrIgnore([
            'username'   => 'admin',
            'password'   => Hash::make('admin123'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('settings')->insertOrIgnore([
            'store_name'  => 'Fleure Flower',
            'whatsapp'    => '6281234567890',
            'instagram'   => '@fleure.flower',
            'address'     => 'Jl. Bunga Melati No. 123, Yogyakarta',
            'maps_embed'  => '',
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);
    }
}
