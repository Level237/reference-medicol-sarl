<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Services\CartService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicCartTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_view_empty_cart_page(): void
    {
        $response = $this->get(route('cart.index'));

        $response->assertOk()
            ->assertSee('Mon panier de devis', false)
            ->assertSee('Rassemblez vos équipements dans une seule demande.', false)
            ->assertSee('Votre panier de devis est vide', false)
            ->assertSee('Parcourir le catalogue', false);
    }

    public function test_can_view_cart_with_items(): void
    {
        $category = Category::query()->create([
            'name' => 'Diagnostic',
            'slug' => 'diagnostic',
            'is_published' => true,
        ]);

        $product = Product::query()->create([
            'category_id' => $category->id,
            'name' => 'Tensiomètre de poignet BP 202H',
            'slug' => 'tensiometre-de-poignet-bp-202h',
            'reference' => 'BP 202H',
            'summary' => 'Surveillance simple et rapide de la tension artérielle.',
            'is_published' => true,
        ]);

        app(CartService::class)->add($product, 2);

        $response = $this->get(route('cart.index'));

        $response->assertOk()
            ->assertSee('Tensiomètre de poignet BP 202H', false)
            ->assertSee('BP 202H', false)
            ->assertSee('Surveillance simple et rapide', false)
            ->assertSee('Votre sélection', false)
            ->assertSee('2 articles', false)
            ->assertSee('Finaliser ma demande', false)
            ->assertSee('Continuer mes recherches', false)
            ->assertSee('+237 699 850 500', false);
    }

    public function test_can_update_item_quantity_via_ajax(): void
    {
        $category = Category::query()->create([
            'name' => 'Cardio',
            'slug' => 'cardio',
            'is_published' => true,
        ]);

        $product = Product::query()->create([
            'category_id' => $category->id,
            'name' => 'Moniteur multiparamétrique',
            'slug' => 'moniteur-multiparametrique',
            'price' => 1500000,
            'is_published' => true,
        ]);

        app(CartService::class)->add($product, 1);

        $response = $this->patchJson(route('cart.update', $product->id), [
            'quantity' => 4,
        ]);

        $response->assertOk()
            ->assertJson([
                'success' => true,
                'count' => 4,
                'quantity' => 4,
            ]);

        $this->assertSame(4, app(CartService::class)->count());
    }

    public function test_can_remove_item_from_cart_via_ajax(): void
    {
        $category = Category::query()->create([
            'name' => 'Stérilisation',
            'slug' => 'sterilisation',
            'is_published' => true,
        ]);

        $product = Product::query()->create([
            'category_id' => $category->id,
            'name' => 'Autoclave de paillasse',
            'slug' => 'autoclave-de-paillasse',
            'is_published' => true,
        ]);

        app(CartService::class)->add($product, 1);

        $response = $this->deleteJson(route('cart.destroy', $product->id));

        $response->assertOk()
            ->assertJson([
                'success' => true,
                'count' => 0,
                'is_empty' => true,
            ]);

        $this->assertSame(0, app(CartService::class)->count());
    }
}
