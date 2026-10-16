@props(['product', 'view' => 'grid'])

<div
    class="group relative flex rounded-2xl border border-[#e4e7ec] bg-white transition-shadow duration-200 hover:shadow-lg hover:shadow-[#0f172a]/5 {{ $view === 'list' ? 'flex-row items-stretch gap-3 p-3 sm:gap-5 sm:p-4' : 'flex-col justify-between p-4 hover:-translate-y-0.5 sm:p-5' }}"
>
    {{-- Zone Image du produit --}}
    <a href="{{ route('products.show', $product->slug) }}" class="relative block shrink-0 overflow-hidden rounded-xl bg-[#e4e7ec] {{ $view === 'list' ? 'h-24 w-24 sm:h-32 sm:w-32' : 'mb-4 h-48 w-full' }}">
        @if($product->coverImage)
            <img
                src="{{ asset('storage/' . $product->coverImage->path) }}"
                alt="{{ $product->coverImage->alt ?: $product->name }}"
                class="absolute inset-0 h-full w-full object-cover transition-transform duration-300 group-hover:scale-105"
                loading="lazy"
            >
        @elseif($product->meta_image)
            <img
                src="{{ asset('storage/' . $product->meta_image) }}"
                alt="{{ $product->name }}"
                class="absolute inset-0 h-full w-full object-cover transition-transform duration-300 group-hover:scale-105"
                loading="lazy"
            >
        @else
            {{-- Illustration Médicale de substitution haute qualité --}}
            <div class="absolute inset-0 flex flex-col items-center justify-center p-4 text-center">
                <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-white shadow-xs ring-1 ring-[#e4e7ec] text-[#029e55]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                    </svg>
                </div>
                <span class="mt-2 text-[11px] font-medium text-[#98a2b3]">Matériel certifié</span>
            </div>
        @endif

        {{-- Badge Promo ou En stock --}}
        @if($product->promo_price && $product->price && $product->promo_price < $product->price)
            <span class="absolute left-3 top-3 rounded-md bg-[#edbb45] px-2 py-0.5 text-[11px] font-bold text-[#1d2939] shadow-xs">
                PROMO
            </span>
        @elseif($product->quantity !== null && $product->quantity > 0)
            <span class="absolute left-3 top-3 rounded-md bg-[#029e55]/10 px-2 py-0.5 text-[10px] font-semibold text-[#029e55]">
                En stock
            </span>
        @endif
    </a>

    {{-- Informations du produit --}}
    <div class="flex min-w-0 flex-1 flex-col justify-between">
        <div>
            {{-- Catégorie --}}
            <span class="text-xs font-medium text-[#029e55]">
                {{ $product->category ? $product->category->name : 'Matériel médical' }}
            </span>

            {{-- Nom du produit --}}
            <h3 class="mt-1 text-base font-bold text-[#1d2939] group-hover:text-[#029e55] transition-colors line-clamp-2">
                <a href="{{ route('products.show', $product->slug) }}">
                    {{ $product->name }}
                </a>
            </h3>

            {{-- Résumé ou référence si présent --}}
            @if($product->reference)
                <p class="mt-0.5 text-[11px] text-[#98a2b3]">
                    Réf : {{ $product->reference }}
                </p>
            @endif
        </div>

        {{-- Prix & Action --}}
        <div class="mt-3 border-t border-[#e4e7ec] pt-3 {{ $view === 'list' ? 'sm:mt-4' : 'mt-4' }}">
            <div class="mb-3 flex items-baseline justify-between gap-3">
                @if($product->effectivePrice())
                    <div class="flex flex-col">
                        <span class="text-base font-bold text-[#1d2939]">
                            {{ number_format((float) $product->effectivePrice(), 0, ',', ' ') }} <span class="text-xs font-normal text-[#667085]">FCFA</span>
                        </span>
                        @if($product->compareAtPrice())
                            <span class="text-xs text-[#98a2b3] line-through">
                                {{ number_format((float) $product->compareAtPrice(), 0, ',', ' ') }} FCFA
                            </span>
                        @endif
                    </div>
                @else
                    <span class="text-sm font-semibold text-[#1d2939]">
                        Sur devis
                    </span>
                @endif

                @if($product->quantity !== null)
                    <span class="text-[11px] {{ $product->quantity > 0 ? 'text-[#029e55]' : 'text-[#d92d20]' }}">
                        {{ $product->quantity > 0 ? 'Disponible' : 'Sur commande' }}
                    </span>
                @endif
            </div>

            {{-- Bouton d'action Voir le produit --}}
            <a
                href="{{ route('products.show', $product->slug) }}"
                class="inline-flex items-center justify-center gap-1.5 rounded-xl bg-[#029e55] px-4 py-2.5 text-center text-xs font-medium text-white shadow-xs transition-all hover:bg-[#0f172a] active:scale-[0.99] sm:text-sm {{ $view === 'list' ? 'w-full sm:w-auto' : 'w-full' }}"
            >
                <span>Voir le produit</span>
                <span aria-hidden="true">&rarr;</span>
            </a>
        </div>
    </div>
</div>
