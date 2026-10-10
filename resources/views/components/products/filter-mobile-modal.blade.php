@props([
    'categories' => [],
    'brands' => [],
    'selectedCategory' => '',
    'selectedBrand' => '',
    'inStock' => false,
    'priceType' => '',
    'priceMin' => null,
    'priceMax' => null,
    'products' => null,
])

@php
    $activeCount = 0;
    if (!empty(request('category'))) $activeCount++;
    if (!empty(request('brand'))) $activeCount++;
    if (request()->boolean('in_stock')) $activeCount++;
    if (!empty(request('price_type')) || request()->filled('price_min') || request()->filled('price_max')) $activeCount++;
    $hasActiveFilters = $activeCount > 0 || request()->filled('q');
@endphp

{{-- Modal Bottom Sheet Mobile pour Filtres --}}
<div
    id="mobile-filter-modal-container"
    class="fixed inset-0 z-50 pointer-events-none transition-all duration-300"
    aria-hidden="true"
    role="region"
    aria-label="Filtres mobiles"
>
    {{-- Arrière-plan sombre (Backdrop) --}}
    <div
        id="mobile-filter-backdrop"
        class="fixed inset-0 bg-black/60 backdrop-blur-xs opacity-0 pointer-events-none transition-opacity duration-300 ease-in-out"
    ></div>

    {{-- Bottom Sheet glissant du bas vers le haut --}}
    <div
        id="mobile-filter-sheet"
        role="dialog"
        aria-modal="true"
        aria-labelledby="mobile-filter-title"
        class="fixed inset-x-0 bottom-0 z-10 flex max-h-[88vh] w-full transform translate-y-full flex-col rounded-t-[28px] bg-white shadow-2xl transition-transform duration-300 ease-out pointer-events-none sm:max-w-lg sm:mx-auto"
    >
        {{-- Barre de préhension (Drag indicator) --}}
        <div class="pt-3 pb-1 flex justify-center shrink-0">
            <span class="h-1.5 w-12 rounded-full bg-[#e4e7ec]"></span>
        </div>

        {{-- En-tête du Modal --}}
        <div class="flex items-center justify-between px-5 py-3 border-b border-[#e4e7ec] shrink-0">
            <div class="flex items-center gap-2">
                <h2 id="mobile-filter-title" class="text-lg font-bold text-[#1d2939]">
                    Filtres
                </h2>
                @if($activeCount > 0)
                    <span class="inline-flex h-5 w-5 items-center justify-center rounded-full bg-[#029e55] text-[11px] font-bold text-white">
                        {{ $activeCount }}
                    </span>
                @endif
            </div>

            <div class="flex items-center gap-3">
                @if($hasActiveFilters)
                    <a
                        href="{{ route('home') }}#catalogue"
                        class="text-xs font-semibold text-[#029e55] hover:text-[#028347] hover:underline transition-colors"
                    >
                        Réinitialiser
                    </a>
                @endif

                <button
                    type="button"
                    id="close-filters-mobile"
                    class="rounded-full p-2 text-[#667085] hover:bg-[#f2f4f7] hover:text-[#1d2939] transition-colors"
                    aria-label="Fermer les filtres"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        {{-- Corps déroulant du Modal (Scrollable) --}}
        <div class="overflow-y-auto px-5 py-3 flex-1 divide-y divide-[#e4e7ec] overscroll-contain">
            <form id="mobile-filters-form" action="{{ route('home') }}#catalogue" method="GET">
                {{-- Préservation des paramètres existants --}}
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
                        id="mobile-filter-category-select"
                    />
                </div>

                {{-- 2. Marque --}}
                <details open class="group py-4">
                    <summary class="flex w-full items-center justify-between text-left text-sm font-bold text-[#1d2939] cursor-pointer list-none [&::-webkit-details-marker]:hidden">
                        <span>Marque</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#667085] transition-transform duration-200 group-open:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7 7" />
                        </svg>
                    </summary>

                    <div class="mt-3">
                        <div class="relative">
                            <select
                                name="brand"
                                class="w-full appearance-none rounded-xl border border-[#e4e7ec] bg-[#fcfcfd] py-3 pl-3.5 pr-10 text-sm text-[#1d2939] focus:border-[#029e55] focus:outline-none focus:ring-2 focus:ring-[#029e55]/20"
                            >
                                <option value="">Toutes les marques</option>
                                @foreach($brands as $brand)
                                    <option value="{{ $brand }}" {{ $selectedBrand === $brand ? 'selected' : '' }}>
                                        {{ $brand }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-[#667085]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7 7" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </details>

                {{-- 3. Disponibilité --}}
                <details open class="group py-4">
                    <summary class="flex w-full items-center justify-between text-left text-sm font-bold text-[#1d2939] cursor-pointer list-none [&::-webkit-details-marker]:hidden">
                        <span>Disponibilité</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#667085] transition-transform duration-200 group-open:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7 7" />
                        </svg>
                    </summary>

                    <div class="mt-3">
                        <label class="flex items-center gap-3 p-2 rounded-xl hover:bg-[#f8fafc] cursor-pointer">
                            <input
                                type="checkbox"
                                name="in_stock"
                                value="1"
                                {{ $inStock ? 'checked' : '' }}
                                class="h-5 w-5 rounded text-[#029e55] border-[#e4e7ec] focus:ring-[#029e55]"
                            >
                            <span class="text-sm {{ $inStock ? 'font-semibold text-[#1d2939]' : 'text-[#667085]' }}">
                                En stock uniquement
                            </span>
                        </label>
                    </div>
                </details>

                {{-- 4. Prix --}}
                <details open class="group py-4">
                    <summary class="flex w-full items-center justify-between text-left text-sm font-bold text-[#1d2939] cursor-pointer list-none [&::-webkit-details-marker]:hidden">
                        <span>Prix</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#667085] transition-transform duration-200 group-open:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7 7" />
                        </svg>
                    </summary>

                    <div class="mt-3 space-y-2">
                        <label class="flex items-center gap-3 p-2 rounded-xl hover:bg-[#f8fafc] cursor-pointer">
                            <input
                                type="radio"
                                name="price_type"
                                value=""
                                {{ empty($priceType) ? 'checked' : '' }}
                                class="h-4 w-4 text-[#029e55] border-[#e4e7ec] focus:ring-[#029e55]"
                            >
                            <span class="text-sm {{ empty($priceType) ? 'font-semibold text-[#1d2939]' : 'text-[#667085]' }}">
                                Tous les prix
                            </span>
                        </label>

                        <label class="flex items-center gap-3 p-2 rounded-xl hover:bg-[#f8fafc] cursor-pointer">
                            <input
                                type="radio"
                                name="price_type"
                                value="quote"
                                {{ $priceType === 'quote' ? 'checked' : '' }}
                                class="h-4 w-4 text-[#029e55] border-[#e4e7ec] focus:ring-[#029e55]"
                            >
                            <span class="text-sm {{ $priceType === 'quote' ? 'font-semibold text-[#029e55]' : 'text-[#667085]' }}">
                                Sur devis uniquement
                            </span>
                        </label>

                        <label class="flex items-center gap-3 p-2 rounded-xl hover:bg-[#f8fafc] cursor-pointer">
                            <input
                                type="radio"
                                name="price_type"
                                value="priced"
                                {{ $priceType === 'priced' ? 'checked' : '' }}
                                class="h-4 w-4 text-[#029e55] border-[#e4e7ec] focus:ring-[#029e55]"
                            >
                            <span class="text-sm {{ $priceType === 'priced' ? 'font-semibold text-[#029e55]' : 'text-[#667085]' }}">
                                Avec prix affiché
                            </span>
                        </label>

                        <div class="pt-2 border-t border-[#f2f4f7] space-y-1">
                            <label class="flex items-center gap-3 p-2 rounded-xl hover:bg-[#f8fafc] cursor-pointer">
                                <input
                                    type="radio"
                                    name="price_type"
                                    value="under_100k"
                                    {{ $priceType === 'under_100k' ? 'checked' : '' }}
                                    class="h-4 w-4 text-[#029e55] border-[#e4e7ec] focus:ring-[#029e55]"
                                >
                                <span class="text-xs text-[#667085]">&lt; 100 000 FCFA</span>
                            </label>

                            <label class="flex items-center gap-3 p-2 rounded-xl hover:bg-[#f8fafc] cursor-pointer">
                                <input
                                    type="radio"
                                    name="price_type"
                                    value="100k_500k"
                                    {{ $priceType === '100k_500k' ? 'checked' : '' }}
                                    class="h-4 w-4 text-[#029e55] border-[#e4e7ec] focus:ring-[#029e55]"
                                >
                                <span class="text-xs text-[#667085]">100 000 - 500 000 FCFA</span>
                            </label>

                            <label class="flex items-center gap-3 p-2 rounded-xl hover:bg-[#f8fafc] cursor-pointer">
                                <input
                                    type="radio"
                                    name="price_type"
                                    value="above_500k"
                                    {{ $priceType === 'above_500k' ? 'checked' : '' }}
                                    class="h-4 w-4 text-[#029e55] border-[#e4e7ec] focus:ring-[#029e55]"
                                >
                                <span class="text-xs text-[#667085]">&gt; 500 000 FCFA</span>
                            </label>
                        </div>
                    </div>
                </details>
            </form>
        </div>

        {{-- Barre d'action inférieure fixe (Sticky Footer) --}}
        <div class="p-4 border-t border-[#e4e7ec] bg-white shrink-0">
            <button
                type="submit"
                form="mobile-filters-form"
                class="flex w-full items-center justify-center gap-2 rounded-xl bg-[#029e55] py-3.5 px-4 text-sm font-semibold text-white shadow-md hover:bg-[#028347] active:scale-[0.99] transition-all"
            >
                <span>Appliquer les filtres</span>
                @if(isset($products) && $products->total() > 0)
                    <span class="rounded-full bg-white/20 px-2 py-0.5 text-xs text-white">
                        {{ $products->total() }}
                    </span>
                @endif
            </button>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const openBtn = document.getElementById('open-filters-mobile');
        const closeBtn = document.getElementById('close-filters-mobile');
        const container = document.getElementById('mobile-filter-modal-container');
        const backdrop = document.getElementById('mobile-filter-backdrop');
        const sheet = document.getElementById('mobile-filter-sheet');

        function openModal() {
            if (!container || !backdrop || !sheet) return;

            container.classList.remove('pointer-events-none');
            container.classList.add('pointer-events-auto');
            container.setAttribute('aria-hidden', 'false');

            backdrop.classList.remove('pointer-events-none', 'opacity-0');
            backdrop.classList.add('pointer-events-auto', 'opacity-100');

            sheet.classList.remove('pointer-events-none', 'translate-y-full');
            sheet.classList.add('pointer-events-auto', 'translate-y-0');

            document.body.classList.add('overflow-hidden');
        }

        function closeModal() {
            if (!container || !backdrop || !sheet) return;

            backdrop.classList.remove('opacity-100', 'pointer-events-auto');
            backdrop.classList.add('opacity-0', 'pointer-events-none');

            sheet.classList.remove('translate-y-0', 'pointer-events-auto');
            sheet.classList.add('translate-y-full', 'pointer-events-none');

            container.setAttribute('aria-hidden', 'true');
            setTimeout(function () {
                container.classList.remove('pointer-events-auto');
                container.classList.add('pointer-events-none');
            }, 300);

            document.body.classList.remove('overflow-hidden');
        }

        if (openBtn) openBtn.addEventListener('click', openModal);
        if (closeBtn) closeBtn.addEventListener('click', closeModal);
        if (backdrop) backdrop.addEventListener('click', closeModal);

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && container && container.getAttribute('aria-hidden') === 'false') {
                closeModal();
            }
        });
    });
</script>
