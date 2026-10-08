<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CategoryFormRequest;
use App\Http\Requests\Admin\StoreCategoryRequest;
use App\Http\Requests\Admin\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Throwable;

class CategoryController extends Controller
{
    public function index(Request $request): View
    {
        $search = str_replace(['%', '_'], '', trim((string) $request->query('q', '')));
        $search = mb_substr($search, 0, 100);

        $categories = Category::query()
            ->withCount('products')
            ->when($search !== '', function ($query) use ($search) {
                $query->where('name', 'like', '%'.$search.'%');
            })
            ->orderBy('sort_order')
            ->orderBy('name')
            ->paginate(12)
            ->withQueryString();

        return view('admin.categories.index', [
            'categories' => $categories,
            'search' => $search,
        ]);
    }

    public function create(): View
    {
        return view('admin.categories.form', [
            'category' => new Category([
                'sort_order' => 0,
                'is_published' => true,
            ]),
        ]);
    }

    public function store(StoreCategoryRequest $request): RedirectResponse
    {
        $category = $this->saveCategory($request);

        return redirect()
            ->route('admin.categories.edit', $category)
            ->with('status', 'La catégorie a été créée.');
    }

    public function edit(Category $category): View
    {
        $category->loadCount('products');

        return view('admin.categories.form', [
            'category' => $category,
        ]);
    }

    public function update(UpdateCategoryRequest $request, Category $category): RedirectResponse
    {
        $this->saveCategory($request, $category);

        return redirect()
            ->route('admin.categories.edit', $category)
            ->with('status', 'La catégorie a été mise à jour.');
    }

    public function destroy(Category $category): RedirectResponse
    {
        if ($category->products()->exists()) {
            return redirect()
                ->route('admin.categories.edit', $category)
                ->with('error', 'Cette catégorie contient des produits. Déplacez-les ou retirez-les avant de la supprimer.');
        }

        $paths = array_filter([$category->image, $category->meta_image]);

        $category->delete();

        foreach ($paths as $path) {
            $this->deletePublicFile($path);
        }

        return redirect()
            ->route('admin.categories.index')
            ->with('status', 'La catégorie a été supprimée.');
    }

    private function saveCategory(CategoryFormRequest $request, ?Category $category = null): Category
    {
        $stored = [];
        $obsolete = [];

        try {
            $saved = DB::transaction(function () use ($request, $category, &$stored, &$obsolete): Category {
                $attributes = $this->attributes($request, $category);

                if ($category === null) {
                    $category = Category::query()->create($attributes);
                } else {
                    $category->update($attributes);
                }

                $this->syncFile($category, $request, 'image', 'remove_image', $stored, $obsolete);
                $this->syncFile($category, $request, 'meta_image', 'remove_meta_image', $stored, $obsolete);

                if ($request->boolean('remove_image') && ! $request->file('image')) {
                    $category->image_alt = null;
                    $category->save();
                }

                return $category;
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
    private function attributes(CategoryFormRequest $request, ?Category $category = null): array
    {
        $data = $request->safe()->only([
            'name',
            'description',
            'image_alt',
            'meta_title',
            'meta_description',
            'sort_order',
            'is_published',
        ]);

        $data['sort_order'] = (int) $data['sort_order'];
        $data['slug'] = $this->resolveSlug($request, $category);
        $data['image_alt'] = $this->blankToNull($data['image_alt'] ?? null);

        return $data;
    }

    private function resolveSlug(CategoryFormRequest $request, ?Category $category = null): string
    {
        $slug = $request->validated('slug');

        if (is_string($slug) && $slug !== '') {
            return $slug;
        }

        if ($category !== null) {
            return $category->slug;
        }

        return $this->uniqueSlug((string) $request->validated('name'));
    }

    private function uniqueSlug(string $name): string
    {
        $base = Str::slug($name);

        if ($base === '') {
            $base = 'categorie';
        }

        $slug = $base;
        $suffix = 2;

        while (Category::query()->where('slug', $slug)->exists()) {
            $slug = $base.'-'.$suffix;
            $suffix++;
        }

        return $slug;
    }

    /**
     * @param  list<string>  $stored
     * @param  list<string|null>  $obsolete
     */
    private function syncFile(Category $category, CategoryFormRequest $request, string $column, string $removeField, array &$stored, array &$obsolete): void
    {
        $file = $request->file($column);

        if ($file instanceof UploadedFile) {
            $path = $this->storeUpload($file);
            $stored[] = $path;

            if (is_string($category->{$column}) && $category->{$column} !== '') {
                $obsolete[] = $category->{$column};
            }

            $category->{$column} = $path;
            $category->save();

            return;
        }

        if ($request->boolean($removeField) && is_string($category->{$column}) && $category->{$column} !== '') {
            $obsolete[] = $category->{$column};
            $category->{$column} = null;
            $category->save();
        }
    }

    private function storeUpload(UploadedFile $file): string
    {
        $path = $file->store('categories', 'public');

        if (! is_string($path) || $path === '') {
            throw ValidationException::withMessages([
                'image' => 'L’image n’a pas pu être enregistrée.',
            ]);
        }

        return $path;
    }

    private function deletePublicFile(mixed $path): void
    {
        if (! is_string($path) || $path === '' || str_contains($path, '..') || ! str_starts_with($path, 'categories/')) {
            return;
        }

        Storage::disk('public')->delete($path);
    }

    private function blankToNull(mixed $value): ?string
    {
        if (! is_string($value)) {
            return null;
        }

        $value = trim($value);

        return $value === '' ? null : $value;
    }
}
