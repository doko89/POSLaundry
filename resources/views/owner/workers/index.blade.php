@extends('layouts.app')

@section('title', 'Manajemen Pekerja')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h2 class="text-xl font-semibold text-gray-800">Daftar Pekerja</h2>
        <p class="mt-1 text-sm text-gray-600">Kelola pekerja di kios Anda</p>
    </div>
    <a href="{{ route('owner.workers.create') }}" class="inline-flex items-center">
        <x-button variant="primary">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
            Tambah Pekerja
        </x-button>
    </a>
</div>

<!-- Filter Section -->
<x-card class="mb-6">
    <form action="{{ route('owner.workers.index') }}" method="GET">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="form-label">Cari</label>
                <input type="text" name="search" class="form-input" 
                    placeholder="Nama atau email..." value="{{ request('search') }}">
            </div>
            <div>
                <label class="form-label">Status</label>
                <select name="status" class="form-input">
                    <option value="">Semua Status</option>
                    <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>
            <div>
                <label class="form-label">Urutkan</label>
                <select name="sort" class="form-input">
                    <option value="newest" {{ request('sort') === 'newest' ? 'selected' : '' }}>Terbaru</option>
                    <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>Terlama</option>
                    <option value="name_asc" {{ request('sort') === 'name_asc' ? 'selected' : '' }}>Nama A-Z</option>
                    <option value="name_desc" {{ request('sort') === 'name_desc' ? 'selected' : '' }}>Nama Z-A</option>
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

<!-- Workers Table -->
<x-card>
    <div class="overflow-x-auto">
        <table class="table">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>No. HP</th>
                    <th>Status</th>
                    <th>Order Selesai</th>
                    <th>Bergabung</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($workers as $worker)
                <tr>
                    <td class="font-medium">
                        <div class="flex items-center">
                            <img class="h-8 w-8 rounded-full mr-3" 
                                src="{{ $worker->avatar_url ?? 'https://ui-avatars.com/api/?name='.$worker->name }}" 
                                alt="{{ $worker->name }}">
                            {{ $worker->name }}
                        </div>
                    </td>
                    <td>{{ $worker->email }}</td>
                    <td>{{ $worker->phone }}</td>
                    <td>
                        <span class="px-2 py-1 text-xs rounded-full 
                            {{ $worker->status ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $worker->status ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </td>
                    <td class="text-center">{{ $worker->completed_orders_count }}</td>
                    <td>{{ $worker->created_at->format('d/m/Y') }}</td>
                    <td class="space-x-2">
                        <x-button variant="secondary" size="sm" 
                            onclick="window.location.href='{{ route('owner.workers.show', $worker) }}'">
                            Detail
                        </x-button>
                        <x-button variant="primary" size="sm" 
                            onclick="window.location.href='{{ route('owner.workers.edit', $worker) }}'">
                            Edit
                        </x-button>
                        <x-button variant="danger" size="sm" 
                            onclick="if(confirm('Apakah Anda yakin ingin menghapus pekerja ini?')) document.getElementById('delete-form-{{ $worker->id }}').submit()">
                            Hapus
                        </x-button>
                        <form id="delete-form-{{ $worker->id }}" 
                            action="{{ route('owner.workers.destroy', $worker) }}" 
                            method="POST" class="hidden">
                            @csrf
                            @method('DELETE')
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-4 text-gray-500">
                        Tidak ada data pekerja yang ditemukan
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $workers->links() }}
    </div>
</x-card>
@endsection 