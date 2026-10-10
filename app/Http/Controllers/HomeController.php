<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;
use Throwable;

class HomeController extends Controller
{
    public function __invoke(Request $request): View
    {
        $q = trim((string) $request->query('q', ''));
        $selectedCategory = trim((string) $request->query('category', ''));
        $selectedBrand = trim((string) $request->query('brand', ''));
        $inStock = $request->boolean('in_stock');
        $priceType = trim((string) $request->query('price_type', ''));
        $priceMin = $request->query('price_min');
        $priceMax = $request->query('price_max');
        $sort = trim((string) $request->query('sort', 'relevance'));
        $view = $request->query('view', 'grid') === 'list' ? 'list' : 'grid';

        $defaultBrands = ['Mindray', 'Omron', 'Philips', 'GE Healthcare', 'Welch Allyn'];

        try {
            if (! Schema::hasTable('categories') || ! Schema::hasTable('products')) {
                throw new \RuntimeException('Database tables not ready yet.');
            }

            // Published categories with product count
            $categories = Category::query()
                ->where('is_published', true)
                ->withCount(['products' => fn ($query) => $query->where('is_published', true)])
                ->orderBy('sort_order')
                ->orderBy('name')
                ->get();

            // Extract available brands from published products specifications
            $extractedBrands = Product::query()
                ->where('is_published', true)
                ->whereNotNull('specifications')
                ->get()
                ->map(function (Product $product) {
                    $specs = $product->specifications ?? [];

                    return $specs['Marque'] ?? $specs['marque'] ?? $specs['Brand'] ?? $specs['brand'] ?? null;
                })
                ->filter()
                ->unique()
                ->values()
                ->all();

            $brands = ! empty($extractedBrands) ? $extractedBrands : $defaultBrands;

            // Build product query
            $productsQuery = Product::query()
                ->where('is_published', true)
                ->with(['category', 'coverImage']);

            if ($q !== '') {
                $productsQuery->where(function ($sub) use ($q) {
                    $sub->where('name', 'like', "%{$q}%")
                        ->orWhere('reference', 'like', "%{$q}%")
                        ->orWhere('summary', 'like', "%{$q}%");
                });
            }

            if ($selectedCategory !== '') {
                $productsQuery->whereHas('category', function ($sub) use ($selectedCategory) {
                    $sub->where('slug', $selectedCategory)
                        ->orWhere('id', $selectedCategory);
                });
            }

            if ($selectedBrand !== '') {
                $productsQuery->where(function ($sub) use ($selectedBrand) {
                    $sub->where('specifications->Marque', $selectedBrand)
                        ->orWhere('specifications->marque', $selectedBrand)
                        ->orWhere('specifications->Brand', $selectedBrand)
                        ->orWhere('specifications->brand', $selectedBrand)
                        ->orWhere('name', 'like', "%{$selectedBrand}%");
                });
            }

            if ($inStock) {
                $productsQuery->where('quantity', '>', 0);
            }

            if ($priceType === 'quote') {
                $productsQuery->whereNull('price');
            } elseif ($priceType === 'priced') {
                $productsQuery->whereNotNull('price');
            } elseif ($priceType === 'under_100k') {
                $productsQuery->whereNotNull('price')->where('price', '<', 100000);
            } elseif ($priceType === '100k_500k') {
                $productsQuery->whereNotNull('price')->whereBetween('price', [100000, 500000]);
            } elseif ($priceType === 'above_500k') {
                $productsQuery->whereNotNull('price')->where('price', '>', 500000);
            }

            if (is_numeric($priceMin)) {
                $productsQuery->where('price', '>=', (float) $priceMin);
            }

            if (is_numeric($priceMax)) {
                $productsQuery->where('price', '<=', (float) $priceMax);
            }

            // Sorting
            match ($sort) {
                'name_asc' => $productsQuery->orderBy('name', 'asc'),
                'name_desc' => $productsQuery->orderBy('name', 'desc'),
                'price_asc' => $productsQuery->orderByRaw('CASE WHEN price IS NULL THEN 1 ELSE 0 END, COALESCE(promo_price, price) ASC')->orderBy('name', 'asc'),
                'price_desc' => $productsQuery->orderByRaw('CASE WHEN price IS NULL THEN 1 ELSE 0 END, COALESCE(promo_price, price) DESC')->orderBy('name', 'asc'),
                'newest' => $productsQuery->orderByDesc('created_at'),
                default => $productsQuery->orderByDesc('is_featured')->orderBy('sort_order')->orderByDesc('id'),
            };

            $products = $productsQuery->paginate(6)->withQueryString();
        } catch (Throwable) {
            $categories = collect();
            $brands = $defaultBrands;
            $products = new LengthAwarePaginator([], 0, 6, 1, [
                'path' => $request->url(),
                'query' => $request->query(),
            ]);
        }

        return view('home', compact(
            'products',
            'categories',
            'brands',
            'q',
            'selectedCategory',
            'selectedBrand',
            'inStock',
            'priceType',
            'priceMin',
            'priceMax',
            'sort',
            'view'
        ));
    }
}
