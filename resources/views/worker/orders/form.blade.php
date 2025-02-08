@extends('layouts.app')

@section('title', isset($order) ? 'Edit Order' : 'Order Baru')

@section('content')
<div class="mb-6">
    <h2 class="text-xl font-semibold text-gray-800">
        {{ isset($order) ? 'Edit Order' : 'Order Baru' }}
    </h2>
    <p class="mt-1 text-sm text-gray-600">
        {{ isset($order) ? 'Edit informasi order yang sudah ada' : 'Buat order baru untuk pelanggan' }}
    </p>
</div>

<x-card>
    <form action="{{ isset($order) ? route('worker.orders.update', $order) : route('worker.orders.store') }}" 
        method="POST" class="space-y-6">
        @csrf
        @if(isset($order))
            @method('PUT')
        @endif

        <!-- Customer Selection -->
        <div>
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Informasi Pelanggan</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="form-label">Pilih Pelanggan</label>
                    <select name="customer_id" class="form-input" required 
                        {{ isset($order) ? 'disabled' : '' }}>
                        <option value="">Pilih Pelanggan</option>
                        @foreach($customers as $customer)
                        <option value="{{ $customer->id }}" 
                            {{ (old('customer_id', $order->customer_id ?? request('customer_id')) == $customer->id) ? 'selected' : '' }}>
                            {{ $customer->name }} - {{ $customer->phone }}
                        </option>
                        @endforeach
                    </select>
                    @if(isset($order))
                        <input type="hidden" name="customer_id" value="{{ $order->customer_id }}">
                    @endif
                    @error('customer_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="form-label">Atau</label>
                    <x-button type="button" variant="secondary" class="w-full" onclick="openQuickAdd()">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        Tambah Pelanggan Baru
                    </x-button>
                </div>
            </div>
        </div>

        <!-- Service Selection -->
        <div>
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Layanan</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="form-label">Pilih Layanan</label>
                    <select name="service_id" class="form-input" required onchange="updatePrice()">
                        <option value="">Pilih Layanan</option>
                        @foreach($services as $service)
                        <option value="{{ $service->id }}" 
                            data-price="{{ $service->price }}"
                            data-min-weight="{{ $service->min_weight }}"
                            {{ (old('service_id', $order->service_id ?? '') == $service->id) ? 'selected' : '' }}>
                            {{ $service->name }} - Rp {{ number_format($service->price) }}/kg
                        </option>
                        @endforeach
                    </select>
                    @error('service_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="form-label">Berat (kg)</label>
                    <input type="number" name="weight" class="form-input" step="0.1" min="0" 
                        value="{{ old('weight', $order->weight ?? '') }}" required onchange="updateTotal()">
                    @error('weight')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="form-label">Prioritas</label>
                    <select name="priority" class="form-input" required onchange="updateTotal()">
                        <option value="normal" {{ old('priority', $order->priority ?? '') == 'normal' ? 'selected' : '' }}>
                            Normal (1-2 hari)
                        </option>
                        <option value="high" {{ old('priority', $order->priority ?? '') == 'high' ? 'selected' : '' }}>
                            Prioritas (8-12 jam) +20%
                        </option>
                        <option value="express" {{ old('priority', $order->priority ?? '') == 'express' ? 'selected' : '' }}>
                            Express (3-6 jam) +50%
                        </option>
                    </select>
                    @error('priority')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="form-label">Total</label>
                    <input type="text" id="total-display" class="form-input bg-gray-50" readonly 
                        value="Rp {{ number_format(old('total', $order->total ?? 0)) }}">
                    <input type="hidden" name="total" id="total-input" 
                        value="{{ old('total', $order->total ?? 0) }}">
                    @error('total')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Additional Information -->
        <div>
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Informasi Tambahan</h3>
            <div class="grid grid-cols-1 gap-6">
                <div>
                    <label class="form-label">Catatan</label>
                    <textarea name="notes" class="form-input" rows="3" 
                        placeholder="Catatan khusus untuk order ini...">{{ old('notes', $order->notes ?? '') }}</textarea>
                    @error('notes')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Submit Buttons -->
        <div class="flex justify-end space-x-3">
            <x-button type="button" variant="secondary" 
                onclick="window.location.href='{{ route('worker.orders.index') }}'">
                Batal
            </x-button>
            <x-button type="submit" variant="primary">
                {{ isset($order) ? 'Simpan Perubahan' : 'Buat Order' }}
            </x-button>
        </div>
    </form>
</x-card>

@push('scripts')
<script>
    function updatePrice() {
        const serviceSelect = document.querySelector('select[name="service_id"]');
        const weightInput = document.querySelector('input[name="weight"]');
        const selectedOption = serviceSelect.options[serviceSelect.selectedIndex];
        
        if (selectedOption.value) {
            const minWeight = parseFloat(selectedOption.dataset.minWeight);
            weightInput.min = minWeight;
            weightInput.placeholder = `Minimal ${minWeight} kg`;
        }
        
        updateTotal();
    }

    function updateTotal() {
        const serviceSelect = document.querySelector('select[name="service_id"]');
        const weightInput = document.querySelector('input[name="weight"]');
        const prioritySelect = document.querySelector('select[name="priority"]');
        const totalDisplay = document.getElementById('total-display');
        const totalInput = document.getElementById('total-input');

        if (serviceSelect.value && weightInput.value) {
            const selectedOption = serviceSelect.options[serviceSelect.selectedIndex];
            const basePrice = parseFloat(selectedOption.dataset.price);
            const weight = parseFloat(weightInput.value);
            let total = basePrice * weight;

            // Apply priority multiplier
            if (prioritySelect.value === 'high') {
                total *= 1.2; // 20% markup
            } else if (prioritySelect.value === 'express') {
                total *= 1.5; // 50% markup
            }

            totalDisplay.value = `Rp ${total.toLocaleString('id-ID')}`;
            totalInput.value = total;
        } else {
            totalDisplay.value = 'Rp 0';
            totalInput.value = 0;
        }
    }

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        updatePrice();
    });
</script>
@endpush
@endsection 