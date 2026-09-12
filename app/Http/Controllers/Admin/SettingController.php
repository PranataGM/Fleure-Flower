<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller {
    public function index() {
        $setting = Setting::first();
        return view('admin.settings', compact('setting'));
    }

    public function update(Request $request) {
        $request->validate([
            'store_name' => 'required|string|max:100',
            'whatsapp'   => 'required|string|max:20',
            'instagram'  => 'required|string|max:100',
            'address'    => 'required|string',
            'maps_embed' => 'nullable|string',
        ]);
        Setting::first()->update($request->only('store_name','whatsapp','instagram','address','maps_embed'));
        return back()->with('success', 'Pengaturan berhasil disimpan.');
    }
}
