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
            <form action="{{ route('worker.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
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
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
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
                        @error('phone')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="form-label">Tanggal Lahir</label>
                        <input type="date" name="birth_date" class="form-input" 
                            value="{{ old('birth_date', auth()->user()->birth_date?->format('Y-m-d')) }}">
                        @error('birth_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-span-2">
                        <label class="form-label">Alamat</label>
                        <textarea name="address" class="form-input" rows="3">{{ old('address', auth()->user()->address) }}</textarea>
                        @error('address')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
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
            <form action="{{ route('worker.profile.password') }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="form-label">Password Saat Ini</label>
                        <input type="password" name="current_password" class="form-input" required>
                        @error('current_password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-span-2 md:col-span-1">
                        <label class="form-label">Password Baru</label>
                        <input type="password" name="password" class="form-input" required>
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
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

        <!-- Performance Stats -->
        <x-card>
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Statistik Kinerja</h3>
            <div class="grid grid-cols-2 gap-4">
                <div class="text-center p-4 bg-gray-50 rounded-lg">
                    <p class="text-2xl font-bold text-primary-600">{{ $totalOrders }}</p>
                    <p class="text-sm text-gray-600">Total Order</p>
                </div>
                <div class="text-center p-4 bg-gray-50 rounded-lg">
                    <p class="text-2xl font-bold text-primary-600">{{ $completedOrders }}</p>
                    <p class="text-sm text-gray-600">Order Selesai</p>
                </div>
                <div class="text-center p-4 bg-gray-50 rounded-lg">
                    <p class="text-2xl font-bold text-primary-600">{{ $averageRating }}</p>
                    <p class="text-sm text-gray-600">Rating Rata-rata</p>
                </div>
                <div class="text-center p-4 bg-gray-50 rounded-lg">
                    <p class="text-2xl font-bold text-primary-600">{{ $performance }}%</p>
                    <p class="text-sm text-gray-600">Performa</p>
                </div>
            </div>
        </x-card>

        <!-- Quick Links -->
        <x-card>
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Akses Cepat</h3>
            <div class="space-y-3">
                <x-button variant="secondary" class="w-full justify-center" 
                    onclick="window.location.href='{{ route('worker.status.index') }}'">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Status Kehadiran
                </x-button>
                <x-button variant="secondary" class="w-full justify-center" 
                    onclick="window.location.href='{{ route('worker.orders.index') }}'">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    Daftar Order
                </x-button>
            </div>
        </x-card>
    </div>
</div>
@endsection 