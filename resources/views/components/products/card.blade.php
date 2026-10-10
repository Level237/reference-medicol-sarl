@props(['product', 'view' => 'grid'])

<div
    class="group relative flex flex-col justify-between rounded-2xl border border-[#e4e7ec] bg-white p-4 sm:p-5 transition-all duration-200 hover:-translate-y-0.5 hover:shadow-lg hover:shadow-black/5 {{ $view === 'list' ? 'sm:flex-row sm:items-center sm:gap-6' : '' }}"
>
    {{-- Bouton Favoris / Signet en haut à droite --}}
    <button
        type="button"
        onclick="this.classList.toggle('text-[#029e55]'); this.classList.toggle('text-[#98a2b3]'); this.querySelector('svg').classList.toggle('fill-current')"
        class="absolute right-4 top-4 z-10 p-1.5 text-[#98a2b3] hover:text-[#029e55] transition-colors rounded-lg"
        aria-label="Ajouter aux favoris"
    >
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
        </svg>
    </button>

    {{-- Zone Image du produit --}}
    <div class="relative flex items-center justify-center overflow-hidden rounded-xl bg-[#f8fafc] {{ $view === 'list' ? 'h-40 w-40 shrink-0' : 'h-48 w-full' }} mb-4 {{ $view === 'list' ? 'sm:mb-0' : '' }}">
        @if($product->coverImage)
            <img
                src="{{ asset('storage/' . $product->coverImage->path) }}"
                alt="{{ $product->coverImage->alt ?: $product->name }}"
                class="max-h-full max-w-full object-contain p-3 group-hover:scale-105 transition-transform duration-300"
                loading="lazy"
            >
        @elseif($product->meta_image)
            <img
                src="{{ asset('storage/' . $product->meta_image) }}"
                alt="{{ $product->name }}"
                class="max-h-full max-w-full object-contain p-3 group-hover:scale-105 transition-transform duration-300"
                loading="lazy"
            >
        @else
            {{-- Illustration Médicale de substitution haute qualité --}}
            <div class="flex flex-col items-center justify-center p-4 text-center">
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
    </div>

    {{-- Informations du produit --}}
    <div class="flex flex-1 flex-col justify-between {{ $view === 'list' ? 'sm:py-1' : '' }}">
        <div>
            {{-- Catégorie --}}
            <span class="text-xs font-medium text-[#029e55]">
                {{ $product->category ? $product->category->name : 'Matériel médical' }}
            </span>

            {{-- Nom du produit --}}
            <h3 class="mt-1 text-base font-bold text-[#1d2939] group-hover:text-[#029e55] transition-colors line-clamp-2">
                {{ $product->name }}
            </h3>

            {{-- Résumé ou référence si présent --}}
            @if($product->reference)
                <p class="mt-0.5 text-[11px] text-[#98a2b3]">
                    Réf : {{ $product->reference }}
                </p>
            @endif
        </div>

        {{-- Prix & Action --}}
        <div class="mt-4 pt-3 border-t border-[#f2f4f7]">
            <div class="flex items-baseline justify-between mb-3">
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
                href="#devis"
                onclick="if(typeof openQuoteModal === 'function') { openQuoteModal('{{ addslashes($product->name) }}', '{{ $product->id }}'); return false; }"
                class="inline-flex w-full items-center justify-center gap-1.5 rounded-xl bg-[#0f172a] px-4 py-2.5 text-center text-xs sm:text-sm font-medium text-white shadow-xs hover:bg-[#1e293b] active:scale-[0.99] transition-all"
            >
                <span>Voir le produit</span>
                <span aria-hidden="true">&rarr;</span>
            </a>
        </div>
    </div>
</div>
