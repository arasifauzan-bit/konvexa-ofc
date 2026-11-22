<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\OrderTracking;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OrderTrackingSyncController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $orderNumber = $request->input('order_number');
        $customerName = $request->input('customer_name');
        $request->merge([
            'order_number' => is_string($orderNumber) ? Str::upper(trim($orderNumber)) : $orderNumber,
            'customer_name' => is_string($customerName) ? Str::upper(trim($customerName)) : $customerName,
        ]);

        $data = $request->validate([
            'order_number' => ['required', 'string', 'max:32', 'regex:/^[A-Z0-9-]+$/'],
            'customer_name' => ['required', 'string', 'max:100'],
        ], [
            'order_number.regex' => 'Nomor pesanan hanya boleh berisi huruf, angka, dan tanda hubung.',
        ]);

        $orderTracking = OrderTracking::query()->firstOrCreate(
            ['order_number' => $data['order_number']],
            [
                'customer_name' => $data['customer_name'],
                'status' => 'antrian',
            ],
        );

        if (! $orderTracking->wasRecentlyCreated) {
            $orderTracking->update(['customer_name' => $data['customer_name']]);
        }

        return response()->json([
            'tracking' => [
                'order_number' => $orderTracking->order_number,
                'customer_name' => $orderTracking->customer_name,
                'status' => $orderTracking->status,
            ],
        ], $orderTracking->wasRecentlyCreated ? 201 : 200);
    }
}
