@extends('admin.layout')

@section('title', $category->exists ? 'Modifier la catégorie' : 'Nouvelle catégorie')

@section('content')
    @php
        $field = 'w-full rounded-xl border border-[#d0d5dd] bg-white px-3.5 py-2.5 text-sm text-[#101828] shadow-xs outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/15';
        $label = 'mb-1.5 block text-sm font-medium text-[#344054]';
    @endphp

    <div class="space-y-6">
        <!-- En-tête -->
        <section class="flex flex-col gap-3 border-b border-[#eaecf0] pb-6 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <a href="{{ route('admin.categories.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-[#667085] transition-colors hover:text-[#101828]">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4">
                        <path fill-rule="evenodd" d="M17 10a.75.75 0 0 1-.75.75H5.612l4.158 3.96a.75.75 0 1 1-1.04 1.08l-5.5-5.25a.75.75 0 0 1 0-1.08l5.5-5.25a.75.75 0 1 1 1.04 1.08L5.612 9.25H16.25A.75.75 0 0 1 17 10Z" clip-rule="evenodd" />
                    </svg>
                    Retour aux catégories
                </a>
                <h1 class="mt-2 text-2xl font-bold tracking-tight text-[#101828] sm:text-[28px]">
                    {{ $category->exists ? 'Modifier la catégorie' : 'Nouvelle catégorie' }}
                </h1>
                <p class="mt-1 text-sm text-[#475467]">
                    {{ $category->exists ? $category->name : 'Nom, visuel représentatif et visibilité dans le catalogue médical.' }}
                </p>
            </div>

            @if ($category->exists)
                <div class="flex items-center gap-2">
                    <span class="inline-flex items-center rounded-full bg-[#f2f4f7] px-3 py-1 text-xs font-semibold text-[#344054]">
                        {{ $category->products_count ?? 0 }} produit(s) rattaché(s)
                    </span>
                </div>
            @endif
        </section>

        <!-- Messages d'erreur -->
        @if ($errors->any())
            <div role="alert" class="rounded-2xl border border-[#fecdca] bg-[#fef3f2] p-4 text-sm text-[#b42318] shadow-xs">
                <div class="flex items-center gap-2 font-semibold">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5 shrink-0">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-8-5a.75.75 0 0 1 .75.75v4.5a.75.75 0 0 1-1.5 0v-4.5A.75.75 0 0 1 10 5Zm0 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" />
                    </svg>
                    <span>Veuillez corriger les informations suivantes :</span>
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
            action="{{ $category->exists ? route('admin.categories.update', $category) : route('admin.categories.store') }}"
            enctype="multipart/form-data"
            class="space-y-6"
        >
            @csrf
            @if ($category->exists)
                @method('PUT')
            @endif

            <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
                <!-- Colonne principale (2 tiers) -->
                <div class="space-y-6 lg:col-span-2">
                    <!-- Fiche informative -->
                    <section class="rounded-2xl border border-[#eaecf0] bg-white p-5 shadow-xs sm:p-6">
                        <div class="border-b border-[#eaecf0] pb-4">
                            <h2 class="text-base font-semibold text-[#101828]">Fiche principale</h2>
                            <p class="text-xs text-[#667085] mt-0.5">Informations descriptives présentées aux professionnels de santé</p>
                        </div>
                        <div class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-2">
                            <div class="sm:col-span-2">
                                <label for="name" class="{{ $label }}">
                                    Nom de la catégorie <span class="text-[#d92d20]">*</span>
                                </label>
                                <input
                                    id="name"
                                    name="name"
                                    type="text"
                                    value="{{ old('name', $category->name) }}"
                                    placeholder="Ex: Imagerie & Échographie"
                                    required
                                    class="{{ $field }}"
                                >
                            </div>
                            <div class="sm:col-span-2">
                                <label for="slug" class="{{ $label }}">Slug d’URL</label>
                                <input
                                    id="slug"
                                    name="slug"
                                    type="text"
                                    value="{{ old('slug', $category->slug) }}"
                                    placeholder="Laissez vide pour le générer automatiquement depuis le nom"
                                    class="{{ $field }} font-mono text-xs sm:text-sm"
                                >
                                <p class="mt-1.5 text-xs text-[#667085]">
                                    Identifiant unique pour l’adresse web de la catégorie (ex: <code class="text-[#101828]">imagerie-echographie</code>).
                                </p>
                            </div>
                            <div class="sm:col-span-2">
                                <label for="description" class="{{ $label }}">Description</label>
                                <textarea
                                    id="description"
                                    name="description"
                                    rows="4"
                                    placeholder="Présentation générale des équipements de cette famille..."
                                    class="{{ $field }}"
                                >{{ old('description', $category->description) }}</textarea>
                            </div>
                        </div>
                    </section>

                    <!-- Image de profil avec prévisualisation temps réel -->
                    <section class="rounded-2xl border border-[#eaecf0] bg-white p-5 shadow-xs sm:p-6">
                        <div class="border-b border-[#eaecf0] pb-4">
                            <h2 class="text-base font-semibold text-[#101828]">Image de profil / vignette</h2>
                            <p class="text-xs text-[#667085] mt-0.5">Visuel représentatif affiché dans le catalogue public (JPEG, PNG ou WebP - max 5 Mo)</p>
                        </div>

                        <div class="mt-5 space-y-5">
                            <!-- Zone Upload avec drag & drop visuel et preview instantanée -->
                            <div>
                                <label class="{{ $label }}">Fichier image</label>
                                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-5">
                                    <!-- Cadre de prévisualisation -->
                                    <div class="relative flex h-28 w-28 shrink-0 items-center justify-center overflow-hidden rounded-2xl border-2 border-dashed border-[#d0d5dd] bg-[#fcfcfd] shadow-2xs">
                                        <img
                                            id="category-image-preview"
                                            src="{{ $category->image ? Storage::disk('public')->url($category->image) : '' }}"
                                            alt="{{ $category->image_alt ?? 'Aperçu' }}"
                                            class="{{ $category->image ? '' : 'hidden' }} h-full w-full object-cover"
                                        >
                                        <div id="category-image-placeholder" class="{{ $category->image ? 'hidden' : 'flex' }} flex-col items-center justify-center p-3 text-center text-[#98a2b3]">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" class="h-8 w-8">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                                            </svg>
                                            <span class="mt-1 text-[11px] font-medium">Aucun visuel</span>
                                        </div>
                                    </div>

                                    <!-- Bouton de téléversement personnalisé -->
                                    <div class="flex-1 space-y-2">
                                        <div class="relative">
                                            <input
                                                id="image"
                                                name="image"
                                                type="file"
                                                accept="image/jpeg,image/png,image/webp"
                                                class="peer absolute inset-0 h-full w-full cursor-pointer opacity-0"
                                            >
                                            <div class="flex items-center gap-3 rounded-xl border border-[#d0d5dd] bg-white px-4 py-3 shadow-2xs transition peer-focus:border-primary peer-focus:ring-2 peer-focus:ring-primary/15 hover:bg-[#f9fafb]">
                                                <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-[#f2f4f7] text-[#344054]">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5">
                                                        <path d="M9.25 13.25a.75.75 0 0 0 1.5 0V4.636l2.155 2.156a.75.75 0 1 0 1.06-1.061l-3.435-3.435a.75.75 0 0 0-1.06 0L6.035 5.73a.75.75 0 0 0 1.06 1.061L9.25 4.636v8.614Z" />
                                                        <path d="M3.5 12.75a.75.75 0 0 0-1.5 0v2.5A2.75 2.75 0 0 0 4.75 18h10.5A2.75 2.75 0 0 0 18 15.25v-2.5a.75.75 0 0 0-1.5 0v2.5c0 .69-.56 1.25-1.25 1.25H4.75c-.69 0-1.25-.56-1.25-1.25v-2.5Z" />
                                                    </svg>
                                                </div>
                                                <div class="min-w-0 flex-1">
                                                    <p id="image-filename" class="truncate text-xs font-semibold text-[#101828]">
                                                        {{ $category->image ? 'Remplacer le visuel actuel' : 'Sélectionner une photo depuis votre appareil' }}
                                                    </p>
                                                    <p class="text-[11px] text-[#667085]">JPEG, PNG ou WebP jusqu’à 5 Mo</p>
                                                </div>
                                                <span class="rounded-lg border border-[#d0d5dd] bg-white px-2.5 py-1 text-xs font-semibold text-[#344054]">
                                                    Parcourir
                                                </span>
                                            </div>
                                        </div>

                                        <p class="text-xs text-[#667085]">
                                            L’image sera automatiquement affichée en direct dès sa sélection.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Texte alternatif -->
                            <div>
                                <label for="image_alt" class="{{ $label }}">
                                    Texte alternatif de l'image (SEO & Accessibilité)
                                </label>
                                <input
                                    id="image_alt"
                                    name="image_alt"
                                    type="text"
                                    value="{{ old('image_alt', $category->image_alt) }}"
                                    placeholder="Ex: Équipements de pointe pour salle d’imagerie médicale"
                                    class="{{ $field }}"
                                >
                                <p class="mt-1 text-xs text-[#667085]">
                                    Obligatoire si une image est sélectionnée. Décrivez précisément le visuel.
                                </p>
                            </div>

                            @if ($category->image)
                                <div class="rounded-xl border border-[#fee4e2] bg-[#fef3f2]/60 p-3">
                                    <label class="inline-flex cursor-pointer items-center gap-2.5 text-xs font-semibold text-[#d92d20]">
                                        <input
                                            type="checkbox"
                                            name="remove_image"
                                            value="1"
                                            @checked(old('remove_image'))
                                            class="rounded border-[#fecdca] text-[#d92d20] focus:ring-[#d92d20]"
                                        >
                                        <span>Supprimer définitivement l’image actuelle de la catégorie</span>
                                    </label>
                                </div>
                            @endif
                        </div>
                    </section>

                    <!-- SEO & Référencement -->
                    <section class="rounded-2xl border border-[#eaecf0] bg-white p-5 shadow-xs sm:p-6">
                        <div class="border-b border-[#eaecf0] pb-4">
                            <h2 class="text-base font-semibold text-[#101828]">Référencement naturel (SEO)</h2>
                            <p class="text-xs text-[#667085] mt-0.5">Optimisez la visibilité de la famille médicale sur les moteurs de recherche</p>
                        </div>
                        <div class="mt-5 space-y-5">
                            <div>
                                <label for="meta_title" class="{{ $label }}">Meta titre</label>
                                <input
                                    id="meta_title"
                                    name="meta_title"
                                    type="text"
                                    value="{{ old('meta_title', $category->meta_title) }}"
                                    placeholder="Ex: Matériel d'imagerie médicale pour hôpitaux — Référence Médico"
                                    class="{{ $field }}"
                                >
                            </div>
                            <div>
                                <label for="meta_description" class="{{ $label }}">Meta description</label>
                                <textarea
                                    id="meta_description"
                                    name="meta_description"
                                    rows="3"
                                    placeholder="Brève description accrocheuse pour Google (recommandé: 140 à 160 caractères)..."
                                    class="{{ $field }}"
                                >{{ old('meta_description', $category->meta_description) }}</textarea>
                            </div>
                            <div>
                                <label for="meta_image" class="{{ $label }}">Image de partage Open Graph (Réseaux sociaux)</label>
                                <div class="flex items-center gap-4">
                                    <div class="relative flex h-16 w-16 shrink-0 items-center justify-center overflow-hidden rounded-xl border border-[#d0d5dd] bg-[#fcfcfd]">
                                        <img
                                            id="meta-image-preview"
                                            src="{{ $category->meta_image ? Storage::disk('public')->url($category->meta_image) : '' }}"
                                            alt=""
                                            class="{{ $category->meta_image ? '' : 'hidden' }} h-full w-full object-cover"
                                        >
                                        <span id="meta-image-placeholder" class="{{ $category->meta_image ? 'hidden' : 'block' }} text-[10px] text-[#98a2b3]">SEO</span>
                                    </div>
                                    <input
                                        id="meta_image"
                                        name="meta_image"
                                        type="file"
                                        accept="image/jpeg,image/png,image/webp"
                                        class="{{ $field }} text-xs"
                                    >
                                </div>
                                @if ($category->meta_image)
                                    <label class="mt-2.5 inline-flex cursor-pointer items-center gap-2 text-xs font-semibold text-[#667085]">
                                        <input type="checkbox" name="remove_meta_image" value="1" @checked(old('remove_meta_image'))>
                                        <span>Retirer l’image de partage enregistrée</span>
                                    </label>
                                @endif
                            </div>
                        </div>
                    </section>
                </div>

                <!-- Colonne latérale (1 tiers) : Publication & Actions -->
                <div class="space-y-6">
                    <section class="rounded-2xl border border-[#eaecf0] bg-white p-5 shadow-xs sm:p-6">
                        <div class="border-b border-[#eaecf0] pb-4">
                            <h2 class="text-base font-semibold text-[#101828]">Visibilité</h2>
                            <p class="text-xs text-[#667085] mt-0.5">Disponibilité dans le catalogue public</p>
                        </div>

                        <div class="mt-5 space-y-4">
                            <label class="flex items-start gap-3 rounded-xl border border-[#eaecf0] p-3 transition-colors hover:bg-[#f9fafb] cursor-pointer">
                                <input
                                    type="checkbox"
                                    name="is_published"
                                    value="1"
                                    class="mt-0.5 h-4 w-4 rounded-sm border-[#d0d5dd] text-primary focus:ring-primary"
                                    @checked(old('is_published', $category->is_published))
                                >
                                <span>
                                    <span class="block text-sm font-semibold text-[#101828]">Publier dans le catalogue</span>
                                    <span class="mt-0.5 block text-xs text-[#667085] leading-relaxed">
                                        Rend visible la catégorie et ses appareils pour les établissements de santé.
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
                                    value="{{ old('sort_order', $category->sort_order ?? 0) }}"
                                    class="{{ $field }}"
                                >
                                <p class="mt-1 text-xs text-[#667085]">Position numérique (0 = premier affiché).</p>
                            </div>
                        </div>

                        <button
                            type="submit"
                            class="mt-6 inline-flex w-full cursor-pointer items-center justify-center gap-2 rounded-xl bg-primary px-4 py-2.5 text-sm font-semibold text-white shadow-xs transition-colors hover:bg-primary-hover focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4">
                                <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z" clip-rule="evenodd" />
                            </svg>
                            <span>Enregistrer la catégorie</span>
                        </button>
                    </section>

                    @if ($category->exists)
                        <section class="rounded-2xl border border-[#fee4e2] bg-[#fef3f2]/40 p-5 shadow-xs">
                            <h3 class="text-xs font-bold text-[#b42318] uppercase tracking-wider">Zone de danger</h3>
                            @if (($category->products_count ?? 0) > 0)
                                <p class="mt-2 text-xs text-[#667085] leading-relaxed">
                                    Cette catégorie contient <strong class="text-[#101828]">{{ $category->products_count }} appareil(s)</strong>.
                                    La suppression est bloquée tant que ces équipements y sont rattachés.
                                </p>
                            @else
                                <p class="mt-2 text-xs text-[#667085] leading-relaxed">
                                    Cette catégorie est vide. Vous pouvez la supprimer définitivement.
                                </p>
                                <button
                                    type="button"
                                    onclick="if(confirm('Supprimer définitivement cette catégorie ?')) { document.getElementById('delete-category-form').submit(); }"
                                    class="mt-3.5 inline-flex w-full cursor-pointer items-center justify-center rounded-xl border border-[#fecdca] bg-white px-3 py-2 text-xs font-semibold text-[#d92d20] shadow-2xs transition-colors hover:bg-[#fee4e2]"
                                >
                                    Supprimer la catégorie
                                </button>
                            @endif
                        </section>
                    @endif
                </div>
            </div>
        </form>

        @if ($category->exists && ($category->products_count ?? 0) === 0)
            <form id="delete-category-form" method="POST" action="{{ route('admin.categories.destroy', $category) }}" class="hidden">
                @csrf
                @method('DELETE')
            </form>
        @endif
    </div>

    <!-- Script de prévisualisation d'images en temps réel -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            function attachImagePreview(inputId, previewId, placeholderId, filenameId) {
                const input = document.getElementById(inputId);
                const preview = document.getElementById(previewId);
                const placeholder = document.getElementById(placeholderId);
                const filename = filenameId ? document.getElementById(filenameId) : null;

                if (!input || !preview) return;

                input.addEventListener('change', function () {
                    const file = this.files && this.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function (e) {
                            preview.src = e.target.result;
                            preview.classList.remove('hidden');
                            if (placeholder) placeholder.classList.add('hidden');
                        };
                        reader.readAsDataURL(file);

                        if (filename) {
                            filename.textContent = file.name;
                        }
                    }
                });
            }

            attachImagePreview('image', 'category-image-preview', 'category-image-placeholder', 'image-filename');
            attachImagePreview('meta_image', 'meta-image-preview', 'meta-image-placeholder');
        });
    </script>
@endsection
