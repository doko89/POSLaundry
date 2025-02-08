<div class="print-only hidden">
    <div class="text-center mb-6">
        <h1 class="text-xl font-bold">{{ $kiosk->name }}</h1>
        <p class="text-sm">{{ $kiosk->address }}</p>
        <p class="text-sm">Telp: {{ $kiosk->phone }}</p>
    </div>

    <div class="border-t border-b border-gray-300 py-2 my-4">
        <div class="flex justify-between">
            <span>No. Order:</span>
            <span class="font-bold">{{ $order->number }}</span>
        </div>
        <div class="flex justify-between">
            <span>Tanggal:</span>
            <span>{{ $order->created_at->format('d/m/Y H:i') }}</span>
        </div>
        <div class="flex justify-between">
            <span>Pelanggan:</span>
            <span>{{ $order->customer->name }}</span>
        </div>
    </div>

    <table class="w-full mb-4">
        <tr>
            <td>Layanan</td>
            <td class="text-right">{{ $order->service->name }}</td>
        </tr>
        <tr>
            <td>Berat</td>
            <td class="text-right">{{ $order->weight }} kg</td>
        </tr>
        <tr>
            <td>Harga per kg</td>
            <td class="text-right">Rp {{ number_format($order->service->price) }}</td>
        </tr>
        @if($order->priority !== 'normal')
        <tr>
            <td>Prioritas ({{ $order->priority === 'high' ? '+20%' : '+50%' }})</td>
            <td class="text-right">Rp {{ number_format($order->priority_charge) }}</td>
        </tr>
        @endif
        <tr class="font-bold border-t">
            <td>Total</td>
            <td class="text-right">Rp {{ number_format($order->total) }}</td>
        </tr>
    </table>

    <div class="text-center text-sm mt-6">
        <p>Estimasi Selesai:</p>
        <p class="font-bold">{{ $order->estimated_completion_time->format('d/m/Y H:i') }}</p>
        <p class="mt-4">Terima kasih telah menggunakan jasa kami</p>
    </div>

    <div class="text-xs text-center mt-6">
        <p>* Barang yang tidak diambil dalam 30 hari</p>
        <p>bukan tanggung jawab kami</p>
    </div>
</div> 