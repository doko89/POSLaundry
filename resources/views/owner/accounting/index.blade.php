@extends('layouts.app')

@section('title', 'Pembukuan')

@section('content')
<div class="mb-6">
    <div class="flex justify-between items-start">
        <div>
            <h2 class="text-xl font-semibold text-gray-800">Pembukuan</h2>
            <p class="mt-1 text-sm text-gray-600">Kelola pemasukan dan pengeluaran kios Anda</p>
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
    <form action="{{ route('owner.accounting.index') }}" method="GET">
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
            <div class="flex-shrink-0 p-3 bg-green-100 rounded-lg">
                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-500">Total Pemasukan</p>
                <h3 class="text-xl font-bold text-gray-900">Rp {{ number_format($totalIncome) }}</h3>
            </div>
        </div>
    </x-card>

    <x-card>
        <div class="flex items-center">
            <div class="flex-shrink-0 p-3 bg-red-100 rounded-lg">
                <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-500">Total Pengeluaran</p>
                <h3 class="text-xl font-bold text-gray-900">Rp {{ number_format($totalExpense) }}</h3>
            </div>
        </div>
    </x-card>

    <x-card>
        <div class="flex items-center">
            <div class="flex-shrink-0 p-3 bg-primary-100 rounded-lg">
                <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-500">Laba Bersih</p>
                <h3 class="text-xl font-bold text-gray-900">Rp {{ number_format($netProfit) }}</h3>
            </div>
        </div>
    </x-card>

    <x-card>
        <div class="flex items-center">
            <div class="flex-shrink-0 p-3 bg-yellow-100 rounded-lg">
                <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v4m-6-4v4m6-11v-4m-6 4v-4"/>
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-500">Saldo Kas</p>
                <h3 class="text-xl font-bold text-gray-900">Rp {{ number_format($cashBalance) }}</h3>
            </div>
        </div>
    </x-card>
</div>

<!-- Transaction History -->
<x-card>
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-semibold text-gray-700">Riwayat Transaksi</h3>
        <x-button variant="primary" onclick="window.location.href='{{ route('owner.accounting.create') }}'">
            Tambah Transaksi
        </x-button>
    </div>

    <div class="overflow-x-auto">
        <table class="table">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Keterangan</th>
                    <th>Kategori</th>
                    <th>Tipe</th>
                    <th>Jumlah</th>
                    <th>Saldo</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($transactions as $transaction)
                <tr>
                    <td>{{ $transaction->date->format('d/m/Y') }}</td>
                    <td>{{ $transaction->description }}</td>
                    <td>{{ $transaction->category }}</td>
                    <td>
                        <span class="px-2 py-1 text-xs rounded-full 
                            {{ $transaction->type === 'income' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $transaction->type === 'income' ? 'Pemasukan' : 'Pengeluaran' }}
                        </span>
                    </td>
                    <td class="{{ $transaction->type === 'income' ? 'text-green-600' : 'text-red-600' }}">
                        Rp {{ number_format($transaction->amount) }}
                    </td>
                    <td>Rp {{ number_format($transaction->balance) }}</td>
                    <td class="space-x-2">
                        <x-button variant="secondary" size="sm" 
                            onclick="window.location.href='{{ route('owner.accounting.edit', $transaction) }}'">
                            Edit
                        </x-button>
                        <x-button variant="danger" size="sm" 
                            onclick="if(confirm('Apakah Anda yakin ingin menghapus transaksi ini?')) document.getElementById('delete-form-{{ $transaction->id }}').submit()">
                            Hapus
                        </x-button>
                        <form id="delete-form-{{ $transaction->id }}" 
                            action="{{ route('owner.accounting.destroy', $transaction) }}" 
                            method="POST" class="hidden">
                            @csrf
                            @method('DELETE')
                        </form>
                    </td>
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

@push('scripts')
<script>
    // Toggle custom date inputs
    document.querySelector('select[name="period"]').addEventListener('change', function(e) {
        const customDateInputs = document.querySelectorAll('.custom-date');
        customDateInputs.forEach(input => {
            input.classList.toggle('hidden', e.target.value !== 'custom');
        });
    });

    // Print Report
    function printReport() {
        window.print();
    }

    // Export Excel
    function exportExcel() {
        window.location.href = '{{ route("owner.accounting.export") }}' + window.location.search;
    }
</script>
@endpush
@endsection 