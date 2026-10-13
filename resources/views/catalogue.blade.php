@extends('layouts.public')

@section('title', 'Catalogue — Matériel et équipements médicaux')
@section('meta_description', "Explorez l'ensemble de nos équipements médicaux, consommables et appareils hospitaliers disponibles à Douala et en zone CEMAC. Référence Médico Sarl.")

@section('content')
    {{-- Section Hero Catalogue --}}
    <x-home.hero
        :categories="$categories"
        :selectedCategory="$selectedCategory"
        breadcrumb="Catalogue"
    />

    {{-- Section Produits & Filtres --}}
    <section id="catalogue" class="border-t border-[#e4e7ec] bg-[#f8fafc]/50 py-10 sm:py-14">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-8 lg:grid-cols-4 lg:gap-8">
                {{-- Sidebar Filtres à gauche (Desktop lg+) --}}
                <aside class="hidden lg:block lg:col-span-1">
                    <x-products.filter-sidebar
                        :categories="$categories"
                        :brands="$brands"
                        :selectedCategory="$selectedCategory"
                        :selectedBrand="$selectedBrand"
                        :inStock="$inStock"
                        :priceType="$priceType"
                        :priceMin="$priceMin"
                        :priceMax="$priceMax"
                    />
                </aside>

                {{-- Contenu Catalogue à droite : Toolbar, Grille & Pagination --}}
                <div class="lg:col-span-3">
                    <x-products.grid
                        :products="$products"
                        :sort="$sort"
                        :view="$view"
                    />
                </div>
            </div>
        </div>
    </section>

    {{-- Modal Filtres Mobile --}}
    <x-products.filter-mobile-modal
        :categories="$categories"
        :brands="$brands"
        :selectedCategory="$selectedCategory"
        :selectedBrand="$selectedBrand"
        :inStock="$inStock"
        :priceType="$priceType"
        :priceMin="$priceMin"
        :priceMax="$priceMax"
        :products="$products"
    />
@endsection
