@php
    $contactUrl = Route::has('contact') ? route('contact') : route('home').'#contact';
@endphp

<section class="relative isolate overflow-hidden bg-[#0f172a]" aria-labelledby="about-cta-heading">
    <div
        class="absolute inset-0 bg-cover bg-center bg-no-repeat"
        style="background-image: url('{{ asset('assets/images/about/hopital.jpg') }}');"
        aria-hidden="true"
    ></div>
    <div class="absolute inset-0 bg-[#0f172a]/70" aria-hidden="true"></div>

    <div class="relative mx-auto max-w-2xl px-4 py-14 text-center sm:px-6 sm:py-16">
        <h2 id="about-cta-heading" class="text-3xl font-extrabold tracking-tight text-white sm:text-4xl">
            Parlons de votre projet
        </h2>
        <p class="mx-auto mt-3 max-w-xl text-base leading-relaxed text-white/85">
            Notre équipe est à votre disposition pour vous conseiller et vous accompagner.
        </p>
        <a
            href="{{ $contactUrl }}"
            class="mt-6 inline-flex items-center justify-center rounded-xl bg-[#029e55] px-6 py-3.5 text-sm font-semibold text-white transition-[transform,background-color,color] duration-300 ease-[cubic-bezier(0.16,1,0.3,1)] hover:bg-white hover:text-[#029e55] active:scale-[0.98]"
        >
            Contactez-nous
        </a>
    </div>
</section>
