@extends('layouts.app')

@section('title', 'Status Worker')

@section('content')
<div class="mb-6">
    <h2 class="text-xl font-semibold text-gray-800">Status Worker</h2>
    <p class="mt-1 text-sm text-gray-600">Kelola status kehadiran dan aktivitas Anda</p>
</div>

<!-- Status Overview -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
    <x-card>
        <div class="flex items-center">
            <div class="flex-shrink-0 p-3 bg-primary-100 rounded-lg">
                <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-500">Jam Kerja Hari Ini</p>
                <h3 class="text-xl font-bold text-gray-900">{{ $workHours }} Jam</h3>
            </div>
        </div>
    </x-card>

    <x-card>
        <div class="flex items-center">
            <div class="flex-shrink-0 p-3 bg-green-100 rounded-lg">
                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-500">Order Selesai</p>
                <h3 class="text-xl font-bold text-gray-900">{{ $completedOrders }}</h3>
            </div>
        </div>
    </x-card>

    <x-card>
        <div class="flex items-center">
            <div class="flex-shrink-0 p-3 bg-yellow-100 rounded-lg">
                <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-500">Performa</p>
                <h3 class="text-xl font-bold text-gray-900">{{ $performance }}%</h3>
            </div>
        </div>
    </x-card>

    <x-card>
        <div class="flex items-center">
            <div class="flex-shrink-0 p-3 bg-blue-100 rounded-lg">
                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-500">Tugas Hari Ini</p>
                <h3 class="text-xl font-bold text-gray-900">{{ $pendingTasks }}</h3>
            </div>
        </div>
    </x-card>
</div>

<!-- Current Status -->
<x-card class="mb-6">
    <div class="flex items-center justify-between">
        <div>
            <h3 class="text-lg font-semibold text-gray-700">Status Saat Ini</h3>
            <p class="mt-1 text-sm text-gray-500">{{ $lastActivity?->created_at->diffForHumans() }}</p>
        </div>
        <span class="px-3 py-1 text-sm rounded-full 
            {{ $currentStatus === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
            {{ $currentStatus === 'active' ? 'Aktif' : 'Nonaktif' }}
        </span>
    </div>

    <div class="mt-6 flex space-x-3">
        @if($currentStatus !== 'active')
        <x-button variant="success" class="w-full justify-center" 
            onclick="if(confirm('Mulai shift kerja?')) document.getElementById('start-shift-form').submit()">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
            </svg>
            Mulai Shift
        </x-button>
        @else
        <x-button variant="danger" class="w-full justify-center" 
            onclick="if(confirm('Akhiri shift kerja?')) document.getElementById('end-shift-form').submit()">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 10a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4z"/>
            </svg>
            Akhiri Shift
        </x-button>
        @endif
    </div>
</x-card>

<!-- Activity History -->
<x-card>
    <h3 class="text-lg font-semibold text-gray-700 mb-4">Riwayat Aktivitas</h3>
    <div class="space-y-6">
        @forelse($activities as $activity)
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <span class="inline-flex items-center justify-center h-8 w-8 rounded-full 
                    {{ $activity->type === 'shift_start' ? 'bg-green-100' : 
                       ($activity->type === 'shift_end' ? 'bg-red-100' : 'bg-blue-100') }}">
                    <svg class="h-5 w-5 
                        {{ $activity->type === 'shift_start' ? 'text-green-600' : 
                           ($activity->type === 'shift_end' ? 'text-red-600' : 'text-blue-600') }}" 
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        @if($activity->type === 'shift_start')
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                        @elseif($activity->type === 'shift_end')
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z M9 10a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4z"/>
                        @else
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        @endif
                    </svg>
                </span>
            </div>
            <div class="ml-4 flex-1">
                <p class="text-sm font-medium text-gray-900">{{ $activity->description }}</p>
                <p class="mt-1 text-sm text-gray-500">{{ $activity->created_at->format('d/m/Y H:i') }}</p>
            </div>
        </div>
        @empty
        <div class="text-center py-4 text-gray-500">
            Tidak ada aktivitas yang tercatat
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $activities->links() }}
    </div>
</x-card>

<!-- Status Change Forms -->
<form id="start-shift-form" action="{{ route('worker.status.start') }}" method="POST" class="hidden">
    @csrf
</form>
<form id="end-shift-form" action="{{ route('worker.status.end') }}" method="POST" class="hidden">
    @csrf
</form>
@endsection 