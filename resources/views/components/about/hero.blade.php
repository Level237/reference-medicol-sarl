{{-- Hero page À propos — titre centré sur image de fond --}}
<section class="relative flex min-h-[320px] items-center justify-center overflow-hidden sm:min-h-[380px] lg:min-h-[440px]">
    {{-- Image de fond --}}
    <div
        class="absolute inset-0 bg-cover bg-center bg-no-repeat scale-105"
        style="background-image: url('{{ asset('assets/images/hero-about.jpg') }}');"
        aria-hidden="true"
    ></div>

    {{-- Voile pour lisibilité du titre centré --}}
    <div
        class="absolute inset-0 bg-gradient-to-b from-[#0f172a]/55 via-[#0f172a]/45 to-[#0f172a]/60"
        aria-hidden="true"
    ></div>

    {{-- Contenu centré --}}
    <div class="relative z-10 mx-auto max-w-4xl px-4 py-16 text-center sm:px-6 lg:px-8">
        <nav aria-label="Fil d'Ariane" class="mb-6 inline-flex items-center justify-center gap-1.5 text-xs font-medium text-white/75">
            <a href="{{ route('home') }}" class="text-white/90 hover:text-white hover:underline transition-colors">Accueil</a>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-white/50" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
            </svg>
            <span class="text-white">À propos</span>
        </nav>

        <h1 class="text-3xl font-extrabold tracking-tight text-white sm:text-4xl md:text-5xl lg:text-[3.25rem] lg:leading-tight">
            Votre Partenaire en matériel médical
        </h1>

        <div class="mx-auto mt-5 h-1 w-16 rounded-full bg-[#029e55]" aria-hidden="true"></div>
    </div>
</section>
