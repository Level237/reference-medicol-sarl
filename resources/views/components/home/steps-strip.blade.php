@php
    $steps = [
        [
            'num' => '01',
            'title' => 'Conseil',
            'desc' => 'Dimensionner le plateau selon vos flux et vos contraintes.',
        ],
        [
            'num' => '02',
            'title' => 'Devis',
            'desc' => 'Chiffrage poste par poste, avec une référence de suivi.',
        ],
        [
            'num' => '03',
            'title' => 'Livraison',
            'desc' => 'Acheminement vers votre site et accompagnement à Douala.',
        ],
    ];
@endphp

<section class="border-t border-[#e4e7ec] bg-white py-12 sm:py-16" aria-labelledby="home-method-heading">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <header class="max-w-2xl">
                <p class="text-xs font-bold uppercase tracking-widest text-[#029e55]">En pratique</p>
                <h2 id="home-method-heading" class="mt-2 text-2xl font-extrabold tracking-tight text-[#1d2939] sm:text-3xl">
                    Trois gestes pour équiper votre établissement
                </h2>
                <p class="mt-2 text-sm leading-relaxed text-[#667085]">
                    Conseil, devis, livraison. Le détail des prestations est sur la page Nos services.
                </p>
            </header>

            <a
                href="{{ route('services') }}"
                class="inline-flex items-center gap-1.5 text-sm font-semibold text-[#029e55] transition-colors hover:text-[#1d2939]"
            >
                Nos services
            </a>
        </div>

        <ol class="mt-8 grid grid-cols-1 divide-y divide-[#e4e7ec] border-y border-[#e4e7ec] md:grid-cols-3 md:divide-x md:divide-y-0">
            @foreach($steps as $step)
                <li class="flex gap-4 py-6 md:px-8 md:py-8 first:md:pl-0 last:md:pr-0">
                    <span class="text-sm font-bold text-[#029e55]">{{ $step['num'] }}</span>
                    <div>
                        <h3 class="text-base font-bold text-[#1d2939]">{{ $step['title'] }}</h3>
                        <p class="mt-1 text-sm leading-relaxed text-[#667085]">{{ $step['desc'] }}</p>
                    </div>
                </li>
            @endforeach
        </ol>
    </div>
</section>
