<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Services\CartService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicSeoTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_pages_expose_a_title_and_a_description(): void
    {
        $pages = [
            'home' => 'Matériel médical et équipements hospitaliers à Douala | Référence Médico Sarl',
            'catalogue' => 'Catalogue de matériel et équipements médicaux | Référence Médico Sarl',
            'categories.index' => 'Catégories | Référence Médico Sarl',
            'services' => 'Nos services | Référence Médico Sarl',
            'about' => 'À propos | Référence Médico Sarl',
            'contact' => 'Contact | Référence Médico Sarl',
            'cart.index' => 'Mon panier de devis | Référence Médico Sarl',
        ];

        foreach ($pages as $route => $title) {
            $this->get(route($route))
                ->assertOk()
                ->assertSee('<title>'.$title.'</title>', false)
                ->assertSee('<meta name="description" content="', false)
                ->assertSee('rel="canonical"', false);
        }

        $category = Category::query()->create([
            'name' => 'Consultation',
            'slug' => 'consultation',
            'is_published' => true,
        ]);

        $product = Product::query()->create([
            'name' => 'Tensiomètre',
            'slug' => 'tensiometre',
            'category_id' => $category->id,
            'reference' => 'TEN-01',
            'is_published' => true,
        ]);

        app(CartService::class)->add($product, 1);

        $this->get(route('quotes.create'))
            ->assertOk()
            ->assertSee('<title>Demande de devis | Référence Médico Sarl</title>', false)
            ->assertSee('<meta name="description" content="', false)
            ->assertSee('noindex, nofollow', false);
    }

    public function test_home_share_image_is_the_hospital_banner(): void
    {
        $this->get(route('home'))
            ->assertOk()
            ->assertSee('property="og:image" content="'.asset('assets/images/banner6.jpeg').'"', false)
            ->assertSee('property="og:image:width" content="1034"', false)
            ->assertSee('property="og:image:height" content="634"', false)
            ->assertSee('name="twitter:image" content="'.asset('assets/images/banner6.jpeg').'"', false);
    }

    public function test_catalogue_category_uses_its_own_meta_and_search_stays_out_of_the_index(): void
    {
        Category::query()->create([
            'name' => 'Imagerie',
            'slug' => 'imagerie',
            'meta_title' => 'Imagerie médicale',
            'meta_description' => 'Échographes et radios pour les plateaux techniques.',
            'is_published' => true,
        ]);

        $this->get(route('catalogue', ['category' => 'imagerie']))
            ->assertOk()
            ->assertSee('<title>Imagerie médicale | Référence Médico Sarl</title>', false)
            ->assertSee('Échographes et radios pour les plateaux techniques.', false)
            ->assertSee('content="index, follow"', false);

        $this->get(route('catalogue', ['q' => 'tensiometre']))
            ->assertOk()
            ->assertSee('content="noindex, follow"', false);
    }
}
