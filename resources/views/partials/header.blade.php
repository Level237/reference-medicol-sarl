{{-- Header Public conforme à la maquette et docs/DESIGN.md --}}
<header class="sticky top-0 z-40 bg-white border-b border-[#e4e7ec]/80 backdrop-blur-md bg-white/95">
    <div class="mx-auto flex h-16 max-w-7xl items-center justify-between gap-3 px-4 sm:h-20 sm:gap-4 sm:px-6 lg:px-8">
        {{-- Logo & Titre de marque --}}
        <a href="{{ route('home') }}" class="group flex min-w-0 items-center gap-2.5 sm:gap-3">
            <img
                src="{{ asset('assets/images/logo.png') }}"
                alt="Référence Médico Sarl"
                class="h-10 w-10 shrink-0 rounded-full object-contain shadow-xs transition-transform group-hover:scale-105 sm:h-12 sm:w-12"
                width="48"
                height="48"
            >
            <div class="flex min-w-0 flex-col">
                <span class="truncate text-base font-bold leading-tight tracking-tight text-[#1d2939] transition-colors group-hover:text-[#029e55] sm:text-lg">
                    Référence Médico Sarl
                </span>
                <span class="hidden text-[11px] font-normal leading-tight text-[#667085] sm:block">
                    Tout le matériel médical de A à Z
                </span>
            </div>
        </a>

        {{-- Navigation Desktop sans border-bottom --}}
        <nav class="hidden md:flex items-center gap-8">
            <a
                href="{{ route('catalogue') }}"
                class="text-sm transition-colors {{ request()->routeIs('catalogue') ? 'font-semibold text-[#029e55]' : 'font-medium text-[#667085] hover:text-[#1d2939]' }}"
            >
                Catalogue
            </a>

            <a
                href="{{ route('services') }}"
                class="text-sm transition-colors {{ request()->routeIs('services') ? 'font-semibold text-[#029e55]' : 'font-medium text-[#667085] hover:text-[#1d2939]' }}"
            >
                Nos services
            </a>

            <a
                href="{{ route('about') }}"
                class="text-sm transition-colors {{ request()->routeIs('about') ? 'font-semibold text-[#029e55]' : 'font-medium text-[#667085] hover:text-[#1d2939]' }}"
            >
                À propos
            </a>

            <a
                href="{{ route('contact') }}"
                class="text-sm transition-colors {{ request()->routeIs('contact') ? 'font-semibold text-[#029e55]' : 'font-medium text-[#667085] hover:text-[#1d2939]' }}"
            >
                Contact
            </a>
        </nav>

        {{-- Actions Desktop : Recherche + Panier Devis + CTA Demander un devis --}}
        <div class="hidden md:flex items-center gap-3">
            {{-- Bouton Recherche --}}
            <button
                type="button"
                id="search-toggle-btn"
                class="p-2.5 text-[#1d2939] hover:text-[#029e55] hover:bg-[#e4e7ec] rounded-lg transition-colors"
                aria-label="Rechercher un produit ou équipement"
                aria-haspopup="dialog"
                aria-controls="search-modal"
                aria-expanded="false"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                </svg>
            </button>

            {{-- Bouton Panier / Devis avec compteur --}}
            <a
                href="{{ route('cart.index') }}"
                id="header-cart-btn"
                class="relative flex items-center justify-center rounded-lg p-2.5 text-[#1d2939] transition-colors hover:bg-[#e4e7ec] hover:text-[#029e55]"
                aria-label="Voir la sélection pour devis"
                title="Articles dans votre demande de devis"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119.993z" />
                </svg>
                <span
                    id="cart-counter-badge"
                    class="{{ ($cartCount ?? 0) > 0 ? '' : 'hidden' }} absolute -right-0.5 -top-0.5 flex h-4 min-w-4 items-center justify-center rounded-full bg-[#029e55] px-1 text-[10px] font-bold text-white shadow-xs"
                >
                    {{ $cartCount ?? 0 }}
                </span>
            </a>

            {{-- Bouton Demander un devis (conforme maquette sombre) --}}
            <a
                href="{{ route('quotes.create') }}"
                class="inline-flex items-center justify-center rounded-lg bg-[#029e55] px-4 py-2.5 text-sm font-medium text-white shadow-sm transition-all hover:bg-[#0f172a] active:scale-[0.99]"
            >
                Demander un devis
            </a>
        </div>

        {{-- Mobile : panier + menu. La recherche vit dans le tiroir. --}}
        <div class="flex shrink-0 items-center gap-1 md:hidden">
            <a
                href="{{ route('cart.index') }}"
                class="relative rounded-lg p-2 text-[#1d2939] hover:bg-[#e4e7ec]"
                aria-label="Voir le panier de devis"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119.993z" />
                </svg>
                <span
                    class="mobile-cart-badge {{ ($cartCount ?? 0) > 0 ? '' : 'hidden' }} absolute -right-0.5 -top-0.5 flex h-4 min-w-4 items-center justify-center rounded-full bg-[#029e55] px-1 text-[10px] font-bold text-white shadow-xs"
                >
                    {{ $cartCount ?? 0 }}
                </span>
            </a>

            <button
                type="button"
                id="mobile-menu-btn"
                class="rounded-lg p-2 text-[#1d2939] hover:bg-[#e4e7ec]"
                aria-label="Menu principal"
                aria-expanded="false"
                aria-controls="menu-mobile"
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

