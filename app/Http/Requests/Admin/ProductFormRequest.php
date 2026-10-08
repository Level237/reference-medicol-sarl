<?php

namespace App\Http\Requests\Admin;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

abstract class ProductFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->is_admin === true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return $this->baseRules();
    }

    /**
     * @return array<string, string>|null
     */
    public function specifications(): ?array
    {
        $pairs = $this->validated('specifications') ?? [];
        $specifications = [];

        foreach ($pairs as $pair) {
            if (! is_array($pair)) {
                continue;
            }

            $name = trim((string) ($pair['name'] ?? ''));
            $value = trim((string) ($pair['value'] ?? ''));

            if ($name === '' || $value === '') {
                continue;
            }

            $specifications[$name] = $value;
        }

        return $specifications === [] ? null : $specifications;
    }

    /**
     * @return array<string, mixed>
     */
    protected function baseRules(): array
    {
        return [
            'category_id' => ['required', 'integer', Rule::exists('categories', 'id')],
            'name' => ['required', 'string', 'max:255'],
            'slug' => [
                'nullable',
                'string',
                'max:255',
                'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
                Rule::unique('products', 'slug')->ignore($this->productId()),
            ],
            'reference' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('products', 'reference')->ignore($this->productId()),
            ],
            'summary' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:20000'],
            'specifications' => ['nullable', 'array'],
            'specifications.*.name' => ['nullable', 'string', 'max:255'],
            'specifications.*.value' => ['nullable', 'string', 'max:1000'],
            'price' => ['nullable', 'numeric', 'min:0', 'decimal:0,2'],
            'promo_price' => ['nullable', 'numeric', 'min:0', 'decimal:0,2'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:320'],
            'meta_image' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:5120'],
            'remove_meta_image' => ['sometimes', 'boolean'],
            'is_featured' => ['sometimes', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:1000000'],
            'is_published' => ['sometimes', 'boolean'],
            'images' => ['nullable', 'array'],
            'images.*.file' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:5120'],
            'images.*.alt' => ['nullable', 'string', 'max:255'],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    protected function galleryRules(): array
    {
        $productId = $this->productId() ?? 0;

        return [
            'existing_images' => ['nullable', 'array'],
            'existing_images.*.id' => [
                'required',
                'integer',
                Rule::exists('product_images', 'id')->where(
                    fn ($query) => $query->where('product_id', $productId),
                ),
            ],
            'existing_images.*.alt' => ['nullable', 'string', 'max:255'],
            'existing_images.*.sort_order' => ['nullable', 'integer', 'min:0', 'max:1000000'],
            'remove_image_ids' => ['nullable', 'array'],
            'remove_image_ids.*' => [
                'integer',
                Rule::exists('product_images', 'id')->where(
                    fn ($query) => $query->where('product_id', $productId),
                ),
            ],
        ];
    }

    protected function prepareForValidation(): void
    {
        $slug = $this->input('slug');

        if (is_string($slug)) {
            $slug = Str::slug($slug);
            $slug = $slug === '' ? null : $slug;
        }

        $this->merge([
            'slug' => $slug,
            'is_published' => $this->boolean('is_published'),
            'is_featured' => $this->boolean('is_featured'),
            'remove_meta_image' => $this->boolean('remove_meta_image'),
            'sort_order' => $this->filled('sort_order') ? $this->input('sort_order') : 0,
        ]);
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator): void {
            $this->validateSpecifications($validator);
            $this->validatePrices($validator);
            $this->validateNewImages($validator);
            $this->validateExistingImages($validator);
        });
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'category_id.required' => 'Choisissez une catégorie.',
            'category_id.exists' => 'Cette catégorie n’existe pas.',
            'name.required' => 'Indiquez le nom du produit.',
            'name.max' => 'Le nom ne peut pas dépasser 255 caractères.',
            'slug.regex' => 'Le slug ne peut contenir que des lettres minuscules, des chiffres et des tirets.',
            'slug.unique' => 'Ce slug est déjà utilisé.',
            'reference.unique' => 'Cette référence est déjà utilisée.',
            'reference.max' => 'La référence ne peut pas dépasser 255 caractères.',
            'summary.max' => 'Le résumé ne peut pas dépasser 255 caractères.',
            'price.numeric' => 'Le prix doit être un nombre.',
            'price.min' => 'Le prix ne peut pas être négatif.',
            'price.decimal' => 'Le prix ne peut pas avoir plus de deux décimales.',
            'promo_price.numeric' => 'Le prix promo doit être un nombre.',
            'promo_price.min' => 'Le prix promo ne peut pas être négatif.',
            'promo_price.decimal' => 'Le prix promo ne peut pas avoir plus de deux décimales.',
            'meta_description.max' => 'La meta description ne peut pas dépasser 320 caractères.',
            'meta_image.image' => 'L’image de référencement doit être une photo.',
            'meta_image.mimes' => 'L’image de référencement doit être au format JPEG, PNG ou WebP.',
            'meta_image.max' => 'L’image de référencement ne peut pas dépasser 5 Mo.',
            'images.*.file.image' => 'Chaque fichier doit être une photo.',
            'images.*.file.mimes' => 'Les photos doivent être au format JPEG, PNG ou WebP.',
            'images.*.file.max' => 'Une photo ne peut pas dépasser 5 Mo.',
            'sort_order.integer' => 'L’ordre d’affichage doit être un nombre entier.',
            'sort_order.min' => 'L’ordre d’affichage ne peut pas être négatif.',
            'remove_image_ids.*.exists' => 'Cette photo n’appartient pas à ce produit.',
            'existing_images.*.id.exists' => 'Cette photo n’appartient pas à ce produit.',
        ];
    }

    protected function validateSpecifications(Validator $validator): void
    {
        $seen = [];

        foreach ($this->input('specifications', []) as $index => $pair) {
            if (! is_array($pair)) {
                continue;
            }

            $name = trim((string) ($pair['name'] ?? ''));
            $value = trim((string) ($pair['value'] ?? ''));

            if ($name === '' && $value === '') {
                continue;
            }

            if ($name === '') {
                $validator->errors()->add("specifications.$index.name", 'Indiquez le nom de la caractéristique.');
            }

            if ($value === '') {
                $validator->errors()->add("specifications.$index.value", 'Indiquez la valeur de la caractéristique.');
            }

            if ($name === '') {
                continue;
            }

            $key = mb_strtolower($name);

            if (isset($seen[$key])) {
                $validator->errors()->add("specifications.$index.name", 'Ce nom de caractéristique est déjà utilisé.');
            }

            $seen[$key] = true;
        }
    }

    protected function validatePrices(Validator $validator): void
    {
        $price = $this->input('price');
        $promo = $this->input('promo_price');

        if ($promo === null || $promo === '') {
            return;
        }

        if ($price === null || $price === '' || ! is_numeric($price)) {
            $validator->errors()->add('promo_price', 'Indiquez un prix avant le prix promo.');

            return;
        }

        if (! is_numeric($promo)) {
            return;
        }

        if ($this->toCents((string) $promo) >= $this->toCents((string) $price)) {
            $validator->errors()->add('promo_price', 'Le prix promo doit être strictement inférieur au prix.');
        }
    }

    protected function validateNewImages(Validator $validator): void
    {
        foreach ($this->input('images', []) as $index => $row) {
            if (! is_array($row)) {
                continue;
            }

            $file = $this->file("images.$index.file");
            $alt = trim((string) ($row['alt'] ?? ''));

            if ($file instanceof UploadedFile && $alt === '') {
                $validator->errors()->add("images.$index.alt", 'Chaque photo doit avoir un texte alternatif.');
            }

            if ($alt !== '' && ! $file instanceof UploadedFile) {
                $validator->errors()->add("images.$index.file", 'Choisissez une photo pour ce texte alternatif.');
            }
        }
    }

    protected function validateExistingImages(Validator $validator): void
    {
        $removed = array_map('strval', (array) $this->input('remove_image_ids', []));

        foreach ($this->input('existing_images', []) as $index => $row) {
            if (! is_array($row)) {
                continue;
            }

            $id = (string) ($row['id'] ?? '');

            if ($id !== '' && in_array($id, $removed, true)) {
                continue;
            }

            if (trim((string) ($row['alt'] ?? '')) === '') {
                $validator->errors()->add("existing_images.$index.alt", 'Chaque photo doit avoir un texte alternatif.');
            }
        }
    }

    protected function productId(): ?int
    {
        $product = $this->route('product');

        return $product instanceof Product ? $product->id : null;
    }

    private function toCents(string $amount): int
    {
        $negative = str_starts_with($amount, '-');
        $amount = ltrim($amount, '-');
        [$whole, $fraction] = array_pad(explode('.', $amount, 2), 2, '0');
        $fraction = str_pad(substr($fraction, 0, 2), 2, '0');
        $cents = ((int) $whole * 100) + (int) $fraction;

        return $negative ? -$cents : $cents;
    }
}
