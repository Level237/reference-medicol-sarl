@php
    $steps = [
        [
            'number' => 1,
            'title' => 'Vous décrivez le besoin',
            'description' => 'Catalogue, panier de devis ou message via le formulaire de contact.',
        ],
        [
            'number' => 2,
            'title' => 'Nous étudions et proposons',
            'description' => 'Sélection des équipements et chiffrage transmis par l\'équipe.',
        ],
        [
            'number' => 3,
            'title' => 'Livraison et suivi',
            'description' => 'Acheminement vers votre site et accompagnement après réception.',
        ],
    ];
@endphp

<section class="bg-white py-14 sm:py-16 lg:py-20" aria-labelledby="services-steps-heading">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <header class="max-w-2xl">
            <p class="text-xs font-bold uppercase tracking-widest text-[#029e55]">En pratique</p>
            <h2 id="services-steps-heading" class="mt-2 text-2xl font-extrabold tracking-tight text-[#1d2939] sm:text-3xl">
                Trois étapes pour avancer sereinement
            </h2>
            <p class="mt-3 text-sm leading-relaxed text-[#667085] sm:text-base">
                De votre première prise de contact jusqu'au suivi après livraison.
            </p>
        </header>

        <ol class="mt-10 grid grid-cols-1 gap-8 lg:mt-12 lg:grid-cols-3 lg:gap-10">
            @foreach ($steps as $step)
                <li class="relative flex gap-4 lg:flex-col lg:gap-0">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-[#029e55] text-sm font-bold text-white lg:mb-4">
                        {{ $step['number'] }}
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-[#1d2939] sm:text-lg">{{ $step['title'] }}</h3>
                        <p class="mt-2 text-sm leading-relaxed text-[#667085]">{{ $step['description'] }}</p>
                    </div>
                </li>
            @endforeach
        </ol>
    </div>
</section>
