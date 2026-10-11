<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuoteRequest;
use App\Models\Product;
use App\Models\QuoteRequest;
use App\Services\CartService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;

class QuoteRequestController extends Controller
{
    public function create(CartService $cart): View|RedirectResponse
    {
        if ($cart->count() === 0) {
            return redirect()->route('cart.index');
        }

        return view('quotes.create', [
            'items' => $cart->items(),
            'cart' => $cart,
        ]);
    }

    public function store(StoreQuoteRequest $request, CartService $cart): RedirectResponse
    {
        if ($cart->count() === 0) {
            return redirect()->route('cart.index');
        }

        $quote = DB::transaction(function () use ($request, $cart): QuoteRequest {
            $items = $cart->items();
            $productIds = collect($items)->pluck('id')->filter()->all();
            $products = Product::query()->whereIn('id', $productIds)->get()->keyBy('id');

            $quote = QuoteRequest::query()->create([
                'reference' => QuoteRequest::generateReference(),
                'status' => QuoteRequest::STATUS_PENDING,
                'organization_name' => $request->string('organization_name')->toString(),
                'contact_name' => $request->string('contact_name')->toString(),
                'email' => $request->string('email')->toString(),
                'phone' => $request->string('phone')->toString(),
                'message' => $request->string('message')->toString(),
                'estimated_total' => $cart->totalAmount(),
            ]);

            foreach ($items as $item) {
                $product = $products->get($item['id'] ?? 0);
                $quantity = max(1, (int) ($item['quantity'] ?? 1));
                $unitPrice = $product?->effectivePrice() ?? ($item['price'] ?? null);
                $lineTotal = $unitPrice !== null ? ((float) $unitPrice) * $quantity : null;

                $quote->items()->create([
                    'product_id' => $product?->id,
                    'product_name' => $product?->name ?? (string) ($item['name'] ?? 'Équipement'),
                    'product_reference' => $product?->reference ?? ($item['reference'] ?? null),
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                    'total_price' => $lineTotal,
                ]);
            }

            return $quote;
        });

        $cart->clear();
        session()->put('quote_reference', $quote->reference);

        return redirect()->route('quotes.sent');
    }

    public function sent(): View|RedirectResponse
    {
        $reference = session('quote_reference');

        if (! is_string($reference) || $reference === '') {
            return redirect()->route('cart.index');
        }

        $quote = QuoteRequest::query()
            ->with(['items.product.coverImage'])
            ->where('reference', $reference)
            ->first();

        return view('quotes.sent', [
            'reference' => $reference,
            'quote' => $quote,
        ]);
    }

    public function track(Request $request): View|RedirectResponse
    {
        $rawRef = trim((string) $request->input('reference', ''));
        $rawEmail = trim((string) $request->input('email', ''));

        if ($rawRef === '') {
            if ($request->isMethod('POST')) {
                return $this->trackFormError($request, 'Veuillez renseigner la référence de la demande.');
            }

            return view('quotes.track', [
                'reference' => (string) old('reference', ''),
                'email' => (string) old('email', ''),
                'quote' => null,
                'lookupError' => session('lookup_error'),
                'searched' => false,
            ]);
        }

        $reference = strtoupper($rawRef);

        if (! preg_match('/^DEV-\d{6}-\d{4}$/', $reference)) {
            return $this->trackFormError($request, 'La référence doit ressembler à DEV-AAAAMM-0001.');
        }

        $quote = QuoteRequest::query()
            ->with(['items.product.coverImage'])
            ->where('reference', $reference)
            ->first();

        if (! $quote) {
            return $this->trackFormError($request, 'Aucune demande ne correspond à cette référence.');
        }

        $sessionRef = session('quote_reference');
        $hasSessionMatch = is_string($sessionRef) && $sessionRef === $reference;

        if ($rawEmail !== '') {
            if (Str::lower($rawEmail) !== Str::lower((string) $quote->email)) {
                return $this->trackFormError($request, 'L\'adresse e-mail ne correspond pas à cette référence.');
            }
            $email = $rawEmail;
        } elseif ($hasSessionMatch) {
            $email = (string) $quote->email;
        } else {
            return $this->trackFormError($request, 'Veuillez renseigner l\'adresse e-mail associée à cette demande.');
        }

        if ($request->isMethod('POST')) {
            return redirect()->route('quotes.track', [
                'reference' => $quote->reference,
                'email' => $email,
            ]);
        }

        return view('quotes.track', [
            'reference' => $quote->reference,
            'email' => $email,
            'quote' => $quote,
            'lookupError' => null,
            'searched' => true,
        ]);
    }

    private function trackFormError(Request $request, string $message): RedirectResponse
    {
        return redirect()
            ->route('quotes.track')
            ->withInput($request->only(['reference', 'email']))
            ->with('lookup_error', $message);
    }
}
