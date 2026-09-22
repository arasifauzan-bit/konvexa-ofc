<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;

class HomeController extends Controller
{
public function index()
{
    $categories = Category::all();

    $featuredProducts = Product::with('category')
        ->where('is_featured', true)
        ->latest()->take(8)->get();

    $searchProducts = Product::with('category')->get()->map(fn ($p) => [
        'id'         => $p->id,
        'nama'       => $p->name,
        'kategori'   => $p->category?->name ?? '-',
        'harga'      => (int) $p->price,
        'hargaCoret' => (int) ($p->original_price ?? 0),
        'gambar'     => $p->image ? asset('storage/' . $p->image) : 'https://placehold.co/200x200',
    ]);

    return view('welcome', compact('categories', 'featuredProducts', 'searchProducts'));
}}