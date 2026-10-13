<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicHomeTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_renders_hero_and_navigation_to_catalogue(): void
    {
        $html = $this->get(route('home'))
            ->assertOk()
            ->assertSee('Référence Médico Sarl', false)
            ->assertSee('Tout le matériel', false)
            ->assertSee('pour vos soins.', false)
            ->assertSee(route('catalogue'), false)
            ->assertSee('assets/images/hero.png', false)
            ->assertSee('Produit ou référence...', false)
            ->assertSee('Matériel médical et équipements hospitaliers à Douala | Référence Médico Sarl', false)
            ->assertSee('rel="canonical"', false)
            ->assertDontSee('—', false)
            ->getContent();

        preg_match('/aria-label="Fil d\'Ariane".*?<\/nav>/s', $html, $breadcrumb);

        $this->assertNotEmpty($breadcrumb);
        $this->assertStringContainsString('Accueil', $breadcrumb[0]);
        $this->assertStringNotContainsString('Catalogue', $breadcrumb[0]);
    }

    public function test_home_renders_banners_carousel_without_automatic_modal(): void
    {
        $this->get(route('home'))
            ->assertOk()
            ->assertSee('En ce moment', false)
            ->assertSee('assets/images/banner3.jpeg', false)
            ->assertSee('assets/images/banner1.jpeg', false)
            ->assertSee('assets/images/banner2.jpeg', false)
            ->assertSee('banner4.jpeg', false)
            ->assertSee('banner5.jpeg', false)
            ->assertSee('banner6.jpeg', false)
            ->assertSee('Tout commence ici !', false)
            ->assertSee('GRACE', false)
            ->assertSee('Livraison sans limite dans toute la zone CEMAC', false)
            ->assertSee('Devenez votre propre patron', false)
            ->assertSee('partenaire phare', false)
            ->assertDontSee('modal-auto', false);
    }

    public function test_home_renders_categories_featured_products_and_method_steps(): void
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
            'is_featured' => true,
            'is_published' => true,
        ]);

        $this->get(route('home'))
            ->assertOk()
            ->assertSee('Familles d\'équipements médicaux', false)
            ->assertSee('Voir plus', false)
            ->assertSee(route('categories.index'), false)
            ->assertSee('Consultation', false)
            ->assertSee('Équipements les plus demandés', false)
            ->assertSee('Tensiomètre de poignet', false)
            ->assertSee('Trois gestes pour équiper votre établissement', false)
            ->assertSee('Parlons de votre projet', false);
    }
}
