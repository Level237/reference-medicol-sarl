<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CatalogSchemaTest extends TestCase
{
    use RefreshDatabase;

    public function test_category_profile_image_can_be_empty(): void
    {
        $category = Category::create([
            'name' => 'Imagerie',
            'slug' => 'imagerie',
            'meta_title' => 'Imagerie médicale',
            'meta_description' => 'Appareils d’imagerie pour hôpitaux et cliniques.',
        ]);

        $category->refresh();

        $this->assertNull($category->image);
        $this->assertNull($category->image_alt);
        $this->assertNull($category->meta_image);
        $this->assertTrue($category->is_published);
        $this->assertSame('Imagerie médicale', $category->meta_title);
    }

    public function test_product_cover_is_the_first_gallery_image(): void
    {
        $category = Category::create([
            'name' => 'Imagerie',
            'slug' => 'imagerie',
        ]);

        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'Échographe portable',
            'slug' => 'echographe-portable',
            'specifications' => ['Écran' => '15 pouces'],
            'meta_title' => 'Échographe portable',
            'meta_description' => 'Échographe portable pour cliniques et hôpitaux.',
            'meta_image' => 'seo/echographe.jpg',
        ]);

        ProductImage::create([
            'product_id' => $product->id,
            'path' => 'products/cote.jpg',
            'alt' => 'Vue de côté',
            'sort_order' => 2,
        ]);

        ProductImage::create([
            'product_id' => $product->id,
            'path' => 'products/face.jpg',
            'alt' => 'Vue de face',
            'sort_order' => 1,
        ]);

        $product->refresh();

        $this->assertFalse($product->is_published);
        $this->assertSame(['Écran' => '15 pouces'], $product->specifications);
        $this->assertSame('seo/echographe.jpg', $product->meta_image);
        $this->assertSame('products/face.jpg', $product->coverImage->path);
        $this->assertSame('Vue de face', $product->coverImage->alt);
        $this->assertSame(
            ['products/face.jpg', 'products/cote.jpg'],
            $product->images->pluck('path')->all(),
        );
    }

    public function test_deleting_a_product_deletes_its_images(): void
    {
        $category = Category::create([
            'name' => 'Imagerie',
            'slug' => 'imagerie',
        ]);

        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'Échographe portable',
            'slug' => 'echographe-portable',
        ]);

        ProductImage::create([
            'product_id' => $product->id,
            'path' => 'products/face.jpg',
            'sort_order' => 1,
        ]);

        $product->delete();

        $this->assertSame(0, ProductImage::query()->count());
        $this->assertModelExists($category);
    }

    public function test_category_with_products_cannot_be_deleted(): void
    {
        $category = Category::create([
            'name' => 'Imagerie',
            'slug' => 'imagerie',
        ]);

        Product::create([
            'category_id' => $category->id,
            'name' => 'Échographe portable',
            'slug' => 'echographe-portable',
        ]);

        $this->expectException(QueryException::class);

        $category->delete();
    }

    public function test_product_uses_promo_price_only_when_it_is_lower(): void
    {
        $category = Category::create([
            'name' => 'Imagerie',
            'slug' => 'imagerie',
        ]);

        $promo = Product::create([
            'category_id' => $category->id,
            'name' => 'Échographe portable',
            'slug' => 'echographe-portable',
            'reference' => 'ECH-100',
            'price' => '1500.00',
            'promo_price' => '1200.00',
            'sort_order' => 2,
            'is_featured' => true,
        ]);

        $promo->refresh();

        $this->assertSame('ECH-100', $promo->reference);
        $this->assertSame('1200.00', $promo->effectivePrice());
        $this->assertSame('1500.00', $promo->compareAtPrice());
        $this->assertTrue($promo->is_featured);
        $this->assertSame(2, $promo->sort_order);

        $regular = Product::create([
            'category_id' => $category->id,
            'name' => 'Moniteur',
            'slug' => 'moniteur',
            'price' => '800.00',
            'promo_price' => '800.00',
        ]);

        $regular->refresh();

        $this->assertSame('800.00', $regular->effectivePrice());
        $this->assertNull($regular->compareAtPrice());
        $this->assertFalse($regular->is_featured);
        $this->assertSame(0, $regular->sort_order);

        $onQuote = Product::create([
            'category_id' => $category->id,
            'name' => 'Scanner',
            'slug' => 'scanner',
        ]);

        $onQuote->refresh();

        $this->assertNull($onQuote->price);
        $this->assertNull($onQuote->promo_price);
        $this->assertNull($onQuote->effectivePrice());
        $this->assertNull($onQuote->compareAtPrice());
    }
}
