<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Setting;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::with('category')
            ->when($request->category, fn ($q, $slug) =>
                $q->whereHas('category', fn ($c) => $c->where('slug', $slug)))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        $categories = Category::all();
        $siteSettings = Setting::forWebsite();
        $whatsappNumber = preg_replace('/\D+/', '', $siteSettings['whatsapp_phone']);

        return view('produk', compact('products', 'categories', 'whatsappNumber'));
    }

public function show(Product $product)
{
    return redirect()->route('produk.index');
}
}