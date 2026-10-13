@props(['products' => []])

@if(!empty($products) && count($products) > 0)
    <section class="bg-white py-12 sm:py-16" aria-labelledby="home-featured-heading">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                <header class="max-w-2xl">
                    <p class="text-xs font-bold uppercase tracking-widest text-[#029e55]">Sélection</p>
                    <h2 id="home-featured-heading" class="mt-2 text-2xl font-extrabold tracking-tight text-[#1d2939] sm:text-3xl">
                        Équipements les plus demandés
                    </h2>
                    <p class="mt-2 text-sm leading-relaxed text-[#667085]">
                        Six références régulièrement demandées par les établissements partenaires. Le catalogue complet reste à un clic.
                    </p>
                </header>

                <a
                    href="{{ route('catalogue') }}"
                    class="inline-flex items-center gap-1.5 text-sm font-semibold text-[#029e55] transition-colors hover:text-[#1d2939]"
                >
                    Voir le catalogue
                </a>
            </div>

            <div class="mt-8 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                @foreach($products as $product)
                    <x-products.card :product="$product" view="grid" />
                @endforeach
            </div>
        </div>
    </section>
@endif
