<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\CartService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(CartService $cart): View
    {
        return view('cart.index', [
            'items' => $cart->items(),
            'cart' => $cart,
        ]);
    }

    public function store(Request $request, CartService $cart): JsonResponse|RedirectResponse
    {
        $validated = $request->validate([
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'quantity' => ['nullable', 'integer', 'min:1', 'max:999'],
        ]);

        $product = Product::query()
            ->where('id', $validated['product_id'])
            ->where('is_published', true)
            ->firstOrFail();

        $quantity = (int) ($validated['quantity'] ?? 1);
        $cart->add($product, $quantity);

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Produit ajouté à votre demande de devis.',
                'count' => $cart->count(),
            ]);
        }

        return back()->with('cart_success', 'Le produit a bien été ajouté à votre devis.');
    }

    public function update(Request $request, int $productId, CartService $cart): JsonResponse|RedirectResponse
    {
        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:1', 'max:999'],
        ]);

        $quantity = (int) $validated['quantity'];
        $cart->update($productId, $quantity);

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'count' => $cart->count(),
                'quantity' => $quantity,
                'total_amount' => $cart->totalAmount(),
                'formatted_total' => $cart->totalAmount() !== null
                    ? number_format($cart->totalAmount(), 0, ',', ' ') . ' FCFA'
                    : null,
            ]);
        }

        return redirect()->route('cart.index');
    }

    public function destroy(Request $request, int $productId, CartService $cart): JsonResponse|RedirectResponse
    {
        $cart->remove($productId);

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'count' => $cart->count(),
                'is_empty' => $cart->count() === 0,
                'total_amount' => $cart->totalAmount(),
                'formatted_total' => $cart->totalAmount() !== null
                    ? number_format($cart->totalAmount(), 0, ',', ' ') . ' FCFA'
                    : null,
            ]);
        }

        return redirect()->route('cart.index');
    }

    public function count(CartService $cart): JsonResponse
    {
        return response()->json([
            'count' => $cart->count(),
        ]);
    }
}
