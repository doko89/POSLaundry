<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Service;
use Carbon\Carbon;

class OrderService
{
    protected $whatsapp;

    public function __construct(WhatsAppService $whatsapp)
    {
        $this->whatsapp = $whatsapp;
    }

    public function create(array $data): Order
    {
        // Hitung estimasi waktu selesai berdasarkan prioritas
        $estimatedHours = match($data['priority']) {
            'express' => 3,
            'high' => 6,
            'normal' => 24,
        };

        $service = Service::find($data['service_id']);
        $total = $this->calculateTotal($service->price, $data['weight'], $data['priority']);

        $order = Order::create([
            ...$data,
            'number' => 'ORD-' . time(),
            'status' => 'pending',
            'total' => $total,
            'estimated_completion_time' => Carbon::now()->addHours($estimatedHours),
            'worker_id' => auth()->id(),
            'kiosk_id' => auth()->user()->kiosk_id,
        ]);

        // Buat timeline
        $order->timeline()->create([
            'type' => 'created',
            'description' => 'Order dibuat',
            'user_id' => auth()->id()
        ]);

        // Kirim notifikasi WhatsApp
        $this->whatsapp->sendOrderStatusUpdate($order);

        return $order;
    }

    public function calculateTotal(float $price, float $weight, string $priority): float
    {
        $subtotal = $price * $weight;

        $priorityMultiplier = match($priority) {
            'express' => 1.5, // +50%
            'high' => 1.2,    // +20%
            'normal' => 1,    // normal price
        };

        return $subtotal * $priorityMultiplier;
    }

    public function updateStatus(Order $order, string $status): void
    {
        $order->update(['status' => $status]);

        if ($status === 'completed') {
            $order->update(['completed_at' => now()]);
        }

        $description = match($status) {
            'processing' => 'Order mulai diproses',
            'completed' => 'Order selesai',
            'cancelled' => 'Order dibatalkan',
            default => 'Status order diperbarui'
        };

        $order->timeline()->create([
            'type' => 'status',
            'description' => $description,
            'user_id' => auth()->id()
        ]);

        $this->whatsapp->sendOrderStatusUpdate($order);
    }
} 