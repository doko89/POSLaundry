@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
<div class="mb-6">
    <h2 class="text-xl font-semibold text-gray-800">Profil Saya</h2>
    <p class="mt-1 text-sm text-gray-600">Kelola informasi profil dan pengaturan akun Anda</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Profile Information -->
    <div class="lg:col-span-2 space-y-6">
        <x-card>
            <form action="{{ route('owner.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="flex items-center space-x-6">
                    <div class="flex-shrink-0">
                        <img class="h-24 w-24 rounded-full" 
                            src="{{ auth()->user()->avatar_url ?? 'https://ui-avatars.com/api/?name='.auth()->user()->name }}" 
                            alt="{{ auth()->user()->name }}">
                    </div>
                    <div>
                        <label class="form-label">Foto Profil</label>
                        <input type="file" name="avatar" class="form-input mt-1">
                        <p class="mt-1 text-sm text-gray-500">Format: JPG, PNG. Maksimal 2MB.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="name" class="form-input" 
                            value="{{ old('name', auth()->user()->name) }}" required>
                    </div>

                    <div>
                        <label class="form-label">Email</label>
                        <input type="email" class="form-input bg-gray-50" 
                            value="{{ auth()->user()->email }}" disabled>
                        <p class="mt-1 text-sm text-gray-500">Email tidak dapat diubah</p>
                    </div>

                    <div>
                        <label class="form-label">Nomor HP</label>
                        <input type="text" name="phone" class="form-input" 
                            value="{{ old('phone', auth()->user()->phone) }}">
                    </div>

                    <div>
                        <label class="form-label">Alamat</label>
                        <textarea name="address" class="form-input" rows="3">{{ old('address', auth()->user()->address) }}</textarea>
                    </div>
                </div>

                <div class="flex justify-end">
                    <x-button type="submit" variant="primary">
                        Simpan Perubahan
                    </x-button>
                </div>
            </form>
        </x-card>

        <!-- Change Password -->
        <x-card>
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Ubah Password</h3>
            <form action="{{ route('owner.profile.password') }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="form-label">Password Saat Ini</label>
                        <input type="password" name="current_password" class="form-input" required>
                    </div>

                    <div class="col-span-2 md:col-span-1">
                        <label class="form-label">Password Baru</label>
                        <input type="password" name="password" class="form-input" required>
                    </div>

                    <div class="col-span-2 md:col-span-1">
                        <label class="form-label">Konfirmasi Password Baru</label>
                        <input type="password" name="password_confirmation" class="form-input" required>
                    </div>
                </div>

                <div class="flex justify-end">
                    <x-button type="submit" variant="primary">
                        Ubah Password
                    </x-button>
                </div>
            </form>
        </x-card>
    </div>

    <!-- Sidebar -->
    <div class="space-y-6">
        <!-- Account Status -->
        <x-card>
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Status Akun</h3>
            <div class="space-y-4">
                <div>
                    <p class="text-sm font-medium text-gray-500">Status</p>
                    <span class="px-2 py-1 text-xs rounded-full inline-block mt-1 bg-green-100 text-green-800">
                        Aktif
                    </span>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Bergabung Sejak</p>
                    <p class="mt-1">{{ auth()->user()->created_at->format('d/m/Y') }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Login Terakhir</p>
                    <p class="mt-1">{{ auth()->user()->last_login_at?->format('d/m/Y H:i') ?? '-' }}</p>
                </div>
            </div>
        </x-card>

        <!-- Security Settings -->
        <x-card>
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Keamanan</h3>
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="font-medium">Verifikasi 2 Langkah</p>
                        <p class="text-sm text-gray-500">Tambahan keamanan untuk akun Anda</p>
                    </div>
                    <button type="button" class="text-primary-600 hover:text-primary-700">
                        Setup
                    </button>
                </div>
                <div class="flex items-center justify-between">
                    <div>
                        <p class="font-medium">Riwayat Login</p>
                        <p class="text-sm text-gray-500">Lihat aktivitas login akun Anda</p>
                    </div>
                    <button type="button" class="text-primary-600 hover:text-primary-700">
                        Lihat
                    </button>
                </div>
            </div>
        </x-card>
    </div>
</div>
@endsection 