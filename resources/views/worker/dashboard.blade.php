@extends('layouts.app')

@section('title', 'Dashboard Worker')

@section('content')
<div class="mb-6">
    <h2 class="text-xl font-semibold text-gray-800">Dashboard</h2>
    <p class="mt-1 text-sm text-gray-600">Ringkasan aktivitas dan kinerja Anda</p>
</div>

<!-- Stats Overview -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
    <x-card>
        <div class="flex items-center">
            <div class="flex-shrink-0 p-3 bg-primary-100 rounded-lg">
                <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-500">Order Hari Ini</p>
                <h3 class="text-xl font-bold text-gray-900">{{ $todayOrders }}</h3>
                <p class="text-sm text-{{ $ordersChange >= 0 ? 'green' : 'red' }}-600">
                    {{ $ordersChange >= 0 ? '+' : '' }}{{ $ordersChange }}% dari kemarin
                </p>
            </div>
        </div>
    </x-card>

    <x-card>
        <div class="flex items-center">
            <div class="flex-shrink-0 p-3 bg-yellow-100 rounded-lg">
                <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-500">Dalam Proses</p>
                <h3 class="text-xl font-bold text-gray-900">{{ $processingOrders }}</h3>
                <p class="text-sm text-gray-600">Order belum selesai</p>
            </div>
        </div>
    </x-card>

    <x-card>
        <div class="flex items-center">
            <div class="flex-shrink-0 p-3 bg-green-100 rounded-lg">
                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-500">Selesai Hari Ini</p>
                <h3 class="text-xl font-bold text-gray-900">{{ $completedToday }}</h3>
                <p class="text-sm text-gray-600">Order selesai</p>
            </div>
        </div>
    </x-card>

    <x-card>
        <div class="flex items-center">
            <div class="flex-shrink-0 p-3 bg-blue-100 rounded-lg">
                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-500">Pelanggan Baru</p>
                <h3 class="text-xl font-bold text-gray-900">{{ $newCustomers }}</h3>
                <p class="text-sm text-gray-600">Hari ini</p>
            </div>
        </div>
    </x-card>
</div>

<!-- Recent Orders & Tasks -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    <!-- Recent Orders -->
    <x-card>
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-700">Order Terbaru</h3>
            <a href="{{ route('worker.orders.index') }}" class="text-sm text-primary-600 hover:text-primary-700">
                Lihat Semua
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="table">
                <thead>
                    <tr>
                        <th>No. Order</th>
                        <th>Pelanggan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($recentOrders as $order)
                    <tr>
                        <td class="font-medium">{{ $order->number }}</td>
                        <td>{{ $order->customer_name }}</td>
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
                        <td colspan="4" class="text-center py-4 text-gray-500">
                            Tidak ada order terbaru
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </x-card>

    <!-- Tasks -->
    <x-card>
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-700">Tugas Hari Ini</h3>
            <span class="px-2 py-1 text-xs rounded-full bg-primary-100 text-primary-800">
                {{ $pendingTasks }} Tugas
            </span>
        </div>
        <div class="space-y-4">
            @forelse($tasks as $task)
            <div class="flex items-start space-x-4">
                <div class="flex-shrink-0">
                    <span class="inline-flex items-center justify-center h-8 w-8 rounded-full 
                        {{ $task->priority === 'high' ? 'bg-red-100' : 
                           ($task->priority === 'medium' ? 'bg-yellow-100' : 'bg-blue-100') }}">
                        <svg class="h-5 w-5 
                            {{ $task->priority === 'high' ? 'text-red-600' : 
                               ($task->priority === 'medium' ? 'text-yellow-600' : 'text-blue-600') }}" 
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </span>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-medium text-gray-900">{{ $task->description }}</p>
                    <p class="text-sm text-gray-500">{{ $task->due_time->format('H:i') }}</p>
                </div>
                <div>
                    <x-button variant="secondary" size="sm" 
                        onclick="markAsComplete({{ $task->id }})">
                        Selesai
                    </x-button>
                </div>
            </div>
            @empty
            <div class="text-center py-4 text-gray-500">
                Tidak ada tugas untuk hari ini
            </div>
            @endforelse
        </div>
    </x-card>
</div>

<!-- Performance Chart -->
<x-card>
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-semibold text-gray-700">Grafik Kinerja</h3>
        <select class="form-input w-32" id="performance-period">
            <option value="week">7 Hari</option>
            <option value="month">30 Hari</option>
        </select>
    </div>
    <div class="h-80">
        <canvas id="performanceChart"></canvas>
    </div>
</x-card>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Performance Chart
    const ctx = document.getElementById('performanceChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($performanceChart['labels']),
            datasets: [{
                label: 'Order Selesai',
                data: @json($performanceChart['data']),
                borderColor: '#4CAF50',
                backgroundColor: 'rgba(76, 175, 80, 0.1)',
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });

    // Mark task as complete
    function markAsComplete(taskId) {
        if (confirm('Tandai tugas ini sebagai selesai?')) {
            fetch(`/worker/tasks/${taskId}/complete`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            }).then(response => {
                if (response.ok) {
                    window.location.reload();
                }
            });
        }
    }
</script>
@endpush
@endsection 