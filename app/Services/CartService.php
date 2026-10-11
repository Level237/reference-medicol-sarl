<?php

namespace App\Services;

use App\Models\Product;

class CartService
{
    private const SESSION_KEY = 'quote_cart.items';

    /**
     * @return array<int, array{
     *     id: int,
     *     name: string,
     *     slug: string,
     *     reference: ?string,
     *     summary: ?string,
     *     price: ?string,
     *     quantity: int,
     *     image: ?string,
     *     category: ?string
     * }>
     */
    public function items(): array
    {
        return session()->get(self::SESSION_KEY, []);
    }

    public function add(Product $product, int $quantity = 1): void
    {
        $items = $this->items();
        $id = $product->id;
        $currentQty = isset($items[$id]) ? (int) $items[$id]['quantity'] : 0;
        $newQty = max(1, $currentQty + $quantity);

        $items[$id] = [
            'id' => $product->id,
            'name' => $product->name,
            'slug' => $product->slug,
            'reference' => $product->reference,
            'summary' => $product->summary,
            'price' => $product->effectivePrice(),
            'quantity' => $newQty,
            'image' => $product->coverImage?->path ?? $product->meta_image,
            'category' => $product->category?->name,
        ];

        session()->put(self::SESSION_KEY, $items);
    }

    public function update(int $productId, int $quantity): void
    {
        $items = $this->items();

        if ($quantity <= 0) {
            unset($items[$productId]);
        } elseif (isset($items[$productId])) {
            $items[$productId]['quantity'] = $quantity;
        }

        session()->put(self::SESSION_KEY, $items);
    }

    public function remove(int $productId): void
    {
        $items = $this->items();
        unset($items[$productId]);
        session()->put(self::SESSION_KEY, $items);
    }

    public function count(): int
    {
        $total = 0;
        foreach ($this->items() as $item) {
            $total += (int) ($item['quantity'] ?? 0);
        }

        return $total;
    }

    public function hasPricedItems(): bool
    {
        foreach ($this->items() as $item) {
            if (! empty($item['price'])) {
                return true;
            }
        }

        return false;
    }

    public function totalAmount(): ?float
    {
        $hasAnyPrice = false;
        $total = 0.0;

        foreach ($this->items() as $item) {
            if (! empty($item['price'])) {
                $hasAnyPrice = true;
                $total += ((float) $item['price']) * ((int) ($item['quantity'] ?? 1));
            }
        }

        return $hasAnyPrice ? $total : null;
    }

    public function clear(): void
    {
        session()->forget(self::SESSION_KEY);
    }
}
