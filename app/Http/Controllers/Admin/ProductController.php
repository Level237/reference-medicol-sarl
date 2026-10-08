<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductFormRequest;
use App\Http\Requests\Admin\StoreProductRequest;
use App\Http\Requests\Admin\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Throwable;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $search = str_replace(['%', '_'], '', trim((string) $request->query('q', '')));
        $search = mb_substr($search, 0, 100);

        $products = Product::query()
            ->with(['category', 'coverImage'])
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('name', 'like', '%'.$search.'%')
                        ->orWhere('reference', 'like', '%'.$search.'%');
                });
            })
            ->orderBy('sort_order')
            ->orderBy('name')
            ->paginate(12)
            ->withQueryString();

        return view('admin.products.index', [
            'products' => $products,
            'search' => $search,
        ]);
    }

    public function create(): View
    {
        return view('admin.products.form', $this->formData(new Product([
            'sort_order' => 0,
            'is_published' => false,
            'is_featured' => false,
        ])));
    }

    public function store(StoreProductRequest $request): RedirectResponse
    {
        $product = $this->saveProduct($request);

        return redirect()
            ->route('admin.products.edit', $product)
            ->with('status', 'Le produit a été créé.');
    }

    public function edit(Product $product): View
    {
        $product->load('images');

        return view('admin.products.form', $this->formData($product));
    }

    public function update(UpdateProductRequest $request, Product $product): RedirectResponse
    {
        $this->saveProduct($request, $product);

        return redirect()
            ->route('admin.products.edit', $product)
            ->with('status', 'Le produit a été mis à jour.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $product->load('images');

        $paths = $product->images
            ->pluck('path')
            ->push($product->meta_image)
            ->filter()
            ->all();

        $product->delete();

        foreach ($paths as $path) {
            $this->deletePublicFile($path);
        }

        return redirect()
            ->route('admin.products.index')
            ->with('status', 'Le produit a été supprimé.');
    }

    /**
     * @return array<string, mixed>
     */
    private function formData(Product $product): array
    {
        return [
            'product' => $product,
            'categories' => Category::query()->orderBy('sort_order')->orderBy('name')->get(),
            'specificationRows' => $this->specificationRows($product),
        ];
    }

    /**
     * @return list<array{name: string, value: string}>
     */
    private function specificationRows(Product $product): array
    {
        $old = old('specifications');

        if (is_array($old)) {
            return array_values(array_map(function ($pair) {
                return [
                    'name' => is_array($pair) ? (string) ($pair['name'] ?? '') : '',
                    'value' => is_array($pair) ? (string) ($pair['value'] ?? '') : '',
                ];
            }, $old));
        }

        $rows = [];

        foreach ($product->specifications ?? [] as $name => $value) {
            $rows[] = [
                'name' => (string) $name,
                'value' => is_scalar($value) ? (string) $value : '',
            ];
        }

        if ($rows === []) {
            $rows[] = ['name' => '', 'value' => ''];
        }

        return $rows;
    }

    private function saveProduct(ProductFormRequest $request, ?Product $product = null): Product
    {
        $stored = [];
        $obsolete = [];

        try {
            $saved = DB::transaction(function () use ($request, $product, &$stored, &$obsolete): Product {
                if ($product === null) {
                    $product = Product::query()->create($this->attributes($request));
                } else {
                    $product->update($this->attributes($request, $product));
                }

                $this->syncMetaImage($product, $request, $stored, $obsolete);
                $this->syncGallery($product, $request, $stored, $obsolete);

                return $product;
            });
        } catch (Throwable $exception) {
            foreach ($stored as $path) {
                $this->deletePublicFile($path);
            }

            throw $exception;
        }

        foreach ($obsolete as $path) {
            $this->deletePublicFile($path);
        }

        return $saved;
    }

    /**
     * @return array<string, mixed>
     */
    private function attributes(ProductFormRequest $request, ?Product $product = null): array
    {
        $data = $request->safe()->only([
            'category_id',
            'name',
            'reference',
            'summary',
            'description',
            'price',
            'promo_price',
            'meta_title',
            'meta_description',
            'is_featured',
            'sort_order',
            'is_published',
        ]);

        $data['category_id'] = (int) $data['category_id'];
        $data['sort_order'] = (int) $data['sort_order'];
        $data['slug'] = $this->resolveSlug($request, $product);
        $data['specifications'] = $request->specifications();

        return $data;
    }

    private function resolveSlug(ProductFormRequest $request, ?Product $product = null): string
    {
        $slug = $request->validated('slug');

        if (is_string($slug) && $slug !== '') {
            return $slug;
        }

        if ($product !== null) {
            return $product->slug;
        }

        return $this->uniqueSlug((string) $request->validated('name'));
    }

    private function uniqueSlug(string $name): string
    {
        $base = Str::slug($name);

        if ($base === '') {
            $base = 'produit';
        }

        $slug = $base;
        $suffix = 2;

        while (Product::query()->where('slug', $slug)->exists()) {
            $slug = $base.'-'.$suffix;
            $suffix++;
        }

        return $slug;
    }

    /**
     * @param  list<string>  $stored
     * @param  list<string|null>  $obsolete
     */
    private function syncMetaImage(Product $product, ProductFormRequest $request, array &$stored, array &$obsolete): void
    {
        $file = $request->file('meta_image');

        if ($file instanceof UploadedFile) {
            $path = $this->storeUpload($file);
            $stored[] = $path;

            if (is_string($product->meta_image) && $product->meta_image !== '') {
                $obsolete[] = $product->meta_image;
            }

            $product->meta_image = $path;
            $product->save();

            return;
        }

        if ($request->boolean('remove_meta_image') && is_string($product->meta_image) && $product->meta_image !== '') {
            $obsolete[] = $product->meta_image;
            $product->meta_image = null;
            $product->save();
        }
    }

    /**
     * @param  list<string>  $stored
     * @param  list<string|null>  $obsolete
     */
    private function syncGallery(Product $product, ProductFormRequest $request, array &$stored, array &$obsolete): void
    {
        $removeIds = collect($request->validated('remove_image_ids') ?? [])
            ->map(fn ($id) => (int) $id);

        $existing = $request->validated('existing_images') ?? [];

        foreach ($product->images()->get() as $image) {
            if ($removeIds->contains($image->id)) {
                $obsolete[] = $image->path;
                $image->delete();

                continue;
            }

            $row = $existing[$image->id] ?? null;

            if (! is_array($row)) {
                continue;
            }

            $image->update([
                'alt' => trim((string) ($row['alt'] ?? '')),
                'sort_order' => array_key_exists('sort_order', $row) && $row['sort_order'] !== null
                    ? (int) $row['sort_order']
                    : $image->sort_order,
            ]);
        }

        $nextOrder = (int) $product->images()->max('sort_order');

        foreach ($request->file('images', []) as $index => $row) {
            $file = is_array($row) ? ($row['file'] ?? null) : null;

            if (! $file instanceof UploadedFile) {
                continue;
            }

            $path = $this->storeUpload($file);
            $stored[] = $path;
            $nextOrder++;

            $product->images()->create([
                'path' => $path,
                'alt' => trim((string) $request->input("images.$index.alt")),
                'sort_order' => $nextOrder,
            ]);
        }
    }

    private function storeUpload(UploadedFile $file): string
    {
        $path = $file->store('products', 'public');

        if (! is_string($path) || $path === '') {
            throw ValidationException::withMessages([
                'images' => 'Une photo n’a pas pu être enregistrée.',
            ]);
        }

        return $path;
    }

    private function deletePublicFile(mixed $path): void
    {
        if (! is_string($path) || $path === '' || str_contains($path, '..') || ! str_starts_with($path, 'products/')) {
            return;
        }

        Storage::disk('public')->delete($path);
    }
}
