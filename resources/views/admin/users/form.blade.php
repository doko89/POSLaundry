@extends('layouts.app')

@section('title', isset($user) ? 'Edit Pengguna' : 'Tambah Pengguna')

@section('content')
<div class="mb-6">
    <h2 class="text-xl font-semibold text-gray-800">
        {{ isset($user) ? 'Edit Pengguna' : 'Tambah Pengguna' }}
    </h2>
    <p class="mt-1 text-sm text-gray-600">
        {{ isset($user) ? 'Edit informasi pengguna yang sudah ada' : 'Tambahkan pengguna baru ke dalam sistem' }}
    </p>
</div>

<x-card>
    <form action="{{ isset($user) ? route('admin.users.update', $user) : route('admin.users.store') }}" 
        method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @if(isset($user))
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
                            src="{{ isset($user) ? ($user->avatar_url ?? 'https://ui-avatars.com/api/?name='.$user->name) : 'https://ui-avatars.com/api/?name=New+User' }}" 
                            alt="Profile photo">
                        <input type="file" name="avatar" class="form-input">
                    </div>
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="name" class="form-input" 
                            value="{{ old('name', $user->name ?? '') }}" required>
                    </div>

                    <div>
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-input" 
                            value="{{ old('email', $user->email ?? '') }}" required>
                    </div>
                </div>
            </div>
        </div>

        <!-- Role & Access -->
        <div>
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Role & Akses</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="form-label">Role</label>
                    <select name="role" class="form-input" required>
                        <option value="">Pilih Role</option>
                        <option value="owner" {{ old('role', $user->role ?? '') == 'owner' ? 'selected' : '' }}>
                            Owner
                        </option>
                        <option value="worker" {{ old('role', $user->role ?? '') == 'worker' ? 'selected' : '' }}>
                            Worker
                        </option>
                    </select>
                </div>

                <div>
                    <label class="form-label">Status</label>
                    <select name="status" class="form-input" required>
                        <option value="1" {{ old('status', $user->status ?? '') == 1 ? 'selected' : '' }}>
                            Aktif
                        </option>
                        <option value="0" {{ old('status', $user->status ?? '') == 0 ? 'selected' : '' }}>
                            Nonaktif
                        </option>
                    </select>
                </div>

                <div id="kiosk-selection" class="hidden">
                    <label class="form-label">Kios</label>
                    <select name="kiosk_id" class="form-input">
                        <option value="">Pilih Kios</option>
                        @foreach($kiosks as $kiosk)
                            <option value="{{ $kiosk->id }}" 
                                {{ old('kiosk_id', $user->kiosk_id ?? '') == $kiosk->id ? 'selected' : '' }}>
                                {{ $kiosk->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <!-- Password Section -->
        @if(!isset($user))
        <div>
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Password</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-input" required>
                </div>

                <div>
                    <label class="form-label">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" class="form-input" required>
                </div>
            </div>
        </div>
        @endif

        <!-- Submit Buttons -->
        <div class="flex justify-end space-x-3">
            <x-button type="button" variant="secondary" 
                onclick="window.location.href='{{ route('admin.users.index') }}'">
                Batal
            </x-button>
            <x-button type="submit" variant="primary">
                {{ isset($user) ? 'Simpan Perubahan' : 'Tambah Pengguna' }}
            </x-button>
        </div>
    </form>
</x-card>

@push('scripts')
<script>
    // Show/hide kiosk selection based on role
    const roleSelect = document.querySelector('select[name="role"]');
    const kioskSelection = document.getElementById('kiosk-selection');

    function toggleKioskSelection() {
        if (roleSelect.value === 'owner' || roleSelect.value === 'worker') {
            kioskSelection.classList.remove('hidden');
        } else {
            kioskSelection.classList.add('hidden');
        }
    }

    roleSelect.addEventListener('change', toggleKioskSelection);
    toggleKioskSelection(); // Run on page load
</script>
@endpush
@endsection 