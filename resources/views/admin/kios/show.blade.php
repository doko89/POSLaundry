@extends('layouts.app')

@section('title', 'Detail Kios')

@section('content')
<div class="mb-6">
    <div class="flex justify-between items-start">
        <div>
            <h2 class="text-xl font-semibold text-gray-800">{{ $kiosk->name }}</h2>
            <p class="mt-1 text-sm text-gray-600">Detail informasi dan statistik kios</p>
        </div>
        <div class="flex space-x-3">
            <x-button variant="secondary" 
                onclick="window.location.href='{{ route('admin.kios.edit', $kiosk) }}'">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Edit Kios
            </x-button>
            <x-button variant="primary" 
                onclick="window.location.href='{{ route('admin.kios.scan-whatsapp', $kiosk) }}'">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                </svg>
                Scan WhatsApp
            </x-button>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Informasi Kios -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Basic Info Card -->
        <x-card>
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Informasi Dasar</h3>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-sm font-medium text-gray-500">Status</p>
                    <span class="px-2 py-1 text-xs rounded-full inline-block mt-1
                        {{ $kiosk->status === 'active' ? 'bg-green-100 text-green-800' : 
                           ($kiosk->status === 'expired' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                        {{ ucfirst($kiosk->status) }}
                    </span>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Pemilik</p>
                    <p class="mt-1">{{ $kiosk->owner->name }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Tanggal Berakhir</p>
                    <p class="mt-1">{{ $kiosk->expired_date->format('d/m/Y') }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">WhatsApp</p>
                    @if($kiosk->whatsapp_number)
                        <span class="text-green-600 mt-1 inline-block">
                            <svg class="w-5 h-5 inline-block mr-1" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                            </svg>
                            Terverifikasi
                        </span>
                    @else
                        <span class="text-red-600 mt-1 inline-block">Belum Terverifikasi</span>
                    @endif
                </div>
            </div>
        </x-card>

        <!-- Statistik Card -->
        <x-card>
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Statistik</h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Pekerja</p>
                    <p class="text-2xl font-bold text-primary-600 mt-1">{{ $kiosk->workers_count }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Pelanggan</p>
                    <p class="text-2xl font-bold text-primary-600 mt-1">{{ $kiosk->customers_count }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Order</p>
                    <p class="text-2xl font-bold text-primary-600 mt-1">{{ $kiosk->orders_count }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Layanan</p>
                    <p class="text-2xl font-bold text-primary-600 mt-1">{{ $kiosk->services_count }}</p>
                </div>
            </div>
        </x-card>

        <!-- Riwayat Perpanjangan -->
        <x-card>
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Riwayat Perpanjangan</h3>
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Durasi</th>
                            <th>Mulai</th>
                            <th>Berakhir</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($kiosk->renewalHistory as $renewal)
                        <tr>
                            <td>{{ $renewal->created_at->format('d/m/Y') }}</td>
                            <td>{{ $renewal->duration }} Bulan</td>
                            <td>{{ $renewal->start_date->format('d/m/Y') }}</td>
                            <td>{{ $renewal->end_date->format('d/m/Y') }}</td>
                            <td>
                                <span class="px-2 py-1 text-xs rounded-full 
                                    {{ $renewal->status === 'completed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ ucfirst($renewal->status) }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </x-card>
    </div>

    <!-- Sidebar -->
    <div class="space-y-6">
        <!-- Quick Actions -->
        <x-card>
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Aksi Cepat</h3>
            <div class="space-y-3">
                <x-button variant="primary" class="w-full justify-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Perpanjang Langganan
                </x-button>
                <x-button variant="secondary" class="w-full justify-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                    </svg>
                    Reset Password Owner
                </x-button>
            </div>
        </x-card>

        <!-- Recent Activities -->
        <x-card>
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Aktivitas Terbaru</h3>
            <div class="space-y-4">
                @foreach($kiosk->recentActivities as $activity)
                <div class="flex items-start space-x-3">
                    <div class="flex-shrink-0">
                        <span class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-primary-100">
                            <svg class="h-5 w-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </span>
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="text-sm text-gray-800">{{ $activity->description }}</p>
                        <p class="text-xs text-gray-500">{{ $activity->created_at->diffForHumans() }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </x-card>
    </div>
</div>
@endsection 