@extends('layouts.app')

@section('title', 'Dashboard Owner')

@section('content')
<!-- Stats Overview -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
    <x-card>
        <div class="flex items-center">
            <div class="flex-shrink-0 p-3 bg-primary-100 rounded-lg">
                <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-500">Pendapatan Hari Ini</p>
                <h3 class="text-xl font-bold text-gray-900">Rp {{ number_format($todayIncome) }}</h3>
                <p class="text-sm text-{{ $incomeChange >= 0 ? 'green' : 'red' }}-600">
                    {{ $incomeChange >= 0 ? '+' : '' }}{{ $incomeChange }}% dari kemarin
                </p>
            </div>
        </div>
    </x-card>

    <x-card>
        <div class="flex items-center">
            <div class="flex-shrink-0 p-3 bg-blue-100 rounded-lg">
                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                <p class="text-sm font-medium text-gray-500">Siap Diambil</p>
                <h3 class="text-xl font-bold text-gray-900">{{ $readyOrders }}</h3>
                <p class="text-sm text-gray-600">Order selesai</p>
            </div>
        </div>
    </x-card>
</div>

<!-- Charts & Recent Orders -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    <!-- Income Chart -->
    <x-card>
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-700">Grafik Pendapatan</h3>
            <select class="form-input w-32" id="income-period">
                <option value="week">7 Hari</option>
                <option value="month">30 Hari</option>
            </select>
        </div>
        <div class="h-80">
            <canvas id="incomeChart"></canvas>
        </div>
    </x-card>

    <!-- Orders Chart -->
    <x-card>
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-700">Grafik Order</h3>
            <select class="form-input w-32" id="orders-period">
                <option value="week">7 Hari</option>
                <option value="month">30 Hari</option>
            </select>
        </div>
        <div class="h-80">
            <canvas id="ordersChart"></canvas>
        </div>
    </x-card>
</div>

<!-- Recent Orders & Top Services -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Recent Orders -->
    <x-card>
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-700">Order Terbaru</h3>
            <a href="{{ route('owner.orders.index') }}" class="text-sm text-primary-600 hover:text-primary-700">
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

    <!-- Top Services -->
    <x-card>
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-700">Layanan Terpopuler</h3>
            <a href="{{ route('owner.services.index') }}" class="text-sm text-primary-600 hover:text-primary-700">
                Kelola Layanan
            </a>
        </div>
        <div class="space-y-4">
            @foreach($topServices as $service)
            <div class="flex items-center">
                <div class="flex-1">
                    <h4 class="text-sm font-medium text-gray-900">{{ $service->name }}</h4>
                    <p class="text-sm text-gray-500">{{ $service->orders_count }} order</p>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-900">Rp {{ number_format($service->total_income) }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </x-card>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Income Chart
    const incomeCtx = document.getElementById('incomeChart').getContext('2d');
    const incomeChart = new Chart(incomeCtx, {
        type: 'line',
        data: {
            labels: @json($incomeChart['labels']),
            datasets: [{
                label: 'Pendapatan',
                data: @json($incomeChart['data']),
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
                        callback: function(value) {
                            return 'Rp ' + value.toLocaleString('id-ID');
                        }
                    }
                }
            }
        }
    });

    // Orders Chart
    const ordersCtx = document.getElementById('ordersChart').getContext('2d');
    const ordersChart = new Chart(ordersCtx, {
        type: 'bar',
        data: {
            labels: @json($ordersChart['labels']),
            datasets: [{
                label: 'Jumlah Order',
                data: @json($ordersChart['data']),
                backgroundColor: '#2196F3'
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

    // Handle period changes
    document.getElementById('income-period').addEventListener('change', function(e) {
        // Update income chart data based on selected period
    });

    document.getElementById('orders-period').addEventListener('change', function(e) {
        // Update orders chart data based on selected period
    });
</script>
@endpush
@endsection 