</header>

{{-- Tiroir mobile : hors du header, le backdrop-filter casserait le positionnement fixed. --}}
<div id="mobile-nav" class="md:hidden">
    <div
        id="mobile-nav-backdrop"
        data-open="false"
        class="fixed inset-0 z-50 bg-[#0f172a]/40 transition-opacity duration-300 ease-out"
        style="opacity: 0; pointer-events: none"
    ></div>

    <div
        id="menu-mobile"
        role="dialog"
        aria-modal="true"
        aria-labelledby="mobile-menu-title"
        aria-hidden="true"
        data-open="false"
        inert
        class="fixed inset-y-0 right-0 z-50 flex w-[min(22rem,88vw)] flex-col bg-white shadow-xl transition-transform duration-300 ease-[cubic-bezier(0.16,1,0.3,1)]"
        style="translate: 100% 0"
    >
        <div class="flex h-16 shrink-0 items-center justify-between border-b border-[#e4e7ec] px-4">
            <p id="mobile-menu-title" class="text-sm font-semibold text-[#1d2939]">Menu</p>
            <button
                type="button"
                id="mobile-menu-close"
                class="rounded-lg p-2 text-[#1d2939] hover:bg-[#e4e7ec]"
                aria-label="Fermer le menu"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <div class="flex-1 overflow-y-auto overscroll-contain px-3 py-4">
            <div class="border-b border-[#e4e7ec] pb-3">
                <button
                    type="button"
                    id="mobile-menu-search-toggle"
                    class="flex w-full items-center gap-3 rounded-lg px-3 py-2.5 text-base font-medium text-[#1d2939] hover:bg-[#e4e7ec]"
                    aria-haspopup="dialog"
                    aria-controls="search-modal"
                    aria-expanded="false"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0 text-[#029e55]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                    </svg>
                    <span>Recherche</span>
                </button>
            </div>

            <nav class="mt-3 flex flex-col gap-1" aria-label="Navigation">
                <a
                    href="{{ route('catalogue') }}"
                    class="flex items-center justify-between rounded-lg px-3 py-2.5 text-base font-semibold {{ request()->routeIs('catalogue') ? 'bg-[#029e55]/10 text-[#029e55]' : 'text-[#1d2939] hover:bg-[#e4e7ec]' }}"
                >
                    <span>Catalogue</span>
                    @if(request()->routeIs('catalogue'))
                        <span class="h-1.5 w-1.5 rounded-full bg-[#029e55]"></span>
                    @endif
                </a>
                <a
                    href="{{ route('services') }}"
                    class="rounded-lg px-3 py-2.5 text-base font-medium {{ request()->routeIs('services') ? 'bg-[#029e55]/10 font-semibold text-[#029e55]' : 'text-[#667085] hover:bg-[#e4e7ec] hover:text-[#1d2939]' }}"
                >
                    Nos services
                </a>
                <a
                    href="{{ route('about') }}"
                    class="rounded-lg px-3 py-2.5 text-base font-medium {{ request()->routeIs('about') ? 'bg-[#029e55]/10 font-semibold text-[#029e55]' : 'text-[#667085] hover:bg-[#e4e7ec] hover:text-[#1d2939]' }}"
                >
                    À propos
                </a>
                <a
                    href="{{ route('contact') }}"
                    class="rounded-lg px-3 py-2.5 text-base font-medium {{ request()->routeIs('contact') ? 'bg-[#029e55]/10 font-semibold text-[#029e55]' : 'text-[#667085] hover:bg-[#e4e7ec] hover:text-[#1d2939]' }}"
                >
                    Contact
                </a>
            </nav>
        </div>

        <div class="shrink-0 border-t border-[#e4e7ec] p-4">
            <a
                href="{{ route('quotes.create') }}"
                class="flex w-full items-center justify-center rounded-lg bg-[#029e55] px-4 py-2.5 text-center text-sm font-medium text-white shadow-sm hover:bg-[#0f172a]"
            >
                Demander un devis
            </a>
        </div>
    </div>
</div>

<dialog
    id="search-modal"
    aria-labelledby="search-modal-title"
    class="m-auto w-[min(32rem,calc(100%-2rem))] rounded-2xl border border-[#e4e7ec] bg-white p-0 text-[#1d2939] shadow-xl backdrop:bg-[#0f172a]/40 backdrop:backdrop-blur-xl"
>
    <div class="flex items-center justify-between border-b border-[#e4e7ec] px-5 py-4">
        <h2 id="search-modal-title" class="text-base font-semibold text-[#1d2939]">Recherche</h2>
        <button
            type="button"
            id="search-modal-close"
            class="rounded-lg p-2 text-[#1d2939] hover:bg-[#e4e7ec]"
            aria-label="Fermer la recherche"
        >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <form action="{{ route('catalogue') }}" method="GET" class="space-y-3 px-5 py-5">
        <x-products.category-select
            :categories="$searchCategories ?? collect()"
            :selectedCategory="request('category', '')"
            id="search-modal-category"
        />

        <div class="relative">
            <label for="search-modal-query" class="sr-only">Produit ou référence</label>
            <input
                id="search-modal-query"
                type="search"
                name="q"
                value="{{ request('q') }}"
                placeholder="Produit ou référence..."
                class="w-full rounded-lg border border-[#e4e7ec] bg-white py-2.5 pl-10 pr-4 text-sm text-[#1d2939] placeholder-[#667085] focus:border-[#029e55] focus:outline-none focus:ring-2 focus:ring-[#029e55]/20"
            />
            <svg xmlns="http://www.w3.org/2000/svg" class="absolute left-3 top-3 h-4 w-4 text-[#98a2b3]" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
            </svg>
        </div>

        <button
            type="submit"
            class="w-full rounded-lg bg-[#029e55] px-4 py-2.5 text-sm font-medium text-white transition-colors hover:bg-[#0f172a]"
        >
            Chercher
        </button>
    </form>
</dialog>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchToggleBtn = document.getElementById('search-toggle-btn');
        const searchModal = document.getElementById('search-modal');
        const searchModalClose = document.getElementById('search-modal-close');
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('menu-mobile');
        const mobileNavBackdrop = document.getElementById('mobile-nav-backdrop');
        const mobileMenuClose = document.getElementById('mobile-menu-close');
        const hamburgerIcon = document.getElementById('hamburger-icon');
        const closeIcon = document.getElementById('close-icon');
        const mobileSearchToggle = document.getElementById('mobile-menu-search-toggle');

        function setMenuOpen(open) {
            if (!mobileMenuBtn || !mobileMenu || !mobileNavBackdrop) return;

            mobileMenuBtn.setAttribute('aria-expanded', open ? 'true' : 'false');
            mobileMenu.setAttribute('aria-hidden', open ? 'false' : 'true');
            mobileMenu.dataset.open = open ? 'true' : 'false';
            mobileNavBackdrop.dataset.open = open ? 'true' : 'false';
            mobileMenu.style.translate = open ? '0 0' : '100% 0';
            mobileNavBackdrop.style.opacity = open ? '1' : '0';
            mobileNavBackdrop.style.pointerEvents = open ? 'auto' : 'none';
            mobileMenu.toggleAttribute('inert', !open);
            document.body.classList.toggle('overflow-hidden', open);

            if (hamburgerIcon && closeIcon) {
                hamburgerIcon.classList.toggle('hidden', open);
                closeIcon.classList.toggle('hidden', !open);
            }

            if (open && mobileMenuClose) {
                mobileMenuClose.focus();
            }
        }

        if (mobileMenuBtn) {
            mobileMenuBtn.addEventListener('click', function () {
                setMenuOpen(mobileMenuBtn.getAttribute('aria-expanded') !== 'true');
            });
        }

        if (mobileMenuClose) {
            mobileMenuClose.addEventListener('click', function () {
                setMenuOpen(false);
                if (mobileMenuBtn) mobileMenuBtn.focus();
            });
        }

        if (mobileNavBackdrop) {
            mobileNavBackdrop.addEventListener('click', function () {
                setMenuOpen(false);
            });
        }

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape' && mobileMenu && mobileMenu.dataset.open === 'true') {
                setMenuOpen(false);
                if (mobileMenuBtn) mobileMenuBtn.focus();
            }
        });

        const desktopNav = window.matchMedia('(min-width: 768px)');
        desktopNav.addEventListener('change', function (event) {
            if (event.matches) setMenuOpen(false);
        });

        function openSearchModal() {
            if (!searchModal) return;

            if (mobileMenu && mobileMenu.dataset.open === 'true') {
                setMenuOpen(false);
            }

            if (typeof searchModal.showModal === 'function' && !searchModal.open) {
                searchModal.showModal();
            }

            if (searchToggleBtn) searchToggleBtn.setAttribute('aria-expanded', 'true');
            if (mobileSearchToggle) mobileSearchToggle.setAttribute('aria-expanded', 'true');

            const input = searchModal.querySelector('input[type="search"]');
            if (input) input.focus();
        }

        if (searchToggleBtn) searchToggleBtn.addEventListener('click', openSearchModal);
        if (mobileSearchToggle) mobileSearchToggle.addEventListener('click', openSearchModal);

        if (searchModalClose && searchModal) {
            searchModalClose.addEventListener('click', function () {
                searchModal.close();
            });
        }

        if (searchModal) {
            searchModal.addEventListener('click', function (event) {
                if (event.target === searchModal) searchModal.close();
            });

            searchModal.addEventListener('close', function () {
                if (searchToggleBtn) searchToggleBtn.setAttribute('aria-expanded', 'false');
                if (mobileSearchToggle) mobileSearchToggle.setAttribute('aria-expanded', 'false');
            });
        }
    });
</script>
