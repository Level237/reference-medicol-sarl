@extends('layouts.public')

@section('title', $product->meta_title ?: $product->name)
@section('meta_description', $product->meta_description ?: ($product->summary ?: 'Fiche technique et demande de cotation pour ' . $product->name . ' — Référence Médico Sarl.'))

@php
    $allImages = $product->images;
    $cover = $product->coverImage;
    $mainImagePath = $cover?->path ?? $product->meta_image;
    $mainImageAlt = $cover?->alt ?: $product->name;
    $effectivePrice = $product->effectivePrice();
    $comparePrice = $product->compareAtPrice();
    $specifications = is_array($product->specifications) ? $product->specifications : [];
@endphp

@section('content')
<div class="bg-white">
    {{-- Fil d'Ariane --}}
    <div class="border-b border-[#e4e7ec] bg-[#f8fafc]/60 py-3.5">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <nav aria-label="Fil d'Ariane" class="flex flex-wrap items-center gap-2 text-xs text-[#667085]">
                <a href="{{ route('home') }}" class="hover:text-[#029e55] transition-colors">Accueil</a>
                <span class="text-[#98a2b3]" aria-hidden="true">/</span>
                <a href="{{ route('catalogue') }}" class="hover:text-[#029e55] transition-colors">Catalogue</a>
                @if($product->category)
                    <span class="text-[#98a2b3]" aria-hidden="true">/</span>
                    <a href="{{ route('catalogue', ['category' => $product->category->slug]) }}" class="hover:text-[#029e55] transition-colors">
                        {{ $product->category->name }}
                    </a>
                @endif
                <span class="text-[#98a2b3]" aria-hidden="true">/</span>
                <span class="truncate font-medium text-[#1d2939]" aria-current="page">{{ $product->name }}</span>
            </nav>
        </div>
    </div>

    {{-- Notification flash ajout panier --}}
    @if(session('cart_success'))
        <div class="border-b border-[#029e55]/20 bg-[#029e55]/10 px-4 py-3">
            <div class="mx-auto flex max-w-7xl items-center justify-between gap-4 px-4 sm:px-6 lg:px-8">
                <div class="flex items-center gap-2 text-sm font-medium text-[#029e55]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                    </svg>
                    <span>{{ session('cart_success') }}</span>
                </div>
                <a href="{{ route('quotes.create') }}" class="text-xs font-semibold text-[#029e55] underline hover:text-[#028347]">
                    Finaliser mon devis &rarr;
                </a>
            </div>
        </div>
    @endif

    {{-- Section Principale : Galerie & Achat B2B --}}
    <section class="py-8 sm:py-12 lg:py-16" aria-labelledby="product-title">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-8 lg:grid-cols-12 lg:gap-12">
                {{-- Colonne GAUCHE : Galerie Visuelle (lg:col-span-7) --}}
                <div class="lg:col-span-7">
                    <div class="sticky top-28 flex flex-col gap-4">
                        {{-- Vue Principale --}}
                        <div class="relative flex min-h-[380px] sm:min-h-[460px] items-center justify-center overflow-hidden rounded-2xl border border-[#e4e7ec] bg-[#f8fafc] p-6 lg:p-10">
                            {{-- Badge Statut --}}
                            <div class="absolute left-4 top-4 z-10 flex flex-col gap-1.5">
                                @if($product->promo_price && $product->price && $product->promo_price < $product->price)
                                    <span class="rounded-md bg-[#edbb45] px-2.5 py-1 text-xs font-bold text-[#1d2939] shadow-xs">
                                        OFFRE SPÉCIALE
                                    </span>
                                @endif
                                @if($product->quantity !== null && $product->quantity > 0)
                                    <span class="rounded-md bg-[#029e55]/15 px-2.5 py-1 text-xs font-semibold text-[#029e55]">
                                        Disponible en stock
                                    </span>
                                @endif
                            </div>

                            @if($mainImagePath)
                                <img
                                    id="main-product-image"
                                    src="{{ asset('storage/' . $mainImagePath) }}"
                                    alt="{{ $mainImageAlt }}"
                                    class="max-h-[360px] sm:max-h-[420px] w-auto max-w-full object-contain transition-transform duration-200 ease-out hover:scale-105"
                                >
                            @else
                                <div class="flex flex-col items-center justify-center p-8 text-center">
                                    <div class="flex h-20 w-20 items-center justify-center rounded-2xl bg-white text-[#029e55] shadow-xs ring-1 ring-[#e4e7ec]">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                                        </svg>
                                    </div>
                                    <p class="mt-3 text-xs font-semibold text-[#1d2939]">Équipement biomédical certifié</p>
                                    <p class="text-[11px] text-[#98a2b3]">Visuel contractuel disponible sur devis</p>
                                </div>
                            @endif
                        </div>

                        {{-- Miniatures (si images multiples) --}}
                        @if($allImages->count() > 1)
                            <div class="flex items-center gap-3 overflow-x-auto pb-2">
                                @foreach($allImages as $index => $img)
                                    <button
                                        type="button"
                                        onclick="changeMainImage('{{ asset('storage/' . $img->path) }}', '{{ addslashes($img->alt ?: $product->name) }}', this)"
                                        class="thumbnail-btn relative flex h-20 w-20 shrink-0 items-center justify-center overflow-hidden rounded-xl border border-[#e4e7ec] bg-[#f8fafc] p-2 transition-all duration-150 hover:border-[#029e55] {{ $index === 0 ? 'ring-2 ring-[#029e55] border-transparent' : '' }}"
                                        aria-label="Afficher vue {{ $index + 1 }}"
                                    >
                                        <img
                                            src="{{ asset('storage/' . $img->path) }}"
                                            alt="{{ $img->alt ?: $product->name }}"
                                            class="h-full w-full object-contain"
                                            loading="lazy"
                                        >
                                    </button>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Colonne DROITE : Informations & Commande Devis B2B (lg:col-span-5) --}}
                <div class="flex flex-col lg:col-span-5">
                    {{-- Catégorie & Référence --}}
                    <div class="flex flex-wrap items-center justify-between gap-2">
                        @if($product->category)
                            <span class="text-xs font-bold uppercase tracking-wider text-[#029e55]">
                                {{ $product->category->name }}
                            </span>
                        @endif

                        @if($product->reference)
                            <span class="font-mono text-xs font-medium text-[#98a2b3]">
                                REF: {{ $product->reference }}
                            </span>
                        @endif
                    </div>

                    {{-- Titre Produit --}}
                    <h1 id="product-title" class="mt-2 text-2xl font-extrabold tracking-tight text-[#1d2939] sm:text-3xl lg:text-[2rem] lg:leading-snug">
                        {{ $product->name }}
                    </h1>

                    {{-- Résumé court --}}
                    @if($product->summary)
                        <p class="mt-3 text-sm leading-relaxed text-[#667085]">
                            {{ $product->summary }}
                        </p>
                    @endif

                    {{-- Encadré Tarif / Cotation B2B --}}
                    <div class="mt-6 rounded-2xl border border-[#e4e7ec] bg-[#f8fafc] p-5">
                        <div class="flex items-baseline justify-between">
                            <span class="text-xs font-semibold uppercase tracking-wider text-[#667085]">
                                Tarification
                            </span>
                            <span class="text-xs {{ ($product->quantity !== null && $product->quantity > 0) ? 'text-[#029e55] font-semibold' : 'text-[#667085]' }}">
                                {{ ($product->quantity !== null && $product->quantity > 0) ? 'En stock à Douala' : 'Disponible sur commande' }}
                            </span>
                        </div>

                        <div class="mt-2 flex items-baseline gap-3">
                            @if($effectivePrice)
                                <span class="text-2xl font-extrabold text-[#1d2939] sm:text-3xl">
                                    {{ number_format((float) $effectivePrice, 0, ',', ' ') }}
                                    <span class="text-sm font-bold text-[#667085]">FCFA</span>
                                </span>
                                @if($comparePrice)
                                    <span class="text-sm text-[#98a2b3] line-through">
                                        {{ number_format((float) $comparePrice, 0, ',', ' ') }} FCFA
                                    </span>
                                @endif
                                <span class="text-xs text-[#98a2b3]">HT</span>
                            @else
                                <span class="text-xl font-bold text-[#1d2939]">
                                    Tarif sur cotation
                                </span>
                                <span class="text-xs text-[#98a2b3]">(Selon quantité & options)</span>
                            @endif
                        </div>

                        {{-- Formulaire Ajout au Devis / Panier Opérationnel --}}
                        <form action="{{ route('cart.store') }}" method="POST" id="add-to-cart-form" class="mt-5 flex flex-col gap-3">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">

                            <div class="flex items-center gap-3">
                                {{-- Sélecteur de quantité tactile --}}
                                <div class="flex h-12 w-32 items-center justify-between rounded-xl border border-[#e4e7ec] bg-white px-2 shadow-xs">
                                    <button
                                        type="button"
                                        onclick="decrementQuantity()"
                                        class="flex h-8 w-8 items-center justify-center rounded-lg text-lg font-bold text-[#667085] transition-colors hover:bg-[#f2f4f7] active:scale-[0.95]"
                                        aria-label="Diminuer la quantité"
                                    >
                                        &minus;
                                    </button>
                                    <input
                                        type="number"
                                        name="quantity"
                                        id="quantity-input"
                                        value="1"
                                        min="1"
                                        max="999"
                                        class="w-12 border-0 p-0 text-center text-sm font-bold text-[#1d2939] focus:outline-none focus:ring-0"
                                    >
                                    <button
                                        type="button"
                                        onclick="incrementQuantity()"
                                        class="flex h-8 w-8 items-center justify-center rounded-lg text-lg font-bold text-[#667085] transition-colors hover:bg-[#f2f4f7] active:scale-[0.95]"
                                        aria-label="Augmenter la quantité"
                                    >
                                        +
                                    </button>
                                </div>

                                {{-- Bouton Principal d'action : Ajouter au devis --}}
                                <button
                                    type="submit"
                                    id="submit-cart-btn"
                                    class="inline-flex h-12 flex-1 items-center justify-center gap-2 rounded-xl bg-[#029e55] px-6 text-sm font-semibold text-white shadow-sm transition-[transform,background-color] duration-150 ease-out hover:bg-[#028347] active:scale-[0.97]"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                    </svg>
                                    <span>Ajouter au devis</span>
                                </button>
                            </div>

                            {{-- Bouton secondaire : Demande de contact rapide --}}
                            <a
                                href="{{ route('quotes.create') }}"
                                class="inline-flex h-11 w-full items-center justify-center rounded-xl border border-[#e4e7ec] bg-white px-4 text-xs font-semibold text-[#1d2939] transition-[transform,border-color,color] duration-150 ease-out hover:border-[#029e55] hover:text-[#029e55] active:scale-[0.97]"
                            >
                                Demander un chiffrage personnalisé immédiat
                            </a>
                        </form>
                    </div>

                    {{-- Réassurance B2B Médicale --}}
                    <div class="mt-6 border-t border-[#e4e7ec] pt-6">
                        <ul class="space-y-3.5 text-xs text-[#667085]">
                            <li class="flex items-start gap-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0 text-[#029e55] mt-0.5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M16.403 12.652a3 3 0 000-5.304 3 3 0 00-3.75-3.751 3 3 0 00-5.305 0 3 3 0 00-3.751 3.75 3 3 0 000 5.305 3 3 0 003.75 3.751 3 3 0 005.305 0 3 3 0 003.751-3.75zm-2.546-4.46a.75.75 0 00-1.214-.883l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                                </svg>
                                <span><strong class="text-[#1d2939]">Matériel garanti & certifié</strong> selon les normes hospitalières internationales.</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0 text-[#029e55] mt-0.5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M11.986 6.002a2.25 2.25 0 012.25 2.25v7.5a2.25 2.25 0 01-2.25 2.25H4.25A2.25 2.25 0 012 15.752v-7.5a2.25 2.25 0 012.25-2.25h7.736zm7.25 3.75a.75.75 0 00-.736-.75h-3.25a.75.75 0 00-.75.75v6a.75.75 0 00.75.75h3.25a.75.75 0 00.736-.75l.001-6z" clip-rule="evenodd" />
                                </svg>
                                <span><strong class="text-[#1d2939]">Livraison & acheminement</strong> directs dans votre établissement ou clinique.</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0 text-[#029e55] mt-0.5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 2a8 8 0 100 16 8 8 0 000-16zm.75 11.25a.75.75 0 01-1.5 0V9a.75.75 0 011.5 0v4.25zm0-6.75a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" clip-rule="evenodd" />
                                </svg>
                                <span><strong class="text-[#1d2939]">Support & réassort</strong> assurés par notre équipe basée à Douala.</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Section DÉTAILS : Spécifications techniques & Description --}}
    <section class="border-t border-[#e4e7ec] bg-[#f8fafc]/50 py-12 sm:py-16" aria-labelledby="details-heading">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <h2 id="details-heading" class="text-xl font-extrabold tracking-tight text-[#1d2939] sm:text-2xl">
                Détails & Spécifications techniques
            </h2>

            <div class="mt-8 grid grid-cols-1 gap-8 lg:grid-cols-12 lg:gap-12">
                {{-- Description clinique complète (7 cols) --}}
                <div class="lg:col-span-7">
                    <div class="rounded-2xl border border-[#e4e7ec] bg-white p-6 sm:p-8">
                        <h3 class="text-base font-bold text-[#1d2939]">
                            Description de l'équipement
                        </h3>

                        <div class="prose prose-sm mt-4 text-sm leading-relaxed text-[#667085]">
                            @if($product->description)
                                {!! nl2br(e($product->description)) !!}
                            @else
                                <p>
                                    Cet équipement a été rigoureusement sélectionné par Référence Médico Sarl pour répondre aux exigences quotidiennes des praticiens, cliniques et plateaux techniques hospitaliers.
                                </p>
                                <p class="mt-3">
                                    Fabriqué selon les normes de précision biomédicales, il garantit fiabilité diagnostique, facilité d'entretien et disponibilité continue des consommables associés.
                                </p>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Tableau des spécifications (5 cols) --}}
                <div class="lg:col-span-5">
                    <div class="rounded-2xl border border-[#e4e7ec] bg-white p-6 sm:p-8">
                        <h3 class="text-base font-bold text-[#1d2939]">
                            Fiche technique
                        </h3>

                        <dl class="mt-4 divide-y divide-[#e4e7ec] border-t border-[#e4e7ec] text-xs">
                            @if($product->reference)
                                <div class="flex justify-between py-2.5">
                                    <dt class="font-medium text-[#667085]">Référence</dt>
                                    <dd class="font-bold text-[#1d2939]">{{ $product->reference }}</dd>
                                </div>
                            @endif
                            @if($product->category)
                                <div class="flex justify-between py-2.5">
                                    <dt class="font-medium text-[#667085]">Catégorie</dt>
                                    <dd class="font-semibold text-[#1d2939]">{{ $product->category->name }}</dd>
                                </div>
                            @endif
                            <div class="flex justify-between py-2.5">
                                <dt class="font-medium text-[#667085]">Usage prévu</dt>
                                <dd class="font-semibold text-[#1d2939]">Professionnel de santé</dd>
                            </div>

                            {{-- Spécifications personnalisées JSON --}}
                            @forelse($specifications as $key => $val)
                                <div class="flex justify-between py-2.5">
                                    <dt class="font-medium text-[#667085]">{{ is_string($key) ? $key : 'Caractéristique' }}</dt>
                                    <dd class="font-semibold text-[#1d2939] text-right">{{ is_array($val) ? implode(', ', $val) : $val }}</dd>
                                </div>
                            @empty
                                <div class="flex justify-between py-2.5">
                                    <dt class="font-medium text-[#667085]">Conformité</dt>
                                    <dd class="font-semibold text-[#1d2939]">Normes médicales CE / ISO</dd>
                                </div>
                                <div class="flex justify-between py-2.5">
                                    <dt class="font-medium text-[#667085]">Disponibilité pièces</dt>
                                    <dd class="font-semibold text-[#029e55]">Pièces d'origine garanties</dd>
                                </div>
                            @endforelse
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Produits Complémentaires & Similaires --}}
    @if($relatedProducts->count() > 0)
        <section class="border-t border-[#e4e7ec] bg-white py-12 sm:py-16" aria-labelledby="related-heading">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex items-end justify-between">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-widest text-[#029e55]">
                            Gamme complémentaire
                        </p>
                        <h2 id="related-heading" class="mt-2 text-xl font-extrabold tracking-tight text-[#1d2939] sm:text-2xl">
                            Équipements de la même catégorie
                        </h2>
                    </div>

                    <a href="{{ route('catalogue') }}" class="hidden text-xs font-bold text-[#029e55] hover:text-[#028347] sm:block">
                        Voir tout le catalogue &rarr;
                    </a>
                </div>

                <div class="mt-8 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach($relatedProducts as $related)
                        <x-products.card :product="$related" />
                    @endforeach
                </div>
            </div>
        </section>
    @endif
