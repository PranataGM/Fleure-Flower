<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller {
    public function showLogin() {
        if (session('admin_logged_in')) return redirect()->route('admin.dashboard');
        return view('admin.login');
    }

    public function login(Request $request) {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);
        $admin = Admin::where('username', $request->username)->first();
        if ($admin && Hash::check($request->password, $admin->password)) {
            $request->session()->regenerate();
            session([
                'admin_logged_in' => true,
                'admin_id'        => $admin->id,
                'admin_username'  => $admin->username,
            ]);
            return redirect()->route('admin.dashboard');
        }
        return back()->withErrors(['username' => 'Username atau password salah.'])->withInput();
    }

    public function logout(Request $request) {
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }
}
