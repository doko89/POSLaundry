@extends('layouts.app')

@section('title', 'Manajemen Pelanggan')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h2 class="text-xl font-semibold text-gray-800">Daftar Pelanggan</h2>
        <p class="mt-1 text-sm text-gray-600">Kelola data pelanggan kios</p>
    </div>
    <a href="{{ route('worker.customers.create') }}" class="inline-flex items-center">
        <x-button variant="primary">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
            Tambah Pelanggan
        </x-button>
    </a>
</div>

<!-- Filter Section -->
<x-card class="mb-6">
    <form action="{{ route('worker.customers.index') }}" method="GET">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="form-label">Cari</label>
                <input type="text" name="search" class="form-input" 
                    placeholder="Nama atau nomor HP..." value="{{ request('search') }}">
            </div>
            <div>
                <label class="form-label">Status</label>
                <select name="status" class="form-input">
                    <option value="">Semua Status</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>
            <div>
                <label class="form-label">Urutkan</label>
                <select name="sort" class="form-input">
                    <option value="newest" {{ request('sort') === 'newest' ? 'selected' : '' }}>Terbaru</option>
                    <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>Terlama</option>
                    <option value="name_asc" {{ request('sort') === 'name_asc' ? 'selected' : '' }}>Nama A-Z</option>
                    <option value="name_desc" {{ request('sort') === 'name_desc' ? 'selected' : '' }}>Nama Z-A</option>
                    <option value="orders_desc" {{ request('sort') === 'orders_desc' ? 'selected' : '' }}>Order Terbanyak</option>
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

<!-- Customers Table -->
<x-card>
    <div class="overflow-x-auto">
        <table class="table">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>No. HP</th>
                    <th>Alamat</th>
                    <th>Total Order</th>
                    <th>Order Terakhir</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($customers as $customer)
                <tr>
                    <td class="font-medium">
                        <div class="flex items-center">
                            <img class="h-8 w-8 rounded-full mr-3" 
                                src="{{ $customer->avatar_url ?? 'https://ui-avatars.com/api/?name='.$customer->name }}" 
                                alt="{{ $customer->name }}">
                            {{ $customer->name }}
                        </div>
                    </td>
                    <td>{{ $customer->phone }}</td>
                    <td class="max-w-xs truncate">{{ $customer->address }}</td>
                    <td class="text-center">{{ $customer->orders_count }}</td>
                    <td>{{ $customer->last_order_at?->format('d/m/Y') ?? '-' }}</td>
                    <td>
                        <span class="px-2 py-1 text-xs rounded-full 
                            {{ $customer->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $customer->status === 'active' ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </td>
                    <td class="space-x-2">
                        <x-button variant="secondary" size="sm" 
                            onclick="window.location.href='{{ route('worker.customers.show', $customer) }}'">
                            Detail
                        </x-button>
                        <x-button variant="primary" size="sm" 
                            onclick="window.location.href='{{ route('worker.customers.edit', $customer) }}'">
                            Edit
                        </x-button>
                        <x-button variant="danger" size="sm" 
                            onclick="if(confirm('Apakah Anda yakin ingin menghapus pelanggan ini?')) document.getElementById('delete-form-{{ $customer->id }}').submit()">
                            Hapus
                        </x-button>
                        <form id="delete-form-{{ $customer->id }}" 
                            action="{{ route('worker.customers.destroy', $customer) }}" 
                            method="POST" class="hidden">
                            @csrf
                            @method('DELETE')
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-4 text-gray-500">
                        Tidak ada data pelanggan yang ditemukan
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $customers->links() }}
    </div>
</x-card>

<!-- Quick Add Customer Modal -->
<div id="quickAddModal" class="modal hidden">
    <div class="modal-content">
        <h3 class="text-lg font-semibold text-gray-700 mb-4">Tambah Pelanggan Cepat</h3>
        <form action="{{ route('worker.customers.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="form-label">Nama Lengkap</label>
                <input type="text" name="name" class="form-input" required>
            </div>
            <div>
                <label class="form-label">Nomor HP</label>
                <input type="text" name="phone" class="form-input" required>
            </div>
            <div>
                <label class="form-label">Alamat</label>
                <textarea name="address" class="form-input" rows="2"></textarea>
            </div>
            <div class="flex justify-end space-x-3">
                <x-button type="button" variant="secondary" onclick="closeQuickAdd()">
                    Batal
                </x-button>
                <x-button type="submit" variant="primary">
                    Simpan
                </x-button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function openQuickAdd() {
        document.getElementById('quickAddModal').classList.remove('hidden');
    }

    function closeQuickAdd() {
        document.getElementById('quickAddModal').classList.add('hidden');
    }
</script>
@endpush
@endsection 