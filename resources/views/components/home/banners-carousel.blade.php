@props(['banners' => []])

@php
    $bannerSlides = collect($banners)->values();
    $visibleSlides = $bannerSlides->take(3);
    $bannerPayload = $bannerSlides->map(fn ($banner) => [
        'src' => asset($banner['src']),
        'title' => $banner['title'],
        'href' => $banner['href'],
    ])->all();
@endphp

@if($bannerSlides->isNotEmpty())
    <section
        class="border-y border-[#e4e7ec] bg-white py-12 sm:py-16"
        aria-labelledby="banners-carousel-heading"
        id="home-banners-section"
        data-banners='@json($bannerPayload)'
    >
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                <header class="max-w-2xl">
                    <p class="text-xs font-bold uppercase tracking-widest text-[#029e55]">En ce moment</p>
                    <h2 id="banners-carousel-heading" class="mt-2 text-2xl font-extrabold tracking-tight text-[#1d2939] sm:text-3xl">
                        Actualités & engagements terrain
                    </h2>
                    <p class="mt-2 text-sm leading-relaxed text-[#667085]">
                        La grande affiche défile. Les deux autres restent visibles, l'une au-dessus de l'autre.
                    </p>
                </header>

                <div class="flex items-center gap-2">
                    <button
                        type="button"
                        id="banner-prev-btn"
                        class="inline-flex h-10 w-10 items-center justify-center rounded-xl border border-[#e4e7ec] bg-white text-[#1d2939] transition-colors hover:border-[#029e55] hover:text-[#029e55] active:scale-[0.98]"
                        aria-label="Affiche précédente"
                    >
                        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M12.79 5.23a.75.75 0 01-.02 1.06L8.832 10l3.938 3.71a.75.75 0 11-1.04 1.08l-4.5-4.25a.75.75 0 010-1.08l4.5-4.25a.75.75 0 011.06.02z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <button
                        type="button"
                        id="banner-next-btn"
                        class="inline-flex h-10 w-10 items-center justify-center rounded-xl border border-[#e4e7ec] bg-white text-[#1d2939] transition-colors hover:border-[#029e55] hover:text-[#029e55] active:scale-[0.98]"
                        aria-label="Affiche suivante"
                    >
                        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </div>

            <div class="mt-8 grid grid-cols-1 items-stretch gap-3 lg:grid-cols-[minmax(0,1.7fr)_minmax(0,1fr)] lg:gap-4">
                <a
                    id="banner-feature"
                    href="{{ $visibleSlides[0]['href'] }}"
                    class="group block overflow-hidden rounded-2xl border border-[#e4e7ec] focus:outline-none focus-visible:ring-2 focus-visible:ring-inset focus-visible:ring-[#029e55]"
                >
                    <img
                        src="{{ asset($visibleSlides[0]['src']) }}"
                        alt="{{ $visibleSlides[0]['title'] }}"
                        class="aspect-[1034/634] h-full w-full object-cover transition-opacity duration-300"
                        width="1034"
                        height="634"
                    >
                </a>

                <div class="grid h-auto grid-cols-2 gap-3 lg:h-full lg:grid-cols-1 lg:grid-rows-2 lg:gap-4">
                    @foreach([1, 2] as $slot)
                        @continue(! isset($visibleSlides[$slot]))
                        <a
                            id="{{ $slot === 1 ? 'banner-side-top' : 'banner-side-bottom' }}"
                            href="{{ $visibleSlides[$slot]['href'] }}"
                            class="group relative block min-h-0 overflow-hidden rounded-2xl border border-[#e4e7ec] focus:outline-none focus-visible:ring-2 focus-visible:ring-inset focus-visible:ring-[#029e55]"
                        >
                            <img
                                src="{{ asset($visibleSlides[$slot]['src']) }}"
                                alt="{{ $visibleSlides[$slot]['title'] }}"
                                class="aspect-[1034/634] h-full w-full object-cover transition-opacity duration-300 lg:absolute lg:inset-0 lg:aspect-auto"
                                width="1034"
                                height="634"
                                loading="lazy"
                            >
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endif
