{{-- Header Public conforme à la maquette et docs/DESIGN.md --}}
<header class="sticky top-0 z-40 bg-white border-b border-[#e4e7ec]/80 backdrop-blur-md bg-white/95">
    <div class="mx-auto flex h-20 max-w-7xl items-center justify-between gap-4 px-4 sm:px-6 lg:px-8">
        {{-- Logo & Titre de marque --}}
        <a href="{{ route('home') }}" class="group flex items-center gap-3 shrink-0">
            <img
                src="{{ asset('assets/images/logo.png') }}"
                alt="Référence Médico Sarl"
                class="h-12 w-12 rounded-full object-contain shadow-xs group-hover:scale-105 transition-transform"
                width="48"
                height="48"
            >
            <div class="flex flex-col">
                <span class="text-lg font-bold tracking-tight text-[#1d2939] group-hover:text-[#029e55] transition-colors leading-tight">
                    Référence Médico Sarl
                </span>
                <span class="text-[11px] font-normal text-[#667085] leading-tight">
                    votre partenaire en matériel médical
                </span>
            </div>
        </a>

        {{-- Navigation Desktop sans border-bottom --}}
        <nav class="hidden md:flex items-center gap-8">
            <a
                href="{{ route('home') }}"
                class="text-sm transition-colors {{ request()->routeIs('home') ? 'font-semibold text-[#029e55]' : 'font-medium text-[#667085] hover:text-[#1d2939]' }}"
            >
                Catalogue
            </a>

            <a
                href="#services"
                class="text-sm font-medium text-[#667085] hover:text-[#1d2939] transition-colors"
            >
                Nos services
            </a>

            <a
                href="#a-propos"
                class="text-sm font-medium text-[#667085] hover:text-[#1d2939] transition-colors"
            >
                À propos
            </a>

            <a
                href="#contact"
                class="text-sm font-medium text-[#667085] hover:text-[#1d2939] transition-colors"
            >
                Contact
            </a>
        </nav>

        {{-- Actions Desktop : Recherche + CTA Demander un devis --}}
        <div class="hidden md:flex items-center gap-3">
            {{-- Bouton Recherche --}}
            <button
                type="button"
                id="search-toggle-btn"
                class="p-2.5 text-[#1d2939] hover:text-[#029e55] hover:bg-[#f2f4f7] rounded-lg transition-colors"
                aria-label="Rechercher un produit ou équipement"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                </svg>
            </button>

            {{-- Bouton Demander un devis (conforme maquette sombre) --}}
            <a
                href="#devis"
                class="inline-flex items-center justify-center rounded-lg bg-[#0f172a] px-4 py-2.5 text-sm font-medium text-white shadow-sm hover:bg-[#1e293b] active:scale-[0.99] transition-all"
            >
                Demander un devis
            </a>
        </div>

        {{-- Mobile Hamburger + Search --}}
        <div class="flex items-center gap-2 md:hidden">
            <button
                type="button"
                id="mobile-search-btn"
                class="p-2 text-[#1d2939] hover:bg-[#f2f4f7] rounded-lg"
                aria-label="Rechercher"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                </svg>
            </button>

            <button
                type="button"
                id="mobile-menu-btn"
                class="p-2 text-[#1d2939] hover:bg-[#f2f4f7] rounded-lg"
                aria-label="Menu principal"
                aria-expanded="false"
            >
                <svg id="hamburger-icon" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
                <svg id="close-icon" xmlns="http://www.w3.org/2000/svg" class="hidden h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>

    {{-- Barre de recherche déroulante --}}
    <div id="search-drawer" class="hidden border-t border-[#e4e7ec] bg-[#f8fafc] px-4 py-3 sm:px-6 lg:px-8">
        <form action="{{ route('home') }}#catalogue" method="GET" class="mx-auto flex max-w-2xl flex-col gap-2 sm:flex-row sm:items-stretch">
            <x-products.category-select
                :categories="$searchCategories ?? collect()"
                :selectedCategory="request('category', '')"
                id="header-category-select"
                class="sm:w-48 shrink-0"
            />

            <div class="relative min-w-0 flex-1">
                <input
                    type="search"
                    name="q"
                    value="{{ request('q') }}"
                    placeholder="Produit ou référence..."
                    class="w-full rounded-lg border border-[#e4e7ec] bg-white py-2 pl-10 pr-4 text-sm text-[#1d2939] placeholder-[#98a2b3] focus:border-[#029e55] focus:outline-none focus:ring-2 focus:ring-[#029e55]/20"
                />
                <svg xmlns="http://www.w3.org/2000/svg" class="absolute left-3 top-2.5 h-4 w-4 text-[#98a2b3]" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                </svg>
            </div>
            <button
                type="submit"
                class="shrink-0 rounded-lg bg-[#029e55] px-4 py-2 text-sm font-medium text-white hover:bg-[#028547] transition-colors"
            >
                Chercher
            </button>
        </form>
    </div>

    {{-- Menu Mobile --}}
    <div id="menu-mobile" class="hidden border-t border-[#e4e7ec] bg-white px-4 py-4 md:hidden">
        <nav class="flex flex-col space-y-3">
            <a
                href="{{ route('home') }}"
                class="flex items-center justify-between rounded-lg px-3 py-2 text-base font-semibold {{ request()->routeIs('home') ? 'bg-[#029e55]/10 text-[#029e55]' : 'text-[#1d2939] hover:bg-[#f2f4f7]' }}"
            >
                <span>Catalogue</span>
                @if(request()->routeIs('home'))
                    <span class="h-1.5 w-1.5 rounded-full bg-[#029e55]"></span>
                @endif
            </a>
            <a
                href="#services"
                class="rounded-lg px-3 py-2 text-base font-medium text-[#667085] hover:bg-[#f2f4f7] hover:text-[#1d2939]"
            >
                Nos services
            </a>
            <a
                href="#a-propos"
                class="rounded-lg px-3 py-2 text-base font-medium text-[#667085] hover:bg-[#f2f4f7] hover:text-[#1d2939]"
            >
                À propos
            </a>
            <a
                href="#contact"
                class="rounded-lg px-3 py-2 text-base font-medium text-[#667085] hover:bg-[#f2f4f7] hover:text-[#1d2939]"
            >
                Contact
            </a>

            <div class="pt-3 border-t border-[#e4e7ec]">
                <a
                    href="#devis"
                    class="flex w-full items-center justify-center rounded-lg bg-[#0f172a] px-4 py-2.5 text-center text-sm font-medium text-white shadow-sm hover:bg-[#1e293b]"
                >
                    Demander un devis
                </a>
            </div>
        </nav>
    </div>
