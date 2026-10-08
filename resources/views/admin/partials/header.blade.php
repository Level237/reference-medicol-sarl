<header class="sticky top-0 z-30 border-b border-[#eaecf0] bg-white/95 backdrop-blur-xs">
    <div class="flex items-center justify-between gap-4 px-4 py-3 sm:px-8 lg:px-10">
        <!-- Bouton hamburger mobile + Barre de recherche moderne -->
        <div class="flex flex-1 items-center gap-3 max-w-xl">
            <button
                type="button"
                id="toggle-sidebar-mobile"
                class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl border border-[#d0d5dd] text-[#344054] transition-colors hover:bg-[#f9fafb] lg:hidden"
                aria-label="Ouvrir le menu"
            >
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-5 w-5" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
            </button>

            <div class="relative w-full max-w-md">
                <label for="admin-search" class="sr-only">Rechercher</label>
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-[#98a2b3]">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4" aria-hidden="true">
                        <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 1 0 0 11 5.5 5.5 0 0 0 0-11ZM2 9a7 7 0 1 1 12.452 4.391l3.328 3.329a.75.75 0 1 1-1.06 1.06l-3.329-3.328A7 7 0 0 1 2 9Z" clip-rule="evenodd" />
                    </svg>
                </div>
                <input
                    type="search"
                    id="admin-search"
                    name="q"
                    placeholder="Rechercher un appareil, une référence, un devis..."
                    class="w-full rounded-xl border border-[#d0d5dd] bg-[#fcfcfd] py-2 pr-10 pl-9.5 text-xs sm:text-sm text-[#1d2939] placeholder:text-[#98a2b3] shadow-2xs transition-all focus:border-primary focus:bg-white focus:outline-none focus:ring-2 focus:ring-primary/15"
                >
                <div class="pointer-events-none absolute inset-y-0 right-0 hidden sm:flex items-center pr-3">
                    <kbd class="inline-flex items-center rounded border border-[#e4e7ec] bg-white px-1.5 py-0.5 text-[10px] font-medium text-[#98a2b3] shadow-2xs">⌘K</kbd>
                </div>
            </div>
        </div>

        <!-- Profil Administrateur avec Dropdown moderne -->
        <div class="relative shrink-0" id="user-menu-container">
            <button
                type="button"
                id="user-menu-button"
                aria-expanded="false"
                aria-haspopup="true"
                class="group flex items-center gap-3 rounded-xl p-1.5 transition-colors hover:bg-[#f2f4f7] focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary"
            >
                <!-- Avatar avec initiale -->
                <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-primary text-sm font-semibold text-white shadow-xs transition-transform group-hover:scale-105" aria-hidden="true">
                    {{ $initial }}
                </span>

                <!-- Nom & Rôle en desktop -->
                <div class="hidden text-left sm:block">
                    <div class="flex items-center gap-1.5">
                        <span class="text-xs font-semibold text-[#101828] group-hover:text-primary transition-colors">
                            {{ $admin->name }}
                        </span>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4 text-[#667085] transition-transform duration-200" id="user-menu-chevron">
                            <path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <span class="block text-[11px] font-medium text-[#667085]">Administrateur</span>
                </div>
            </button>

            <!-- Menu Dropdown -->
            <div
                id="user-menu-dropdown"
                class="absolute right-0 z-50 mt-2 hidden w-64 origin-top-right rounded-2xl border border-[#eaecf0] bg-white p-1.5 shadow-lg ring-1 ring-black/5 focus:outline-none transition-all duration-150"
                role="menu"
                aria-orientation="vertical"
                aria-labelledby="user-menu-button"
                tabindex="-1"
            >
                <!-- Entête du profil dans le dropdown -->
                <div class="border-b border-[#eaecf0] px-3 py-2.5">
                    <p class="text-xs font-semibold text-[#101828]">{{ $admin->name }}</p>
                    <p class="truncate text-[11px] text-[#667085]">{{ $admin->email }}</p>
                    <div class="mt-1.5">
                        <span class="inline-flex items-center gap-1 rounded-full bg-[#ecfdf3] px-2 py-0.5 text-[10px] font-semibold text-[#027a48] border border-[#a6f4c5]">
                            <span class="h-1.5 w-1.5 rounded-full bg-[#12b76a]"></span>
                            Connecté en Administrateur
                        </span>
                    </div>
                </div>

                <!-- Liens du dropdown -->
                <div class="py-1">
                    <a
                        href="{{ route('home') }}"
                        target="_blank"
                        class="flex items-center gap-2.5 rounded-xl px-3 py-2 text-xs font-medium text-[#344054] transition-colors hover:bg-[#f2f4f7] hover:text-[#101828]"
                        role="menuitem"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4 text-[#667085]">
                            <path fill-rule="evenodd" d="M4.25 5.5a.75.75 0 0 0-.75.75v8.5c0 .414.336.75.75.75h8.5a.75.75 0 0 0 .75-.75v-4a.75.75 0 0 1 1.5 0v4A2.25 2.25 0 0 1 12.75 17h-8.5A2.25 2.25 0 0 1 2 14.75v-8.5A2.25 2.25 0 0 1 4.25 4h5a.75.75 0 0 1 0 1.5h-5Z" clip-rule="evenodd" />
                            <path fill-rule="evenodd" d="M6.194 12.753a.75.75 0 0 0 1.06.053L16.5 4.44v2.81a.75.75 0 0 0 1.5 0v-4.5a.75.75 0 0 0-.75-.75h-4.5a.75.75 0 0 0 0 1.5h2.553l-9.056 8.194a.75.75 0 0 0-.053 1.06Z" clip-rule="evenodd" />
                        </svg>
                        <span>Voir le site public</span>
                    </a>
                </div>

                <!-- Séparateur & Déconnexion -->
                <div class="border-t border-[#eaecf0] pt-1">
                    <form method="POST" action="{{ route('admin.logout') }}">
                        @csrf
                        <button
                            type="submit"
                            class="flex w-full cursor-pointer items-center gap-2.5 rounded-xl px-3 py-2 text-xs font-semibold text-[#d92d20] transition-colors hover:bg-[#fee4e2] focus:bg-[#fee4e2] focus:outline-none"
                            role="menuitem"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4">
                                <path fill-rule="evenodd" d="M3 4.25A2.25 2.25 0 0 1 5.25 2h5.5A2.25 2.25 0 0 1 13 4.25v2a.75.75 0 0 1-1.5 0v-2a.75.75 0 0 0-.75-.75h-5.5a.75.75 0 0 0-.75.75v11.5c0 .414.336.75.75.75h5.5a.75.75 0 0 0 .75-.75v-2a.75.75 0 0 1 1.5 0v2A2.25 2.25 0 0 1 10.75 18h-5.5A2.25 2.25 0 0 1 3 15.75V4.25Z" clip-rule="evenodd" />
                                <path fill-rule="evenodd" d="M19 10a.75.75 0 0 0-.75-.75H8.704l2.523-2.523a.75.75 0 1 0-1.06-1.06l-3.8 3.8a.75.75 0 0 0 0 1.06l3.8 3.8a.75.75 0 1 0 1.06-1.06L8.704 10.75H18.25A.75.75 0 0 0 19 10Z" clip-rule="evenodd" />
                            </svg>
                            <span>Se déconnecter</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const menuButton = document.getElementById('user-menu-button');
        const menuDropdown = document.getElementById('user-menu-dropdown');
        const menuChevron = document.getElementById('user-menu-chevron');
        const menuContainer = document.getElementById('user-menu-container');

        if (!menuButton || !menuDropdown) return;

        function toggleDropdown() {
            const isHidden = menuDropdown.classList.contains('hidden');
            if (isHidden) {
                menuDropdown.classList.remove('hidden');
                menuButton.setAttribute('aria-expanded', 'true');
                if (menuChevron) menuChevron.classList.add('rotate-180');
            } else {
                menuDropdown.classList.add('hidden');
                menuButton.setAttribute('aria-expanded', 'false');
                if (menuChevron) menuChevron.classList.remove('rotate-180');
            }
        }

        function closeDropdown() {
            menuDropdown.classList.add('hidden');
            menuButton.setAttribute('aria-expanded', 'false');
            if (menuChevron) menuChevron.classList.remove('rotate-180');
        }

        menuButton.addEventListener('click', function (e) {
            e.stopPropagation();
            toggleDropdown();
        });

        document.addEventListener('click', function (e) {
            if (menuContainer && !menuContainer.contains(e.target)) {
                closeDropdown();
            }
        });

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                closeDropdown();
            }
        });
    });
</script>
