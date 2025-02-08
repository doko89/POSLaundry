@extends('layouts.app')

@section('title', isset($service) ? 'Edit Layanan' : 'Tambah Layanan')

@section('content')
<div class="mb-6">
    <h2 class="text-xl font-semibold text-gray-800">
        {{ isset($service) ? 'Edit Layanan' : 'Tambah Layanan' }}
    </h2>
    <p class="mt-1 text-sm text-gray-600">
        {{ isset($service) ? 'Edit informasi layanan yang sudah ada' : 'Tambahkan layanan baru ke kios Anda' }}
    </p>
</div>

<x-card>
    <form action="{{ isset($service) ? route('owner.services.update', $service) : route('owner.services.store') }}" 
        method="POST" class="space-y-6">
        @csrf
        @if(isset($service))
            @method('PUT')
        @endif

        <!-- Basic Information -->
        <div>
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Informasi Layanan</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="form-label">Nama Layanan</label>
                    <input type="text" name="name" class="form-input" 
                        value="{{ old('name', $service->name ?? '') }}" required>
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="form-label">Kategori</label>
                    <select name="category" class="form-input" required>
                        <option value="">Pilih Kategori</option>
                        <option value="kiloan" {{ old('category', $service->category ?? '') == 'kiloan' ? 'selected' : '' }}>
                            Kiloan
                        </option>
                        <option value="satuan" {{ old('category', $service->category ?? '') == 'satuan' ? 'selected' : '' }}>
                            Satuan
                        </option>
                        <option value="premium" {{ old('category', $service->category ?? '') == 'premium' ? 'selected' : '' }}>
                            Premium
                        </option>
                    </select>
                    @error('category')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="col-span-2">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="description" class="form-input" rows="3">{{ old('description', $service->description ?? '') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Pricing & Duration -->
        <div>
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Harga & Durasi</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="form-label">Harga (Rp)</label>
                    <input type="number" name="price" class="form-input" 
                        value="{{ old('price', $service->price ?? '') }}" required>
                    @error('price')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="form-label">Durasi (Jam)</label>
                    <input type="number" name="duration" class="form-input" 
                        value="{{ old('duration', $service->duration ?? '') }}" required>
                    @error('duration')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="form-label">Minimal Order</label>
                    <input type="number" name="minimum_order" class="form-input" 
                        value="{{ old('minimum_order', $service->minimum_order ?? '1') }}" required>
                    @error('minimum_order')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Additional Settings -->
        <div>
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Pengaturan Tambahan</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="form-label">Status</label>
                    <select name="status" class="form-input" required>
                        <option value="1" {{ old('status', $service->status ?? '') == 1 ? 'selected' : '' }}>
                            Aktif
                        </option>
                        <option value="0" {{ old('status', $service->status ?? '') == 0 ? 'selected' : '' }}>
                            Nonaktif
                        </option>
                    </select>
                    @error('status')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="form-label">Prioritas</label>
                    <select name="priority" class="form-input" required>
                        <option value="normal" {{ old('priority', $service->priority ?? '') == 'normal' ? 'selected' : '' }}>
                            Normal
                        </option>
                        <option value="high" {{ old('priority', $service->priority ?? '') == 'high' ? 'selected' : '' }}>
                            Prioritas Tinggi
                        </option>
                        <option value="express" {{ old('priority', $service->priority ?? '') == 'express' ? 'selected' : '' }}>
                            Express
                        </option>
                    </select>
                    @error('priority')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Submit Buttons -->
        <div class="flex justify-end space-x-3">
            <x-button type="button" variant="secondary" 
                onclick="window.location.href='{{ route('owner.services.index') }}'">
                Batal
            </x-button>
            <x-button type="submit" variant="primary">
                {{ isset($service) ? 'Simpan Perubahan' : 'Tambah Layanan' }}
            </x-button>
        </div>
    </form>
</x-card>
@endsection 