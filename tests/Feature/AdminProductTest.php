<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminProductTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();
        Storage::fake('public');
    }

    public function test_guessable_product_paths_are_not_registered(): void
    {
        $this->get('/admin/products')->assertNotFound();
        $this->get('/products')->assertNotFound();
    }

    public function test_guest_is_sent_to_the_login_page(): void
    {
        $this->get(route('admin.products.index'))->assertRedirect(route('access.create'));
    }

    public function test_non_admin_cannot_manage_products(): void
    {
        $this->actingAs(User::factory()->create())
            ->get(route('admin.products.index'))
            ->assertForbidden();
    }

    public function test_admin_sees_an_empty_catalog(): void
    {
        $admin = User::factory()->admin()->create(['name' => 'Awa Ndiaye']);

        $this->actingAs($admin)
            ->get(route('admin.products.index'))
            ->assertOk()
            ->assertSee('Aucun produit pour le moment.', false)
            ->assertSee('Awa Ndiaye', false)
            ->assertSee('Nouveau produit', false);
    }

    public function test_create_page_asks_for_a_category_first(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->get(route('admin.products.create'))
            ->assertOk()
            ->assertSee('Créez d’abord une catégorie.', false);
    }

    public function test_admin_can_create_a_product_with_specs_price_and_photo(): void
    {
        $admin = User::factory()->admin()->create();
        $category = $this->category();

        $response = $this->actingAs($admin)->post(route('admin.products.store'), [
            'category_id' => $category->id,
            'name' => 'Échographe portable',
            'reference' => 'ECH-100',
            'summary' => 'Pour les services de soin.',
            'description' => 'Un échographe compact.',
            'price' => '1500.00',
            'promo_price' => '1200.00',
            'specifications' => [
                ['name' => 'Écran', 'value' => '15 pouces'],
            ],
            'sort_order' => 2,
            'is_featured' => '1',
            'meta_title' => 'Échographe portable',
            'meta_description' => 'Échographe pour cliniques.',
            'images' => [
                ['file' => UploadedFile::fake()->image('face.jpg'), 'alt' => 'Vue de face'],
            ],
            'meta_image' => UploadedFile::fake()->image('partage.jpg'),
        ]);

        $product = Product::query()->first();

        $this->assertNotNull($product);
        $response->assertRedirect(route('admin.products.edit', $product));
        $this->assertSame('echographe-portable', $product->slug);
        $this->assertSame(['Écran' => '15 pouces'], $product->specifications);
        $this->assertSame('1200.00', $product->effectivePrice());
        $this->assertFalse($product->is_published);
        $this->assertTrue($product->is_featured);
        $this->assertSame(2, $product->sort_order);
        $this->assertSame('Vue de face', $product->coverImage->alt);
        Storage::disk('public')->assertExists($product->coverImage->path);
        Storage::disk('public')->assertExists($product->meta_image);
        $this->assertStringStartsWith('products/', $product->meta_image);
    }

    public function test_blank_references_do_not_collide(): void
    {
        $admin = User::factory()->admin()->create();
        $category = $this->category();

        $this->actingAs($admin)->post(route('admin.products.store'), $this->payload($category, [
            'name' => 'Échographe portable',
            'reference' => '',
        ]))->assertRedirect();

        $this->actingAs($admin)->post(route('admin.products.store'), $this->payload($category, [
            'name' => 'Moniteur',
            'reference' => '',
        ]))->assertRedirect();

        $this->assertSame(2, Product::query()->count());
        $this->assertNull(Product::query()->where('name', 'Moniteur')->first()->reference);
    }

    public function test_duplicate_names_receive_a_slug_suffix(): void
    {
        $admin = User::factory()->admin()->create();
        $category = $this->category();

        $this->actingAs($admin)->post(route('admin.products.store'), $this->payload($category, [
            'name' => 'Échographe portable',
        ]));

        $this->actingAs($admin)->post(route('admin.products.store'), $this->payload($category, [
            'name' => 'Échographe portable',
            'reference' => 'ECH-200',
        ]));

        $this->assertDatabaseHas('products', ['slug' => 'echographe-portable']);
        $this->assertDatabaseHas('products', ['slug' => 'echographe-portable-2']);
    }

    public function test_renaming_a_product_keeps_its_slug(): void
    {
        $admin = User::factory()->admin()->create();
        $category = $this->category();

        $this->actingAs($admin)->post(route('admin.products.store'), $this->payload($category));
        $product = Product::query()->first();

        $this->actingAs($admin)->put(route('admin.products.update', $product), $this->payload($category, [
            'name' => 'Échographe de service',
            'slug' => '',
        ]))->assertRedirect(route('admin.products.edit', $product));

        $this->assertSame('Échographe de service', $product->refresh()->name);
        $this->assertSame('echographe-portable', $product->slug);
    }

    public function test_promo_must_be_strictly_lower_than_the_price(): void
    {
        $admin = User::factory()->admin()->create();
        $category = $this->category();

        $this->actingAs($admin)
            ->post(route('admin.products.store'), $this->payload($category, [
                'price' => '800',
                'promo_price' => '800',
            ]))
            ->assertSessionHasErrors('promo_price');

        $this->actingAs($admin)
            ->post(route('admin.products.store'), $this->payload($category, [
                'price' => '',
                'promo_price' => '100',
            ]))
            ->assertSessionHasErrors('promo_price');

        $this->assertSame(0, Product::query()->count());
    }

    public function test_a_photo_needs_an_alternative_text_and_a_real_image(): void
    {
        $admin = User::factory()->admin()->create();
        $category = $this->category();

        $this->actingAs($admin)
            ->post(route('admin.products.store'), $this->payload($category, [
                'images' => [
                    ['file' => UploadedFile::fake()->image('face.jpg'), 'alt' => ''],
                ],
            ]))
            ->assertSessionHasErrors('images.0.alt');

        $this->actingAs($admin)
            ->post(route('admin.products.store'), $this->payload($category, [
                'images' => [
                    ['file' => UploadedFile::fake()->create('notice.pdf', 100, 'application/pdf'), 'alt' => 'Notice'],
                ],
            ]))
            ->assertSessionHasErrors('images.0.file');

        $this->assertSame(0, Product::query()->count());
    }

    public function test_admin_can_publish_update_and_remove_a_photo(): void
    {
        $admin = User::factory()->admin()->create();
        $category = $this->category();

        $this->actingAs($admin)->post(route('admin.products.store'), $this->payload($category, [
            'is_published' => '1',
            'images' => [
                ['file' => UploadedFile::fake()->image('face.jpg'), 'alt' => 'Vue de face'],
            ],
        ]));

        $product = Product::query()->first();
        $image = $product->coverImage;
        $path = $image->path;

        $this->assertTrue($product->is_published);

        $this->actingAs($admin)->put(route('admin.products.update', $product), $this->payload($category, [
            'slug' => $product->slug,
            'existing_images' => [
                $image->id => [
                    'id' => $image->id,
                    'alt' => 'Vue de face recadrée',
                    'sort_order' => 1,
                ],
            ],
            'images' => [
                ['file' => UploadedFile::fake()->image('cote.jpg'), 'alt' => 'Vue de côté'],
            ],
        ]))->assertRedirect(route('admin.products.edit', $product));

        $this->assertFalse($product->refresh()->is_published);
        $this->assertSame('Vue de face recadrée', $image->refresh()->alt);
        $this->assertSame(2, $product->images()->count());

        $this->actingAs($admin)->put(route('admin.products.update', $product), $this->payload($category, [
            'slug' => $product->slug,
            'remove_image_ids' => [$image->id],
            'existing_images' => [
                $image->id => [
                    'id' => $image->id,
                    'alt' => '',
                    'sort_order' => 1,
                ],
            ],
        ]))->assertRedirect();

        $this->assertNull(ProductImage::query()->find($image->id));
        Storage::disk('public')->assertMissing($path);
        $this->assertSame(1, $product->images()->count());
    }

    public function test_admin_cannot_remove_a_photo_from_another_product(): void
    {
        $admin = User::factory()->admin()->create();
        $category = $this->category();

        $this->actingAs($admin)->post(route('admin.products.store'), $this->payload($category, [
            'name' => 'Échographe portable',
            'images' => [
                ['file' => UploadedFile::fake()->image('face.jpg'), 'alt' => 'Vue de face'],
            ],
        ]));

        $this->actingAs($admin)->post(route('admin.products.store'), $this->payload($category, [
            'name' => 'Moniteur',
            'reference' => 'MON-1',
            'images' => [
                ['file' => UploadedFile::fake()->image('moniteur.jpg'), 'alt' => 'Moniteur'],
            ],
        ]));

        $first = Product::query()->where('name', 'Échographe portable')->first();
        $second = Product::query()->where('name', 'Moniteur')->first();

        $this->actingAs($admin)->put(route('admin.products.update', $second), $this->payload($category, [
            'name' => 'Moniteur',
            'reference' => 'MON-1',
            'slug' => $second->slug,
            'remove_image_ids' => [$first->coverImage->id],
        ]))->assertSessionHasErrors('remove_image_ids.0');

        $this->assertNotNull(ProductImage::query()->find($first->coverImage->id));
    }

    public function test_deleting_a_product_removes_its_files(): void
    {
        $admin = User::factory()->admin()->create();
        $category = $this->category();

        $this->actingAs($admin)->post(route('admin.products.store'), $this->payload($category, [
            'images' => [
                ['file' => UploadedFile::fake()->image('face.jpg'), 'alt' => 'Vue de face'],
            ],
            'meta_image' => UploadedFile::fake()->image('partage.jpg'),
        ]));

        $product = Product::query()->first();
        $photo = $product->coverImage->path;
        $meta = $product->meta_image;

        $this->actingAs($admin)
            ->delete(route('admin.products.destroy', $product))
            ->assertRedirect(route('admin.products.index'));

        $this->assertModelMissing($product);
        $this->assertSame(0, ProductImage::query()->count());
        Storage::disk('public')->assertMissing($photo);
        Storage::disk('public')->assertMissing($meta);
    }

    public function test_the_list_can_be_filtered_by_name(): void
    {
        $admin = User::factory()->admin()->create();
        $category = $this->category();

        Product::query()->create([
            'category_id' => $category->id,
            'name' => 'Scanner 16 barrettes',
            'slug' => 'scanner-16-barrettes',
        ]);

        Product::query()->create([
            'category_id' => $category->id,
            'name' => 'Moniteur multiparamétrique',
            'slug' => 'moniteur-multiparametrique',
        ]);

        $this->actingAs($admin)
            ->get(route('admin.products.index', ['q' => 'Scanner']))
            ->assertOk()
            ->assertSee('Scanner 16 barrettes', false)
            ->assertDontSee('Moniteur multiparamétrique', false);
    }

    private function category(): Category
    {
        return Category::query()->create([
            'name' => 'Imagerie',
            'slug' => 'imagerie',
        ]);
    }

    /**
     * @param  array<string, mixed>  $overrides
     * @return array<string, mixed>
     */
    private function payload(Category $category, array $overrides = []): array
    {
        return array_merge([
            'category_id' => $category->id,
            'name' => 'Échographe portable',
            'reference' => 'ECH-100',
            'price' => '1500',
            'promo_price' => '1200',
            'sort_order' => 0,
        ], $overrides);
    }
}
