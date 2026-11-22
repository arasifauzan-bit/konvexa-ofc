<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrderTracking;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class OrderTrackingController extends Controller
{
    public function index(Request $request): View
    {
        $orderTrackings = OrderTracking::query()
            ->when($request->filled('search'), function ($query) use ($request) {
                $query->where('order_number', 'like', '%' . strtoupper(trim((string) $request->input('search'))) . '%');
            })
            ->latest('updated_at')
            ->paginate(15)
            ->withQueryString();

        return view('admin.tracking.index', compact('orderTrackings'));
    }

    public function create(): View
    {
        return view('admin.tracking.create', [
            'orderTracking' => new OrderTracking(['status' => 'antrian']),
            'statuses' => OrderTracking::STATUS_OPTIONS,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        OrderTracking::query()->create($this->validatedData($request));

        return redirect()
            ->route('admin.tracking.index')
            ->with('status', 'Pesanan tracking berhasil ditambahkan.');
    }

    public function edit(OrderTracking $orderTracking): View
    {
        return view('admin.tracking.edit', [
            'orderTracking' => $orderTracking,
            'statuses' => OrderTracking::STATUS_OPTIONS,
        ]);
    }

    public function update(Request $request, OrderTracking $orderTracking): RedirectResponse
    {
        $orderTracking->update($this->validatedData($request, $orderTracking));

        return redirect()
            ->route('admin.tracking.index')
            ->with('status', 'Tracking pesanan berhasil diperbarui.');
    }

    private function validatedData(Request $request, ?OrderTracking $orderTracking = null): array
    {
        $orderNumber = $request->input('order_number');
        $customerName = $request->input('customer_name');
        $request->merge([
            'order_number' => is_string($orderNumber) ? Str::upper(trim($orderNumber)) : $orderNumber,
            'customer_name' => is_string($customerName) ? Str::upper(trim($customerName)) : $customerName,
        ]);

        $uniqueOrderNumber = Rule::unique('order_trackings', 'order_number');
        if ($orderTracking) {
            $uniqueOrderNumber->ignore($orderTracking);
        }

        return $request->validate([
            'order_number' => ['required', 'string', 'max:32', 'regex:/^[A-Z0-9-]+$/', $uniqueOrderNumber],
            'customer_name' => ['required', 'string', 'max:100'],
            'status' => ['required', Rule::in(array_keys(OrderTracking::STATUS_OPTIONS))],
        ], [
            'order_number.regex' => 'Nomor pesanan hanya boleh berisi huruf, angka, dan tanda hubung.',
        ]);
    }
}
