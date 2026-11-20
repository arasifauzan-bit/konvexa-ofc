<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $totalCategories = Category::query()->count();
        $activeCategories = Category::query()->where('is_active', true)->count();
        $inactiveCategories = $totalCategories - $activeCategories;
        $recentCategories = Category::query()
            ->latest('updated_at')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalCategories',
            'activeCategories',
            'inactiveCategories',
            'recentCategories',
        ));
    }
}
