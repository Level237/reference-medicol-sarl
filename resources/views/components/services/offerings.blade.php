@php
    $offerings = [
        [
            'title' => 'Conseil & sélection',
            'description' => 'Comprendre votre besoin clinique et technique avant tout achat.',
            'points' => ['Analyse du plateau existant', 'Choix d\'appareils compatibles', 'Orientation vers le catalogue'],
            'href' => route('catalogue'),
            'link' => 'Voir le catalogue',
        ],
        [
            'title' => 'Devis & chiffrage',
            'description' => 'Une proposition structurée à partir de votre sélection ou de votre cahier des charges.',
            'points' => ['Panier de demande en ligne', 'Référence de suivi dédiée', 'Réponse par l\'équipe commerciale'],
            'href' => route('quotes.create'),
            'link' => 'Demander un devis',
        ],
        [
            'title' => 'Approvisionnement',
            'description' => 'Sourcing d\'équipements médicaux pour hôpitaux et cliniques.',
            'points' => ['Références et libellés conservés', 'Commandes groupées possibles', 'Coordination avec votre service achats'],
            'href' => route('contact'),
            'link' => 'Parler à un conseiller',
        ],
        [
            'title' => 'Livraison & mise en service',
            'description' => 'Acheminement vers votre site et coordination à la réception.',
            'points' => ['Livraison à l\'établissement', 'Points de contrôle à réception', 'Prise en main selon le matériel'],
            'href' => route('contact'),
            'link' => 'Organiser une livraison',
        ],
        [
            'title' => 'Support & réassort',
            'description' => 'Une équipe basée à Douala pour vous accompagner dans la durée.',
            'points' => ['Assistance après livraison', 'Réassort de consommables', 'Relance par téléphone ou e-mail'],
            'href' => route('contact'),
            'link' => 'Joindre le support',
        ],
        [
            'title' => 'Suivi de demande',
            'description' => 'Consultez l\'avancement de votre devis avec votre référence, sans compte.',
            'points' => ['Étape reçue, étude ou proposition', 'Liste des équipements concernés', 'Accès public sécurisé par référence'],
            'href' => route('quotes.track'),
            'link' => 'Suivre une demande',
        ],
    ];
@endphp

<section class="bg-white py-14 sm:py-16 lg:py-20" aria-labelledby="services-offerings-heading">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <header class="max-w-3xl">
            <p class="text-xs font-bold uppercase tracking-widest text-[#029e55]">Nos prestations</p>
            <h2 id="services-offerings-heading" class="mt-2 text-2xl font-extrabold tracking-tight text-[#1d2939] sm:text-3xl">
                Des services pensés pour les décideurs de santé
            </h2>
            <p class="mt-3 text-sm leading-relaxed text-[#667085] sm:text-base">
                De la première question au suivi de votre demande, chaque étape reste claire et traçable.
            </p>
        </header>

        <div class="mt-10 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:mt-12 lg:grid-cols-3 lg:gap-8">
            @foreach ($offerings as $offering)
                <article class="flex flex-col rounded-2xl border border-[#e4e7ec] bg-white p-6 shadow-xs transition-[border-color,box-shadow] duration-150 hover:border-[#029e55]/30 hover:shadow-sm">
                    <div class="h-1 w-10 rounded-full bg-[#029e55]" aria-hidden="true"></div>
                    <h3 class="mt-4 text-lg font-bold tracking-tight text-[#1d2939]">{!! $offering['title'] !!}</h3>
                    <p class="mt-2 text-sm leading-relaxed text-[#667085]">{{ $offering['description'] }}</p>
                    <ul class="mt-4 flex-1 space-y-2 text-sm text-[#667085]">
                        @foreach ($offering['points'] as $point)
                            <li class="flex gap-2">
                                <span class="mt-1.5 h-1.5 w-1.5 shrink-0 rounded-full bg-[#029e55]" aria-hidden="true"></span>
                                <span>{{ $point }}</span>
                            </li>
                        @endforeach
                    </ul>
                    <a
                        href="{{ $offering['href'] }}"
                        class="mt-5 inline-flex items-center gap-1 text-sm font-semibold text-[#029e55] transition-colors hover:text-[#028347]"
                    >
                        <span>{{ $offering['link'] }}</span>
                        <span aria-hidden="true">&rarr;</span>
                    </a>
                </article>
            @endforeach
        </div>
    </div>
</section>
