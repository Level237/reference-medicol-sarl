@php
    $pillars = [
        [
            'title' => 'Écoute',
            'description' => 'Une équipe à votre écoute pour bien comprendre vos besoins.',
            'icon' => 'team',
        ],
        [
            'title' => 'Accompagnement',
            'description' => 'Des conseils adaptés à chaque projet d\'équipement.',
            'icon' => 'delivery',
        ],
        [
            'title' => 'Qualité de service',
            'description' => 'Un service fiable pour vous soutenir dans la durée.',
            'icon' => 'service',
        ],
    ];
@endphp

<section class="border-b border-[#e4e7ec] bg-white py-12 sm:py-14 lg:py-16" aria-labelledby="about-values-heading">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <h2 id="about-values-heading" class="sr-only">Nos engagements</h2>

        <div class="grid grid-cols-1 gap-8 md:grid-cols-3 md:gap-6 lg:gap-10 xl:gap-14">
            @foreach ($pillars as $index => $pillar)
                <article
                    class="flex items-start gap-3 sm:gap-4"
                    style="animation: about-fade-up 0.55s cubic-bezier(0.16, 1, 0.3, 1) {{ $index * 0.08 }}s both"
                >
                    {{-- Icône à gauche (outline, sans encadré) --}}
                    <div class="shrink-0 pt-0.5 text-[#1d2939]" aria-hidden="true">
                        @if ($pillar['icon'] === 'team')
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-9 w-9 sm:h-10 sm:w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                            </svg>
                        @elseif ($pillar['icon'] === 'delivery')
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-9 w-9 sm:h-10 sm:w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12" />
                            </svg>
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-9 w-9 sm:h-10 sm:w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        @endif
                    </div>

                    {{-- Texte à droite, aligné à gauche --}}
                    <div class="min-w-0 text-left">
                        <h3 class="text-base font-bold leading-snug text-[#1d2939] sm:text-lg">
                            {{ $pillar['title'] }}
                        </h3>
                        <p class="mt-1 text-sm leading-relaxed text-[#667085] sm:text-[15px]">
                            {{ $pillar['description'] }}
                        </p>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>

<style>
    @keyframes about-fade-up {
        from {
            opacity: 0;
            transform: translateY(14px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>
