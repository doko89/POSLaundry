@extends('layouts.app')

@section('title', isset($worker) ? 'Edit Pekerja' : 'Tambah Pekerja')

@section('content')
<div class="mb-6">
    <h2 class="text-xl font-semibold text-gray-800">
        {{ isset($worker) ? 'Edit Pekerja' : 'Tambah Pekerja' }}
    </h2>
    <p class="mt-1 text-sm text-gray-600">
        {{ isset($worker) ? 'Edit informasi pekerja yang sudah ada' : 'Tambahkan pekerja baru ke kios Anda' }}
    </p>
</div>

<x-card>
    <form action="{{ isset($worker) ? route('owner.workers.update', $worker) : route('owner.workers.store') }}" 
        method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @if(isset($worker))
            @method('PUT')
        @endif

        <!-- Basic Information -->
        <div>
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Informasi Dasar</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="form-label">Foto Profil</label>
                    <div class="mt-2 flex items-center space-x-4">
                        <img class="h-20 w-20 rounded-full" 
                            src="{{ isset($worker) ? ($worker->avatar_url ?? 'https://ui-avatars.com/api/?name='.$worker->name) : 'https://ui-avatars.com/api/?name=New+Worker' }}" 
                            alt="Profile photo">
                        <input type="file" name="avatar" class="form-input">
                    </div>
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="name" class="form-input" 
                            value="{{ old('name', $worker->name ?? '') }}" required>
                    </div>

                    <div>
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-input" 
                            value="{{ old('email', $worker->email ?? '') }}" required>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact Information -->
        <div>
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Informasi Kontak</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="form-label">Nomor HP</label>
                    <input type="text" name="phone" class="form-input" 
                        value="{{ old('phone', $worker->phone ?? '') }}">
                </div>

                <div>
                    <label class="form-label">Alamat</label>
                    <textarea name="address" class="form-input" rows="3">{{ old('address', $worker->address ?? '') }}</textarea>
                </div>
            </div>
        </div>

        <!-- Account Settings -->
        <div>
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Pengaturan Akun</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @if(!isset($worker))
                <div>
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-input" required>
                </div>

                <div>
                    <label class="form-label">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" class="form-input" required>
                </div>
                @endif

                <div>
                    <label class="form-label">Status</label>
                    <select name="status" class="form-input" required>
                        <option value="1" {{ old('status', $worker->status ?? '') == 1 ? 'selected' : '' }}>
                            Aktif
                        </option>
                        <option value="0" {{ old('status', $worker->status ?? '') == 0 ? 'selected' : '' }}>
                            Nonaktif
                        </option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Submit Buttons -->
        <div class="flex justify-end space-x-3">
            <x-button type="button" variant="secondary" 
                onclick="window.location.href='{{ route('owner.workers.index') }}'">
                Batal
            </x-button>
            <x-button type="submit" variant="primary">
                {{ isset($worker) ? 'Simpan Perubahan' : 'Tambah Pekerja' }}
            </x-button>
        </div>
    </form>
</x-card>
@endsection 