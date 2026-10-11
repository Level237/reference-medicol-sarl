@php
    $sectors = [
        [
            'title' => 'Cabinets',
            'description' => 'Équipement pour la pratique quotidienne',
            'icon' => 'stethoscope',
            'image' => 'assets/images/about/cabinet.jpg',
        ],
        [
            'title' => 'Cliniques',
            'description' => 'Solutions adaptées à vos besoins',
            'icon' => 'clinic',
            'image' => 'assets/images/about/clinique.jpg',
        ],
        [
            'title' => 'Hôpitaux',
            'description' => 'Des équipements pour des environnements exigeants',
            'icon' => 'hospital',
            'image' => 'assets/images/about/hopital.jpg',
        ],
        [
            'title' => 'Laboratoires',
            'description' => 'Matériel pour l\'analyse et la recherche',
            'icon' => 'laboratory',
            'image' => 'assets/images/about/laboratoire.jpg',
        ],
    ];
@endphp

<section class="bg-white py-14 sm:py-16 lg:py-20" aria-labelledby="about-sectors-heading">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <header class="max-w-3xl text-left">
            <h2 id="about-sectors-heading" class="text-2xl font-extrabold tracking-tight text-[#1d2939] sm:text-3xl lg:text-[2rem] lg:leading-tight">
                Au service des professionnels de santé
            </h2>
            <p class="mt-3 max-w-2xl text-sm leading-relaxed text-[#667085] sm:mt-4 sm:text-base">
                Nous proposons une large gamme d'équipements et de consommables médicaux pour répondre aux besoins des différents acteurs de la santé
            </p>
        </header>

        <div class="mt-10 grid grid-cols-1 gap-8 sm:grid-cols-2 sm:gap-6 lg:mt-12 lg:grid-cols-4 lg:gap-6">
            @foreach ($sectors as $index => $sector)
                <x-about.sector-card
                    :title="$sector['title']"
                    :description="$sector['description']"
                    :icon="$sector['icon']"
                    :image="$sector['image']"
                    :index="$index"
                />
            @endforeach
        </div>
    </div>
</section>
