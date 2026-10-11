<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicProductShowTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_view_published_product_detail_page(): void
    {
        $category = Category::query()->create([
            'name' => 'Imagerie médicale',
            'slug' => 'imagerie-medicale',
            'is_published' => true,
        ]);

        $product = Product::query()->create([
            'category_id' => $category->id,
            'name' => 'Échographe Doppler Portable',
            'slug' => 'echographe-doppler-portable',
            'reference' => 'ECH-DOP-01',
            'summary' => 'Échographe haute résolution pour diagnostic rapide.',
            'description' => 'Sondes multiples pour cardiologie et obstétrique.',
            'specifications' => [
                'Écran' => '15 pouces LED',
                'Poids' => '4.5 kg',
                'Autonomie' => '3 heures',
            ],
            'price' => 3500000,
            'promo_price' => 3200000,
            'quantity' => 5,
            'is_published' => true,
        ]);

        $this->get(route('products.show', $product->slug))
            ->assertOk()
            ->assertSee('Échographe Doppler Portable', false)
            ->assertSee('Imagerie médicale', false)
            ->assertSee('REF: ECH-DOP-01', false)
            ->assertSee('3 200 000', false)
            ->assertSee('3 500 000', false)
            ->assertSee('Écran', false)
            ->assertSee('15 pouces LED', false)
            ->assertSee('Ajouter au devis', false);
    }

    public function test_unpublished_product_returns_404(): void
    {
        $category = Category::query()->create([
            'name' => 'Consultation',
            'slug' => 'consultation',
            'is_published' => true,
        ]);

        $product = Product::query()->create([
            'category_id' => $category->id,
            'name' => 'Produit Masqué',
            'slug' => 'produit-masque',
            'is_published' => false,
        ]);

        $this->get(route('products.show', $product->slug))
            ->assertNotFound();
    }

    public function test_can_add_product_to_cart_via_standard_post(): void
    {
        $category = Category::query()->create([
            'name' => 'Laboratoire',
            'slug' => 'laboratoire',
            'is_published' => true,
        ]);

        $product = Product::query()->create([
            'category_id' => $category->id,
            'name' => 'Centrifugeuse de Paillasse',
            'slug' => 'centrifugeuse-de-paillasse',
            'is_published' => true,
        ]);

        $response = $this->post(route('cart.store'), [
            'product_id' => $product->id,
            'quantity' => 2,
        ]);

        $response->assertSessionHas('cart_success');
        $this->assertSame(2, app(\App\Services\CartService::class)->count());
    }

    public function test_can_add_product_to_cart_via_ajax(): void
    {
        $category = Category::query()->create([
            'name' => 'Mobilier',
            'slug' => 'mobilier',
            'is_published' => true,
        ]);

        $product = Product::query()->create([
            'category_id' => $category->id,
            'name' => 'Lit Médicalisé Électrique',
            'slug' => 'lit-medicalise-electrique',
            'is_published' => true,
        ]);

        $response = $this->postJson(route('cart.store'), [
            'product_id' => $product->id,
            'quantity' => 3,
        ]);

        $response->assertOk()
            ->assertJson([
                'success' => true,
                'count' => 3,
            ]);
    }
}
