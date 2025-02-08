<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kiosk;
use Illuminate\Http\Request;

class KioskController extends Controller
{
    public function index()
    {
        $kiosks = Kiosk::all();
        return view('admin.kios.index', compact('kiosks'));
    }

    public function create()
    {
        return view('admin.kios.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'phone' => 'required|string',
        ]);

        Kiosk::create($request->all());
        return redirect()->route('admin.kios.index')->with('success', 'Kiosk created successfully.');
    }

    // Metode lainnya (show, edit, update, destroy)...
}
