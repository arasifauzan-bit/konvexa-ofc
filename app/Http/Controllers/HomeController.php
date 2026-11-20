<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Setting;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::query()
            ->where('is_active', true)
            ->orderBy('order')
            ->select('id', 'name', 'slug', 'image', 'order')
            ->get();

        $searchCategories = $categories
            ->map(function (Category $category) {
                return [
                    'id'     => $category->id,
                    'nama'   => $category->name,
                    'slug'   => $category->slug,
                    'gambar' => $category->image_url,
                ];
            });

        $siteSettings = Setting::forWebsite();
        $whatsappNumber = preg_replace('/\D+/', '', $siteSettings['whatsapp_phone']);

        return view('welcome', compact('categories', 'searchCategories', 'siteSettings', 'whatsappNumber'));
    }
}