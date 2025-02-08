<?php

namespace App\Http\Controllers\Worker;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        $totalOrders = auth()->user()->orders()->count();
        $completedOrders = auth()->user()->orders()->where('status', 'completed')->count();
        $averageRating = auth()->user()->calculateAverageRating();
        $performance = auth()->user()->calculatePerformance();

        return view('worker.profile.index', compact(
            'totalOrders',
            'completedOrders',
            'averageRating',
            'performance'
        ));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20|unique:users,phone,'.auth()->id(),
            'address' => 'nullable|string',
            'birth_date' => 'nullable|date',
            'avatar' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('avatar')) {
            if (auth()->user()->avatar) {
                Storage::delete(auth()->user()->avatar);
            }
            $validated['avatar'] = $request->file('avatar')->store('avatars');
        }

        auth()->user()->update($validated);

        return back()->with('success', 'Profil berhasil diperbarui');
    }

    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => 'required|current_password',
            'password' => 'required|string|min:8|confirmed'
        ]);

        auth()->user()->update([
            'password' => Hash::make($validated['password'])
        ]);

        return back()->with('success', 'Password berhasil diubah');
    }
}
