<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateQuoteStatusRequest;
use App\Models\QuoteRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class QuoteRequestController extends Controller
{
    public function index(Request $request): View
    {
        $query = QuoteRequest::query()
            ->with(['items.product.coverImage'])
            ->latest();

        if ($search = $request->query('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('reference', 'like', "%{$search}%")
                    ->orWhere('organization_name', 'like', "%{$search}%")
                    ->orWhere('contact_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if ($status = $request->query('status')) {
            $query->where('status', $status);
        }

        $quotes = $query->paginate(15)->withQueryString();

        $counts = [
            'all' => QuoteRequest::query()->count(),
            'pending' => QuoteRequest::query()->where('status', QuoteRequest::STATUS_PENDING)->count(),
            'processing' => QuoteRequest::query()->where('status', QuoteRequest::STATUS_PROCESSING)->count(),
            'processed' => QuoteRequest::query()->where('status', QuoteRequest::STATUS_PROCESSED)->count(),
            'rejected' => QuoteRequest::query()->where('status', QuoteRequest::STATUS_REJECTED)->count(),
        ];

        return view('admin.quotes.index', [
            'quotes' => $quotes,
            'counts' => $counts,
            'currentStatus' => $request->query('status'),
            'search' => $request->query('search'),
        ]);
    }

    public function show(Request $request, QuoteRequest $quote): View|JsonResponse
    {
        $quote->load(['items.product.coverImage']);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'id' => $quote->id,
                'reference' => $quote->reference,
                'status' => $quote->status,
                'status_label' => $quote->statusLabel(),
                'status_badge' => $quote->statusBadgeClasses(),
                'status_dot' => $quote->statusDotColor(),
                'organization_name' => $quote->organization_name,
                'organization_type' => $quote->organization_type,
                'contact_name' => $quote->contact_name,
                'email' => $quote->email,
                'phone' => $quote->phone,
                'address' => $quote->address,
                'postal_code' => $quote->postal_code,
                'city' => $quote->city,
                'message' => $quote->message,
                'estimated_total' => $quote->estimated_total ? number_format((float) $quote->estimated_total, 2, ',', ' ').' €' : 'Sur devis',
                'admin_notes' => $quote->admin_notes,
                'created_at' => $quote->created_at->format('d/m/Y à H:i'),
                'created_at_human' => $quote->created_at->diffForHumans(),
                'items' => $quote->items->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'product_name' => $item->product_name,
                        'product_reference' => $item->product_reference,
                        'quantity' => $item->quantity,
                        'unit_price' => $item->unit_price ? number_format((float) $item->unit_price, 2, ',', ' ').' €' : null,
                        'total_price' => $item->total_price ? number_format((float) $item->total_price, 2, ',', ' ').' €' : null,
                        'image_url' => $item->product?->coverImage ? asset('storage/'.$item->product->coverImage->file_path) : null,
                    ];
                }),
                'update_url' => route('admin.quotes.update-status', $quote),
                'destroy_url' => route('admin.quotes.destroy', $quote),
            ]);
        }

        return view('admin.quotes.show', [
            'quote' => $quote,
        ]);
    }

    public function updateStatus(UpdateQuoteStatusRequest $request, QuoteRequest $quote): RedirectResponse
    {
        $validated = $request->validated();

        $processedAt = $validated['status'] === QuoteRequest::STATUS_PROCESSED
            ? ($quote->processed_at ?? now())
            : null;

        $quote->update([
            'status' => $validated['status'],
            'admin_notes' => $validated['admin_notes'] ?? $quote->admin_notes,
            'processed_at' => $processedAt,
        ]);

        return back()->with('status', "Le statut du devis {$quote->reference} a été mis à jour.");
    }

    public function destroy(QuoteRequest $quote): RedirectResponse
    {
        $reference = $quote->reference;
        $quote->delete();

        return redirect()
            ->route('admin.quotes.index')
            ->with('status', "La demande de devis {$reference} a été supprimée.");
    }
}
