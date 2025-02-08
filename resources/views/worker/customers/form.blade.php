@extends('layouts.app')

@section('title', isset($customer) ? 'Edit Pelanggan' : 'Tambah Pelanggan')

@section('content')
<div class="mb-6">
    <h2 class="text-xl font-semibold text-gray-800">
        {{ isset($customer) ? 'Edit Pelanggan' : 'Tambah Pelanggan' }}
    </h2>
    <p class="mt-1 text-sm text-gray-600">
        {{ isset($customer) ? 'Edit informasi pelanggan yang sudah ada' : 'Tambahkan pelanggan baru ke kios' }}
    </p>
</div>

<x-card>
    <form action="{{ isset($customer) ? route('worker.customers.update', $customer) : route('worker.customers.store') }}" 
        method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @if(isset($customer))
            @method('PUT')
        @endif

        <!-- Basic Information -->
        <div>
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Informasi Dasar</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" name="name" class="form-input" 
                        value="{{ old('name', $customer->name ?? '') }}" required>
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="form-label">Nomor HP</label>
                    <input type="text" name="phone" class="form-input" 
                        value="{{ old('phone', $customer->phone ?? '') }}" required>
                    @error('phone')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="col-span-2">
                    <label class="form-label">Alamat</label>
                    <textarea name="address" class="form-input" rows="3">{{ old('address', $customer->address ?? '') }}</textarea>
                    @error('address')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Additional Information -->
        <div>
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Informasi Tambahan</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-input" 
                        value="{{ old('email', $customer->email ?? '') }}">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="form-label">Tanggal Lahir</label>
                    <input type="date" name="birth_date" class="form-input" 
                        value="{{ old('birth_date', $customer->birth_date ?? '') }}">
                    @error('birth_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="form-label">Jenis Kelamin</label>
                    <select name="gender" class="form-input">
                        <option value="">Pilih Jenis Kelamin</option>
                        <option value="male" {{ old('gender', $customer->gender ?? '') == 'male' ? 'selected' : '' }}>
                            Laki-laki
                        </option>
                        <option value="female" {{ old('gender', $customer->gender ?? '') == 'female' ? 'selected' : '' }}>
                            Perempuan
                        </option>
                    </select>
                    @error('gender')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="form-label">Status</label>
                    <select name="status" class="form-input" required>
                        <option value="active" {{ old('status', $customer->status ?? 'active') == 'active' ? 'selected' : '' }}>
                            Aktif
                        </option>
                        <option value="inactive" {{ old('status', $customer->status ?? '') == 'inactive' ? 'selected' : '' }}>
                            Nonaktif
                        </option>
                    </select>
                    @error('status')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Notes -->
        <div>
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Catatan</h3>
            <div>
                <label class="form-label">Catatan Khusus</label>
                <textarea name="notes" class="form-input" rows="3" 
                    placeholder="Catatan tambahan untuk pelanggan ini...">{{ old('notes', $customer->notes ?? '') }}</textarea>
                @error('notes')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Submit Buttons -->
        <div class="flex justify-end space-x-3">
            <x-button type="button" variant="secondary" 
                onclick="window.location.href='{{ route('worker.customers.index') }}'">
                Batal
            </x-button>
            <x-button type="submit" variant="primary">
                {{ isset($customer) ? 'Simpan Perubahan' : 'Tambah Pelanggan' }}
            </x-button>
        </div>
    </form>
</x-card>
@endsection 