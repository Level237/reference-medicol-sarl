<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

#[Fillable([
    'category_id',
    'name',
    'slug',
    'summary',
    'description',
    'specifications',
    'reference',
    'price',
    'promo_price',
    'meta_title',
    'meta_description',
    'meta_image',
    'is_featured',
    'sort_order',
    'is_published',
])]
class Product extends Model
{
    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'specifications' => 'array',
            'price' => 'decimal:2',
            'promo_price' => 'decimal:2',
            'is_featured' => 'boolean',
            'sort_order' => 'integer',
            'is_published' => 'boolean',
        ];
    }

    public function effectivePrice(): ?string
    {
        if ($this->hasActivePromo()) {
            return $this->promo_price;
        }

        return $this->price;
    }

    public function compareAtPrice(): ?string
    {
        if ($this->hasActivePromo()) {
            return $this->price;
        }

        return null;
    }

    private function hasActivePromo(): bool
    {
        if ($this->promo_price === null || $this->price === null) {
            return false;
        }

        return $this->toCents($this->promo_price) < $this->toCents($this->price);
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

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order')->orderBy('id');
    }

    public function coverImage(): HasOne
    {
        return $this->hasOne(ProductImage::class)->ofMany([
            'sort_order' => 'min',
            'id' => 'min',
        ]);
    }
}
