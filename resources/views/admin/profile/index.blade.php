@extends('layouts.app')

@section('title', 'Profil Admin')

@section('content')
<div class="mb-6">
    <h2 class="text-xl font-semibold text-gray-800">Profil Saya</h2>
    <p class="mt-1 text-sm text-gray-600">Kelola informasi profil dan keamanan akun Anda</p>
</div>

<div class="grid grid-cols-1 gap-6">
    <!-- Profile Information -->
    <x-card>
        <h3 class="text-lg font-semibold text-gray-700 mb-4">Informasi Profil</h3>
        <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="form-label">Foto Profil</label>
                    <div class="mt-2 flex items-center space-x-4">
                        <img class="h-20 w-20 rounded-full" 
                            src="{{ auth()->user()->avatar_url ?? 'https://ui-avatars.com/api/?name='.auth()->user()->name }}" 
                            alt="Profile photo">
                        <input type="file" name="avatar" class="form-input">
                    </div>
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="name" class="form-input" value="{{ auth()->user()->name }}">
                    </div>

                    <div>
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-input" value="{{ auth()->user()->email }}">
                    </div>
                </div>
            </div>

            <div class="mt-6">
                <x-button type="submit" variant="primary">Simpan Perubahan</x-button>
            </div>
        </form>
    </x-card>

    <!-- Change Password -->
    <x-card>
        <h3 class="text-lg font-semibold text-gray-700 mb-4">Ubah Password</h3>
        <form action="{{ route('admin.profile.password') }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="space-y-4">
                <div>
                    <label class="form-label">Password Lama</label>
                    <input type="password" name="current_password" class="form-input">
                </div>

                <div>
                    <label class="form-label">Password Baru</label>
                    <input type="password" name="password" class="form-input">
                </div>

                <div>
                    <label class="form-label">Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation" class="form-input">
                </div>
            </div>

            <div class="mt-6">
                <x-button type="submit" variant="primary">Ubah Password</x-button>
            </div>
        </form>
    </x-card>

    <!-- Activity Log -->
    <x-card>
        <h3 class="text-lg font-semibold text-gray-700 mb-4">Riwayat Login</h3>
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>Waktu</th>
                        <th>IP Address</th>
                        <th>Browser</th>
                        <th>Platform</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($loginHistory as $history)
                    <tr>
                        <td>{{ $history->created_at->format('d/m/Y H:i') }}</td>
                        <td>{{ $history->ip_address }}</td>
                        <td>{{ $history->browser }}</td>
                        <td>{{ $history->platform }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </x-card>
</div>
@endsection 