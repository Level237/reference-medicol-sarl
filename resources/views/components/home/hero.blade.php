@props([
    'categories' => collect(),
    'selectedCategory' => '',
])

{{-- Section Hero reproduction fidèle avec image de fond --}}
<section class="relative min-h-[500px] sm:min-h-[540px] lg:min-h-[580px] xl:min-h-[620px] overflow-hidden bg-white">
    {{-- Image d'arrière-plan --}}
    <div
        class="absolute inset-0 bg-no-repeat bg-cover bg-[position:85%_center] sm:bg-[position:right_center]"
        style="background-image: url('{{ asset('assets/images/hero.png') }}');"
        aria-hidden="true"
    ></div>

    {{-- Voile dégradé blanc subtil pour garantir la lisibilité du texte --}}
    <div
        class="absolute inset-0 bg-gradient-to-r from-white via-white/90 to-transparent lg:via-white/60 xl:via-white/40 pointer-events-none"
        aria-hidden="true"
    ></div>

    {{-- Contenu du Hero --}}
    <div class="relative mx-auto flex max-w-7xl flex-col justify-between px-4 py-8 sm:px-6 sm:py-12 lg:px-8 lg:py-16 min-h-[500px] sm:min-h-[540px] lg:min-h-[580px] xl:min-h-[620px]">
        {{-- Ligne supérieure : Fil d'Ariane & Tagline supérieure droite --}}
        <div class="flex items-start justify-between gap-4">
            {{-- Fil d'Ariane : Accueil > Catalogue --}}
            <nav aria-label="Fil d'Ariane" class="inline-flex items-center gap-1.5 text-xs font-medium text-[#667085]">
                <a href="{{ route('home') }}" class="text-[#029e55] hover:underline transition-colors">Accueil</a>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-[#98a2b3]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                </svg>
                <span class="text-[#667085]">Catalogue</span>
            </nav>

            {{-- Accroche en haut à droite visible sur écran large --}}
            <div class="hidden md:block text-right">
                <p class="text-xs sm:text-sm font-semibold text-[#1d2939] leading-snug">
                    Équiper<br>
                    aujourd'hui<br>
                    pour une santé<br>
                    meilleure demain
                </p>
                <div class="mt-1.5 h-0.5 w-8 bg-[#029e55] ml-auto rounded-full" aria-hidden="true"></div>
            </div>
        </div>

        {{-- Bloc principal de gauche : Titre, Description et Barre de Recherche --}}
        <div class="my-auto max-w-xl lg:max-w-2xl py-6">
            {{-- Titre principal --}}
            <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-[54px] font-extrabold tracking-tight text-[#1d2939] leading-[1.12]">
                Tout le matériel<br>
                pour vos soins.
            </h1>

            {{-- Description --}}
            <p class="mt-4 sm:mt-5 text-sm sm:text-base md:text-lg text-[#667085] leading-relaxed max-w-lg">
                Des équipements fiables pour les professionnels de santé à Douala et dans toute l'Afrique centrale
            </p>

            {{-- Barre de recherche compacte : select catégorie + champ + bouton --}}
            <form action="{{ route('home') }}#catalogue" method="GET" class="mt-6 sm:mt-8 max-w-xl">
                @if(request('brand'))
                    <input type="hidden" name="brand" value="{{ request('brand') }}">
                @endif

                <div class="flex flex-col gap-2 sm:flex-row sm:items-stretch rounded-2xl bg-white p-1.5 sm:p-2 shadow-lg shadow-black/5 ring-1 ring-[#e4e7ec] focus-within:ring-2 focus-within:ring-[#029e55] transition-all">
                    {{-- Select catégorie (peu encombrant) --}}
                   

                    {{-- Champ recherche + bouton --}}
                    <div class="flex min-w-0 flex-1 items-center gap-1">
                        <div class="flex min-w-0 flex-1 items-center pl-1 sm:pl-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0 text-[#98a2b3]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                            </svg>
                            <input
                                type="search"
                                name="q"
                                value="{{ request('q') }}"
                                placeholder="Produit ou référence..."
                                class="w-full min-w-0 bg-transparent py-2.5 sm:py-3 pl-2 pr-2 text-sm text-[#1d2939] placeholder-[#98a2b3] focus:outline-none"
                            />
                        </div>

                        <button
                            type="submit"
                            aria-label="Rechercher"
                            class="shrink-0 rounded-xl bg-[#0f172a] px-3.5 sm:px-6 py-2.5 sm:py-3 text-sm font-medium text-white shadow-sm hover:bg-[#1e293b] active:scale-[0.99] transition-all"
                        >
                            <span class="hidden sm:inline">Rechercher</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                            </svg>
                        </button>
                    </div>
                </div>
            </form>
        </div>

        {{-- Espace réservé bas pour l'équilibre de composition --}}
        <div class="hidden lg:block h-6" aria-hidden="true"></div>
    </div>
</section>
