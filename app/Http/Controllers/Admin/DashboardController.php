<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kiosk;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_kios' => Kiosk::count(),
            'total_owner' => User::where('role', 'owner')->count(),
            'total_worker' => User::where('role', 'worker')->count(),
            'active_kios' => Kiosk::whereHas('users')->count(),
        ];
        
        return view('admin.dashboard', compact('stats'));
    }
}
