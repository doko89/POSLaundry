<?php

namespace App\Http\Controllers\Worker;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $customers = auth()->user()->kiosk->customers()
            ->withCount('orders')
            ->when($request->search, function($query, $search) {
                $query->where(function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%");
                });
            })
            ->when($request->status, function($query, $status) {
                $query->where('status', $status);
            })
            ->when($request->sort, function($query, $sort) {
                match($sort) {
                    'oldest' => $query->oldest(),
                    'name_asc' => $query->orderBy('name'),
                    'name_desc' => $query->orderByDesc('name'),
                    'orders_desc' => $query->orderByDesc('orders_count'),
                    default => $query->latest()
                };
            })
            ->paginate(10);

        return view('worker.customers.index', compact('customers'));
    }

    public function create()
    {
        return view('worker.customers.form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20|unique:customers,phone',
            'email' => 'nullable|email|max:255|unique:customers,email',
            'address' => 'nullable|string',
            'birth_date' => 'nullable|date',
            'gender' => 'nullable|in:male,female',
            'notes' => 'nullable|string'
        ]);

        $customer = auth()->user()->kiosk->customers()->create($validated);

        return redirect()
            ->route('worker.customers.show', $customer)
            ->with('success', 'Pelanggan berhasil ditambahkan');
    }

    public function show(Customer $customer)
    {
        $customer->load(['orders' => function($query) {
            $query->latest()->take(10);
        }]);

        return view('worker.customers.show', compact('customer'));
    }

    public function edit(Customer $customer)
    {
        return view('worker.customers.form', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20|unique:customers,phone,'.$customer->id,
            'email' => 'nullable|email|max:255|unique:customers,email,'.$customer->id,
            'address' => 'nullable|string',
            'birth_date' => 'nullable|date',
            'gender' => 'nullable|in:male,female',
            'notes' => 'nullable|string'
        ]);

        $customer->update($validated);

        return redirect()
            ->route('worker.customers.show', $customer)
            ->with('success', 'Informasi pelanggan berhasil diperbarui');
    }

    public function quickStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20|unique:customers,phone',
            'address' => 'nullable|string'
        ]);

        $customer = auth()->user()->kiosk->customers()->create($validated);

        return response()->json([
            'success' => true,
            'customer' => $customer
        ]);
    }
}
