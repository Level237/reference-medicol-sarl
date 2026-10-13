@extends('layouts.public')

@section('title', 'Catégories')
@section('meta_description', 'Toutes les familles d\'équipements médicaux proposées par Référence Médico Sarl à Douala et dans la zone CEMAC.')
@section('canonical', route('categories.index'))
@section('og_image', asset('assets/images/about/cabinet.jpg'))

@section('content')
    <x-categories.hero />

    <section class="bg-white py-12 sm:py-16" aria-labelledby="categories-list-heading">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <h2 id="categories-list-heading" class="sr-only">Liste des catégories</h2>

            @if($categories->isEmpty())
                <div class="mx-auto max-w-lg rounded-2xl border border-[#e4e7ec] bg-[#f8fafc] px-6 py-12 text-center">
                    <p class="text-base font-semibold text-[#1d2939]">Aucune catégorie publiée pour le moment.</p>
                    <a
                        href="{{ route('catalogue') }}"
                        class="mt-6 inline-flex items-center justify-center rounded-xl bg-[#029e55] px-6 py-3.5 text-sm font-semibold text-white transition-[transform,background-color] duration-300 ease-[cubic-bezier(0.16,1,0.3,1)] hover:bg-[#028347] active:scale-[0.98]"
                    >
                        Voir le catalogue
                    </a>
                </div>
            @else
                <ul class="grid grid-cols-2 gap-x-4 gap-y-8 sm:grid-cols-3 sm:gap-x-6 lg:grid-cols-4 xl:grid-cols-6">
                    @foreach($categories as $category)
                        @php
                            $imageUrl = $category->image
                                ? \Illuminate\Support\Facades\Storage::disk('public')->url($category->image)
                                : null;
                        @endphp
                        <li>
                            <a
                                href="{{ route('catalogue', ['category' => $category->slug]) }}"
                                class="group block text-center"
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
                                <p class="mt-0.5 text-xs text-[#98a2b3]">
                                    {{ $category->products_count }} référence{{ $category->products_count > 1 ? 's' : '' }}
                                </p>
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </section>
@endsection
