@extends('layouts.app')

@section('title', 'Laporan Keuangan')

@push('styles')
<style>
    @media print {
        /* Hide elements that shouldn't be printed */
        .no-print,
        nav,
        header,
        footer,
        .sidebar,
        button,
        .filters,
        .pagination {
            display: none !important;
        }

        /* Reset background colors and shadows */
        body {
            background: white;
            padding: 0;
            margin: 0;
        }

        .card {
            box-shadow: none !important;
            border: 1px solid #eee;
            break-inside: avoid;
        }

        /* Ensure content fits on paper */
        .container {
            max-width: 100% !important;
            width: 100% !important;
            margin: 0 !important;
            padding: 20px !important;
        }

        /* Add report header for print */
        .print-header {
            text-align: center;
            margin-bottom: 20px;
            display: block !important;
        }

        .print-header h1 {
            font-size: 24px;
            margin-bottom: 5px;
        }

        .print-header p {
            font-size: 14px;
            color: #666;
        }

        /* Adjust table for printing */
        table {
            width: 100% !important;
            border-collapse: collapse !important;
        }

        th, td {
            border: 1px solid #ddd !important;
            padding: 8px !important;
        }

        /* Force page breaks where needed */
        .page-break {
            page-break-before: always;
        }

        /* Show full amounts */
        .truncate {
            text-overflow: clip !important;
            overflow: visible !important;
            white-space: normal !important;
        }
    }
</style>
@endpush

@section('content')
<div class="mb-6">
    <div class="flex justify-between items-start">
        <div>
            <h2 class="text-xl font-semibold text-gray-800">Laporan Keuangan</h2>
            <p class="mt-1 text-sm text-gray-600">Ringkasan dan detail keuangan kios Anda</p>
        </div>
        <div class="flex space-x-3">
            <x-button variant="secondary" onclick="printReport()">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                </svg>
                Cetak Laporan
            </x-button>
            <x-button variant="primary" onclick="exportExcel()">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Export Excel
            </x-button>
        </div>
    </div>
</div>

<!-- Filter Section -->
<x-card class="mb-6">
    <form action="{{ route('owner.reports.index') }}" method="GET">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="form-label">Periode</label>
                <select name="period" class="form-input" onchange="this.form.submit()">
                    <option value="today" {{ request('period') === 'today' ? 'selected' : '' }}>Hari Ini</option>
                    <option value="week" {{ request('period') === 'week' ? 'selected' : '' }}>Minggu Ini</option>
                    <option value="month" {{ request('period') === 'month' ? 'selected' : '' }}>Bulan Ini</option>
                    <option value="year" {{ request('period') === 'year' ? 'selected' : '' }}>Tahun Ini</option>
                    <option value="custom" {{ request('period') === 'custom' ? 'selected' : '' }}>Kustom</option>
                </select>
            </div>
            <div class="custom-date {{ request('period') === 'custom' ? '' : 'hidden' }}">
                <label class="form-label">Tanggal Mulai</label>
                <input type="date" name="start_date" class="form-input" 
                    value="{{ request('start_date') }}">
            </div>
            <div class="custom-date {{ request('period') === 'custom' ? '' : 'hidden' }}">
                <label class="form-label">Tanggal Akhir</label>
                <input type="date" name="end_date" class="form-input" 
                    value="{{ request('end_date') }}">
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

<!-- Summary Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
    <x-card>
        <div class="flex items-center">
            <div class="flex-shrink-0 p-3 bg-primary-100 rounded-lg">
                <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-500">Total Pendapatan</p>
                <h3 class="text-xl font-bold text-gray-900">Rp {{ number_format($totalIncome) }}</h3>
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
                <p class="text-sm font-medium text-gray-500">Total Order</p>
                <h3 class="text-xl font-bold text-gray-900">{{ $totalOrders }}</h3>
            </div>
        </div>
    </x-card>

    <x-card>
        <div class="flex items-center">
            <div class="flex-shrink-0 p-3 bg-green-100 rounded-lg">
                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-500">Rata-rata Order</p>
                <h3 class="text-xl font-bold text-gray-900">Rp {{ number_format($averageOrderValue) }}</h3>
            </div>
        </div>
    </x-card>

    <x-card>
        <div class="flex items-center">
            <div class="flex-shrink-0 p-3 bg-yellow-100 rounded-lg">
                <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-500">Pelanggan Baru</p>
                <h3 class="text-xl font-bold text-gray-900">{{ $newCustomers }}</h3>
            </div>
        </div>
    </x-card>
</div>

<!-- Charts -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    <!-- Income Chart -->
    <x-card>
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-700">Grafik Pendapatan</h3>
        </div>
        <div class="h-80">
            <canvas id="incomeChart"></canvas>
        </div>
    </x-card>

    <!-- Orders Chart -->
    <x-card>
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-700">Grafik Order</h3>
        </div>
        <div class="h-80">
            <canvas id="ordersChart"></canvas>
        </div>
    </x-card>
</div>

<!-- Transactions Table -->
<x-card>
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-semibold text-gray-700">Riwayat Transaksi</h3>
    </div>
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
                    <th>Pekerja</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($transactions as $transaction)
                <tr>
                    <td class="font-medium">{{ $transaction->number }}</td>
                    <td>{{ $transaction->created_at->format('d/m/Y') }}</td>
                    <td>{{ $transaction->customer_name }}</td>
                    <td>{{ $transaction->service_name }}</td>
                    <td>Rp {{ number_format($transaction->total) }}</td>
                    <td>
                        <span class="px-2 py-1 text-xs rounded-full 
                            {{ $transaction->status === 'completed' ? 'bg-green-100 text-green-800' : 
                               ($transaction->status === 'processing' ? 'bg-yellow-100 text-yellow-800' : 'bg-blue-100 text-blue-800') }}">
                            {{ ucfirst($transaction->status) }}
                        </span>
                    </td>
                    <td>{{ $transaction->worker_name }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-4 text-gray-500">
                        Tidak ada transaksi yang ditemukan
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $transactions->links() }}
    </div>
</x-card>

<!-- Tambahkan print header yang hanya muncul saat print -->
<div class="print-header hidden">
    <h1>{{ config('app.name') }}</h1>
    <p>Laporan Keuangan</p>
    <p>Periode: {{ $period }}</p>
    <p>Dicetak pada: {{ now()->format('d/m/Y H:i') }}</p>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Toggle custom date inputs
    document.querySelector('select[name="period"]').addEventListener('change', function(e) {
        const customDateInputs = document.querySelectorAll('.custom-date');
        customDateInputs.forEach(input => {
            input.classList.toggle('hidden', e.target.value !== 'custom');
        });
    });

    // Income Chart
    const incomeCtx = document.getElementById('incomeChart').getContext('2d');
    new Chart(incomeCtx, {
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
    new Chart(ordersCtx, {
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

    // Print Report
    function printReport() {
        window.print();
    }

    // Export Excel
    function exportExcel() {
        window.location.href = '{{ route("owner.reports.export") }}' + window.location.search;
    }
</script>
@endpush
@endsection 