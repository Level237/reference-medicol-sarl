<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicHomeTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_renders_the_public_header_and_topbar(): void
    {
        $this->get(route('home'))
            ->assertOk()
            ->assertSee('Référence Médico Sarl', false)
            ->assertSee('assets/images/logo.png', false)
            ->assertSee('+237 699 850 500', false)
            ->assertSee('jacquesmaud@referencemedicosarl.com', false)
            ->assertSee('Catalogue', false)
            ->assertSee('Nos services', false)
            ->assertSee('À propos', false)
            ->assertSee('Contact', false)
            ->assertSee('Demander un devis', false)
            ->assertSee('id="menu-mobile"', false)
            ->assertSee('Tout le matériel', false)
            ->assertSee('pour vos soins.', false)
            ->assertSee('Des équipements fiables pour les professionnels de santé', false)
            ->assertSee('assets/images/hero.png', false)
            ->assertSee('Produit ou référence...', false)
            ->assertSee('Toutes les catégories', false)
            ->assertSee('id="hero-category-select"', false)
            ->assertSee('Filtres', false)
            ->assertSee('Catégories', false)
            ->assertSee('Disponibilité', false)
            ->assertSee('Prix', false);
    }

    public function test_home_renders_products_and_filters_correctly(): void
    {
        $category = Category::query()->create([
            'name' => 'Consultation',
            'slug' => 'consultation',
            'is_published' => true,
        ]);

        Product::query()->create([
            'name' => 'Tensiomètre de poignet',
            'slug' => 'tensiometre-de-poignet',
            'category_id' => $category->id,
            'reference' => 'TEN-01',
            'quantity' => 10,
            'is_published' => true,
        ]);

        Product::query()->create([
            'name' => 'Microscope binoculaire',
            'slug' => 'microscope-binoculaire',
            'category_id' => $category->id,
            'reference' => 'MIC-02',
            'quantity' => 0,
            'is_published' => true,
        ]);

        $this->get(route('home'))
            ->assertOk()
            ->assertSee('Tensiomètre de poignet', false)
            ->assertSee('Microscope binoculaire', false)
            ->assertSee('Sur devis', false)
            ->assertSee('Voir le produit', false);

        // Filter by in_stock
        $this->get(route('home', ['in_stock' => '1']))
            ->assertOk()
            ->assertSee('Tensiomètre de poignet', false)
            ->assertDontSee('Microscope binoculaire', false);

        // Filter by search query
        $this->get(route('home', ['q' => 'Tensiomètre']))
            ->assertOk()
            ->assertSee('Tensiomètre de poignet', false)
            ->assertDontSee('Microscope binoculaire', false);
    }

    public function test_home_renders_responsive_filter_bottom_sheet_on_mobile(): void
    {
        $this->get(route('home'))
            ->assertOk()
            ->assertSee('id="open-filters-mobile"', false)
            ->assertSee('id="mobile-filter-sheet"', false)
            ->assertSee('id="close-filters-mobile"', false)
            ->assertSee('id="mobile-filters-form"', false)
            ->assertSee('Appliquer les filtres', false);
    }
}
