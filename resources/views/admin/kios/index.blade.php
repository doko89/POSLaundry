@extends('layouts.app')

@section('title', 'Manajemen Kios')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h2 class="text-xl font-semibold text-gray-800">Daftar Kios</h2>
        <p class="mt-1 text-sm text-gray-600">Kelola semua kios yang terdaftar</p>
    </div>
    <a href="{{ route('admin.kios.create') }}" class="inline-flex items-center">
        <x-button variant="primary">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
            Tambah Kios Baru
        </x-button>
    </a>
</div>

<!-- Filter Section -->
<x-card class="mb-6">
    <form action="{{ route('admin.kios.index') }}" method="GET">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="form-label">Cari</label>
                <input type="text" name="search" class="form-input" placeholder="Nama kios atau pemilik..." value="{{ request('search') }}">
            </div>
            <div>
                <label class="form-label">Status</label>
                <select name="status" class="form-input">
                    <option value="">Semua Status</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif</option>
                    <option value="suspended" {{ request('status') === 'suspended' ? 'selected' : '' }}>Suspend</option>
                    <option value="expired" {{ request('status') === 'expired' ? 'selected' : '' }}>Expired</option>
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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    Filter
                </x-button>
            </div>
        </div>
    </form>
</x-card>

<!-- Kios Table -->
<x-card>
    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th>Nama Kios</th>
                    <th>Pemilik</th>
                    <th>Status</th>
                    <th>Expired Date</th>
                    <th>WhatsApp</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($kiosks as $kiosk)
                <tr>
                    <td class="font-medium">{{ $kiosk->name }}</td>
                    <td>{{ $kiosk->owner->name }}</td>
                    <td>
                        <span class="px-2 py-1 text-xs rounded-full 
                            {{ $kiosk->status === 'active' ? 'bg-green-100 text-green-800' : 
                               ($kiosk->status === 'expired' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                            {{ ucfirst($kiosk->status) }}
                        </span>
                    </td>
                    <td>
                        {{ $kiosk->expired_date->format('d/m/Y') }}
                        @if($kiosk->isExpiringSoon())
                            <span class="ml-2 text-xs text-red-600">
                                ({{ $kiosk->daysUntilExpired() }} hari lagi)
                            </span>
                        @endif
                    </td>
                    <td>
                        @if($kiosk->whatsapp_number)
                            <span class="text-green-600">
                                <svg class="w-5 h-5 inline-block" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                                </svg>
                                Terverifikasi
                            </span>
                        @else
                            <x-button variant="secondary" size="sm">
                                Scan QR
                            </x-button>
                        @endif
                    </td>
                    <td class="space-x-2">
                        <x-button variant="secondary" size="sm" 
                            onclick="window.location.href='{{ route('admin.kios.edit', $kiosk) }}'">
                            Edit
                        </x-button>
                        <x-button variant="danger" size="sm" 
                            onclick="if(confirm('Apakah Anda yakin ingin menghapus kios ini?')) document.getElementById('delete-form-{{ $kiosk->id }}').submit()">
                            Hapus
                        </x-button>
                        <form id="delete-form-{{ $kiosk->id }}" 
                            action="{{ route('admin.kios.destroy', $kiosk) }}" 
                            method="POST" class="hidden">
                            @csrf
                            @method('DELETE')
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-4 text-gray-500">
                        Tidak ada data kios yang ditemukan
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $kiosks->links() }}
    </div>
</x-card>
@endsection 