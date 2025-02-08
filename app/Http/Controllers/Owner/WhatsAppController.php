<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WhatsAppController extends Controller
{
    public function showScanPage()
    {
        return view('owner.whatsapp.scan');
    }

    public function generateQR()
    {
        // Logika untuk menghasilkan QR code
    }

    public function verifyConnection(Request $request)
    {
        // Logika untuk memverifikasi koneksi WhatsApp
    }
} 