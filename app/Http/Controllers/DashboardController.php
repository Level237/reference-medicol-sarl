<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function show(Request $request): View
    {
        $admin = $request->user();

        $stats = [
            'products_count' => Product::query()->count(),
            'products_published' => Product::query()->where('is_published', true)->count(),
            'categories_count' => Category::query()->count(),
            'quotes_count' => 0,
            'messages_count' => 0,
        ];

        $recentProducts = Product::query()
            ->with('category')
            ->orderByDesc('created_at')
            ->take(5)
            ->get();

        return view('admin.dashboard', [
            'admin' => $admin,
            'initial' => mb_strtoupper(mb_substr((string) $admin->name, 0, 1)),
            'stats' => $stats,
            'recentProducts' => $recentProducts,
        ]);
    }
}
