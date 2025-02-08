@extends('layouts.app')

@section('title', isset($kiosk) ? 'Edit Kios' : 'Tambah Kios Baru')

@section('content')
<div class="mb-6">
    <h2 class="text-xl font-semibold text-gray-800">
        {{ isset($kiosk) ? 'Edit Kios' : 'Tambah Kios Baru' }}
    </h2>
    <p class="mt-1 text-sm text-gray-600">
        {{ isset($kiosk) ? 'Edit informasi kios yang sudah ada' : 'Tambahkan kios baru ke dalam sistem' }}
    </p>
</div>

<x-card>
    <form action="{{ isset($kiosk) ? route('admin.kios.update', $kiosk) : route('admin.kios.store') }}" 
        method="POST" class="space-y-6">
        @csrf
        @if(isset($kiosk))
            @method('PUT')
        @endif

        <!-- Basic Information -->
        <div>
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Informasi Dasar</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="form-label">Nama Kios</label>
                    <input type="text" name="name" class="form-input" 
                        value="{{ old('name', $kiosk->name ?? '') }}" required>
                </div>

                <div>
                    <label class="form-label">Pemilik</label>
                    <select name="owner_id" class="form-input" required>
                        <option value="">Pilih Pemilik</option>
                        @foreach($owners as $owner)
                            <option value="{{ $owner->id }}" 
                                {{ old('owner_id', $kiosk->owner_id ?? '') == $owner->id ? 'selected' : '' }}>
                                {{ $owner->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="form-label">Alamat</label>
                    <textarea name="address" class="form-input" rows="3">{{ old('address', $kiosk->address ?? '') }}</textarea>
                </div>

                <div>
                    <label class="form-label">Nomor WhatsApp</label>
                    <input type="text" name="whatsapp_number" class="form-input" 
                        value="{{ old('whatsapp_number', $kiosk->whatsapp_number ?? '') }}">
                </div>
            </div>
        </div>

        <!-- Subscription Information -->
        <div>
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Informasi Berlangganan</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="form-label">Durasi Berlangganan</label>
                    <select name="subscription_duration" class="form-input" required>
                        <option value="1" {{ old('subscription_duration') == 1 ? 'selected' : '' }}>1 Bulan</option>
                        <option value="3" {{ old('subscription_duration') == 3 ? 'selected' : '' }}>3 Bulan</option>
                        <option value="6" {{ old('subscription_duration') == 6 ? 'selected' : '' }}>6 Bulan</option>
                        <option value="12" {{ old('subscription_duration') == 12 ? 'selected' : '' }}>12 Bulan</option>
                    </select>
                </div>

                <div>
                    <label class="form-label">Status</label>
                    <select name="status" class="form-input" required>
                        <option value="active" {{ old('status', $kiosk->status ?? '') == 'active' ? 'selected' : '' }}>
                            Aktif
                        </option>
                        <option value="suspended" {{ old('status', $kiosk->status ?? '') == 'suspended' ? 'selected' : '' }}>
                            Suspend
                        </option>
                    </select>
                </div>

                @if(isset($kiosk))
                <div>
                    <label class="form-label">Tanggal Berakhir</label>
                    <input type="date" class="form-input" value="{{ $kiosk->expired_date->format('Y-m-d') }}" disabled>
                </div>
                @endif
            </div>
        </div>

        <!-- Submit Buttons -->
        <div class="flex justify-end space-x-3">
            <x-button type="button" variant="secondary" 
                onclick="window.location.href='{{ route('admin.kios.index') }}'">
                Batal
            </x-button>
            <x-button type="submit" variant="primary">
                {{ isset($kiosk) ? 'Simpan Perubahan' : 'Tambah Kios' }}
            </x-button>
        </div>
    </form>
</x-card>
@endsection 