<?php

namespace App\Services;

use App\Models\Customer;
use Illuminate\Support\Facades\DB;

class CustomerService
{
    public function create(array $data): Customer
    {
        return DB::transaction(function () use ($data) {
            $customer = Customer::create([
                ...$data,
                'kiosk_id' => auth()->user()->kiosk_id
            ]);

            // Log aktivitas
            activity()
                ->performedOn($customer)
                ->causedBy(auth()->user())
                ->log('created');

            return $customer;
        });
    }

    public function update(Customer $customer, array $data): Customer
    {
        return DB::transaction(function () use ($customer, $data) {
            $customer->update($data);

            // Log aktivitas
            activity()
                ->performedOn($customer)
                ->causedBy(auth()->user())
                ->log('updated');

            return $customer;
        });
    }

    public function getCustomerStats(Customer $customer): array
    {
        return [
            'total_orders' => $customer->orders()->count(),
            'completed_orders' => $customer->orders()->where('status', 'completed')->count(),
            'total_spent' => $customer->orders()->where('status', 'completed')->sum('total'),
            'average_order_value' => $customer->orders()->where('status', 'completed')->avg('total') ?? 0,
            'first_order' => $customer->orders()->oldest()->first()?->created_at,
            'last_order' => $customer->orders()->latest()->first()?->created_at,
        ];
    }
} 