@extends('layouts.app')

@section('title', 'Manajemen Layanan')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h2 class="text-xl font-semibold text-gray-800">Daftar Layanan</h2>
        <p class="mt-1 text-sm text-gray-600">Kelola layanan yang tersedia di kios Anda</p>
    </div>
    <a href="{{ route('owner.services.create') }}" class="inline-flex items-center">
        <x-button variant="primary">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
            Tambah Layanan
        </x-button>
    </a>
</div>

<!-- Filter Section -->
<x-card class="mb-6">
    <form action="{{ route('owner.services.index') }}" method="GET">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="form-label">Cari</label>
                <input type="text" name="search" class="form-input" 
                    placeholder="Nama layanan..." value="{{ request('search') }}">
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
                    <option value="name_asc" {{ request('sort') === 'name_asc' ? 'selected' : '' }}>Nama A-Z</option>
                    <option value="name_desc" {{ request('sort') === 'name_desc' ? 'selected' : '' }}>Nama Z-A</option>
                    <option value="price_asc" {{ request('sort') === 'price_asc' ? 'selected' : '' }}>Harga Terendah</option>
                    <option value="price_desc" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>Harga Tertinggi</option>
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

<!-- Services Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($services as $service)
    <x-card>
        <div class="flex justify-between items-start">
            <div>
                <h3 class="text-lg font-semibold text-gray-800">{{ $service->name }}</h3>
                <p class="mt-1 text-sm text-gray-600">{{ $service->description }}</p>
            </div>
            <span class="px-2 py-1 text-xs rounded-full 
                {{ $service->status ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                {{ $service->status ? 'Aktif' : 'Nonaktif' }}
            </span>
        </div>

        <div class="mt-4">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-sm font-medium text-gray-500">Harga</p>
                    <p class="mt-1 text-lg font-semibold text-gray-900">Rp {{ number_format($service->price) }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Durasi</p>
                    <p class="mt-1">{{ $service->duration }} Jam</p>
                </div>
            </div>
        </div>

        <div class="mt-4 pt-4 border-t border-gray-200">
            <div class="flex justify-end space-x-3">
                <x-button variant="secondary" size="sm" 
                    onclick="window.location.href='{{ route('owner.services.edit', $service) }}'">
                    Edit
                </x-button>
                <x-button variant="danger" size="sm" 
                    onclick="if(confirm('Apakah Anda yakin ingin menghapus layanan ini?')) document.getElementById('delete-form-{{ $service->id }}').submit()">
                    Hapus
                </x-button>
                <form id="delete-form-{{ $service->id }}" 
                    action="{{ route('owner.services.destroy', $service) }}" 
                    method="POST" class="hidden">
                    @csrf
                    @method('DELETE')
                </form>
            </div>
        </div>
    </x-card>
    @empty
    <div class="col-span-full">
        <x-card>
            <div class="text-center py-4 text-gray-500">
                Tidak ada layanan yang ditemukan
            </div>
        </x-card>
    </div>
    @endforelse
</div>

<!-- Pagination -->
<div class="mt-6">
    {{ $services->links() }}
</div>
@endsection 