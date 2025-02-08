@extends('layouts.app')

@section('title', 'Pengaturan Sistem')

@section('content')
<div class="mb-6">
    <h2 class="text-xl font-semibold text-gray-800">Pengaturan Sistem</h2>
    <p class="mt-1 text-sm text-gray-600">Kelola pengaturan umum aplikasi</p>
</div>

<div class="grid grid-cols-1 gap-6">
    <!-- General Settings -->
    <x-card>
        <h3 class="text-lg font-semibold text-gray-700 mb-4">Pengaturan Umum</h3>
        <form action="{{ route('admin.settings.update') }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="space-y-4">
                <div>
                    <label class="form-label">Nama Aplikasi</label>
                    <input type="text" name="app_name" class="form-input" value="{{ $settings->app_name ?? config('app.name') }}">
                </div>

                <div>
                    <label class="form-label">Mata Uang</label>
                    <select name="currency" class="form-input">
                        <option value="IDR" {{ ($settings->currency ?? '') === 'IDR' ? 'selected' : '' }}>IDR (Rupiah)</option>
                        <option value="USD" {{ ($settings->currency ?? '') === 'USD' ? 'selected' : '' }}>USD (Dollar)</option>
                    </select>
                </div>

                <div>
                    <label class="form-label">Format Tanggal</label>
                    <select name="date_format" class="form-input">
                        <option value="d/m/Y" {{ ($settings->date_format ?? '') === 'd/m/Y' ? 'selected' : '' }}>DD/MM/YYYY</option>
                        <option value="Y-m-d" {{ ($settings->date_format ?? '') === 'Y-m-d' ? 'selected' : '' }}>YYYY-MM-DD</option>
                    </select>
                </div>

                <div>
                    <label class="form-label">Zona Waktu</label>
                    <select name="timezone" class="form-input">
                        <option value="Asia/Jakarta" {{ ($settings->timezone ?? '') === 'Asia/Jakarta' ? 'selected' : '' }}>Asia/Jakarta (WIB)</option>
                        <option value="Asia/Makassar" {{ ($settings->timezone ?? '') === 'Asia/Makassar' ? 'selected' : '' }}>Asia/Makassar (WITA)</option>
                        <option value="Asia/Jayapura" {{ ($settings->timezone ?? '') === 'Asia/Jayapura' ? 'selected' : '' }}>Asia/Jayapura (WIT)</option>
                    </select>
                </div>
            </div>

            <div class="mt-6">
                <x-button type="submit" variant="primary">Simpan Pengaturan</x-button>
            </div>
        </form>
    </x-card>

    <!-- Backup Settings -->
    <x-card>
        <h3 class="text-lg font-semibold text-gray-700 mb-4">Backup Data</h3>
        <div class="space-y-4">
            <p class="text-sm text-gray-600">
                Backup database dan file aplikasi secara berkala untuk keamanan data.
            </p>
            <div class="flex space-x-3">
                <x-button variant="primary">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                    </svg>
                    Backup Sekarang
                </x-button>
                <x-button variant="secondary">
                    Riwayat Backup
                </x-button>
            </div>
        </div>
    </x-card>

    <!-- System Logs -->
    <x-card>
        <h3 class="text-lg font-semibold text-gray-700 mb-4">Log Aktivitas</h3>
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>Waktu</th>
                        <th>User</th>
                        <th>Aktivitas</th>
                        <th>IP Address</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($logs as $log)
                    <tr>
                        <td>{{ $log->created_at->format('d/m/Y H:i') }}</td>
                        <td>{{ $log->user->name }}</td>
                        <td>{{ $log->activity }}</td>
                        <td>{{ $log->ip_address }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $logs->links() }}
        </div>
    </x-card>
</div>
@endsection 