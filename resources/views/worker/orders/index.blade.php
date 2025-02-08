@extends('layouts.app')

@section('title', 'Manajemen Order')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h2 class="text-xl font-semibold text-gray-800">Daftar Order</h2>
        <p class="mt-1 text-sm text-gray-600">Kelola semua order laundry</p>
    </div>
    <a href="{{ route('worker.orders.create') }}" class="inline-flex items-center">
        <x-button variant="primary">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
            Order Baru
        </x-button>
    </a>
</div>

<!-- Filter Section -->
<x-card class="mb-6">
    <form action="{{ route('worker.orders.index') }}" method="GET">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="form-label">Cari</label>
                <input type="text" name="search" class="form-input" 
                    placeholder="No. Order atau nama pelanggan..." value="{{ request('search') }}">
            </div>
            <div>
                <label class="form-label">Status</label>
                <select name="status" class="form-input">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="processing" {{ request('status') === 'processing' ? 'selected' : '' }}>Diproses</option>
                    <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Selesai</option>
                    <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                </select>
            </div>
            <div>
                <label class="form-label">Urutkan</label>
                <select name="sort" class="form-input">
                    <option value="newest" {{ request('sort') === 'newest' ? 'selected' : '' }}>Terbaru</option>
                    <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>Terlama</option>
                    <option value="total_asc" {{ request('sort') === 'total_asc' ? 'selected' : '' }}>Total Terendah</option>
                    <option value="total_desc" {{ request('sort') === 'total_desc' ? 'selected' : '' }}>Total Tertinggi</option>
                </select>
            </div>
            <div class="flex items-end">
                <x-button type="submit" variant="primary" class="w-full">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    Filter
                </x-button>
            </div>
        </div>
    </form>
</x-card>

<!-- Orders Table -->
<x-card>
    <div class="overflow-x-auto">
        <table class="table">
            <thead>
                <tr>
                    <th>No. Order</th>
                    <th>Tanggal</th>
                    <th>Pelanggan</th>
                    <th>Layanan</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($orders as $order)
                <tr>
                    <td class="font-medium">{{ $order->number }}</td>
                    <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        <div class="flex items-center">
                            <img class="h-8 w-8 rounded-full mr-3" 
                                src="{{ $order->customer->avatar_url ?? 'https://ui-avatars.com/api/?name='.$order->customer->name }}" 
                                alt="{{ $order->customer->name }}">
                            {{ $order->customer->name }}
                        </div>
                    </td>
                    <td>{{ $order->service->name }}</td>
                    <td>Rp {{ number_format($order->total) }}</td>
                    <td>
                        <span class="px-2 py-1 text-xs rounded-full 
                            {{ $order->status === 'completed' ? 'bg-green-100 text-green-800' : 
                               ($order->status === 'processing' ? 'bg-yellow-100 text-yellow-800' : 
                               ($order->status === 'cancelled' ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800')) }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>
                    <td class="space-x-2">
                        <x-button variant="secondary" size="sm" 
                            onclick="window.location.href='{{ route('worker.orders.show', $order) }}'">
                            Detail
                        </x-button>
                        @if($order->status === 'pending')
                        <x-button variant="primary" size="sm" 
                            onclick="if(confirm('Mulai proses order ini?')) document.getElementById('process-form-{{ $order->id }}').submit()">
                            Proses
                        </x-button>
                        @elseif($order->status === 'processing')
                        <x-button variant="success" size="sm" 
                            onclick="if(confirm('Selesaikan order ini?')) document.getElementById('complete-form-{{ $order->id }}').submit()">
                            Selesai
                        </x-button>
                        @endif
                        @if($order->status !== 'completed' && $order->status !== 'cancelled')
                        <x-button variant="danger" size="sm" 
                            onclick="if(confirm('Batalkan order ini?')) document.getElementById('cancel-form-{{ $order->id }}').submit()">
                            Batal
                        </x-button>
                        @endif
                        <form id="process-form-{{ $order->id }}" 
                            action="{{ route('worker.orders.process', $order) }}" 
                            method="POST" class="hidden">
                            @csrf
                            @method('PUT')
                        </form>
                        <form id="complete-form-{{ $order->id }}" 
                            action="{{ route('worker.orders.complete', $order) }}" 
                            method="POST" class="hidden">
                            @csrf
                            @method('PUT')
                        </form>
                        <form id="cancel-form-{{ $order->id }}" 
                            action="{{ route('worker.orders.cancel', $order) }}" 
                            method="POST" class="hidden">
                            @csrf
                            @method('PUT')
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-4 text-gray-500">
                        Tidak ada order yang ditemukan
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $orders->links() }}
    </div>
</x-card>
@endsection 