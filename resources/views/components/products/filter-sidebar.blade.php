@props([
    'categories' => [],
    'brands' => [],
    'selectedCategory' => '',
    'selectedBrand' => '',
    'inStock' => false,
    'priceType' => '',
    'priceMin' => null,
    'priceMax' => null,
])

@php
    $activeCount = 0;
    if (!empty(request('category'))) $activeCount++;
    if (!empty(request('brand'))) $activeCount++;
    if (request()->boolean('in_stock')) $activeCount++;
    if (!empty(request('price_type')) || request()->filled('price_min') || request()->filled('price_max')) $activeCount++;
    $hasActiveFilters = $activeCount > 0 || request()->filled('q');
@endphp

<div class="rounded-2xl border border-[#e4e7ec] bg-white p-5 shadow-xs">
    {{-- Header Filtres --}}
    <div class="flex items-center justify-between pb-4 border-b border-[#e4e7ec]">
        <div class="flex items-center gap-2">
            <h2 class="text-lg font-bold text-[#1d2939] tracking-tight">Filtres</h2>
            @if($activeCount > 0)
                <span class="inline-flex h-5 w-5 items-center justify-center rounded-full bg-[#029e55] text-[11px] font-bold text-white">
                    {{ $activeCount }}
                </span>
            @endif
        </div>

        @if($hasActiveFilters)
            <a
                href="{{ route('home') }}#catalogue"
                class="text-xs font-semibold text-[#029e55] hover:text-[#028347] hover:underline transition-colors"
            >
                Réinitialiser
            </a>
        @endif
    </div>

    <form id="filter-form" action="{{ route('home') }}#catalogue" method="GET" class="divide-y divide-[#e4e7ec]">
        {{-- Préservation de la recherche, du tri et du mode d'affichage --}}
        @if(request('q'))
            <input type="hidden" name="q" value="{{ request('q') }}">
        @endif
        @if(request('sort'))
            <input type="hidden" name="sort" value="{{ request('sort') }}">
        @endif
        @if(request('view'))
            <input type="hidden" name="view" value="{{ request('view') }}">
        @endif

        {{-- 1. Catégories (select compact) --}}
        <div class="py-4">
            <p class="mb-2 text-sm font-bold text-[#1d2939]">Catégories</p>
            <x-products.category-select
                :categories="$categories"
                :selectedCategory="$selectedCategory"
                id="filter-category-select"
                :submitOnChange="true"
            />
        </div>

        {{-- 2. Marque --}}
        <details open class="group py-4">
            <summary class="flex w-full items-center justify-between text-left text-sm font-bold text-[#1d2939] hover:text-[#029e55] transition-colors cursor-pointer list-none [&::-webkit-details-marker]:hidden">
                <span>Marque</span>
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-4 w-4 text-[#667085] transition-transform duration-200 group-open:rotate-180"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7 7" />
                </svg>
            </summary>

            <div class="mt-3">
                <div class="relative">
                    <select
                        name="brand"
                        onchange="this.form.submit()"
                        class="w-full appearance-none rounded-xl border border-[#e4e7ec] bg-[#fcfcfd] py-2 pl-3 pr-8 text-xs sm:text-sm text-[#1d2939] focus:border-[#029e55] focus:outline-none focus:ring-2 focus:ring-[#029e55]/20 cursor-pointer"
                    >
                        <option value="">Toutes les marques</option>
                        @foreach($brands as $brand)
                            <option value="{{ $brand }}" {{ $selectedBrand === $brand ? 'selected' : '' }}>
                                {{ $brand }}
                            </option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2.5 text-[#667085]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7 7" />
                        </svg>
                    </div>
                </div>
            </div>
        </details>

        {{-- 3. Disponibilité --}}
        <details open class="group py-4">
            <summary class="flex w-full items-center justify-between text-left text-sm font-bold text-[#1d2939] hover:text-[#029e55] transition-colors cursor-pointer list-none [&::-webkit-details-marker]:hidden">
                <span>Disponibilité</span>
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-4 w-4 text-[#667085] transition-transform duration-200 group-open:rotate-180"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7 7" />
                </svg>
            </summary>

            <div class="mt-3">
                <label class="flex items-center gap-2.5 text-xs sm:text-sm cursor-pointer group">
                    <input
                        type="checkbox"
                        name="in_stock"
                        value="1"
                        {{ $inStock ? 'checked' : '' }}
                        onchange="this.form.submit()"
                        class="h-4 w-4 rounded text-[#029e55] border-[#e4e7ec] focus:ring-[#029e55]"
                    >
                    <span class="{{ $inStock ? 'font-semibold text-[#1d2939]' : 'text-[#667085] group-hover:text-[#1d2939]' }}">
                        En stock
                    </span>
                </label>
            </div>
        </details>

        {{-- 4. Prix --}}
        <details open class="group py-4">
            <summary class="flex w-full items-center justify-between text-left text-sm font-bold text-[#1d2939] hover:text-[#029e55] transition-colors cursor-pointer list-none [&::-webkit-details-marker]:hidden">
                <span>Prix</span>
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-4 w-4 text-[#667085] transition-transform duration-200 group-open:rotate-180"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7 7" />
                </svg>
            </summary>

            <div class="mt-3 space-y-2">
                <label class="flex items-center gap-2.5 text-xs sm:text-sm cursor-pointer group">
                    <input
                        type="radio"
                        name="price_type"
                        value=""
                        {{ empty($priceType) ? 'checked' : '' }}
                        onchange="this.form.submit()"
                        class="h-4 w-4 text-[#029e55] border-[#e4e7ec] focus:ring-[#029e55]"
                    >
                    <span class="{{ empty($priceType) ? 'font-semibold text-[#1d2939]' : 'text-[#667085] group-hover:text-[#1d2939]' }}">
                        Tous les prix
                    </span>
                </label>

                <label class="flex items-center gap-2.5 text-xs sm:text-sm cursor-pointer group">
                    <input
                        type="radio"
                        name="price_type"
                        value="quote"
                        {{ $priceType === 'quote' ? 'checked' : '' }}
                        onchange="this.form.submit()"
                        class="h-4 w-4 text-[#029e55] border-[#e4e7ec] focus:ring-[#029e55]"
                    >
                    <span class="{{ $priceType === 'quote' ? 'font-semibold text-[#029e55]' : 'text-[#667085] group-hover:text-[#1d2939]' }}">
                        Sur devis uniquement
                    </span>
                </label>

                <label class="flex items-center gap-2.5 text-xs sm:text-sm cursor-pointer group">
                    <input
                        type="radio"
                        name="price_type"
                        value="priced"
                        {{ $priceType === 'priced' ? 'checked' : '' }}
                        onchange="this.form.submit()"
                        class="h-4 w-4 text-[#029e55] border-[#e4e7ec] focus:ring-[#029e55]"
                    >
                    <span class="{{ $priceType === 'priced' ? 'font-semibold text-[#029e55]' : 'text-[#667085] group-hover:text-[#1d2939]' }}">
                        Avec prix affiché
                    </span>
                </label>

                {{-- Fourchettes rapides --}}
                <div class="pt-2 border-t border-[#f2f4f7] space-y-1.5">
                    <label class="flex items-center gap-2 text-xs cursor-pointer group">
                        <input
                            type="radio"
                            name="price_type"
                            value="under_100k"
                            {{ $priceType === 'under_100k' ? 'checked' : '' }}
                            onchange="this.form.submit()"
                            class="h-3.5 w-3.5 text-[#029e55] border-[#e4e7ec] focus:ring-[#029e55]"
                        >
                        <span class="text-[#667085] group-hover:text-[#1d2939]">&lt; 100 000 FCFA</span>
                    </label>

                    <label class="flex items-center gap-2 text-xs cursor-pointer group">
                        <input
                            type="radio"
                            name="price_type"
                            value="100k_500k"
                            {{ $priceType === '100k_500k' ? 'checked' : '' }}
                            onchange="this.form.submit()"
                            class="h-3.5 w-3.5 text-[#029e55] border-[#e4e7ec] focus:ring-[#029e55]"
                        >
                        <span class="text-[#667085] group-hover:text-[#1d2939]">100 000 - 500 000 FCFA</span>
                    </label>

                    <label class="flex items-center gap-2 text-xs cursor-pointer group">
                        <input
                            type="radio"
                            name="price_type"
                            value="above_500k"
                            {{ $priceType === 'above_500k' ? 'checked' : '' }}
                            onchange="this.form.submit()"
                            class="h-3.5 w-3.5 text-[#029e55] border-[#e4e7ec] focus:ring-[#029e55]"
                        >
                        <span class="text-[#667085] group-hover:text-[#1d2939]">&gt; 500 000 FCFA</span>
                    </label>
                </div>
            </div>
        </details>
    </form>
</div>
