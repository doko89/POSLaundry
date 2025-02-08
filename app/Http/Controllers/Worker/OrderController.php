<?php

namespace App\Http\Controllers\Worker;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Customer;
use App\Models\Service;
use App\Services\WhatsAppService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $whatsapp;

    public function __construct(WhatsAppService $whatsapp)
    {
        $this->whatsapp = $whatsapp;
    }

    public function index(Request $request)
    {
        $orders = auth()->user()->kiosk->orders()
            ->with(['customer', 'service'])
            ->when($request->search, function($query, $search) {
                $query->where('number', 'like', "%{$search}%")
                    ->orWhereHas('customer', function($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            })
            ->when($request->status, function($query, $status) {
                $query->where('status', $status);
            })
            ->when($request->sort, function($query, $sort) {
                match($sort) {
                    'oldest' => $query->oldest(),
                    'total_asc' => $query->orderBy('total'),
                    'total_desc' => $query->orderByDesc('total'),
                    default => $query->latest()
                };
            })
            ->paginate(10);

        return view('worker.orders.index', compact('orders'));
    }

    public function create()
    {
        $customers = auth()->user()->kiosk->customers()->get();
        $services = auth()->user()->kiosk->services()->active()->get();

        return view('worker.orders.form', compact('customers', 'services'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'service_id' => 'required|exists:services,id',
            'weight' => 'required|numeric|min:0',
            'priority' => 'required|in:normal,high,express',
            'notes' => 'nullable|string',
            'total' => 'required|numeric|min:0'
        ]);

        $order = auth()->user()->kiosk->orders()->create($validated + [
            'number' => 'ORD-' . time(),
            'status' => 'pending',
            'worker_id' => auth()->id()
        ]);

        $this->whatsapp->sendOrderStatusUpdate($order);

        return redirect()
            ->route('worker.orders.show', $order)
            ->with('success', 'Order berhasil dibuat');
    }

    public function show(Order $order)
    {
        $order->load(['customer', 'service', 'timeline']);
        return view('worker.orders.show', compact('order'));
    }

    public function process(Order $order)
    {
        $order->update(['status' => 'processing']);
        $order->timeline()->create([
            'type' => 'status',
            'description' => 'Order mulai diproses',
            'user_id' => auth()->id()
        ]);

        $this->whatsapp->sendOrderStatusUpdate($order);

        return back()->with('success', 'Order sedang diproses');
    }

    public function complete(Order $order)
    {
        $order->update([
            'status' => 'completed',
            'completed_at' => now()
        ]);
        
        $order->timeline()->create([
            'type' => 'status',
            'description' => 'Order selesai',
            'user_id' => auth()->id()
        ]);

        $this->whatsapp->sendOrderStatusUpdate($order);

        return back()->with('success', 'Order telah selesai');
    }

    public function cancel(Order $order)
    {
        $order->update(['status' => 'cancelled']);
        
        $order->timeline()->create([
            'type' => 'status',
            'description' => 'Order dibatalkan',
            'user_id' => auth()->id()
        ]);

        $this->whatsapp->sendOrderStatusUpdate($order);

        return back()->with('success', 'Order telah dibatalkan');
    }
}
