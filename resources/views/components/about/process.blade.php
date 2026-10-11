@php
    $steps = [
        [
            'title' => 'Analyse de vos besoins',
            'description' => 'Compréhension directe de votre plateau technique, de vos contraintes d\'espace et de vos priorités cliniques.',
            'icon' => 'analysis',
        ],
        [
            'title' => 'Proposition et devis',
            'description' => 'Sélection rigoureuse des équipements adaptés et chiffrage transparent poste par poste sous 48h.',
            'icon' => 'quote',
        ],
        [
            'title' => 'Approvisionnement et livraison',
            'description' => 'Acheminement sécurisé, contrôle qualité systématique à réception et livraison directe dans votre établissement.',
            'icon' => 'delivery',
        ],
        [
            'title' => 'Suivi et support',
            'description' => 'Assistance dédiée pour la prise en main, réassort de consommables et maintenance préventive.',
            'icon' => 'support',
        ],
    ];

    $catalogueUrl = route('home').'#catalogue';
    $devisUrl = route('home').'#devis';
@endphp

<section class="border-y border-[#e4e7ec] bg-white py-14 sm:py-16 lg:py-20" aria-labelledby="about-process-heading">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        {{-- En-tête sobre : typographie stricte Instrument Sans, palette DESIGN.md --}}
        <div class="flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
            <div class="max-w-2xl text-left">
                <p class="text-xs font-bold uppercase tracking-widest text-[#029e55]">
                    Méthode d'intervention
                </p>
                <h2 id="about-process-heading" class="mt-2 text-2xl font-extrabold tracking-tight text-[#1d2939] sm:text-3xl lg:text-[2rem] lg:leading-tight">
                    Comment nous accompagnons votre projet
                </h2>
                <p class="mt-3 text-sm leading-relaxed text-[#667085] sm:text-base">
                    Un protocole rigoureux de la première évaluation technique jusqu'au suivi opérationnel de votre matériel.
                </p>
            </div>

            <div class="flex shrink-0 flex-wrap items-center gap-3">
                <a
                    href="{{ $devisUrl }}"
                    class="inline-flex items-center justify-center rounded-xl bg-[#029e55] px-5 py-3 text-sm font-semibold text-white shadow-sm transition-[transform,background-color] duration-150 ease-out hover:bg-[#028347] active:scale-[0.97]"
                >
                    Demander un devis
                </a>
                <a
                    href="{{ $catalogueUrl }}"
                    class="inline-flex items-center justify-center rounded-xl border border-[#e4e7ec] bg-white px-5 py-3 text-sm font-semibold text-[#1d2939] transition-[transform,border-color,color] duration-150 ease-out hover:border-[#029e55] hover:text-[#029e55] active:scale-[0.97]"
                >
                    Consulter le catalogue
                </a>
            </div>
        </div>

        {{-- Ligne éditoriale continue : pas de cartes flottantes, filets 1px #E4E7EC --}}
        <div class="mt-12 border-t border-[#e4e7ec]">
            <ol class="grid grid-cols-1 lg:grid-cols-4">
                @foreach ($steps as $index => $step)
                    <x-about.process-step
                        :step="$index + 1"
                        :title="$step['title']"
                        :description="$step['description']"
                        :icon="$step['icon']"
                        :index="$index"
                        :is-last="$index === count($steps) - 1"
                    />
                @endforeach
            </ol>
        </div>
    </div>
</section>
