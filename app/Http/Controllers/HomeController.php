<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;
use Throwable;

class HomeController extends Controller
{
    public function __invoke(Request $request): View
    {
        try {
            if (! Schema::hasTable('categories') || ! Schema::hasTable('products')) {
                throw new \RuntimeException('Database tables not ready yet.');
            }

            $categories = Category::query()
                ->where('is_published', true)
                ->withCount(['products' => fn ($query) => $query->where('is_published', true)])
                ->orderBy('sort_order')
                ->orderBy('name')
                ->get();

            $featuredCategories = $categories->take(6);

            $featuredProducts = Product::query()
                ->where('is_published', true)
                ->with(['category', 'coverImage'])
                ->orderByDesc('is_featured')
                ->orderBy('sort_order')
                ->orderByDesc('id')
                ->take(6)
                ->get();
        } catch (Throwable) {
            $categories = collect();
            $featuredCategories = collect();
            $featuredProducts = collect();
        }

        $banners = [
            [
                'src' => 'assets/images/banner3.jpeg',
                'title' => 'Tout commence ici ! Matériel médical de consultation et de diagnostic',
                'href' => route('catalogue'),
            ],
            [
                'src' => 'assets/images/banner1.jpeg',
                'title' => 'GRACE, plus qu\'une marque, une confiance absolue',
                'href' => route('catalogue', ['q' => 'Grace']),
            ],
            [
                'src' => 'assets/images/banner2.jpeg',
                'title' => 'Livraison sans limite dans toute la zone CEMAC',
                'href' => route('services'),
            ],
            [
                'src' => 'assets/images/banner4.jpeg',
                'title' => 'Devenez votre propre patron',
                'href' => route('contact'),
            ],
            [
                'src' => 'assets/images/banner5.jpeg',
                'title' => 'Référence Medico Sarl, le partenaire phare des hôpitaux, cliniques et écoles de médecine',
                'href' => route('about'),
            ],
            [
                'src' => 'assets/images/banner6.jpeg',
                'title' => 'Un bon équipement aujourd\'hui, une meilleure santé demain',
                'href' => route('catalogue'),
            ],
        ];

        return view('home', compact(
            'categories',
            'featuredCategories',
            'featuredProducts',
            'banners'
        ));
    }
}