</header>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchToggleBtn = document.getElementById('search-toggle-btn');
        const mobileSearchBtn = document.getElementById('mobile-search-btn');
        const searchDrawer = document.getElementById('search-drawer');

        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('menu-mobile');
        const hamburgerIcon = document.getElementById('hamburger-icon');
        const closeIcon = document.getElementById('close-icon');

        function toggleSearch() {
            if (searchDrawer) {
                searchDrawer.classList.toggle('hidden');
                if (!searchDrawer.classList.contains('hidden')) {
                    const input = searchDrawer.querySelector('input[type="search"]');
                    if (input) input.focus();
                }
            }
        }

        if (searchToggleBtn) searchToggleBtn.addEventListener('click', toggleSearch);
        if (mobileSearchBtn) mobileSearchBtn.addEventListener('click', toggleSearch);

        if (mobileMenuBtn && mobileMenu) {
            mobileMenuBtn.addEventListener('click', function () {
                const isExpanded = mobileMenuBtn.getAttribute('aria-expanded') === 'true';
                mobileMenuBtn.setAttribute('aria-expanded', !isExpanded);
                mobileMenu.classList.toggle('hidden');
                if (hamburgerIcon && closeIcon) {
                    hamburgerIcon.classList.toggle('hidden');
                    closeIcon.classList.toggle('hidden');
                }
            });
        }
    });
</script>
