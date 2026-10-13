@extends('layouts.public')

@section('title', 'Référence Médico Sarl — Matériel médical & équipements hospitaliers à Douala')
@section('meta_description', "Partenaire B2B pour l'équipement, l'approvisionnement et la maintenance de plateaux techniques à Douala et dans toute la zone CEMAC. Référence Médico Sarl.")

@section('content')
    {{-- 1. Hero : même structure que catalogue, sans fil d'ariane catalogue --}}
    <x-home.hero
        :categories="$categories"
        breadcrumb=""
        :searchAction="route('catalogue')"
    />

    {{-- 2. Familles d'équipements : 6 tuiles directes vers le catalogue --}}
    <x-home.categories-grid :categories="$featuredCategories" />

    {{-- 3. Carrousel des 3 bannières en ratio natif 1034x634 --}}
    <x-home.banners-carousel :banners="$banners" />

    {{-- 4. Sélection d'équipements prioritaires (max 6 produits, sans filtres) --}}
    <x-home.featured-products :products="$featuredProducts" />

    {{-- 5. Trois gestes d'intervention B2B --}}
    <x-home.steps-strip />

    {{-- 6. Bandeau final centré, 1 seul bouton --}}
    <x-about.cta-contact />
@endsection
