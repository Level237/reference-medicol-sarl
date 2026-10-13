<section class="border-b border-[#e4e7ec] bg-white py-12 sm:py-14 lg:py-16" aria-labelledby="services-intro-heading">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col gap-8 lg:flex-row lg:items-center lg:justify-between lg:gap-12">
            <div class="max-w-2xl">
                <h2 id="services-intro-heading" class="sr-only">Comment démarrer</h2>
                <p class="text-base leading-relaxed text-[#667085] sm:text-lg">
                    Référence Médico Sarl vous aide à choisir, chiffrer et déployer le matériel adapté à votre établissement.
                    Parcourez le catalogue, composez votre demande de devis ou écrivez-nous pour un besoin spécifique.
                </p>
            </div>

            <div class="flex shrink-0 flex-col gap-3 sm:flex-row sm:items-center">
                <a
                    href="{{ route('quotes.create') }}"
                    class="inline-flex items-center justify-center rounded-xl bg-[#0f172a] px-6 py-3.5 text-sm font-semibold text-white transition-[transform,background-color] duration-150 ease-out hover:bg-[#029e55] active:scale-[0.97]"
                >
                    Demander un devis
                </a>
                <a
                    href="{{ route('contact') }}"
                    class="inline-flex items-center justify-center rounded-xl border border-[#e4e7ec] bg-white px-6 py-3.5 text-sm font-semibold text-[#1d2939] transition-[border-color,color] duration-150 ease-out hover:border-[#029e55] hover:text-[#029e55] active:scale-[0.97]"
                >
                    Nous contacter
                </a>
            </div>
        </div>
    </div>
</section>