</div>

{{-- Script Galerie & Gestion Panier AJAX --}}
<script>
    function changeMainImage(src, alt, btn) {
        const mainImg = document.getElementById('main-product-image');
        if (mainImg) {
            mainImg.src = src;
            mainImg.alt = alt;
        }

        document.querySelectorAll('.thumbnail-btn').forEach(b => {
            b.classList.remove('ring-2', 'ring-[#029e55]', 'border-transparent');
            b.classList.add('border-[#e4e7ec]');
        });

        if (btn) {
            btn.classList.remove('border-[#e4e7ec]');
            btn.classList.add('ring-2', 'ring-[#029e55]', 'border-transparent');
        }
    }

    function incrementQuantity() {
        const input = document.getElementById('quantity-input');
        if (input) {
            input.value = Math.min(999, (parseInt(input.value) || 1) + 1);
        }
    }

    function decrementQuantity() {
        const input = document.getElementById('quantity-input');
        if (input) {
            input.value = Math.max(1, (parseInt(input.value) || 1) - 1);
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('add-to-cart-form');
        const submitBtn = document.getElementById('submit-cart-btn');
        const badge = document.getElementById('cart-counter-badge');

        if (form && submitBtn) {
            form.addEventListener('submit', function (e) {
                // Support AJAX sans rechargement brusque
                e.preventDefault();

                const originalHtml = submitBtn.innerHTML;
                submitBtn.disabled = true;
                submitBtn.innerHTML = `
                    <svg class="h-4 w-4 animate-spin text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                    </svg>
                    <span>Ajout...</span>
                `;

                const formData = new FormData(form);

                fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                    },
                    body: formData,
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        submitBtn.innerHTML = `
                            <svg class="h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                            </svg>
                            <span>Ajouté au devis !</span>
                        `;
                        submitBtn.classList.remove('bg-[#029e55]', 'hover:bg-[#028347]');
                        submitBtn.classList.add('bg-[#028347]');

                        // Mise à jour badge compteur du header
                        if (badge) {
                            badge.textContent = data.count;
                            badge.classList.remove('hidden');
                        }

                        setTimeout(() => {
                            submitBtn.disabled = false;
                            submitBtn.innerHTML = originalHtml;
                            submitBtn.classList.remove('bg-[#028347]');
                            submitBtn.classList.add('bg-[#029e55]', 'hover:bg-[#028347]');
                        }, 2200);
                    }
                })
                .catch(() => {
                    // Fallback en soumission standard si le réseau / AJAX échoue
                    form.submit();
                });
            });
        }
    });
</script>
@endsection
