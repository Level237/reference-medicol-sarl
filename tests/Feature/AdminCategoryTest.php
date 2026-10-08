<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminCategoryTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();
        Storage::fake('public');
    }

    public function test_guessable_category_paths_are_not_registered(): void
    {
        $this->get('/admin/categories')->assertNotFound();
        $this->get('/categories')->assertNotFound();
    }

    public function test_guest_is_sent_to_the_login_page(): void
    {
        $this->get(route('admin.categories.index'))->assertRedirect(route('access.create'));
    }

    public function test_non_admin_cannot_manage_categories(): void
    {
        $this->actingAs(User::factory()->create())
            ->get(route('admin.categories.index'))
            ->assertForbidden();
    }

    public function test_admin_sees_an_empty_list(): void
    {
        $admin = User::factory()->admin()->create(['name' => 'Awa Ndiaye']);

        $this->actingAs($admin)
            ->get(route('admin.categories.index'))
            ->assertOk()
            ->assertSee('Aucune catégorie pour le moment.', false)
            ->assertSee('Awa Ndiaye', false)
            ->assertSee('Nouvelle catégorie', false);
    }

    public function test_a_new_category_is_published_by_default(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->get(route('admin.categories.create'))
            ->assertOk()
            ->assertSee('name="is_published"', false)
            ->assertSee('checked', false);

        $response = $this->actingAs($admin)->post(route('admin.categories.store'), [
            'name' => 'Imagerie',
            'description' => 'Appareils d’imagerie.',
            'is_published' => '1',
            'sort_order' => 3,
            'meta_title' => 'Imagerie médicale',
            'meta_description' => 'Famille imagerie.',
        ]);

        $category = Category::query()->first();

        $this->assertNotNull($category);
        $response->assertRedirect(route('admin.categories.edit', $category));
        $this->assertSame('imagerie', $category->slug);
        $this->assertTrue($category->is_published);
        $this->assertSame(3, $category->sort_order);
        $this->assertNull($category->image);
        $this->assertSame('Imagerie médicale', $category->meta_title);
    }

    public function test_admin_can_attach_a_profile_image_with_an_alternative_text(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)->post(route('admin.categories.store'), [
            'name' => 'Imagerie',
            'is_published' => '1',
            'image' => UploadedFile::fake()->image('imagerie.jpg'),
            'image_alt' => 'Salle d’imagerie',
            'meta_image' => UploadedFile::fake()->image('partage.jpg'),
        ])->assertRedirect();

        $category = Category::query()->first();

        $this->assertSame('Salle d’imagerie', $category->image_alt);
        $this->assertStringStartsWith('categories/', $category->image);
        $this->assertStringStartsWith('categories/', $category->meta_image);
        Storage::disk('public')->assertExists($category->image);
        Storage::disk('public')->assertExists($category->meta_image);
    }

    public function test_a_profile_image_needs_an_alternative_text_and_a_real_image(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->post(route('admin.categories.store'), [
                'name' => 'Imagerie',
                'image' => UploadedFile::fake()->image('imagerie.jpg'),
                'image_alt' => '',
            ])
            ->assertSessionHasErrors('image_alt');

        $this->actingAs($admin)
            ->post(route('admin.categories.store'), [
                'name' => 'Imagerie',
                'image' => UploadedFile::fake()->create('notice.pdf', 100, 'application/pdf'),
                'image_alt' => 'Notice',
            ])
            ->assertSessionHasErrors('image');

        $this->assertSame(0, Category::query()->count());
    }

    public function test_duplicate_names_receive_a_slug_suffix_and_a_rename_keeps_the_slug(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)->post(route('admin.categories.store'), [
            'name' => 'Imagerie',
            'is_published' => '1',
        ]);

        $this->actingAs($admin)->post(route('admin.categories.store'), [
            'name' => 'Imagerie',
            'is_published' => '1',
        ]);

        $this->assertDatabaseHas('categories', ['slug' => 'imagerie']);
        $this->assertDatabaseHas('categories', ['slug' => 'imagerie-2']);

        $category = Category::query()->where('slug', 'imagerie')->first();

        $this->actingAs($admin)->put(route('admin.categories.update', $category), [
            'name' => 'Imagerie médicale',
            'slug' => '',
            'is_published' => '1',
        ])->assertRedirect(route('admin.categories.edit', $category));

        $this->assertSame('Imagerie médicale', $category->refresh()->name);
        $this->assertSame('imagerie', $category->slug);
    }

    public function test_a_category_with_products_cannot_be_deleted(): void
    {
        $admin = User::factory()->admin()->create();
        $category = Category::query()->create([
            'name' => 'Imagerie',
            'slug' => 'imagerie',
        ]);

        Product::query()->create([
            'category_id' => $category->id,
            'name' => 'Échographe portable',
            'slug' => 'echographe-portable',
        ]);

        $this->actingAs($admin)
            ->delete(route('admin.categories.destroy', $category))
            ->assertRedirect(route('admin.categories.edit', $category))
            ->assertSessionHas('error');

        $this->assertModelExists($category);
    }

    public function test_deleting_an_empty_category_removes_its_files(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)->post(route('admin.categories.store'), [
            'name' => 'Imagerie',
            'is_published' => '1',
            'image' => UploadedFile::fake()->image('imagerie.jpg'),
            'image_alt' => 'Salle d’imagerie',
            'meta_image' => UploadedFile::fake()->image('partage.jpg'),
        ]);

        $category = Category::query()->first();
        $image = $category->image;
        $meta = $category->meta_image;

        $this->actingAs($admin)
            ->delete(route('admin.categories.destroy', $category))
            ->assertRedirect(route('admin.categories.index'));

        $this->assertModelMissing($category);
        Storage::disk('public')->assertMissing($image);
        Storage::disk('public')->assertMissing($meta);
    }

    public function test_the_list_can_be_filtered_by_name(): void
    {
        $admin = User::factory()->admin()->create();

        Category::query()->create([
            'name' => 'Imagerie',
            'slug' => 'imagerie',
        ]);

        Category::query()->create([
            'name' => 'Bloc opératoire',
            'slug' => 'bloc-operatoire',
        ]);

        $this->actingAs($admin)
            ->get(route('admin.categories.index', ['q' => 'Bloc']))
            ->assertOk()
            ->assertSee('Bloc opératoire', false)
            ->assertDontSee('Imagerie', false);
    }
}
