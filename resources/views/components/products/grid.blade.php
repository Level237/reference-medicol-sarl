@props([
    'products',
    'sort' => 'relevance',
    'view' => 'grid',
])

@php
    $activeCount = 0;
    if (!empty(request('category'))) $activeCount++;
    if (!empty(request('brand'))) $activeCount++;
    if (request()->boolean('in_stock')) $activeCount++;
    if (!empty(request('price_type')) || request()->filled('price_min') || request()->filled('price_max')) $activeCount++;
@endphp

<div>
    {{-- Barre d'outils supérieure --}}
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        {{-- Compteur de produits --}}
        <div>
            <p class="text-sm font-medium text-[#667085]">
                <span class="font-bold text-[#1d2939]">{{ $products->total() }}</span>
                produit{{ $products->total() > 1 ? 's' : '' }}
                @if(request('q'))
                    pour <span class="font-semibold text-[#029e55]">« {{ request('q') }} »</span>
                @endif
            </p>
        </div>

        {{-- Tri & Bascule Grille/Liste & Bouton Filtres Mobile --}}
        <div class="flex items-center gap-2.5 sm:gap-3 flex-wrap justify-between sm:justify-end w-full sm:w-auto">
            {{-- Bouton Filtres Mobile (visible uniquement < lg) --}}
            <button
                type="button"
                id="open-filters-mobile"
                class="lg:hidden inline-flex items-center gap-2 rounded-xl border border-[#e4e7ec] bg-white px-3.5 py-2 text-xs sm:text-sm font-semibold text-[#1d2939] shadow-xs hover:border-[#029e55] hover:text-[#029e55] active:scale-[0.98] transition-all cursor-pointer"
                aria-label="Ouvrir les filtres"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#029e55]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                </svg>
                <span>Filtres</span>
                @if($activeCount > 0)
                    <span class="inline-flex h-5 w-5 items-center justify-center rounded-full bg-[#029e55] text-[11px] font-bold text-white">
                        {{ $activeCount }}
                    </span>
                @endif
            </button>

            {{-- Dropdown Trier par --}}
            <div class="flex items-center gap-2">
                <span class="text-xs sm:text-sm font-medium text-[#667085] whitespace-nowrap">Trier par</span>
                <div class="relative">
                    <select
                        onchange="const url = new URL(window.location.href); url.searchParams.set('sort', this.value); window.location.href = url.toString();"
                        class="appearance-none rounded-xl border border-[#e4e7ec] bg-white py-1.5 pl-3 pr-8 text-xs sm:text-sm font-semibold text-[#1d2939] focus:border-[#029e55] focus:outline-none focus:ring-2 focus:ring-[#029e55]/20 shadow-xs cursor-pointer"
                    >
                        <option value="relevance" {{ $sort === 'relevance' ? 'selected' : '' }}>Pertinence</option>
                        <option value="name_asc" {{ $sort === 'name_asc' ? 'selected' : '' }}>Nom (A - Z)</option>
                        <option value="name_desc" {{ $sort === 'name_desc' ? 'selected' : '' }}>Nom (Z - A)</option>
                        <option value="price_asc" {{ $sort === 'price_asc' ? 'selected' : '' }}>Prix croissant</option>
                        <option value="price_desc" {{ $sort === 'price_desc' ? 'selected' : '' }}>Prix décroissant</option>
                        <option value="newest" {{ $sort === 'newest' ? 'selected' : '' }}>Nouveautés</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2 text-[#667085]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7 7" />
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Boutons Vue Grille / Liste --}}
            <div class="hidden sm:flex items-center rounded-xl border border-[#e4e7ec] bg-white p-1 shadow-xs">
                {{-- Bouton Grille --}}
                <button
                    type="button"
                    onclick="const url = new URL(window.location.href); url.searchParams.set('view', 'grid'); window.location.href = url.toString();"
                    class="rounded-lg p-1.5 transition-colors {{ $view !== 'list' ? 'bg-[#0f172a] text-white' : 'text-[#667085] hover:text-[#1d2939]' }}"
                    aria-label="Affichage en grille"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M1 2.5A1.5 1.5 0 0 1 2.5 1h3A1.5 1.5 0 0 1 7 2.5v3A1.5 1.5 0 0 1 5.5 7h-3A1.5 1.5 0 0 1 1 5.5v-3zM2.5 2a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5h-3zm6.5.5A1.5 1.5 0 0 1 10.5 1h3A1.5 1.5 0 0 1 15 2.5v3A1.5 1.5 0 0 1 13.5 7h-3A1.5 1.5 0 0 1 9 5.5v-3zm1.5-.5a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5h-3zM1 10.5A1.5 1.5 0 0 1 2.5 9h3A1.5 1.5 0 0 1 7 10.5v3A1.5 1.5 0 0 1 5.5 15h-3A1.5 1.5 0 0 1 1 13.5v-3zm1.5-.5a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5h-3zm6.5.5A1.5 1.5 0 0 1 10.5 9h3a1.5 1.5 0 0 1 1.5 1.5v3a1.5 1.5 0 0 1-1.5 1.5h-3A1.5 1.5 0 0 1 9 13.5v-3zm1.5-.5a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5h-3z"/>
                    </svg>
                </button>

                {{-- Bouton Liste --}}
                <button
                    type="button"
                    onclick="const url = new URL(window.location.href); url.searchParams.set('view', 'list'); window.location.href = url.toString();"
                    class="rounded-lg p-1.5 transition-colors {{ $view === 'list' ? 'bg-[#0f172a] text-white' : 'text-[#667085] hover:text-[#1d2939]' }}"
                    aria-label="Affichage en liste"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Grille / Liste de produits --}}
    @if($products->isNotEmpty())
        <div class="{{ $view === 'list' ? 'flex flex-col gap-4' : 'grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-3 sm:gap-6' }}">
            @foreach($products as $product)
                <x-products.card :product="$product" :view="$view" />
            @endforeach
        </div>

        {{-- Pagination assortie au design --}}
        @if($products->hasPages())
            <div class="mt-10 flex items-center justify-center">
                <nav role="navigation" aria-label="Pagination" class="flex items-center gap-2">
                    {{-- Page précédente --}}
                    @if ($products->onFirstPage())
                        <span class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-[#e4e7ec] text-xs text-[#98a2b3] cursor-not-allowed" aria-disabled="true">
                            &larr;
                        </span>
                    @else
                        <a href="{{ $products->previousPageUrl() }}#catalogue" class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-[#e4e7ec] bg-white text-xs font-medium text-[#1d2939] hover:border-[#029e55] hover:text-[#029e55] transition-colors">
                            &larr;
                        </a>
                    @endif

                    {{-- Liens de pagination --}}
                    @foreach ($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                        @if ($page == $products->currentPage())
                            <span class="inline-flex h-9 w-9 items-center justify-center rounded-lg bg-[#0f172a] text-xs font-semibold text-white shadow-xs" aria-current="page">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $url }}#catalogue" class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-[#e4e7ec] bg-white text-xs font-medium text-[#667085] hover:border-[#029e55] hover:text-[#029e55] transition-colors">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach

                    {{-- Page suivante --}}
                    @if ($products->hasMorePages())
                        <a href="{{ $products->nextPageUrl() }}#catalogue" class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-[#e4e7ec] bg-white text-xs font-medium text-[#1d2939] hover:border-[#029e55] hover:text-[#029e55] transition-colors">
                            &rarr;
                        </a>
                    @else
                        <span class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-[#e4e7ec] text-xs text-[#98a2b3] cursor-not-allowed" aria-disabled="true">
                            &rarr;
                        </span>
                    @endif
                </nav>
            </div>
        @endif
    @else
        {{-- État vide soigné --}}
        <div class="flex flex-col items-center justify-center rounded-2xl border border-dashed border-[#e4e7ec] bg-[#fcfcfd] p-10 text-center">
            <div class="flex h-14 w-14 items-center justify-center rounded-full bg-[#029e55]/10 text-[#029e55]">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <h3 class="mt-4 text-base font-bold text-[#1d2939]">Aucun équipement trouvé</h3>
            <p class="mt-1 text-xs sm:text-sm text-[#667085] max-w-sm">
                Aucun produit ne correspond à vos filtres actuels. Essayez de réinitialiser vos critères ou d'élargir votre recherche.
            </p>
            <div class="mt-5">
                <a
                    href="{{ route('home') }}#catalogue"
                    class="inline-flex items-center gap-2 rounded-xl bg-[#029e55] px-4 py-2.5 text-xs sm:text-sm font-semibold text-white shadow-xs hover:bg-[#028347] transition-colors"
                >
                    <span>Afficher tout le catalogue</span>
                </a>
            </div>
        </div>
    @endif
</div>
