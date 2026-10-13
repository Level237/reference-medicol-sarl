@extends('layouts.public')

@section('title', 'Matériel médical et équipements hospitaliers à Douala')
@section('meta_description', "Partenaire B2B pour l'équipement, l'approvisionnement et la maintenance de plateaux techniques à Douala et dans toute la zone CEMAC. Référence Médico Sarl.")
@section('og_image', asset('assets/images/banner6.jpeg'))
@section('og_image_alt', 'Équipement hospitalier proposé par Référence Médico Sarl à Douala')
@section('og_image_width', '1034')
@section('og_image_height', '634')

@section('content')
    {{-- 1. Hero : même structure que catalogue, sans fil d'ariane catalogue --}}
    <x-home.hero
        :categories="$categories"
        breadcrumb=""
        :searchAction="route('catalogue')"
        :showCategorySelect="false"
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
