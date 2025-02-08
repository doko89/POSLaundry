@extends('layouts.app')

@section('title', 'Manajemen Pengguna')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h2 class="text-xl font-semibold text-gray-800">Daftar Pengguna</h2>
        <p class="mt-1 text-sm text-gray-600">Kelola semua pengguna sistem</p>
    </div>
    <a href="{{ route('admin.users.create') }}" class="inline-flex items-center">
        <x-button variant="primary">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
            Tambah Pengguna
        </x-button>
    </a>
</div>

<!-- Filter Section -->
<x-card class="mb-6">
    <form action="{{ route('admin.users.index') }}" method="GET">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="form-label">Cari</label>
                <input type="text" name="search" class="form-input" 
                    placeholder="Nama atau email..." value="{{ request('search') }}">
            </div>
            <div>
                <label class="form-label">Role</label>
                <select name="role" class="form-input">
                    <option value="">Semua Role</option>
                    <option value="owner" {{ request('role') === 'owner' ? 'selected' : '' }}>Owner</option>
                    <option value="worker" {{ request('role') === 'worker' ? 'selected' : '' }}>Worker</option>
                </select>
            </div>
            <div>
                <label class="form-label">Status</label>
                <select name="status" class="form-input">
                    <option value="">Semua Status</option>
                    <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Nonaktif</option>
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

<!-- Users Table -->
<x-card>
    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Kios</th>
                    <th>Status</th>
                    <th>Terdaftar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($users as $user)
                <tr>
                    <td class="font-medium">
                        <div class="flex items-center">
                            <img class="h-8 w-8 rounded-full mr-3" 
                                src="{{ $user->avatar_url ?? 'https://ui-avatars.com/api/?name='.$user->name }}" 
                                alt="{{ $user->name }}">
                            {{ $user->name }}
                        </div>
                    </td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <span class="px-2 py-1 text-xs rounded-full 
                            {{ $user->role === 'owner' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }}">
                            {{ ucfirst($user->role) }}
                        </span>
                    </td>
                    <td>{{ $user->kiosk->name ?? '-' }}</td>
                    <td>
                        <span class="px-2 py-1 text-xs rounded-full 
                            {{ $user->status ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $user->status ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </td>
                    <td>{{ $user->created_at->format('d/m/Y') }}</td>
                    <td class="space-x-2">
                        <x-button variant="secondary" size="sm" 
                            onclick="window.location.href='{{ route('admin.users.edit', $user) }}'">
                            Edit
                        </x-button>
                        <x-button variant="danger" size="sm" 
                            onclick="if(confirm('Apakah Anda yakin ingin menghapus pengguna ini?')) document.getElementById('delete-form-{{ $user->id }}').submit()">
                            Hapus
                        </x-button>
                        <form id="delete-form-{{ $user->id }}" 
                            action="{{ route('admin.users.destroy', $user) }}" 
                            method="POST" class="hidden">
                            @csrf
                            @method('DELETE')
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-4 text-gray-500">
                        Tidak ada data pengguna yang ditemukan
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $users->links() }}
    </div>
</x-card>
@endsection 