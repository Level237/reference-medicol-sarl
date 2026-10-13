@extends('layouts.public')

@section('title', 'Nos services')
@section('meta_description', 'Conseil, devis, approvisionnement, livraison et support pour équipements médicaux à Douala et en Afrique centrale. Référence Médico Sarl.')
@section('og_image', asset('assets/images/about/laboratoire.jpg'))

@section('content')
    <x-services.hero />
    <x-services.intro />
    <x-services.offerings />
    <x-services.audiences />
    <x-services.steps />
    <x-services.reassurance />
    <x-about.cta-contact />
@endsection
