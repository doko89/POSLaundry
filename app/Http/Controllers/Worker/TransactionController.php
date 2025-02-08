<?php

namespace App\Http\Controllers\Worker;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::where('worker_id', auth()->id())->get();
        return view('worker.transactions.index', compact('transactions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'amount' => 'required|numeric',
            'payment_method' => 'required|in:cash,transfer,ewallet',
        ]);

        $transaction = Transaction::create([
            'order_id' => $request->order_id,
            'kiosk_id' => auth()->user()->kiosk_id,
            'number' => 'TRX-' . time(),
            'amount' => $request->amount,
            'payment_method' => $request->payment_method,
            'status' => 'pending',
        ]);

        return redirect()->route('worker.transactions.index')->with('success', 'Transaction created successfully.');
    }

    public function show(Transaction $transaction)
    {
        return view('worker.transactions.show', compact('transaction'));
    }

    public function markAsPaid(Transaction $transaction)
    {
        $transaction->update(['status' => 'paid', 'paid_at' => now()]);
        return redirect()->route('worker.transactions.index')->with('success', 'Transaction marked as paid.');
    }
} 