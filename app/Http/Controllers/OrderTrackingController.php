<?php

namespace App\Http\Controllers;

use App\Models\OrderTracking;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class OrderTrackingController extends Controller
{
    public function index(): View
    {
        return view('tracking.index', [
            'orderTracking' => null,
            'searched' => false,
            'statuses' => OrderTracking::STATUS_OPTIONS,
            'currentStatusIndex' => -1,
        ]);
    }

    public function lookup(Request $request): View
    {
        $customerName = $request->input('customer_name');
        $request->merge([
            'customer_name' => is_string($customerName) ? Str::upper(trim($customerName)) : $customerName,
        ]);

        $validated = $request->validate([
            'order_number' => ['required', 'string', 'max:32'],
            'customer_name' => ['required', 'string', 'max:100'],
        ], [
            'order_number.required' => 'Masukkan nomor pesanan.',
            'customer_name.required' => 'Masukkan nama pelanggan.',
        ]);

        $orderNumber = Str::upper(trim($validated['order_number']));
        $matchingOrderNumber = OrderTracking::query()
            ->where('order_number', $orderNumber)
            ->first();
        $orderTracking = $matchingOrderNumber
            && $matchingOrderNumber->customer_name === $validated['customer_name']
                ? $matchingOrderNumber
                : null;

        return view('tracking.index', [
            'orderTracking' => $orderTracking,
            'searched' => true,
            'lookupState' => $matchingOrderNumber
                ? ($orderTracking ? 'found' : 'name_mismatch')
                : 'not_found',
            'statuses' => OrderTracking::STATUS_OPTIONS,
            'currentStatusIndex' => $orderTracking
                ? array_search($orderTracking->status, array_keys(OrderTracking::STATUS_OPTIONS), true)
                : -1,
        ]);
    }
}
