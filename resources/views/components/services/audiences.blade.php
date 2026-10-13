@php
    $audiences = [
        [
            'title' => 'Cabinets',
            'description' => 'Matériel de consultation et petits équipements du quotidien.',
            'icon' => 'stethoscope',
            'image' => 'assets/images/about/cabinet.jpg',
        ],
        [
            'title' => 'Cliniques',
            'description' => 'Équipements adaptés aux parcours de soins et à la montée en charge.',
            'icon' => 'clinic',
            'image' => 'assets/images/about/clinique.jpg',
        ],
        [
            'title' => 'Hôpitaux',
            'description' => 'Plateaux techniques, imagerie et réassort pour environnements exigeants.',
            'icon' => 'hospital',
            'image' => 'assets/images/about/hopital.jpg',
        ],
        [
            'title' => 'Laboratoires',
            'description' => 'Analyseurs, consommables et accompagnement pour l’activité de labo.',
            'icon' => 'laboratory',
            'image' => 'assets/images/about/laboratoire.jpg',
        ],
    ];
@endphp

<section class="border-y border-[#e4e7ec] bg-white py-14 sm:py-16 lg:py-20" aria-labelledby="services-audiences-heading">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <header class="max-w-3xl text-left">
            <h2 id="services-audiences-heading" class="text-2xl font-extrabold tracking-tight text-[#1d2939] sm:text-3xl lg:text-[2rem] lg:leading-tight">
                Pour qui intervenons-nous ?
            </h2>
            <p class="mt-3 max-w-2xl text-sm leading-relaxed text-[#667085] sm:mt-4 sm:text-base">
                Le même niveau d'écoute, avec des réponses adaptées à la taille et au rôle de votre structure.
            </p>
        </header>

        <div class="mt-10 grid grid-cols-1 gap-8 sm:grid-cols-2 sm:gap-6 lg:mt-12 lg:grid-cols-4 lg:gap-6">
            @foreach ($audiences as $index => $audience)
                <x-about.sector-card
                    :title="$audience['title']"
                    :description="$audience['description']"
                    :icon="$audience['icon']"
                    :image="$audience['image']"
                    :index="$index"
                />
            @endforeach
        </div>
    </div>
</section>
