<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\QuoteRequest;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function show(): View
    {
        $recentProducts = Product::query()
            ->with('category')
            ->orderByDesc('created_at')
            ->take(5)
            ->get();

        $recentQuotes = QuoteRequest::query()
            ->with(['items.product.coverImage'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', [
            'recentProducts' => $recentProducts,
            'recentQuotes' => $recentQuotes,
        ]);
    }
}
