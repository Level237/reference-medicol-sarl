@extends('layouts.public')

@section('title', 'Tout le matériel pour vos soins')
@section('meta_description', "Des équipements fiables pour les professionnels de santé à Douala et dans toute l'Afrique centrale. Référence Médico Sarl.")

@section('content')
    {{-- 1. Section Hero (Composant dédié) --}}
    <x-home.hero
        :categories="$categories"
        :selectedCategory="$selectedCategory"
    />

    {{-- 2. Section Produits & Filtres (Composants dédiés) --}}
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

    {{-- Modal Filtres Mobile (Bottom Sheet glissant du bas vers le haut) --}}
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
