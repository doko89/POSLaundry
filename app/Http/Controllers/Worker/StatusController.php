<?php

namespace App\Http\Controllers\Worker;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    public function index()
    {
        $workHours = auth()->user()->getWorkHoursToday();
        $completedOrders = auth()->user()->getCompletedOrdersToday();
        $performance = auth()->user()->calculatePerformance();
        $pendingTasks = auth()->user()->getPendingTasksCount();
        
        $lastActivity = auth()->user()->lastActivity();
        $currentStatus = auth()->user()->getCurrentStatus();
        
        $activities = auth()->user()->activities()
            ->latest()
            ->paginate(10);

        return view('worker.status.index', compact(
            'workHours',
            'completedOrders',
            'performance',
            'pendingTasks',
            'lastActivity',
            'currentStatus',
            'activities'
        ));
    }

    public function start()
    {
        auth()->user()->startShift();
        return back()->with('success', 'Shift dimulai');
    }

    public function end()
    {
        auth()->user()->endShift();
        return back()->with('success', 'Shift diakhiri');
    }
}
