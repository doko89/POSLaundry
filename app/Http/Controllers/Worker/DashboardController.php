<?php

namespace App\Http\Controllers\Worker;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $todayOrders = auth()->user()->kiosk->orders()
            ->whereDate('created_at', today())
            ->count();

        $ordersChange = 0; // Implement percentage change calculation
        $processingOrders = auth()->user()->kiosk->orders()
            ->where('status', 'processing')
            ->count();

        $completedToday = auth()->user()->kiosk->orders()
            ->where('status', 'completed')
            ->whereDate('completed_at', today())
            ->count();

        $newCustomers = auth()->user()->kiosk->customers()
            ->whereDate('created_at', today())
            ->count();

        $pendingTasks = auth()->user()->tasks()
            ->where('status', 'pending')
            ->count();

        $tasks = auth()->user()->tasks()
            ->where('status', 'pending')
            ->orderBy('due_time')
            ->take(5)
            ->get();

        $performanceChart = [
            'labels' => ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
            'data' => [5, 7, 4, 6, 8, 3, 5] // Implement real data
        ];

        return view('worker.dashboard', compact(
            'todayOrders',
            'ordersChange',
            'processingOrders',
            'completedToday',
            'newCustomers',
            'pendingTasks',
            'tasks',
            'performanceChart'
        ));
    }
}
