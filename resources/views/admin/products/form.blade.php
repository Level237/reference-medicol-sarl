@extends('admin.layout')

@section('title', $product->exists ? 'Modifier le produit' : 'Nouveau produit')

@section('content')
    @php
        $field = 'w-full rounded-xl border border-[#d0d5dd] bg-white px-3.5 py-2.5 text-sm text-[#101828] shadow-xs outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/15';
        $label = 'mb-1.5 block text-sm font-medium text-[#344054]';
    @endphp

    <div class="space-y-6">
        <!-- En-tête -->
        <section class="flex flex-col gap-3 border-b border-[#eaecf0] pb-6 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <a href="{{ route('admin.products.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-[#667085] transition-colors hover:text-[#101828]">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4">
                        <path fill-rule="evenodd" d="M17 10a.75.75 0 0 1-.75.75H5.612l4.158 3.96a.75.75 0 1 1-1.04 1.08l-5.5-5.25a.75.75 0 0 1 0-1.08l5.5-5.25a.75.75 0 1 1 1.04 1.08L5.612 9.25H16.25A.75.75 0 0 1 17 10Z" clip-rule="evenodd" />
                    </svg>
                    Retour aux produits
                </a>
                <h1 class="mt-2 text-2xl font-bold tracking-tight text-[#101828] sm:text-[28px]">
                    {{ $product->exists ? 'Modifier le produit' : 'Nouveau produit' }}
                </h1>
                <p class="mt-1 text-sm text-[#475467]">
                    {{ $product->exists ? $product->name : 'Renseignez la fiche technique, la galerie photos avec prévisualisation et le tarif indicatif.' }}
                </p>
            </div>

            @if ($product->exists)
                <div class="flex items-center gap-2">
                    <span class="inline-flex items-center rounded-full bg-[#f2f4f7] px-3 py-1 text-xs font-semibold text-[#344054]">
                        Catégorie : {{ $product->category?->name ?? 'Général' }}
                    </span>
                </div>
            @endif
        </section>

        @if ($categories->isEmpty())
            <div class="rounded-2xl border border-[#eaecf0] bg-white px-6 py-14 text-center shadow-xs">
                <div class="flex h-14 w-14 mx-auto items-center justify-center rounded-2xl bg-[#f2f4f7] text-[#667085]">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" class="h-7 w-7">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 0 1 0 3.75H5.625a1.875 1.875 0 0 1 0-3.75Z" />
                    </svg>
                </div>
                <h2 class="mt-3.5 text-base font-semibold text-[#101828]">Aucune catégorie pour le moment</h2>
                <p class="mx-auto mt-1 max-w-md text-xs leading-relaxed text-[#667085]">
                    Un produit doit obligatoirement appartenir à une catégorie médicale. Créez d’abord une catégorie.
                </p>
                <a href="{{ route('admin.categories.create') }}" class="mt-5 inline-flex items-center gap-2 rounded-xl bg-primary px-4 py-2.5 text-xs font-semibold text-white shadow-xs hover:bg-primary-hover">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4">
                        <path d="M10.75 4.75a.75.75 0 0 0-1.5 0v4.5h-4.5a.75.75 0 0 0 0 1.5h4.5v4.5a.75.75 0 0 0 1.5 0v-4.5h4.5a.75.75 0 0 0 0-1.5h-4.5v-4.5Z" />
                    </svg>
                    <span>Créer une catégorie</span>
                </a>
            </div>
        @else
            @if ($errors->any())
                <div role="alert" class="rounded-2xl border border-[#fecdca] bg-[#fef3f2] p-4 text-sm text-[#b42318] shadow-xs">
                    <div class="flex items-center gap-2 font-semibold">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5 shrink-0">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-8-5a.75.75 0 0 1 .75.75v4.5a.75.75 0 0 1-1.5 0v-4.5A.75.75 0 0 1 10 5Zm0 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" />
                        </svg>
                        <span>Certaines informations sont à corriger :</span>
                    </div>
                    <ul class="mt-2 list-disc space-y-1 pl-7 text-xs sm:text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form
                method="POST"
                action="{{ $product->exists ? route('admin.products.update', $product) : route('admin.products.store') }}"
                enctype="multipart/form-data"
                class="space-y-6"
            >
                @csrf
                @if ($product->exists)
                    @method('PUT')
                @endif

                <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
                    <!-- Colonne de contenu (2 tiers) -->
                    <div class="space-y-6 lg:col-span-2">
                        <!-- Fiche d'identification -->
                        <section class="rounded-2xl border border-[#eaecf0] bg-white p-5 shadow-xs sm:p-6">
                            <div class="border-b border-[#eaecf0] pb-4">
                                <h2 class="text-base font-semibold text-[#101828]">Identification de l’appareil</h2>
                                <p class="text-xs text-[#667085] mt-0.5">Désignation, classification et présentation technique</p>
                            </div>
                            <div class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-2">
                                <div class="sm:col-span-2">
                                    <label for="name" class="{{ $label }}">
                                        Nom de l’appareil médical <span class="text-[#d92d20]">*</span>
                                    </label>
                                    <input
                                        id="name"
                                        name="name"
                                        type="text"
                                        value="{{ old('name', $product->name) }}"
                                        placeholder="Ex: Échographe Doppler couleur portable"
                                        required
                                        class="{{ $field }}"
                                    >
                                </div>
                                <div>
                                    <label for="category_id" class="{{ $label }}">
                                        Catégorie d'affectation <span class="text-[#d92d20]">*</span>
                                    </label>
                                    <select id="category_id" name="category_id" required class="{{ $field }}">
                                        <option value="">Choisir une catégorie</option>
                                        @foreach ($categories as $category)
                                            <option
                                                value="{{ $category->id }}"
                                                @selected((string) old('category_id', $product->category_id) === (string) $category->id)
                                            >
                                                {{ $category->name }}{{ $category->is_published ? '' : ' (masquée)' }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label for="reference" class="{{ $label }}">Référence fabricant / modèle</label>
                                    <input
                                        id="reference"
                                        name="reference"
                                        type="text"
                                        value="{{ old('reference', $product->reference) }}"
                                        placeholder="Ex: REF-ECH-800"
                                        class="{{ $field }}"
                                    >
                                    <p class="mt-1.5 text-xs text-[#667085]">Facultative. Plusieurs produits peuvent rester sans référence.</p>
                                </div>
                                <div class="sm:col-span-2">
                                    <label for="slug" class="{{ $label }}">Slug d’URL</label>
                                    <input
                                        id="slug"
                                        name="slug"
                                        type="text"
                                        value="{{ old('slug', $product->slug) }}"
                                        placeholder="Laissez vide pour le créer depuis le nom"
                                        class="{{ $field }} font-mono text-xs sm:text-sm"
                                    >
                                    <p class="mt-1.5 text-xs text-[#667085]">Il reste inchangé tant que vous ne le modifiez pas.</p>
                                </div>
                                <div class="sm:col-span-2">
                                    <label for="summary" class="{{ $label }}">Résumé synthétique (accroche)</label>
                                    <input
                                        id="summary"
                                        name="summary"
                                        type="text"
                                        value="{{ old('summary', $product->summary) }}"
                                        placeholder="Courte phrase d'introduction affichée sur la carte..."
                                        class="{{ $field }}"
                                    >
                                </div>
                                <div class="sm:col-span-2">
                                    <label for="description" class="{{ $label }}">Description technique détaillée</label>
                                    <textarea
                                        id="description"
                                        name="description"
                                        rows="6"
                                        placeholder="Spécifications cliniques, conformités, applications médicales..."
                                        class="{{ $field }}"
                                    >{{ old('description', $product->description) }}</textarea>
                                </div>
                            </div>
                        </section>

                        <!-- Tarification indicative -->
                        <section class="rounded-2xl border border-[#eaecf0] bg-white p-5 shadow-xs sm:p-6">
                            <div class="border-b border-[#eaecf0] pb-4">
                                <h2 class="text-base font-semibold text-[#101828]">Prix indicatif</h2>
                                <p class="text-xs text-[#667085] mt-0.5">
                                    Laissez les deux champs vides pour un appareil « Sur devis ». Le promo ne s’applique que s’il est strictement inférieur au prix standard.
                                </p>
                            </div>
                            <div class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-2">
                                <div>
                                    <label for="price" class="{{ $label }}">Prix standard (€)</label>
                                    <div class="relative">
                                        <input
                                            id="price"
                                            name="price"
                                            type="number"
                                            min="0"
                                            step="0.01"
                                            value="{{ old('price', $product->price) }}"
                                            placeholder="Ex: 12500.00"
                                            class="{{ $field }} pr-8"
                                        >
                                        <span class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3.5 text-xs font-semibold text-[#98a2b3]">€</span>
                                    </div>
                                </div>
                                <div>
                                    <label for="promo_price" class="{{ $label }}">Prix promotionnel (€)</label>
                                    <div class="relative">
                                        <input
                                            id="promo_price"
                                            name="promo_price"
                                            type="number"
                                            min="0"
                                            step="0.01"
                                            value="{{ old('promo_price', $product->promo_price) }}"
                                            placeholder="Ex: 10900.00"
                                            class="{{ $field }} pr-8"
                                        >
                                        <span class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3.5 text-xs font-semibold text-[#98a2b3]">€</span>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <!-- Spécifications / Caractéristiques techniques -->
                        <section class="rounded-2xl border border-[#eaecf0] bg-white p-5 shadow-xs sm:p-6">
                            <div class="flex items-center justify-between gap-3 border-b border-[#eaecf0] pb-4">
                                <div>
                                    <h2 class="text-base font-semibold text-[#101828]">Caractéristiques techniques</h2>
                                    <p class="mt-0.5 text-xs text-[#667085]">Paires structurées présentées sous forme de tableau clinique (ex: Écran, Sonde, Poids)</p>
                                </div>
                                <button
                                    type="button"
                                    id="add-spec"
                                    class="inline-flex cursor-pointer items-center gap-1.5 rounded-xl border border-[#d0d5dd] bg-white px-3 py-1.5 text-xs font-semibold text-[#344054] shadow-2xs hover:bg-[#f9fafb] hover:border-[#98a2b3]"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-3.5 w-3.5">
                                        <path d="M10.75 4.75a.75.75 0 0 0-1.5 0v4.5h-4.5a.75.75 0 0 0 0 1.5h4.5v4.5a.75.75 0 0 0 1.5 0v-4.5h4.5a.75.75 0 0 0 0-1.5h-4.5v-4.5Z" />
                                    </svg>
                                    <span>Ajouter une ligne</span>
                                </button>
                            </div>

                            <div id="spec-rows" class="mt-5 space-y-3">
                                @foreach ($specificationRows as $index => $row)
                                    <div data-row class="grid grid-cols-1 gap-3 rounded-xl border border-[#eaecf0] bg-[#fcfcfd] p-3 sm:grid-cols-[1fr_1fr_auto] sm:items-center">
                                        <div>
                                            <input
                                                name="specifications[{{ $index }}][name]"
                                                type="text"
                                                value="{{ $row['name'] }}"
                                                placeholder="Propriété (ex: Fréquence)"
                                                aria-label="Nom de la caractéristique {{ $index + 1 }}"
                                                class="{{ $field }}"
                                            >
                                        </div>
                                        <div>
                                            <input
                                                name="specifications[{{ $index }}][value]"
                                                type="text"
                                                value="{{ $row['value'] }}"
                                                placeholder="Valeur (ex: 2.5 - 5.0 MHz)"
                                                aria-label="Valeur de la caractéristique {{ $index + 1 }}"
                                                class="{{ $field }}"
                                            >
                                        </div>
                                        <button
                                            type="button"
                                            data-remove-row
                                            class="cursor-pointer rounded-xl border border-[#fee4e2] bg-white px-3 py-2 text-xs font-semibold text-[#d92d20] hover:bg-[#fee4e2]"
                                        >
                                            Retirer
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                        </section>

                        <!-- Galerie Photos avec prévisualisation en direct -->
                        <section class="rounded-2xl border border-[#eaecf0] bg-white p-5 shadow-xs sm:p-6">
                            <div class="flex items-center justify-between gap-3 border-b border-[#eaecf0] pb-4">
                                <div>
                                    <h2 class="text-base font-semibold text-[#101828]">Galerie de photos</h2>
                                    <p class="mt-0.5 text-xs text-[#667085]">
                                        JPEG, PNG ou WebP. La première image selon l’ordre sert de photo de couverture. Texte alternatif obligatoire.
                                    </p>
                                </div>
                                <button
                                    type="button"
                                    id="add-image"
                                    class="inline-flex cursor-pointer items-center gap-1.5 rounded-xl border border-[#d0d5dd] bg-white px-3 py-1.5 text-xs font-semibold text-[#344054] shadow-2xs hover:bg-[#f9fafb] hover:border-[#98a2b3]"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-3.5 w-3.5">
                                        <path d="M10.75 4.75a.75.75 0 0 0-1.5 0v4.5h-4.5a.75.75 0 0 0 0 1.5h4.5v4.5a.75.75 0 0 0 1.5 0v-4.5h4.5a.75.75 0 0 0 0-1.5h-4.5v-4.5Z" />
                                    </svg>
                                    <span>Ajouter une photo</span>
                                </button>
                            </div>

                            <!-- Photos existantes enregistrées -->
                            @if ($product->exists && $product->images->isNotEmpty())
                                <div class="mt-5 space-y-3">
                                    <h3 class="text-xs font-semibold text-[#344054] uppercase tracking-wider">Photos déjà enregistrées</h3>
                                    @foreach ($product->images as $image)
                                        <div class="grid grid-cols-1 gap-3.5 rounded-xl border border-[#eaecf0] bg-[#fcfcfd] p-3 sm:grid-cols-[5rem_1fr_6rem_auto] sm:items-center">
                                            <div class="relative h-18 w-18 overflow-hidden rounded-xl border border-[#eaecf0] bg-white shadow-2xs">
                                                <img
                                                    src="{{ Storage::disk('public')->url($image->path) }}"
                                                    alt="{{ $image->alt }}"
                                                    class="h-full w-full object-cover"
                                                >
                                                @if ($loop->first)
                                                    <span class="absolute bottom-1 left-1 rounded bg-[#101828]/80 px-1 py-0.2 text-[9px] font-semibold text-white">
                                                        Carte
                                                    </span>
                                                @endif
                                            </div>
                                            <input type="hidden" name="existing_images[{{ $image->id }}][id]" value="{{ $image->id }}">
                                            <div>
                                                <label class="sr-only" for="existing-alt-{{ $image->id }}">Texte alternatif</label>
                                                <input
                                                    id="existing-alt-{{ $image->id }}"
                                                    name="existing_images[{{ $image->id }}][alt]"
                                                    type="text"
                                                    value="{{ old('existing_images.'.$image->id.'.alt', $image->alt) }}"
                                                    placeholder="Description clinique du cliché..."
                                                    aria-label="Texte alternatif de la photo {{ $image->id }}"
                                                    class="{{ $field }}"
                                                >
                                            </div>
                                            <div>
                                                <label class="sr-only" for="existing-sort-{{ $image->id }}">Ordre</label>
                                                <input
                                                    id="existing-sort-{{ $image->id }}"
                                                    name="existing_images[{{ $image->id }}][sort_order]"
                                                    type="number"
                                                    min="0"
                                                    value="{{ old('existing_images.'.$image->id.'.sort_order', $image->sort_order) }}"
                                                    placeholder="Ordre"
                                                    aria-label="Ordre de la photo {{ $image->id }}"
                                                    class="{{ $field }}"
                                                >
                                            </div>
                                            <label class="inline-flex cursor-pointer items-center gap-1.5 text-xs font-semibold text-[#d92d20]">
                                                <input
                                                    type="checkbox"
                                                    name="remove_image_ids[]"
                                                    value="{{ $image->id }}"
                                                    @checked(in_array((string) $image->id, array_map('strval', (array) old('remove_image_ids', [])), true))
                                                    class="rounded border-[#fecdca] text-[#d92d20] focus:ring-[#d92d20]"
                                                >
                                                <span>Retirer</span>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            <!-- Nouvelles photos à téléverser (avec prévisualisation dynamique temps réel) -->
                            <div class="mt-5 space-y-3">
                                <h3 class="text-xs font-semibold text-[#344054] uppercase tracking-wider">Ajouter de nouvelles photos</h3>
                                <div id="image-rows" class="space-y-3"></div>
                            </div>
                        </section>

                        <!-- SEO & Référencement -->
                        <section class="rounded-2xl border border-[#eaecf0] bg-white p-5 shadow-xs sm:p-6">
                            <div class="border-b border-[#eaecf0] pb-4">
                                <h2 class="text-base font-semibold text-[#101828]">Référencement naturel (SEO)</h2>
                                <p class="text-xs text-[#667085] mt-0.5">Balises spécifiques pour Google et partage sur réseaux professionnels</p>
                            </div>
                            <div class="mt-5 space-y-5">
                                <div>
                                    <label for="meta_title" class="{{ $label }}">Meta titre</label>
                                    <input
                                        id="meta_title"
                                        name="meta_title"
                                        type="text"
                                        value="{{ old('meta_title', $product->meta_title) }}"
                                        placeholder="Ex: Échographe Doppler portable haute précision — Référence Médico"
                                        class="{{ $field }}"
                                    >
                                </div>
                                <div>
                                    <label for="meta_description" class="{{ $label }}">Meta description</label>
                                    <textarea
                                        id="meta_description"
                                        name="meta_description"
                                        rows="3"
                                        placeholder="Synthèse clinique pour les résultats de recherche (max 320 caractères)..."
                                        class="{{ $field }}"
                                    >{{ old('meta_description', $product->meta_description) }}</textarea>
                                </div>
                                <div>
                                    <label for="meta_image" class="{{ $label }}">Image de partage Open Graph</label>
                                    <div class="flex items-center gap-4">
                                        <div class="relative flex h-16 w-16 shrink-0 items-center justify-center overflow-hidden rounded-xl border border-[#d0d5dd] bg-[#fcfcfd]">
                                            <img
                                                id="meta-image-preview"
                                                src="{{ $product->meta_image ? Storage::disk('public')->url($product->meta_image) : '' }}"
                                                alt=""
                                                class="{{ $product->meta_image ? '' : 'hidden' }} h-full w-full object-cover"
                                            >
                                            <span id="meta-image-placeholder" class="{{ $product->meta_image ? 'hidden' : 'block' }} text-[10px] text-[#98a2b3]">SEO</span>
                                        </div>
                                        <input
                                            id="meta_image"
                                            name="meta_image"
                                            type="file"
                                            accept="image/jpeg,image/png,image/webp"
                                            class="{{ $field }} text-xs"
                                        >
                                    </div>
                                    @if ($product->meta_image)
                                        <label class="mt-2.5 inline-flex cursor-pointer items-center gap-2 text-xs font-semibold text-[#667085]">
                                            <input type="checkbox" name="remove_meta_image" value="1" @checked(old('remove_meta_image'))>
                                            <span>Retirer l’image de référencement enregistrée</span>
                                        </label>
                                    @endif
                                </div>
                            </div>
                        </section>
                    </div>

                    <!-- Colonne latérale (1 tiers) -->
                    <div class="space-y-6">
                        <!-- Statut et publication -->
                        <section class="rounded-2xl border border-[#eaecf0] bg-white p-5 shadow-xs sm:p-6">
                            <div class="border-b border-[#eaecf0] pb-4">
                                <h2 class="text-base font-semibold text-[#101828]">Visibilité & Mise en avant</h2>
                                <p class="text-xs text-[#667085] mt-0.5">Contrôlez l'exposition du produit</p>
                            </div>

                            <div class="mt-5 space-y-4">
                                <label class="flex items-start gap-3 rounded-xl border border-[#eaecf0] p-3 transition-colors hover:bg-[#f9fafb] cursor-pointer">
                                    <input
                                        type="checkbox"
                                        name="is_published"
                                        value="1"
                                        class="mt-0.5 h-4 w-4 rounded-sm border-[#d0d5dd] text-primary focus:ring-primary"
                                        @checked(old('is_published', $product->is_published))
                                    >
                                    <span>
                                        <span class="block text-sm font-semibold text-[#101828]">Publier sur le catalogue</span>
                                        <span class="mt-0.5 block text-xs text-[#667085]">
                                            Sans cette case cochée, l'équipement reste au stade de brouillon privé.
                                        </span>
                                    </span>
                                </label>

                                <label class="flex items-start gap-3 rounded-xl border border-[#eaecf0] p-3 transition-colors hover:bg-[#f9fafb] cursor-pointer">
                                    <input
                                        type="checkbox"
                                        name="is_featured"
                                        value="1"
                                        class="mt-0.5 h-4 w-4 rounded-sm border-[#d0d5dd] text-[#edbb45] focus:ring-[#edbb45]"
                                        @checked(old('is_featured', $product->is_featured))
                                    >
                                    <span>
                                        <span class="block text-sm font-semibold text-[#101828]">Mettre en vedette (Accueil)</span>
                                        <span class="mt-0.5 block text-xs text-[#667085]">
                                            Place l’appareil en priorité dans les sélections d’équipements recommandés.
                                        </span>
                                    </span>
                                </label>

                                <div>
                                    <label for="sort_order" class="{{ $label }}">Ordre d’affichage</label>
                                    <input
                                        id="sort_order"
                                        name="sort_order"
                                        type="number"
                                        min="0"
                                        value="{{ old('sort_order', $product->sort_order ?? 0) }}"
                                        class="{{ $field }}"
                                    >
                                    <p class="mt-1 text-xs text-[#667085]">Valeur numérique (0 = premier produit affiché).</p>
                                </div>
                            </div>

                            <button
                                type="submit"
                                class="mt-6 inline-flex w-full cursor-pointer items-center justify-center gap-2 rounded-xl bg-primary px-4 py-2.5 text-sm font-semibold text-white shadow-xs transition-colors hover:bg-primary-hover focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4">
                                    <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z" clip-rule="evenodd" />
                                </svg>
                                <span>Enregistrer le produit</span>
                            </button>
                        </section>

                        @if ($product->exists)
                            <section class="rounded-2xl border border-[#fee4e2] bg-[#fef3f2]/40 p-5 shadow-xs">
                                <h3 class="text-xs font-bold text-[#b42318] uppercase tracking-wider">Zone de danger</h3>
                                <p class="mt-2 text-xs text-[#667085] leading-relaxed">
                                    Supprime définitivement cet appareil médical, toutes ses photos associées et ses métadonnées.
                                </p>
                                <button
                                    type="button"
                                    onclick="if(confirm('Supprimer définitivement ce produit et ses photos ?')) { document.getElementById('delete-product-form').submit(); }"
                                    class="mt-3.5 inline-flex w-full cursor-pointer items-center justify-center rounded-xl border border-[#fecdca] bg-white px-3 py-2 text-xs font-semibold text-[#d92d20] shadow-2xs transition-colors hover:bg-[#fee4e2]"
                                >
                                    Supprimer ce produit
                                </button>
                            </section>
                        @endif
                    </div>
                </div>
            </form>

            @if ($product->exists)
                <form id="delete-product-form" method="POST" action="{{ route('admin.products.destroy', $product) }}" class="hidden">
                    @csrf
                    @method('DELETE')
                </form>
            @endif
        @endif
    </div>

    <!-- Modèle dynamique pour caractéristique -->
    <template id="spec-template">
        <div data-row class="grid grid-cols-1 gap-3 rounded-xl border border-[#eaecf0] bg-[#fcfcfd] p-3 sm:grid-cols-[1fr_1fr_auto] sm:items-center">
            <div>
                <input
                    name="specifications[__INDEX__][name]"
                    type="text"
                    placeholder="Propriété"
                    aria-label="Nom de la caractéristique"
                    class="{{ $field }}"
                >
            </div>
            <div>
                <input
                    name="specifications[__INDEX__][value]"
                    type="text"
                    placeholder="Valeur"
                    aria-label="Valeur de la caractéristique"
                    class="{{ $field }}"
                >
            </div>
            <button
                type="button"
                data-remove-row
                class="cursor-pointer rounded-xl border border-[#fee4e2] bg-white px-3 py-2 text-xs font-semibold text-[#d92d20] hover:bg-[#fee4e2]"
            >
                Retirer
            </button>
        </div>
    </template>

    <!-- Modèle dynamique pour photo avec zone de prévisualisation en temps réel -->
    <template id="image-template">
        <div data-row class="grid grid-cols-1 gap-3.5 rounded-xl border border-dashed border-[#d0d5dd] bg-[#fcfcfd] p-3.5 sm:grid-cols-[5rem_1fr_1fr_auto] sm:items-center">
            <!-- Vignette prévisualisation en direct -->
            <div class="relative flex h-18 w-18 shrink-0 items-center justify-center overflow-hidden rounded-xl border border-[#d0d5dd] bg-white shadow-2xs">
                <img data-preview-img src="" alt="" class="hidden h-full w-full object-cover">
                <div data-preview-placeholder class="flex flex-col items-center justify-center p-1 text-center text-[#98a2b3]">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5">
                        <path fill-rule="evenodd" d="M1 5.25A2.25 2.25 0 0 1 3.25 3h13.5A2.25 2.25 0 0 1 19 5.25v9.5A2.25 2.25 0 0 1 16.75 17H3.25A2.25 2.25 0 0 1 1 14.75v-9.5Zm1.5 5.81v3.69c0 .414.336.75.75.75h13.5a.75.75 0 0 0 .75-.75v-2.69l-2.22-2.219a.75.75 0 0 0-1.06 0l-1.91 1.909-3.97-3.97a.75.75 0 0 0-1.06 0L2.5 11.06ZM3.25 4.5a.75.75 0 0 0-.75.75v3.69l3.72-3.72a.75.75 0 0 1 1.06 0l3.97 3.97 1.91-1.91a.75.75 0 0 1 1.06 0l2.22 2.22V5.25a.75.75 0 0 0-.75-.75H3.25Zm8.5 4a1.25 1.25 0 1 0 0-2.5 1.25 1.25 0 0 0 0 2.5Z" clip-rule="evenodd" />
                    </svg>
                    <span class="text-[9px]">Aperçu</span>
                </div>
            </div>

            <!-- Fichier image -->
            <div>
                <label class="sr-only">Fichier image</label>
                <input
                    name="images[__INDEX__][file]"
                    type="file"
                    accept="image/jpeg,image/png,image/webp"
                    data-image-file-input
                    aria-label="Photo"
                    class="{{ $field }} text-xs"
                >
            </div>

            <!-- Texte alternatif -->
            <div>
                <label class="sr-only">Texte alternatif</label>
                <input
                    name="images[__INDEX__][alt]"
                    type="text"
                    placeholder="Texte alternatif (SEO / clinique)..."
                    aria-label="Texte alternatif"
                    class="{{ $field }}"
                >
            </div>

            <button
                type="button"
                data-remove-row
                class="cursor-pointer rounded-xl border border-[#fee4e2] bg-white px-3 py-2 text-xs font-semibold text-[#d92d20] hover:bg-[#fee4e2]"
            >
                Retirer
            </button>
        </div>
    </template>

    <script>
        (function () {
            const specList = document.getElementById('spec-rows');
            const specButton = document.getElementById('add-spec');
            const specTemplate = document.getElementById('spec-template');
            const imageList = document.getElementById('image-rows');
            const imageButton = document.getElementById('add-image');
            const imageTemplate = document.getElementById('image-template');

            function attachRowImagePreview(row) {
                const fileInput = row.querySelector('[data-image-file-input]');
                const previewImg = row.querySelector('[data-preview-img]');
                const placeholder = row.querySelector('[data-preview-placeholder]');

                if (!fileInput || !previewImg) return;

                fileInput.addEventListener('change', function () {
                    const file = this.files && this.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function (e) {
                            previewImg.src = e.target.result;
                            previewImg.classList.remove('hidden');
                            if (placeholder) placeholder.classList.add('hidden');
                        };
                        reader.readAsDataURL(file);
                    }
                });
            }

            function addRow(list, template, isImage) {
                if (!list || !template) return;

                const index = Date.now() + Math.floor(Math.random() * 1000);
                const html = template.innerHTML.replaceAll('__INDEX__', String(index));
                list.insertAdjacentHTML('beforeend', html);

                const newlyAdded = list.lastElementChild;
                if (isImage && newlyAdded) {
                    attachRowImagePreview(newlyAdded);
                }
            }

            function bind(list, button, template, keepOne, isImage) {
                if (!list || !button || !template) return;

                button.addEventListener('click', function () {
                    addRow(list, template, isImage);
                });

                list.addEventListener('click', function (event) {
                    const remove = event.target.closest('[data-remove-row]');
                    if (!remove) return;

                    const row = remove.closest('[data-row]');
                    if (!row) return;

                    if (keepOne && list.querySelectorAll('[data-row]').length === 1) {
                        row.querySelectorAll('input').forEach(function (input) {
                            input.value = '';
                        });
                        return;
                    }

                    row.remove();
                });
            }

            bind(specList, specButton, specTemplate, true, false);
            bind(imageList, imageButton, imageTemplate, false, true);

            // Ajoute une première ligne photo prête avec preview
            addRow(imageList, imageTemplate, true);

            // Preview pour meta image
            const metaInput = document.getElementById('meta_image');
            const metaPreview = document.getElementById('meta-image-preview');
            const metaPlaceholder = document.getElementById('meta-image-placeholder');
            if (metaInput && metaPreview) {
                metaInput.addEventListener('change', function () {
                    const file = this.files && this.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function (e) {
                            metaPreview.src = e.target.result;
                            metaPreview.classList.remove('hidden');
                            if (metaPlaceholder) metaPlaceholder.classList.add('hidden');
                        };
                        reader.readAsDataURL(file);
                    }
                });
            }
        })();
    </script>
@endsection
