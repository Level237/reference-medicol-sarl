@props(['categories' => []])

@if(!empty($categories) && count($categories) > 0)
    <section class="bg-white py-12 sm:py-16" aria-labelledby="home-categories-heading">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <header class="mx-auto max-w-2xl text-center">
                <p class="text-xs font-bold uppercase tracking-widest text-[#029e55]">Spécialités</p>
                <h2 id="home-categories-heading" class="mt-2 text-2xl font-extrabold tracking-tight text-[#1d2939] sm:text-3xl">
                    Familles d'équipements médicaux
                </h2>
                <p class="mx-auto mt-2 max-w-xl text-sm leading-relaxed text-[#667085]">
                    Accédez aux gammes adaptées à votre plateau. Chaque pastille ouvre le catalogue filtré.
                </p>
            </header>

            <div class="mt-6 flex items-center justify-center gap-2 lg:hidden">
                <button
                    type="button"
                    id="categories-prev"
                    class="inline-flex h-10 w-10 items-center justify-center rounded-full border border-[#e4e7ec] bg-white text-[#1d2939] transition-colors hover:border-[#029e55] hover:text-[#029e55] active:scale-[0.98]"
                    aria-label="Catégories précédentes"
                >
                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M12.79 5.23a.75.75 0 01-.02 1.06L8.832 10l3.938 3.71a.75.75 0 11-1.04 1.08l-4.5-4.25a.75.75 0 010-1.08l4.5-4.25a.75.75 0 011.06.02z" clip-rule="evenodd" />
                    </svg>
                </button>
                <button
                    type="button"
                    id="categories-next"
                    class="inline-flex h-10 w-10 items-center justify-center rounded-full border border-[#e4e7ec] bg-white text-[#1d2939] transition-colors hover:border-[#029e55] hover:text-[#029e55] active:scale-[0.98]"
                    aria-label="Catégories suivantes"
                >
                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>

            <div
                id="home-categories-scroller"
                class="mt-6 flex snap-x snap-mandatory gap-4 overflow-x-auto scroll-smooth pb-2 [-ms-overflow-style:none] [scrollbar-width:none] lg:mt-8 lg:grid lg:grid-cols-6 lg:gap-6 lg:overflow-visible lg:pb-0 [&::-webkit-scrollbar]:hidden"
                tabindex="0"
                aria-label="Familles d'équipements"
            >
                @foreach(collect($categories)->take(6) as $category)
                    @php
                        $imageUrl = $category->image
                            ? \Illuminate\Support\Facades\Storage::disk('public')->url($category->image)
                            : null;
                    @endphp
                    <a
                        href="{{ route('catalogue', ['category' => $category->slug]) }}"
                        class="group w-[42%] shrink-0 snap-center text-center sm:w-[30%] lg:w-auto lg:shrink"
                    >
                        <div class="mx-auto h-24 w-24 overflow-hidden rounded-full border border-[#e4e7ec] bg-white sm:h-28 sm:w-28">
                            @if($imageUrl)
                                <img
                                    src="{{ $imageUrl }}"
                                    alt="{{ $category->image_alt ?: $category->name }}"
                                    class="h-full w-full object-cover transition-transform duration-300 ease-[cubic-bezier(0.16,1,0.3,1)] group-hover:scale-[1.03]"
                                    loading="lazy"
                                >
                            @else
                                <div class="flex h-full w-full items-center justify-center text-[#029e55]/20" aria-hidden="true">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <h3 class="mt-3 text-sm font-bold text-[#1d2939] transition-colors group-hover:text-[#029e55]">
                            {{ $category->name }}
                        </h3>
                        @if(isset($category->products_count))
                            <p class="mt-0.5 text-xs text-[#98a2b3]">
                                {{ $category->products_count }} référence{{ $category->products_count > 1 ? 's' : '' }}
                            </p>
                        @endif
                    </a>
                @endforeach
            </div>

            <div class="mt-10 flex justify-center">
                <a
                    href="{{ route('catalogue') }}"
                    class="inline-flex items-center justify-center rounded-xl bg-[#029e55] px-6 py-3.5 text-sm font-semibold text-white transition-[transform,background-color] duration-300 ease-[cubic-bezier(0.16,1,0.3,1)] hover:bg-[#028347] active:scale-[0.98]"
                >
                    Voir le catalogue
                </a>
            </div>
        </div>
    </section>
@endif
