<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicCategoriesTest extends TestCase
{
    use RefreshDatabase;

    public function test_categories_page_lists_only_published_families(): void
    {
        $consultation = Category::query()->create([
            'name' => 'Consultation',
            'slug' => 'consultation',
            'sort_order' => 2,
            'is_published' => true,
        ]);

        Category::query()->create([
            'name' => 'Bloc opératoire',
            'slug' => 'bloc-operatoire',
            'sort_order' => 1,
            'is_published' => true,
        ]);

        Category::query()->create([
            'name' => 'Catégorie masquée',
            'slug' => 'categorie-masquee',
            'is_published' => false,
        ]);

        Product::query()->create([
            'name' => 'Tensiomètre',
            'slug' => 'tensiometre',
            'category_id' => $consultation->id,
            'reference' => 'TEN-01',
            'is_published' => true,
        ]);

        $response = $this->get(route('categories.index'));

        $response
            ->assertOk()
            ->assertSee('Toutes les familles d\'équipements', false)
            ->assertSee('assets/images/about/cabinet.jpg', false)
            ->assertSee('Consultation', false)
            ->assertSee('Bloc opératoire', false)
            ->assertSee('1 référence', false)
            ->assertSee(route('catalogue', ['category' => 'consultation']), false)
            ->assertSee(route('catalogue', ['category' => 'bloc-operatoire']), false)
            ->assertDontSee('Catégorie masquée', false);

        $html = $response->getContent();
        $bloc = strpos($html, 'Bloc opératoire');
        $consultationPos = strpos($html, 'Consultation');

        $this->assertNotFalse($bloc);
        $this->assertNotFalse($consultationPos);
        $this->assertLessThan($consultationPos, $bloc);
    }
}
