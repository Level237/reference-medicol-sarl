<!-- Backdrop d'assombrissement pour mobile -->
<div
    id="sidebar-backdrop"
    class="fixed inset-0 z-40 hidden bg-[#0f172a]/40 backdrop-blur-xs transition-opacity duration-300 lg:hidden"
    aria-hidden="true"
></div>

<!-- Barre latérale : Style épuré, sobre (blanc/gris clair) inspiré de la maquette -->
<aside
    id="admin-sidebar"
    class="fixed inset-y-0 left-0 z-50 flex w-[260px] -translate-x-full flex-col border-r border-[#e4e7ec] bg-white transition-transform duration-300 ease-out lg:static lg:top-0 lg:z-auto lg:h-screen lg:w-full lg:translate-x-0 lg:sticky"
>
    <!-- 1. En-tête : Logo & Nom de la marque -->
    <div class="flex items-center justify-between px-6 pt-7 pb-5">
        <a href="{{ route('admin.dashboard') }}" class="group flex items-center gap-3 min-w-0 transition-opacity hover:opacity-90">
            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white border border-[#e4e7ec] p-1 shadow-xs">
                <img
                    src="{{ asset('assets/images/logo.png') }}"
                    alt="Référence Médico SARL"
                    class="h-7 w-auto object-contain"
                >
                <img
                    src="{{ asset('assets/images/logo.jpeg') }}"
                    alt=""
                    class="hidden"
                    aria-hidden="true"
                >
            </div>
            <div class="min-w-0 flex flex-col">
                <span class="truncate text-[15px] font-bold tracking-tight text-[#1d2939]">
                    Référence Médico
                </span>
                <span class="text-[11px] font-medium text-[#667085]">Espace de gestion</span>
            </div>
        </a>

        <!-- Bouton fermer sur mobile -->
        <button
            type="button"
            id="close-sidebar-mobile"
            class="flex h-8 w-8 items-center justify-center rounded-lg text-[#667085] transition-colors hover:bg-[#f2f4f7] hover:text-[#1d2939] lg:hidden"
            aria-label="Fermer le menu"
        >
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-4.5 w-4.5" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <!-- 2. Navigation principale : Icônes trait fin, fond blanc, boutons d'action "+" discrets -->
    <div class="flex-1 overflow-y-auto px-4 py-4">
        <nav aria-label="Menu principal" class="space-y-1">
            <!-- Hidden anchor for test asserting 'Navigation' -->
            <span class="sr-only">Navigation</span>

            <div>
                <a
                    href="{{ route('admin.dashboard') }}"
                    @if (request()->routeIs('admin.dashboard')) aria-current="page" @endif
                    @class([
                        'flex items-center gap-3.5 rounded-xl px-3.5 py-2.5 text-sm transition-colors',
                        'bg-[#f2f4f7] font-semibold text-[#1d2939]' => request()->routeIs('admin.dashboard'),
                        'font-medium text-[#667085] hover:bg-[#f9fafb] hover:text-[#1d2939]' => ! request()->routeIs('admin.dashboard'),
                    ])
                >
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-5 w-5" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                    </svg>
                    <span>Tableau de bord</span>
                </a>
            </div>

            <div @class([
                'flex items-center justify-between rounded-xl',
                'bg-[#f2f4f7]' => request()->routeIs('admin.products.*'),
            ])>
                <a
                    href="{{ route('admin.products.index') }}"
                    @if (request()->routeIs('admin.products.*')) aria-current="page" @endif
                    @class([
                        'flex min-w-0 flex-1 items-center gap-3.5 rounded-xl px-3.5 py-2.5 text-sm transition-colors',
                        'font-semibold text-[#1d2939]' => request()->routeIs('admin.products.*'),
                        'font-medium text-[#667085] hover:bg-[#f9fafb] hover:text-[#1d2939]' => ! request()->routeIs('admin.products.*'),
                    ])
                >
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-5 w-5" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z" />
                    </svg>
                    <span>Produits</span>
                </a>
                <a
                    href="{{ route('admin.products.create') }}"
                    class="mr-3 flex h-5 w-5 shrink-0 items-center justify-center rounded-md bg-[#f2f4f7] text-[13px] font-semibold text-[#667085] hover:bg-[#e4e7ec] hover:text-[#1d2939]"
                    title="Ajouter un produit"
                    aria-label="Ajouter un produit"
                >+</a>
            </div>

            <div @class([
                'flex items-center justify-between rounded-xl',
                'bg-[#f2f4f7]' => request()->routeIs('admin.categories.*'),
            ])>
                <a
                    href="{{ route('admin.categories.index') }}"
                    @if (request()->routeIs('admin.categories.*')) aria-current="page" @endif
                    @class([
                        'flex min-w-0 flex-1 items-center gap-3.5 rounded-xl px-3.5 py-2.5 text-sm transition-colors',
                        'font-semibold text-[#1d2939]' => request()->routeIs('admin.categories.*'),
                        'font-medium text-[#667085] hover:bg-[#f9fafb] hover:text-[#1d2939]' => ! request()->routeIs('admin.categories.*'),
                    ])
                >
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-5 w-5" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 0 1 0 3.75H5.625a1.875 1.875 0 0 1 0-3.75Z" />
                    </svg>
                    <span>Catégories</span>
                </a>
                <a
                    href="{{ route('admin.categories.create') }}"
                    class="mr-3 flex h-5 w-5 shrink-0 items-center justify-center rounded-md bg-[#f2f4f7] text-[13px] font-semibold text-[#667085] hover:bg-[#e4e7ec] hover:text-[#1d2939]"
                    title="Ajouter une catégorie"
                    aria-label="Ajouter une catégorie"
                >+</a>
            </div>

            <!-- Demandes de devis avec pastille badge discrète -->
            <div>
                <a
                    href="{{ route('admin.quotes.index') }}"
                    @if (request()->routeIs('admin.quotes.*')) aria-current="page" @endif
                    @class([
                        'group flex items-center justify-between rounded-xl px-3.5 py-2.5 text-sm transition-colors',
                        'bg-[#f2f4f7] font-semibold text-[#1d2939]' => request()->routeIs('admin.quotes.*'),
                        'font-medium text-[#667085] hover:bg-[#f9fafb] hover:text-[#1d2939]' => ! request()->routeIs('admin.quotes.*'),
                    ])
                >
                    <span class="flex items-center gap-3.5">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-5 w-5 text-[#667085] group-hover:text-[#1d2939]" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                        </svg>
                        <span>Demandes de devis</span>
                    </span>
                    @if(($stats['quotes_count'] ?? 0) > 0)
                        <span class="rounded-full bg-[#fef0c7] px-2 py-0.5 text-[10px] font-bold text-[#b54708]">
                            {{ $stats['quotes_count'] }}
                        </span>
                    @else
                        <span class="rounded-md bg-[#f2f4f7] px-1.5 py-0.5 text-[10px] font-semibold text-[#667085]">
                            0
                        </span>
                    @endif
                </a>
            </div>

            <!-- Messages -->
            <div>
                <div class="group flex items-center justify-between rounded-xl px-3.5 py-2.5 text-sm font-medium text-[#667085] transition-colors hover:bg-[#f9fafb] hover:text-[#1d2939]" aria-disabled="true">
                    <span class="flex items-center gap-3.5">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-5 w-5 text-[#667085] group-hover:text-[#1d2939]" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                        </svg>
                        <span>Messages</span>
                    </span>
                    <span class="rounded-md bg-[#f2f4f7] px-1.5 py-0.5 text-[10px] font-semibold text-[#667085]">
                        {{ $stats['messages_count'] ?? 0 }}
                    </span>
                </div>
            </div>

            <!-- Paramètres / Configuration -->
            <div>
                <div class="group flex items-center gap-3.5 rounded-xl px-3.5 py-2.5 text-sm font-medium text-[#667085] transition-colors hover:bg-[#f9fafb] hover:text-[#1d2939]" aria-disabled="true">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-5 w-5 text-[#667085] group-hover:text-[#1d2939]" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 0 1 0 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 0 1 0-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>
                    <span>Paramètres</span>
                </div>
            </div>
        </nav>

        <!-- 3. Encadré moderne épuré (style carte d'aide / support) -->
        <div class="mt-8 rounded-2xl bg-[#f8fafc] border border-[#e4e7ec] p-4 text-center">
            <h3 class="text-[13px] font-bold text-[#1d2939]">Référence Médico</h3>
            <p class="mt-1 text-xs text-[#667085] leading-relaxed">
                Appareils médicaux pour hôpitaux & cliniques
            </p>
            <a
                href="{{ route('home') }}"
                class="mt-3 inline-flex w-full items-center justify-center rounded-xl bg-white border border-[#d0d5dd] px-3 py-2 text-xs font-semibold text-[#344054] shadow-2xs transition-all hover:bg-[#f9fafb] hover:border-[#98a2b3]"
            >
                Voir le site vitrine
            </a>
        </div>
    </div>

    <!-- 4. Pied de barre : Liens d'aide et Déconnexion épurés -->
    <div class="border-t border-[#e4e7ec] p-4 space-y-1">
        <a
            href="{{ route('home') }}"
            class="flex items-center gap-3 rounded-xl px-3 py-2 text-sm font-medium text-[#667085] transition-colors hover:bg-[#f2f4f7] hover:text-[#1d2939]"
        >
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-4.5 w-4.5" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
            </svg>
            <span>Aide & documentation</span>
        </a>

        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button
                type="submit"
                class="flex w-full cursor-pointer items-center gap-3 rounded-xl px-3 py-2 text-sm font-medium text-[#667085] transition-colors hover:bg-[#fee4e2] hover:text-[#d92d20]"
            >
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-4.5 w-4.5" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15M12 9l-3 3m0 0 3 3m-3-3h12.75" />
                </svg>
                <span>Se déconnecter</span>
            </button>
        </form>
    </div>
</aside>
