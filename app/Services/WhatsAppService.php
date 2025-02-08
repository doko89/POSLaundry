<?php

namespace App\Services;

class WhatsAppService
{
    public function sendOrderStatusUpdate($order)
    {
        $message = match ($order->status) {
            'pending' => $this->getPendingTemplate($order),
            'processing' => $this->getProcessingTemplate($order),
            'completed' => $this->getCompletedTemplate($order),
            'cancelled' => $this->getCancelledTemplate($order),
            default => null
        };

        if ($message) {
            return $this->send($order->customer->phone, $message);
        }
    }

    private function getPendingTemplate($order)
    {
        return "Halo {$order->customer->name},\n\n" .
            "Order laundry Anda telah kami terima:\n" .
            "No. Order: {$order->number}\n" .
            "Layanan: {$order->service->name}\n" .
            "Berat: {$order->weight} kg\n" .
            "Total: Rp " . number_format($order->total) . "\n\n" .
            "Estimasi selesai: {$order->estimated_completion_time->format('d/m/Y H:i')}\n\n" .
            "Terima kasih telah menggunakan jasa kami.";
    }

    private function getProcessingTemplate($order)
    {
        return "Halo {$order->customer->name},\n\n" .
            "Order laundry Anda sedang kami proses:\n" .
            "No. Order: {$order->number}\n\n" .
            "Kami akan memberitahu Anda ketika order sudah selesai.\n\n" .
            "Terima kasih atas kesabarannya.";
    }

    private function getCompletedTemplate($order)
    {
        return "Halo {$order->customer->name},\n\n" .
            "Order laundry Anda telah selesai dan siap diambil:\n" .
            "No. Order: {$order->number}\n\n" .
            "Silakan ambil di outlet kami dengan menunjukkan nomor order.\n\n" .
            "Terima kasih telah menggunakan jasa kami.";
    }

    private function getCancelledTemplate($order)
    {
        return "Halo {$order->customer->name},\n\n" .
            "Order laundry Anda telah dibatalkan:\n" .
            "No. Order: {$order->number}\n\n" .
            "Mohon hubungi kami untuk informasi lebih lanjut.\n\n" .
            "Terima kasih atas pengertiannya.";
    }

    private function send($phone, $message)
    {
        // Implementasi pengiriman WhatsApp menggunakan provider yang dipilih
        // Contoh menggunakan Fonnte
        $apiKey = config('services.fonnte.key');
        $url = 'https://api.fonnte.com/send';

        $payload = [
            'target' => $phone,
            'message' => $message,
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payload));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: ' . $apiKey
        ]);

        $response = curl_exec($ch);
        curl_close($ch);

        return json_decode($response, true);
    }
} 