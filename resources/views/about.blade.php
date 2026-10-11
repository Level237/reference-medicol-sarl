@extends('layouts.public')

@section('title', 'À propos')
@section('meta_description', 'Référence Médico Sarl — votre partenaire en matériel médical à Douala et en Afrique centrale.')

@section('content')
    <x-about.hero />
    <x-about.values />
    <x-about.sectors />
    <x-about.process />
    <x-about.cta-contact />
@endsection
