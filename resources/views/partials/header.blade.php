{{-- En-tête public, réutilisé par le layout public. --}}
<header class="sticky top-0 z-40 border-b border-line bg-white/95 backdrop-blur-md">
    <div class="mx-auto flex h-[4.5rem] max-w-7xl items-center gap-3 px-4 sm:px-6 lg:h-20 lg:gap-6 lg:px-8">
        <a href="{{ route('home') }}" class="flex min-w-0 shrink-0 items-center gap-2.5">
            <img
                src="{{ asset('assets/images/logo.png') }}"
                alt="RMS"
                class="h-11 w-11 rounded-full object-cover ring-1 ring-line lg:h-12 lg:w-12"
            >
            <span class="min-w-0 leading-tight">
                <span class="block truncate text-[15px] font-bold tracking-tight text-dark sm:text-base">Référence Médico Sarl</span>
                <span class="hidden text-[11px] font-medium text-muted sm:block">Équipements médicaux pour hôpitaux et cliniques</span>
            </span>
        </a>

        <nav aria-label="Navigation principale" class="ml-auto hidden items-center gap-1 lg:flex">
            @foreach ([
                ['label' => 'Catalogue', 'url' => route('home').'#catalogue'],
                ['label' => 'Nos services', 'url' => route('home').'#services'],
                ['label' => 'À propos', 'url' => route('home').'#a-propos'],
                ['label' => 'Contact', 'url' => route('home').'#contact'],
            ] as $item)
                <a
                    href="{{ $item['url'] }}"
                    class="rounded-lg px-3 py-2 text-sm font-medium text-dark transition-colors hover:bg-[#f9fafb] hover:text-primary"
                >
                    {{ $item['label'] }}
                </a>
            @endforeach
        </nav>

        <div class="ml-auto flex items-center gap-1.5 lg:ml-2 lg:gap-2">
            <button
                type="button"
                id="toggle-site-search"
                class="inline-flex h-10 w-10 items-center justify-center rounded-full text-dark transition-colors hover:bg-[#f2f4f7]"
                aria-expanded="false"
                aria-controls="recherche-site"
                aria-label="Rechercher"
            >
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5" aria-hidden="true">
                    <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 1 0 0 11 5.5 5.5 0 0 0 0-11ZM2 9a7 7 0 1 1 12.452 4.391l3.328 3.329a.75.75 0 1 1-1.06 1.06l-3.329-3.328A7 7 0 0 1 2 9Z" clip-rule="evenodd" />
                </svg>
            </button>

            <a
                href="{{ route('home') }}#devis"
                class="hidden items-center rounded-full bg-night px-4 py-2.5 text-sm font-semibold text-white shadow-xs transition-colors hover:bg-dark sm:inline-flex"
            >
                Demander un devis
            </a>

            <button
                type="button"
                id="toggle-mobile-nav"
                class="inline-flex h-10 w-10 items-center justify-center rounded-full text-dark transition-colors hover:bg-[#f2f4f7] lg:hidden"
                aria-expanded="false"
                aria-controls="menu-mobile"
                aria-label="Ouvrir le menu"
            >
                <svg id="mobile-nav-open-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-5 w-5" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
                <svg id="mobile-nav-close-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="hidden h-5 w-5" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>

    <form
        id="recherche-site"
        role="search"
        action="{{ route('home') }}"
        class="hidden border-t border-line bg-white"
    >
        <div class="mx-auto flex max-w-7xl items-center gap-3 px-4 py-3 sm:px-6 lg:px-8">
            <label for="q" class="sr-only">Rechercher un équipement</label>
            <input
                id="q"
                name="q"
                type="search"
                placeholder="Rechercher un appareil, une référence…"
                class="w-full rounded-xl border border-line bg-[#fcfcfd] px-4 py-2.5 text-sm text-dark outline-none placeholder:text-subtle focus:border-primary focus:ring-2 focus:ring-primary/20"
            >
        </div>
    </form>

    <div id="menu-mobile" class="hidden border-t border-line bg-white lg:hidden">
        <nav aria-label="Navigation mobile" class="mx-auto flex max-w-7xl flex-col gap-1 px-4 py-3 sm:px-6">
            @foreach ([
                ['label' => 'Catalogue', 'url' => route('home').'#catalogue'],
                ['label' => 'Nos services', 'url' => route('home').'#services'],
                ['label' => 'À propos', 'url' => route('home').'#a-propos'],
                ['label' => 'Contact', 'url' => route('home').'#contact'],
            ] as $item)
                <a
                    href="{{ $item['url'] }}"
                    class="mobile-nav-link rounded-xl px-3 py-3 text-sm font-semibold text-dark hover:bg-[#f9fafb] hover:text-primary"
                >
                    {{ $item['label'] }}
                </a>
            @endforeach
            <a
                href="{{ route('home') }}#devis"
                class="mobile-nav-link mt-2 inline-flex items-center justify-center rounded-full bg-night px-4 py-3 text-sm font-semibold text-white"
            >
                Demander un devis
            </a>
        </nav>
    </div>
</header>

<script>
    (function () {
        const menuButton = document.getElementById('toggle-mobile-nav');
        const menu = document.getElementById('menu-mobile');
        const openIcon = document.getElementById('mobile-nav-open-icon');
        const closeIcon = document.getElementById('mobile-nav-close-icon');
        const searchButton = document.getElementById('toggle-site-search');
        const searchForm = document.getElementById('recherche-site');
        const searchInput = document.getElementById('q');

        function setMenu(open) {
            if (!menu || !menuButton) return;
            menu.classList.toggle('hidden', !open);
            menuButton.setAttribute('aria-expanded', open ? 'true' : 'false');
            menuButton.setAttribute('aria-label', open ? 'Fermer le menu' : 'Ouvrir le menu');
            openIcon?.classList.toggle('hidden', open);
            closeIcon?.classList.toggle('hidden', !open);
        }

        function setSearch(open) {
            if (!searchForm || !searchButton) return;
            searchForm.classList.toggle('hidden', !open);
            searchButton.setAttribute('aria-expanded', open ? 'true' : 'false');
            if (open) searchInput?.focus();
        }

        menuButton?.addEventListener('click', function () {
            const open = menu.classList.contains('hidden');
            setSearch(false);
            setMenu(open);
        });

        searchButton?.addEventListener('click', function () {
            const open = searchForm.classList.contains('hidden');
            setMenu(false);
            setSearch(open);
        });

        menu?.querySelectorAll('.mobile-nav-link').forEach(function (link) {
            link.addEventListener('click', function () {
                setMenu(false);
            });
        });

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') {
                setMenu(false);
                setSearch(false);
            }
        });
    })();
</script>
