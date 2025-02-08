@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
    <x-card>
        <h3 class="text-lg font-semibold text-gray-700 mb-2">Total Kios</h3>
        <p class="text-3xl font-bold text-primary-600">{{ $totalKios }}</p>
    </x-card>

    <x-card>
        <h3 class="text-lg font-semibold text-gray-700 mb-2">Kios Aktif</h3>
        <p class="text-3xl font-bold text-green-600">{{ $activeKios }}</p>
    </x-card>

    <x-card>
        <h3 class="text-lg font-semibold text-gray-700 mb-2">Kios Expired</h3>
        <p class="text-3xl font-bold text-red-600">{{ $expiredKios }}</p>
    </x-card>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <x-card>
        <h3 class="text-lg font-semibold text-gray-700 mb-4">Kios Terbaru</h3>
        <!-- Table Recent Kios -->
    </x-card>

    <x-card>
        <h3 class="text-lg font-semibold text-gray-700 mb-4">Aktivitas Terbaru</h3>
        <!-- Table Recent Activities -->
    </x-card>
</div>
@endsection 