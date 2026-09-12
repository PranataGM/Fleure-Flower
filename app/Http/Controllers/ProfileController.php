<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ProfileController extends Controller
{
    public function index()
    {
        $avatars = [
            'ph-user', 'ph-smiley', 'ph-alien', 'ph-cat', 'ph-dog', 
            'ph-flower-lotus', 'ph-ghost', 'ph-heart', 'ph-star', 'ph-crown'
        ];
        
        $user = Auth::user();
        
        // Cek apakah user bisa ganti nama (24 jam)
        $canChangeName = true;
        $nameRemainingHours = 0;
        
        if ($user->name_updated_at) {
            $lastUpdated = Carbon::parse($user->name_updated_at);
            if (now()->diffInHours($lastUpdated) < 24) {
                $canChangeName = false;
                $nameRemainingHours = 24 - now()->diffInHours($lastUpdated);
            }
        }

        return view('profile', compact('user', 'avatars', 'canChangeName', 'nameRemainingHours'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        
        // Base validation rules
        $rules = [
            'avatar' => 'nullable|string|max:255',
            'bio' => 'nullable|string|max:150',
        ];

        // Check if name can be updated
        $canChangeName = true;
        if ($user->name_updated_at) {
            $lastUpdated = Carbon::parse($user->name_updated_at);
            if (now()->diffInHours($lastUpdated) < 24) {
                $canChangeName = false;
            }
        }

        if ($canChangeName) {
            $rules['name'] = 'required|string|max:50';
        }

        $validated = $request->validate($rules);

        // Sanitize bio (remove HTML tags)
        if (isset($validated['bio'])) {
            $validated['bio'] = strip_tags($validated['bio']);
        }

        if (isset($validated['name'])) {
            $validated['name'] = strip_tags($validated['name']);
            // Only update name_updated_at if name actually changed
            if ($user->name !== $validated['name']) {
                $validated['name_updated_at'] = now();
            }
        }

        $user->update($validated);

        return back()->with('success', 'Profil berhasil diperbarui.');
    }
}
