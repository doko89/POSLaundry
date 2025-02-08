@extends('layouts.app')

@section('title', 'Scan WhatsApp')

@section('content')
<div class="mb-6">
    <div class="flex justify-between items-start">
        <div>
            <h2 class="text-xl font-semibold text-gray-800">Scan WhatsApp</h2>
            <p class="mt-1 text-sm text-gray-600">Hubungkan WhatsApp kios untuk menerima notifikasi otomatis</p>
        </div>
        <x-button variant="secondary" 
            onclick="window.location.href='{{ route('owner.dashboard') }}'">
            Kembali ke Dashboard
        </x-button>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- QR Code Section -->
    <x-card>
        <div class="text-center">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Scan QR Code</h3>
            
            <div class="bg-white p-4 rounded-lg shadow-inner mx-auto max-w-xs">
                <div id="qr-container" class="aspect-square">
                    <!-- QR Code will be displayed here -->
                </div>
            </div>

            <div class="mt-6 space-y-4">
                <x-button variant="primary" id="generate-qr" class="w-full justify-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    Generate QR Code Baru
                </x-button>
                <p class="text-sm text-gray-500">
                    QR Code akan expired dalam <span id="countdown" class="font-medium text-primary-600">60</span> detik
                </p>
            </div>
        </div>
    </x-card>

    <!-- Instructions -->
    <x-card>
        <h3 class="text-lg font-semibold text-gray-700 mb-4">Petunjuk</h3>
        <div class="space-y-4">
            <div class="flex items-start space-x-3">
                <div class="flex-shrink-0">
                    <span class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-primary-100 text-primary-600 font-bold">
                        1
                    </span>
                </div>
                <div>
                    <p class="text-gray-800 font-medium">Buka WhatsApp di HP</p>
                    <p class="text-sm text-gray-600">Buka aplikasi WhatsApp di smartphone Anda</p>
                </div>
            </div>

            <div class="flex items-start space-x-3">
                <div class="flex-shrink-0">
                    <span class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-primary-100 text-primary-600 font-bold">
                        2
                    </span>
                </div>
                <div>
                    <p class="text-gray-800 font-medium">Buka Menu WhatsApp Web</p>
                    <p class="text-sm text-gray-600">Klik menu titik tiga > WhatsApp Web > + Perangkat Baru</p>
                </div>
            </div>

            <div class="flex items-start space-x-3">
                <div class="flex-shrink-0">
                    <span class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-primary-100 text-primary-600 font-bold">
                        3
                    </span>
                </div>
                <div>
                    <p class="text-gray-800 font-medium">Scan QR Code</p>
                    <p class="text-sm text-gray-600">Arahkan kamera ke QR Code yang ditampilkan</p>
                </div>
            </div>

            <div class="flex items-start space-x-3">
                <div class="flex-shrink-0">
                    <span class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-primary-100 text-primary-600 font-bold">
                        4
                    </span>
                </div>
                <div>
                    <p class="text-gray-800 font-medium">Verifikasi</p>
                    <p class="text-sm text-gray-600">Tunggu hingga proses verifikasi selesai</p>
                </div>
            </div>
        </div>

        <div class="mt-6 p-4 bg-yellow-50 rounded-lg">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-yellow-800">Perhatian</h3>
                    <div class="mt-2 text-sm text-yellow-700">
                        <ul class="list-disc pl-5 space-y-1">
                            <li>Pastikan HP terhubung ke internet</li>
                            <li>Jangan tutup halaman ini selama proses scan</li>
                            <li>QR Code hanya berlaku untuk satu kali scan</li>
                            <li>Notifikasi akan dikirim ke nomor WhatsApp yang terdaftar</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </x-card>
</div>

@push('scripts')
<script>
    let countdown;
    const generateQR = document.getElementById('generate-qr');
    const countdownEl = document.getElementById('countdown');
    const qrContainer = document.getElementById('qr-container');

    function startCountdown(seconds) {
        clearInterval(countdown);
        let timeLeft = seconds;
        
        countdown = setInterval(() => {
            timeLeft--;
            countdownEl.textContent = timeLeft;
            
            if (timeLeft <= 0) {
                clearInterval(countdown);
                qrContainer.innerHTML = `
                    <div class="flex items-center justify-center h-full">
                        <p class="text-gray-500">QR Code expired</p>
                    </div>
                `;
            }
        }, 1000);
    }

    generateQR.addEventListener('click', async () => {
        try {
            const response = await fetch('{{ route("owner.whatsapp.generate-qr") }}');
            const data = await response.json();
            
            if (data.qr) {
                qrContainer.innerHTML = `<img src="${data.qr}" alt="WhatsApp QR Code" class="w-full h-full">`;
                startCountdown(60);
            }
        } catch (error) {
            console.error('Error generating QR:', error);
        }
    });

    // Generate QR on page load
    generateQR.click();
</script>
@endpush
@endsection 