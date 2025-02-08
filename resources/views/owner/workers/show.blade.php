@extends('layouts.app')

@section('title', 'Detail Pekerja')

@section('content')
<div class="mb-6">
    <div class="flex justify-between items-start">
        <div>
            <h2 class="text-xl font-semibold text-gray-800">Detail Pekerja</h2>
            <p class="mt-1 text-sm text-gray-600">Informasi lengkap dan kinerja pekerja</p>
        </div>
        <div class="flex space-x-3">
            <x-button variant="secondary" 
                onclick="window.location.href='{{ route('owner.workers.edit', $worker) }}'">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Edit Pekerja
            </x-button>
            <x-button variant="danger" 
                onclick="if(confirm('Apakah Anda yakin ingin menghapus pekerja ini?')) document.getElementById('delete-form').submit()">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
                Hapus Pekerja
            </x-button>
            <form id="delete-form" action="{{ route('owner.workers.destroy', $worker) }}" 
                method="POST" class="hidden">
                @csrf
                @method('DELETE')
            </form>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Worker Information -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Basic Info Card -->
        <x-card>
            <div class="flex items-center space-x-4 mb-6">
                <img class="h-20 w-20 rounded-full" 
                    src="{{ $worker->avatar_url ?? 'https://ui-avatars.com/api/?name='.$worker->name }}" 
                    alt="{{ $worker->name }}">
                <div>
                    <h3 class="text-xl font-semibold text-gray-800">{{ $worker->name }}</h3>
                    <p class="text-gray-600">{{ $worker->email }}</p>
                    <span class="px-2 py-1 text-xs rounded-full inline-block mt-2
                        {{ $worker->status ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $worker->status ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-sm font-medium text-gray-500">Nomor HP</p>
                    <p class="mt-1">{{ $worker->phone ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Bergabung Sejak</p>
                    <p class="mt-1">{{ $worker->created_at->format('d/m/Y') }}</p>
                </div>
                <div class="col-span-2">
                    <p class="text-sm font-medium text-gray-500">Alamat</p>
                    <p class="mt-1">{{ $worker->address ?? '-' }}</p>
                </div>
            </div>
        </x-card>

        <!-- Performance Stats -->
        <x-card>
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Statistik Kinerja</h3>
            <div class="grid grid-cols-3 gap-4">
                <div class="text-center p-4 bg-gray-50 rounded-lg">
                    <p class="text-2xl font-bold text-primary-600">{{ $worker->completed_orders_count }}</p>
                    <p class="text-sm text-gray-600">Order Selesai</p>
                </div>
                <div class="text-center p-4 bg-gray-50 rounded-lg">
                    <p class="text-2xl font-bold text-primary-600">{{ number_format($worker->average_orders_per_day, 1) }}</p>
                    <p class="text-sm text-gray-600">Rata-rata Order/Hari</p>
                </div>
                <div class="text-center p-4 bg-gray-50 rounded-lg">
                    <p class="text-2xl font-bold text-primary-600">{{ $worker->rating ?? '-' }}</p>
                    <p class="text-sm text-gray-600">Rating</p>
                </div>
            </div>
        </x-card>

        <!-- Recent Orders -->
        <x-card>
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-700">Order Terbaru</h3>
                <a href="#" class="text-sm text-primary-600 hover:text-primary-700">
                    Lihat Semua
                </a>
            </div>
            <div class="overflow-x-auto">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No. Order</th>
                            <th>Pelanggan</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($recentOrders as $order)
                        <tr>
                            <td class="font-medium">{{ $order->number }}</td>
                            <td>{{ $order->customer_name }}</td>
                            <td>Rp {{ number_format($order->total) }}</td>
                            <td>
                                <span class="px-2 py-1 text-xs rounded-full 
                                    {{ $order->status === 'completed' ? 'bg-green-100 text-green-800' : 
                                       ($order->status === 'processing' ? 'bg-yellow-100 text-yellow-800' : 'bg-blue-100 text-blue-800') }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td>{{ $order->created_at->format('d/m/Y') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-gray-500">
                                Tidak ada order terbaru
                            </td>
                        </tr>
                        @endforelse
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
                <x-button variant="secondary" class="w-full justify-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                    </svg>
                    Reset Password
                </x-button>
                @if($worker->status)
                <x-button variant="danger" class="w-full justify-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                    </svg>
                    Nonaktifkan Akun
                </x-button>
                @else
                <x-button variant="success" class="w-full justify-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Aktifkan Akun
                </x-button>
                @endif
            </div>
        </x-card>

        <!-- Recent Activities -->
        <x-card>
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Aktivitas Terbaru</h3>
            <div class="space-y-4">
                @foreach($recentActivities as $activity)
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