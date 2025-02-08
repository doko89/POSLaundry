@extends('layouts.app')

@section('title', 'Detail Order')

@push('styles')
<style>
    @media print {
        /* Hide elements that shouldn't be printed */
        .no-print, 
        nav, 
        header,
        footer,
        .sidebar,
        button,
        .quick-actions {
            display: none !important;
        }

        /* Reset background colors and shadows for printing */
        body {
            background: white;
            padding: 0;
            margin: 0;
        }

        .card {
            box-shadow: none !important;
            border: 1px solid #eee;
            break-inside: avoid;
        }

        /* Ensure content fits on paper */
        .container {
            max-width: 100% !important;
            width: 100% !important;
            margin: 0 !important;
            padding: 20px !important;
        }

        /* Add order details header for print */
        .print-header {
            text-align: center;
            margin-bottom: 20px;
            display: block !important;
        }

        .print-header h1 {
            font-size: 24px;
            margin-bottom: 5px;
        }

        .print-header p {
            font-size: 14px;
            color: #666;
        }

        /* Adjust grid layout for print */
        .grid {
            display: block !important;
        }

        .lg\:col-span-2 {
            width: 100% !important;
        }

        /* Hide certain elements in timeline */
        .timeline .action-buttons {
            display: none !important;
        }

        /* Force page breaks where needed */
        .page-break {
            page-break-before: always;
        }
    }
</style>
@endpush

@section('content')
<div class="mb-6">
    <div class="flex justify-between items-start">
        <div>
            <h2 class="text-xl font-semibold text-gray-800">Detail Order</h2>
            <p class="mt-1 text-sm text-gray-600">Informasi lengkap order laundry</p>
        </div>
        <div class="flex space-x-3">
            @if($order->status === 'pending')
            <x-button variant="primary" 
                onclick="if(confirm('Mulai proses order ini?')) document.getElementById('process-form').submit()">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Mulai Proses
            </x-button>
            @elseif($order->status === 'processing')
            <x-button variant="success" 
                onclick="if(confirm('Selesaikan order ini?')) document.getElementById('complete-form').submit()">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Selesai
            </x-button>
            @endif

            @if($order->status !== 'completed' && $order->status !== 'cancelled')
            <x-button variant="danger" 
                onclick="if(confirm('Batalkan order ini?')) document.getElementById('cancel-form').submit()">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
                Batalkan
            </x-button>
            @endif

            <x-button variant="secondary" onclick="printOrder()">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                </svg>
                Cetak
            </x-button>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Order Information -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Basic Info Card -->
        <x-card>
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-xl font-semibold text-gray-800">Order #{{ $order->number }}</h3>
                    <p class="text-sm text-gray-600">{{ $order->created_at->format('d/m/Y H:i') }}</p>
                </div>
                <span class="px-3 py-1 text-sm rounded-full 
                    {{ $order->status === 'completed' ? 'bg-green-100 text-green-800' : 
                       ($order->status === 'processing' ? 'bg-yellow-100 text-yellow-800' : 
                       ($order->status === 'cancelled' ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800')) }}">
                    {{ ucfirst($order->status) }}
                </span>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-sm font-medium text-gray-500">Layanan</p>
                    <p class="mt-1">{{ $order->service->name }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Berat</p>
                    <p class="mt-1">{{ $order->weight }} kg</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Prioritas</p>
                    <p class="mt-1">{{ ucfirst($order->priority) }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Total</p>
                    <p class="mt-1 font-semibold">Rp {{ number_format($order->total) }}</p>
                </div>
                @if($order->notes)
                <div class="col-span-2">
                    <p class="text-sm font-medium text-gray-500">Catatan</p>
                    <p class="mt-1">{{ $order->notes }}</p>
                </div>
                @endif
            </div>
        </x-card>

        <!-- Timeline -->
        <x-card>
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Timeline Order</h3>
            <div class="space-y-6">
                @foreach($order->timeline as $event)
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <span class="inline-flex items-center justify-center h-8 w-8 rounded-full 
                            {{ $event->type === 'status' ? 'bg-blue-100' : 'bg-gray-100' }}">
                            <svg class="h-5 w-5 {{ $event->type === 'status' ? 'text-blue-600' : 'text-gray-600' }}" 
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                @if($event->type === 'status')
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                @else
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                @endif
                            </svg>
                        </span>
                    </div>
                    <div class="ml-4 flex-1">
                        <p class="text-sm font-medium text-gray-900">{{ $event->description }}</p>
                        <p class="mt-1 text-sm text-gray-500">
                            {{ $event->created_at->format('d/m/Y H:i') }}
                            @if($event->user)
                            oleh {{ $event->user->name }}
                            @endif
                        </p>
                    </div>
                </div>
                @endforeach
            </div>
        </x-card>
    </div>

    <!-- Sidebar -->
    <div class="space-y-6">
        <!-- Customer Info -->
        <x-card>
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Informasi Pelanggan</h3>
            <div class="flex items-center space-x-4 mb-4">
                <img class="h-12 w-12 rounded-full" 
                    src="{{ $order->customer->avatar_url ?? 'https://ui-avatars.com/api/?name='.$order->customer->name }}" 
                    alt="{{ $order->customer->name }}">
                <div>
                    <h4 class="text-sm font-medium text-gray-900">{{ $order->customer->name }}</h4>
                    <p class="text-sm text-gray-600">{{ $order->customer->phone }}</p>
                </div>
            </div>
            <div class="space-y-3">
                @if($order->customer->address)
                <div>
                    <p class="text-sm font-medium text-gray-500">Alamat</p>
                    <p class="mt-1 text-sm">{{ $order->customer->address }}</p>
                </div>
                @endif
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Order</p>
                    <p class="mt-1 text-sm">{{ $order->customer->orders_count }} order</p>
                </div>
            </div>
            <div class="mt-4">
                <x-button variant="secondary" class="w-full justify-center" 
                    onclick="window.location.href='https://wa.me/{{ $order->customer->phone }}'">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                    Chat WhatsApp
                </x-button>
            </div>
        </x-card>

        <!-- Quick Actions -->
        <x-card>
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Aksi Cepat</h3>
            <div class="space-y-3">
                <x-button variant="secondary" class="w-full justify-center" 
                    onclick="window.location.href='{{ route('worker.orders.create', ['customer_id' => $order->customer_id]) }}'">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Order Baru
                </x-button>
                <x-button variant="secondary" class="w-full justify-center" 
                    onclick="window.location.href='{{ route('worker.customers.show', $order->customer) }}'">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    Lihat Profil
                </x-button>
            </div>
        </x-card>
    </div>
</div>

<!-- Status Change Forms -->
<form id="process-form" action="{{ route('worker.orders.process', $order) }}" method="POST" class="hidden">
    @csrf
    @method('PUT')
</form>
<form id="complete-form" action="{{ route('worker.orders.complete', $order) }}" method="POST" class="hidden">
    @csrf
    @method('PUT')
</form>
<form id="cancel-form" action="{{ route('worker.orders.cancel', $order) }}" method="POST" class="hidden">
    @csrf
    @method('PUT')
</form>

@push('scripts')
<script>
    function printOrder() {
        window.print();
    }
</script>
@endpush

<!-- Tambahkan print header yang hanya muncul saat print -->
<div class="print-header hidden">
    <h1>{{ config('app.name') }}</h1>
    <p>Order #{{ $order->number }}</p>
    <p>{{ now()->format('d/m/Y H:i') }}</p>
</div>
@endsection 