<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SitemapTest extends TestCase
{
    use RefreshDatabase;

    public function test_sitemap_lists_static_pages_and_published_catalogue_entries(): void
    {
        $category = Category::query()->create([
            'name' => 'Imagerie',
            'slug' => 'imagerie',
            'is_published' => true,
        ]);

        Category::query()->create([
            'name' => 'Brouillon',
            'slug' => 'brouillon',
            'is_published' => false,
        ]);

        $product = Product::query()->create([
            'category_id' => $category->id,
            'name' => 'Échographe',
            'slug' => 'echographe',
            'reference' => 'ECH-01',
            'is_published' => true,
        ]);

        Product::query()->create([
            'category_id' => $category->id,
            'name' => 'Produit masqué',
            'slug' => 'produit-masque',
            'reference' => 'HID-01',
            'is_published' => false,
        ]);

        $response = $this->get(route('sitemap'));

        $response->assertOk();
        $this->assertStringContainsString('xml', (string) $response->headers->get('Content-Type'));

        $response
            ->assertSee('<urlset', false)
            ->assertSee(route('home'), false)
            ->assertSee(route('catalogue'), false)
            ->assertSee(route('categories.index'), false)
            ->assertSee(route('services'), false)
            ->assertSee(route('about'), false)
            ->assertSee(route('contact'), false)
            ->assertSee(route('catalogue', ['category' => 'imagerie']), false)
            ->assertSee(route('products.show', $product->slug), false)
            ->assertDontSee('brouillon', false)
            ->assertDontSee('produit-masque', false)
            ->assertDontSee(route('cart.index'), false)
            ->assertDontSee(route('quotes.create'), false);
    }

    public function test_robots_points_to_the_sitemap_and_hides_private_paths(): void
    {
        $this->get(route('robots'))
            ->assertOk()
            ->assertSee('User-agent: *', false)
            ->assertSee('Disallow: /panier', false)
            ->assertSee('Disallow: /devis', false)
            ->assertSee('Sitemap: '.route('sitemap'), false);
    }
}
