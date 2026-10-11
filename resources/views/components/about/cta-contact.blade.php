@php
    $ctaCandidates = [
        'assets/images/about/cta.png',
        'assets/images/about/cta.jpg',
    ];
    $ctaImage = null;
    foreach ($ctaCandidates as $path) {
        if (is_file(public_path($path))) {
            $ctaImage = $path;
            break;
        }
    }
    $contactUrl = Route::has('contact') ? route('contact') : route('home').'#contact';
@endphp

<section class="bg-white py-12 sm:py-14 lg:py-16" aria-labelledby="about-cta-heading">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="relative overflow-hidden rounded-2xl border border-[#e4e7ec] bg-[#f8fafc] sm:rounded-3xl">
            <div class="relative grid grid-cols-1 items-center gap-6 p-6 sm:gap-8 sm:p-8 lg:grid-cols-[minmax(0,13rem)_1fr_auto] lg:gap-10 lg:p-0 lg:pr-10 lg:py-8 xl:grid-cols-[minmax(0,15rem)_1fr_auto] xl:pr-12">
                {{-- Visuel : PNG transparent ancré à gauche --}}
                <div class="relative flex min-h-[9rem] items-end justify-center lg:min-h-[10.5rem] lg:justify-start lg:self-stretch">
                    @if ($ctaImage)
                        <img
                            src="{{ asset($ctaImage) }}"
                            alt=""
                            class="max-h-36 w-auto max-w-[85%] object-contain object-bottom sm:max-h-40 lg:absolute lg:inset-y-0 lg:left-0 lg:max-h-none lg:h-full lg:max-w-none lg:w-auto lg:object-contain lg:object-left-bottom lg:pl-2 xl:pl-4"
                            loading="lazy"
                        >
                    @else
                        <div class="h-32 w-full max-w-xs rounded-xl bg-white" aria-hidden="true"></div>
                    @endif
                </div>

                <div class="min-w-0 border-[#e4e7ec] text-center lg:border-l lg:pl-8 lg:text-left xl:pl-10">
                    <h2 id="about-cta-heading" class="text-xl font-extrabold tracking-tight text-[#1d2939] sm:text-2xl lg:text-[1.65rem] lg:leading-snug">
                        Parlons de votre projet
                    </h2>
                    <p class="mx-auto mt-2 max-w-md text-sm leading-relaxed text-[#667085] sm:text-base lg:mx-0 lg:max-w-xl">
                        Notre équipe est à votre disposition pour vous conseiller et vous accompagner.
                    </p>
                </div>

                <div class="flex justify-center lg:justify-end lg:self-center">
                    <a
                        href="{{ $contactUrl }}"
                        class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-[#0f172a] px-6 py-3.5 text-sm font-semibold text-white shadow-sm transition-[transform,background-color] duration-150 ease-out hover:bg-[#1e293b] active:scale-[0.97] sm:w-auto sm:min-w-[200px]"
                    >
                        <span>Contactez-nous</span>
                        <span aria-hidden="true">&rarr;</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
