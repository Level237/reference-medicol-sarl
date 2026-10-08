<?php

namespace App\Http\Requests\Admin;

use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

abstract class CategoryFormRequest extends FormRequest
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
        return [
            'name' => ['required', 'string', 'max:255'],
            'slug' => [
                'nullable',
                'string',
                'max:255',
                'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
                Rule::unique('categories', 'slug')->ignore($this->categoryId()),
            ],
            'description' => ['nullable', 'string', 'max:20000'],
            'image' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:5120'],
            'image_alt' => ['nullable', 'string', 'max:255'],
            'remove_image' => ['sometimes', 'boolean'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:320'],
            'meta_image' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:5120'],
            'remove_meta_image' => ['sometimes', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:1000000'],
            'is_published' => ['sometimes', 'boolean'],
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
            'remove_image' => $this->boolean('remove_image'),
            'remove_meta_image' => $this->boolean('remove_meta_image'),
            'sort_order' => $this->filled('sort_order') ? $this->input('sort_order') : 0,
        ]);
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator): void {
            $file = $this->file('image');
            $alt = trim((string) $this->input('image_alt', ''));
            $remove = $this->boolean('remove_image');
            $category = $this->route('category');
            $hasImage = $category instanceof Category
                && is_string($category->image)
                && $category->image !== ''
                && ! $remove;

            if ($file instanceof UploadedFile && $alt === '') {
                $validator->errors()->add('image_alt', 'L’image de profil doit avoir un texte alternatif.');
            }

            if ($hasImage && ! $file instanceof UploadedFile && $alt === '') {
                $validator->errors()->add('image_alt', 'L’image de profil doit avoir un texte alternatif.');
            }

            if ($alt !== '' && ! $file instanceof UploadedFile && ! $hasImage) {
                $validator->errors()->add('image', 'Choisissez une image pour ce texte alternatif.');
            }
        });
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Indiquez le nom de la catégorie.',
            'name.max' => 'Le nom ne peut pas dépasser 255 caractères.',
            'slug.regex' => 'Le slug ne peut contenir que des lettres minuscules, des chiffres et des tirets.',
            'slug.unique' => 'Ce slug est déjà utilisé.',
            'meta_description.max' => 'La meta description ne peut pas dépasser 320 caractères.',
            'image.image' => 'L’image de profil doit être une photo.',
            'image.mimes' => 'L’image de profil doit être au format JPEG, PNG ou WebP.',
            'image.max' => 'L’image de profil ne peut pas dépasser 5 Mo.',
            'image_alt.max' => 'Le texte alternatif ne peut pas dépasser 255 caractères.',
            'meta_image.image' => 'L’image de référencement doit être une photo.',
            'meta_image.mimes' => 'L’image de référencement doit être au format JPEG, PNG ou WebP.',
            'meta_image.max' => 'L’image de référencement ne peut pas dépasser 5 Mo.',
            'sort_order.integer' => 'L’ordre d’affichage doit être un nombre entier.',
            'sort_order.min' => 'L’ordre d’affichage ne peut pas être négatif.',
        ];
    }

    protected function categoryId(): ?int
    {
        $category = $this->route('category');

        return $category instanceof Category ? $category->id : null;
    }
}
