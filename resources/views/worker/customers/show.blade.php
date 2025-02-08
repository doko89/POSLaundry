@extends('layouts.app')

@section('title', 'Detail Pelanggan')

@section('content')
<div class="mb-6">
    <div class="flex justify-between items-start">
        <div>
            <h2 class="text-xl font-semibold text-gray-800">Detail Pelanggan</h2>
            <p class="mt-1 text-sm text-gray-600">Informasi lengkap dan riwayat transaksi pelanggan</p>
        </div>
        <div class="flex space-x-3">
            <x-button variant="secondary" 
                onclick="window.location.href='{{ route('worker.customers.edit', $customer) }}'">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Edit Pelanggan
            </x-button>
            <x-button variant="primary" 
                onclick="window.location.href='{{ route('worker.orders.create', ['customer_id' => $customer->id]) }}'">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                Order Baru
            </x-button>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Customer Information -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Basic Info Card -->
        <x-card>
            <div class="flex items-center space-x-4 mb-6">
                <img class="h-20 w-20 rounded-full" 
                    src="{{ $customer->avatar_url ?? 'https://ui-avatars.com/api/?name='.$customer->name }}" 
                    alt="{{ $customer->name }}">
                <div>
                    <h3 class="text-xl font-semibold text-gray-800">{{ $customer->name }}</h3>
                    <p class="text-gray-600">{{ $customer->phone }}</p>
                    <span class="px-2 py-1 text-xs rounded-full inline-block mt-2
                        {{ $customer->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $customer->status === 'active' ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-sm font-medium text-gray-500">Email</p>
                    <p class="mt-1">{{ $customer->email ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Tanggal Lahir</p>
                    <p class="mt-1">{{ $customer->birth_date?->format('d/m/Y') ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Jenis Kelamin</p>
                    <p class="mt-1">{{ $customer->gender === 'male' ? 'Laki-laki' : ($customer->gender === 'female' ? 'Perempuan' : '-') }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Bergabung Sejak</p>
                    <p class="mt-1">{{ $customer->created_at->format('d/m/Y') }}</p>
                </div>
                <div class="col-span-2">
                    <p class="text-sm font-medium text-gray-500">Alamat</p>
                    <p class="mt-1">{{ $customer->address ?? '-' }}</p>
                </div>
                @if($customer->notes)
                <div class="col-span-2">
                    <p class="text-sm font-medium text-gray-500">Catatan</p>
                    <p class="mt-1">{{ $customer->notes }}</p>
                </div>
                @endif
            </div>
        </x-card>

        <!-- Order History -->
        <x-card>
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-700">Riwayat Order</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No. Order</th>
                            <th>Tanggal</th>
                            <th>Layanan</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($customer->orders as $order)
                        <tr>
                            <td class="font-medium">{{ $order->number }}</td>
                            <td>{{ $order->created_at->format('d/m/Y') }}</td>
                            <td>{{ $order->service_name }}</td>
                            <td>Rp {{ number_format($order->total) }}</td>
                            <td>
                                <span class="px-2 py-1 text-xs rounded-full 
                                    {{ $order->status === 'completed' ? 'bg-green-100 text-green-800' : 
                                       ($order->status === 'processing' ? 'bg-yellow-100 text-yellow-800' : 'bg-blue-100 text-blue-800') }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td>
                                <x-button variant="secondary" size="sm" 
                                    onclick="window.location.href='{{ route('worker.orders.show', $order) }}'">
                                    Detail
                                </x-button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-gray-500">
                                Belum ada riwayat order
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
        <!-- Customer Stats -->
        <x-card>
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Statistik Pelanggan</h3>
            <div class="grid grid-cols-2 gap-4">
                <div class="text-center p-4 bg-gray-50 rounded-lg">
                    <p class="text-2xl font-bold text-primary-600">{{ $customer->orders_count }}</p>
                    <p class="text-sm text-gray-600">Total Order</p>
                </div>
                <div class="text-center p-4 bg-gray-50 rounded-lg">
                    <p class="text-2xl font-bold text-primary-600">Rp {{ number_format($customer->total_spent) }}</p>
                    <p class="text-sm text-gray-600">Total Pengeluaran</p>
                </div>
                <div class="text-center p-4 bg-gray-50 rounded-lg">
                    <p class="text-2xl font-bold text-primary-600">{{ $customer->completed_orders_count }}</p>
                    <p class="text-sm text-gray-600">Order Selesai</p>
                </div>
                <div class="text-center p-4 bg-gray-50 rounded-lg">
                    <p class="text-2xl font-bold text-primary-600">{{ $customer->average_order_value }}</p>
                    <p class="text-sm text-gray-600">Rata-rata Order</p>
                </div>
            </div>
        </x-card>

        <!-- Quick Actions -->
        <x-card>
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Aksi Cepat</h3>
            <div class="space-y-3">
                <x-button variant="secondary" class="w-full justify-center" 
                    onclick="window.location.href='https://wa.me/{{ $customer->phone }}'">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                    Chat WhatsApp
                </x-button>
                @if($customer->status === 'active')
                <x-button variant="danger" class="w-full justify-center" 
                    onclick="if(confirm('Nonaktifkan pelanggan ini?')) document.getElementById('deactivate-form').submit()">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                    </svg>
                    Nonaktifkan
                </x-button>
                @else
                <x-button variant="success" class="w-full justify-center" 
                    onclick="if(confirm('Aktifkan pelanggan ini?')) document.getElementById('activate-form').submit()">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Aktifkan
                </x-button>
                @endif
            </div>
        </x-card>
    </div>
</div>

<!-- Status Change Forms -->
<form id="activate-form" action="{{ route('worker.customers.activate', $customer) }}" method="POST" class="hidden">
    @csrf
    @method('PUT')
</form>
<form id="deactivate-form" action="{{ route('worker.customers.deactivate', $customer) }}" method="POST" class="hidden">
    @csrf
    @method('PUT')
</form>
@endsection 