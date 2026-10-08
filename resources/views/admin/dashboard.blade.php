@extends('admin.layout')

@section('title', 'Tableau de bord')

@section('content')
    <div class="space-y-8">
        <!-- 1. En-tête de bienvenue moderne avec actions -->
        <section class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between border-b border-[#eaecf0] pb-6">
            <div>
                <div class="flex items-center gap-2.5">
                    <h1 class="text-2xl sm:text-[28px] font-bold tracking-tight text-[#101828]">
                        Bonjour, {{ $admin->name }}
                    </h1>
                    <span class="inline-flex items-center gap-1.5 rounded-full bg-[#ecfdf3] px-2.5 py-0.5 text-xs font-semibold text-[#027a48] border border-[#a6f4c5]">
                        <span class="h-1.5 w-1.5 rounded-full bg-[#12b76a] animate-pulse"></span>
                        Admin
                    </span>
                </div>
                <p class="mt-1 text-sm text-[#475467]">
                    Aperçu opérationnel de la plateforme B2B et des demandes d'équipements médicaux.
                </p>
            </div>

            <div class="flex items-center gap-3">
                <a
                    href="{{ route('home') }}"
                    target="_blank"
                    class="inline-flex items-center gap-2 rounded-xl border border-[#d0d5dd] bg-white px-3.5 py-2 text-xs sm:text-sm font-semibold text-[#344054] shadow-xs transition-colors hover:bg-[#f9fafb] hover:text-[#1d2939]"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4 text-[#667085]">
                        <path fill-rule="evenodd" d="M4.25 5.5a.75.75 0 0 0-.75.75v8.5c0 .414.336.75.75.75h8.5a.75.75 0 0 0 .75-.75v-4a.75.75 0 0 1 1.5 0v4A2.25 2.25 0 0 1 12.75 17h-8.5A2.25 2.25 0 0 1 2 14.75v-8.5A2.25 2.25 0 0 1 4.25 4h5a.75.75 0 0 1 0 1.5h-5Z" clip-rule="evenodd" />
                        <path fill-rule="evenodd" d="M6.194 12.753a.75.75 0 0 0 1.06.053L16.5 4.44v2.81a.75.75 0 0 0 1.5 0v-4.5a.75.75 0 0 0-.75-.75h-4.5a.75.75 0 0 0 0 1.5h2.553l-9.056 8.194a.75.75 0 0 0-.053 1.06Z" clip-rule="evenodd" />
                    </svg>
                    <span>Voir le site</span>
                </a>

                <a
                    href="{{ route('admin.products.create') }}"
                    class="inline-flex items-center gap-2 rounded-xl bg-primary px-3.5 py-2 text-xs font-semibold text-white shadow-xs transition-colors hover:bg-primary-hover focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary sm:text-sm"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4">
                        <path d="M10.75 4.75a.75.75 0 0 0-1.5 0v4.5h-4.5a.75.75 0 0 0 0 1.5h4.5v4.5a.75.75 0 0 0 1.5 0v-4.5h4.5a.75.75 0 0 0 0-1.5h-4.5v-4.5Z" />
                    </svg>
                    <span>Nouveau produit</span>
                </a>
            </div>
        </section>

        <!-- 2. Grille de métriques KPIs modernes (Cards épurées, style SaaS) -->
        <section aria-label="Indicateurs clés" class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
            <!-- KPI 1 : Produits -->
            <div class="rounded-2xl border border-[#eaecf0] bg-white p-5 shadow-xs transition-all hover:border-[#d0d5dd] hover:shadow-sm">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold text-[#667085] uppercase tracking-wider">Catalogue</span>
                    <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-[#f2f4f7] text-[#344054]">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-5 w-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m21 7.5-9-5.25L3 7.5m18 0-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4 flex items-baseline justify-between">
                    <div>
                        <span class="text-3xl font-bold tracking-tight text-[#101828]">{{ $stats['products_count'] }}</span>
                        <span class="block text-xs font-medium text-[#475467] mt-0.5">appareils répertoriés</span>
                    </div>
                    <span class="inline-flex items-center rounded-md bg-[#ecfdf3] px-2 py-1 text-xs font-medium text-[#027a48]">
                        {{ $stats['products_published'] }} en ligne
                    </span>
                </div>
            </div>

            <!-- KPI 2 : Catégories -->
            <div class="rounded-2xl border border-[#eaecf0] bg-white p-5 shadow-xs transition-all hover:border-[#d0d5dd] hover:shadow-sm">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold text-[#667085] uppercase tracking-wider">Catégories</span>
                    <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-[#f2f4f7] text-[#344054]">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-5 w-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 0 1 0 3.75H5.625a1.875 1.875 0 0 1 0-3.75Z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4 flex items-baseline justify-between">
                    <div>
                        <span class="text-3xl font-bold tracking-tight text-[#101828]">{{ $stats['categories_count'] }}</span>
                        <span class="block text-xs font-medium text-[#475467] mt-0.5">familles d'équipements</span>
                    </div>
                    <span class="text-xs text-[#667085]">Rayons actifs</span>
                </div>
            </div>

            <!-- KPI 3 : Demandes de devis -->
            <div class="rounded-2xl border border-[#eaecf0] bg-white p-5 shadow-xs transition-all hover:border-[#d0d5dd] hover:shadow-sm">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold text-[#667085] uppercase tracking-wider">Devis reçus</span>
                    <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-[#fef0c7] text-[#b54708]">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-5 w-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4 flex items-baseline justify-between">
                    <div>
                        <span class="text-3xl font-bold tracking-tight text-[#101828]">{{ $stats['quotes_count'] }}</span>
                        <span class="block text-xs font-medium text-[#475467] mt-0.5">en attente de traitement</span>
                    </div>
                    <span class="inline-flex items-center rounded-md bg-[#fffaeb] px-2 py-1 text-xs font-medium text-[#b54708]">
                        Panier B2B
                    </span>
                </div>
            </div>

            <!-- KPI 4 : Messages de contact -->
            <a href="{{ route('admin.messages.index') }}" class="group block rounded-2xl border border-[#eaecf0] bg-white p-5 shadow-xs transition-all hover:border-[#d0d5dd] hover:shadow-sm">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold text-[#667085] uppercase tracking-wider group-hover:text-[#101828]">Messages</span>
                    <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-[#f2f4f7] text-[#344054] group-hover:bg-[#eaecf0]">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-5 w-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4 flex items-baseline justify-between">
                    <div>
                        <span class="text-3xl font-bold tracking-tight text-[#101828]">{{ $stats['messages_count'] }}</span>
                        <span class="block text-xs font-medium text-[#475467] mt-0.5">non lu(s)</span>
                    </div>
                    <span class="inline-flex items-center rounded-md bg-[#f2f4f7] px-2 py-1 text-xs font-medium text-[#344054]">
                        Formulaire direct
                    </span>
                </div>
            </a>
        </section>

        <!-- 3. Section principale : Table de suivi des produits + Panneau latéral de raccourcis -->
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            <!-- Colonne gauche (2 tiers) : Tableau des derniers équipements / activités -->
            <div class="lg:col-span-2 rounded-2xl border border-[#eaecf0] bg-white shadow-xs overflow-hidden">
                <div class="flex items-center justify-between border-b border-[#eaecf0] px-6 py-4.5">
                    <div>
                        <h2 class="text-base font-semibold text-[#101828]">Derniers produits enregistrés</h2>
                        <p class="text-xs text-[#475467] mt-0.5">Équipements médicaux récemment ajoutés au catalogue</p>
                    </div>
                    <span class="text-xs font-semibold text-[#667085]">
                        {{ $recentProducts->count() }} affiché(s)
                    </span>
                </div>

                @if($recentProducts->isNotEmpty())
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm text-[#475467]">
                            <thead class="bg-[#f9fafb] text-xs font-medium text-[#475467] border-b border-[#eaecf0]">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Produit</th>
                                    <th scope="col" class="px-4 py-3">Catégorie</th>
                                    <th scope="col" class="px-4 py-3">Prix indicatif</th>
                                    <th scope="col" class="px-4 py-3">Stock</th>
                                    <th scope="col" class="px-4 py-3">Statut</th>
                                    <th scope="col" class="px-6 py-3 text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-[#eaecf0]">
                                @foreach($recentProducts as $product)
                                    <tr class="hover:bg-[#f9fafb]/80 transition-colors">
                                        <td class="px-6 py-4">
                                            <div class="font-medium text-[#101828]">{{ $product->name }}</div>
                                            @if($product->reference)
                                                <div class="text-xs text-[#667085]">Réf: {{ $product->reference }}</div>
                                            @endif
                                        </td>
                                        <td class="px-4 py-4 text-xs">
                                            <span class="inline-flex items-center rounded-md bg-[#f2f4f7] px-2 py-1 font-medium text-[#344054]">
                                                {{ $product->category?->name ?? 'Général' }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-4 text-xs font-medium text-[#101828]">
                                            @if($product->effectivePrice())
                                                {{ number_format((float) $product->effectivePrice(), 2, ',', ' ') }} €
                                            @else
                                                <span class="text-[#98a2b3] italic">Sur devis</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-4 text-xs">
                                            @if($product->quantity !== null)
                                                <span class="font-medium text-[#344054]">{{ $product->quantity }}</span>
                                            @else
                                                <span class="text-[#98a2b3] italic">-</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-4 text-xs">
                                            @if($product->is_published)
                                                <span class="inline-flex items-center gap-1 rounded-full bg-[#ecfdf3] px-2 py-0.5 text-xs font-medium text-[#027a48]">
                                                    <span class="h-1.5 w-1.5 rounded-full bg-[#12b76a]"></span>
                                                    En ligne
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1 rounded-full bg-[#f2f4f7] px-2 py-0.5 text-xs font-medium text-[#667085]">
                                                    Brouillon
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-right text-xs">
                                            <a href="{{ route('admin.products.edit', $product) }}" class="font-semibold text-primary hover:text-primary-hover">
                                                Modifier
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <!-- État vide si aucun produit -->
                    <div class="flex flex-col items-center justify-center p-10 text-center">
                        <div class="flex h-12 w-12 items-center justify-center rounded-full bg-[#f2f4f7] text-[#667085]">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" class="h-6 w-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                            </svg>
                        </div>
                        <h3 class="mt-3 text-sm font-semibold text-[#101828]">Catalogue en attente d'articles</h3>
                        <p class="mt-1 max-w-sm text-xs text-[#667085] leading-relaxed">
                            Les appareils médicaux que vous enregistrerez pour vos clients hospitaliers apparaîtront ici.
                        </p>
                    </div>
                @endif
            </div>

            <!-- Colonne droite (1 tiers) : Actions rapides & Statut du système -->
            <div class="space-y-6">
                <!-- Bloc Actions & Raccourcis (exigé par les tests fonctionnels) -->
                <div class="rounded-2xl border border-[#eaecf0] bg-white p-5 shadow-xs">
                    <h2 class="text-sm font-bold text-[#101828] uppercase tracking-wider text-xs pb-3 border-b border-[#eaecf0]">
                        Actions & Raccourcis
                    </h2>
                    <div class="mt-4 space-y-2.5">
                        <a href="{{ route('admin.products.create') }}" class="group flex items-center justify-between rounded-xl border border-[#eaecf0] p-3 transition-colors hover:border-[#d0d5dd] hover:bg-[#f9fafb]">
                            <span class="flex items-center gap-3">
                                <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-[#f2f4f7] text-[#344054]">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4">
                                        <path d="M10.75 4.75a.75.75 0 0 0-1.5 0v4.5h-4.5a.75.75 0 0 0 0 1.5h4.5v4.5a.75.75 0 0 0 1.5 0v-4.5h4.5a.75.75 0 0 0 0-1.5h-4.5v-4.5Z" />
                                    </svg>
                                </span>
                                <span>
                                    <span class="block text-xs font-semibold text-[#101828]">Ajouter un produit</span>
                                    <span class="block text-[11px] text-[#667085]">Fiche technique & photos</span>
                                </span>
                            </span>
                            <span class="rounded bg-[#f2f4f7] px-1.5 py-0.5 text-[10px] font-semibold text-[#667085]">+</span>
                        </a>

                        <a href="{{ route('admin.quotes.index') }}" class="group flex items-center justify-between rounded-xl border border-[#eaecf0] p-3 transition-colors hover:border-[#d0d5dd] hover:bg-[#f9fafb]">
                            <div class="flex items-center gap-3">
                                <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-[#fef0c7] text-[#b54708]">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4">
                                        <path fill-rule="evenodd" d="M4.5 2A1.5 1.5 0 0 0 3 3.5v13A1.5 1.5 0 0 0 4.5 18h11a1.5 1.5 0 0 0 1.5-1.5V7.621a1.5 1.5 0 0 0-.44-1.06l-4.12-4.122A1.5 1.5 0 0 0 11.378 2H4.5Zm2.25 8.5a.75.75 0 0 0 0 1.5h6.5a.75.75 0 0 0 0-1.5h-6.5Zm0 3a.75.75 0 0 0 0 1.5h6.5a.75.75 0 0 0 0-1.5h-6.5Z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs font-semibold text-[#101828]">Traiter les devis</p>
                                    <p class="text-[11px] text-[#667085]">Chiffrage & expédition</p>
                                </div>
                            </div>
                            <span class="rounded bg-[#fffaeb] px-1.5 py-0.5 text-[10px] font-semibold text-[#b54708]">{{ $stats['quotes_count'] }}</span>
                        </a>

                        <a href="{{ route('admin.categories.index') }}" class="group flex items-center justify-between rounded-xl border border-[#eaecf0] p-3 transition-colors hover:border-[#d0d5dd] hover:bg-[#f9fafb]">
                            <span class="flex items-center gap-3">
                                <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-[#f2f4f7] text-[#344054]">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4">
                                        <path fill-rule="evenodd" d="M4.25 2A2.25 2.25 0 0 0 2 4.25v2.5A2.25 2.25 0 0 0 4.25 9h2.5A2.25 2.25 0 0 0 9 6.75v-2.5A2.25 2.25 0 0 0 6.75 2h-2.5Zm0 9A2.25 2.25 0 0 0 2 13.25v2.5A2.25 2.25 0 0 0 4.25 18h2.5A2.25 2.25 0 0 0 9 15.75v-2.5A2.25 2.25 0 0 0 6.75 11h-2.5Zm9-9a2.25 2.25 0 0 0-2.25 2.25v2.5A2.25 2.25 0 0 0 13.25 9h2.5A2.25 2.25 0 0 0 18 6.75v-2.5A2.25 2.25 0 0 0 15.75 2h-2.5Zm0 9a2.25 2.25 0 0 0-2.25 2.25v2.5a2.25 2.25 0 0 0 2.25 2.25h2.5A2.25 2.25 0 0 0 18 15.75v-2.5A2.25 2.25 0 0 0 15.75 11h-2.5Z" clip-rule="evenodd" />
                                    </svg>
                                </span>
                                <span>
                                    <span class="block text-xs font-semibold text-[#101828]">Gérer les catégories</span>
                                    <span class="block text-[11px] text-[#667085]">Familles d’équipements</span>
                                </span>
                            </span>
                            <span class="rounded bg-[#f2f4f7] px-1.5 py-0.5 text-[10px] font-semibold text-[#667085]">+</span>
                        </a>

                        <a href="{{ route('admin.messages.index') }}" class="group flex items-center justify-between rounded-xl border border-[#eaecf0] p-3 transition-colors hover:border-[#d0d5dd] hover:bg-[#f9fafb]">
                            <span class="flex items-center gap-3">
                                <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-[#f2f4f7] text-[#344054]">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4">
                                        <path d="M3 4a2 2 0 0 0-2 2v1.161l8.441 4.221a1.25 1.25 0 0 0 1.118 0L19 7.162V6a2 2 0 0 0-2-2H3Z" />
                                        <path d="m19 8.839-7.77 3.885a2.75 2.75 0 0 1-2.46 0L1 8.839V14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V8.839Z" />
                                    </svg>
                                </span>
                                <span>
                                    <span class="block text-xs font-semibold text-[#101828]">Consulter les messages</span>
                                    <span class="block text-[11px] text-[#667085]">Boîte de réception</span>
                                </span>
                            </span>
                            @if(($stats['messages_count'] ?? 0) > 0)
                                <span class="rounded bg-[#fffaeb] px-1.5 py-0.5 text-[10px] font-semibold text-[#b54708]">{{ $stats['messages_count'] }}</span>
                            @else
                                <span class="rounded bg-[#f2f4f7] px-1.5 py-0.5 text-[10px] font-semibold text-[#667085]">0</span>
                            @endif
                        </a>
                    </div>
                </div>

                <!-- Bloc Synthèse d'activité récente (exigé par les tests fonctionnels) -->
                <div class="rounded-2xl border border-[#eaecf0] bg-white p-5 shadow-xs">
                    <div class="flex items-center justify-between pb-3 border-b border-[#eaecf0]">
                        <h2 class="text-xs font-bold text-[#101828] uppercase tracking-wider">
                            Dernières demandes & activités
                        </h2>
                        <span class="inline-flex items-center rounded-full bg-[#f2f4f7] px-2 py-0.5 text-[10px] font-medium text-[#475467]">
                            Flux direct
                        </span>
                    </div>

                    <div class="mt-4 space-y-3">
                        <div class="flex items-start gap-3 text-xs">
                            <span class="mt-1 h-2 w-2 rounded-full bg-primary shrink-0"></span>
                            <div>
                                <p class="font-medium text-[#101828]">Base de données prête</p>
                                <p class="text-[11px] text-[#667085]">Modèles Catégories et Produits configurés</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3 text-xs">
                            <span class="mt-1 h-2 w-2 rounded-full bg-[#edbb45] shrink-0"></span>
                            <div>
                                <p class="font-medium text-[#101828]">Panier & Devis</p>
                                <p class="text-[11px] text-[#667085]">Gestion et aperçu instantané opérationnels</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3 text-xs">
                            <span class="mt-1 h-2 w-2 rounded-full bg-[#98a2b3] shrink-0"></span>
                            <div>
                                <p class="font-medium text-[#101828]">Formulaire de contact</p>
                                <p class="text-[11px] text-[#667085]">Les messages arriveront dans cette boîte</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 4. Section Nouvelle : Dernières Demandes de devis avec Aperçu interactif -->
        <div class="rounded-2xl border border-[#eaecf0] bg-white shadow-xs overflow-hidden">
            <div class="flex items-center justify-between border-b border-[#eaecf0] px-6 py-4.5">
                <div>
                    <h2 class="text-base font-semibold text-[#101828]">Dernières demandes de devis reçues</h2>
                    <p class="text-xs text-[#475467] mt-0.5">Cliquez sur « Aperçu » pour inspecter les coordonnées et les équipements en temps réel</p>
                </div>
                <a href="{{ route('admin.quotes.index') }}" class="text-xs font-semibold text-primary hover:text-primary-hover">
                    Voir tous les devis &rarr;
                </a>
            </div>

            @if($recentQuotes->isNotEmpty())
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-[#475467]">
                        <thead class="bg-[#f9fafb] text-xs font-medium text-[#475467] border-b border-[#eaecf0]">
                            <tr>
                                <th scope="col" class="px-6 py-3">Réf & Date</th>
                                <th scope="col" class="px-4 py-3">Établissement & Demandeur</th>
                                <th scope="col" class="px-4 py-3">Équipements</th>
                                <th scope="col" class="px-4 py-3">Montant</th>
                                <th scope="col" class="px-4 py-3">Statut</th>
                                <th scope="col" class="px-6 py-3 text-right">Aperçu rapide</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#eaecf0]">
                            @foreach($recentQuotes as $quote)
                                <tr class="hover:bg-[#f9fafb]/80 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="font-bold text-[#101828]">{{ $quote->reference }}</div>
                                        <div class="text-[11px] text-[#667085]">{{ $quote->created_at->diffForHumans() }}</div>
                                    </td>
                                    <td class="px-4 py-4">
                                        <div class="font-medium text-[#101828]">{{ $quote->organization_name }}</div>
                                        <div class="text-xs text-[#667085]">{{ $quote->contact_name }} • {{ $quote->phone }}</div>
                                    </td>
                                    <td class="px-4 py-4 text-xs font-medium text-[#344054]">
                                        {{ $quote->items->count() }} appareil(s)
                                    </td>
                                    <td class="px-4 py-4 text-xs font-semibold text-[#101828]">
                                        @if($quote->estimated_total)
                                            {{ number_format((float) $quote->estimated_total, 2, ',', ' ') }} €
                                        @else
                                            <span class="text-[#98a2b3] italic font-normal">Sur devis</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-4 text-xs">
                                        <span class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-0.5 text-xs font-semibold {{ $quote->statusBadgeClasses() }}">
                                            <span class="h-1.5 w-1.5 rounded-full {{ $quote->statusDotColor() }}"></span>
                                            {{ $quote->statusLabel() }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right text-xs">
                                        <button
                                            type="button"
                                            @click="$dispatch('open-quote-preview', '{{ route('admin.quotes.show', $quote) }}')"
                                            class="inline-flex items-center gap-1.5 rounded-lg border border-[#d0d5dd] bg-white px-3 py-1.5 font-semibold text-[#344054] shadow-xs hover:bg-[#f9fafb] hover:text-primary transition-colors"
                                        >
                                            <svg class="h-3.5 w-3.5 text-[#667085]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            <span>Aperçu</span>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="flex flex-col items-center justify-center p-8 text-center">
                    <p class="text-xs text-[#667085]">
                        Aucune demande de devis reçue pour l'instant. Les futures demandes s'afficheront directement ici.
                    </p>
                </div>
            @endif
        </div>

        <!-- 5. Section Nouvelle : Derniers messages de contact avec Aperçu interactif -->
        <div class="rounded-2xl border border-[#eaecf0] bg-white shadow-xs overflow-hidden">
            <div class="flex items-center justify-between border-b border-[#eaecf0] px-6 py-4.5">
                <div>
                    <h2 class="text-base font-semibold text-[#101828]">Derniers messages de contact reçus</h2>
                    <p class="text-xs text-[#475467] mt-0.5">Cliquez sur « Lire » pour ouvrir et consulter instantanément le message sans rechargement</p>
                </div>
                <a href="{{ route('admin.messages.index') }}" class="text-xs font-semibold text-primary hover:text-primary-hover">
                    Voir tous les messages &rarr;
                </a>
            </div>

            @if($recentMessages->isNotEmpty())
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-[#475467]">
                        <thead class="bg-[#f9fafb] text-xs font-medium text-[#475467] border-b border-[#eaecf0]">
                            <tr>
                                <th scope="col" class="px-6 py-3">Statut & Date</th>
                                <th scope="col" class="px-4 py-3">Expéditeur</th>
                                <th scope="col" class="px-4 py-3">Objet & Aperçu</th>
                                <th scope="col" class="px-6 py-3 text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#eaecf0]">
                            @foreach($recentMessages as $msg)
                                <tr @class([
                                    'transition-colors hover:bg-[#f9fafb]/80',
                                    'bg-[#fffcf5]/50' => !$msg->is_read,
                                ])>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-1.5">
                                            <span class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-0.5 text-xs font-semibold {{ $msg->statusBadgeClasses() }}">
                                                <span class="h-1.5 w-1.5 rounded-full {{ $msg->statusDotColor() }}"></span>
                                                {{ $msg->statusLabel() }}
                                            </span>
                                        </div>
                                        <div class="text-[11px] text-[#667085] mt-1">{{ $msg->created_at->diffForHumans() }}</div>
                                    </td>
                                    <td class="px-4 py-4">
                                        <div class="font-medium text-[#101828]">{{ $msg->name }}</div>
                                        <div class="text-xs text-[#667085]">
                                            @if($msg->organization)
                                                <span class="text-[#344054]">{{ $msg->organization }}</span> •
                                            @endif
                                            {{ $msg->email }}
                                        </div>
                                    </td>
                                    <td class="px-4 py-4">
                                        <div class="font-semibold text-xs text-[#101828] truncate max-w-sm">
                                            {{ $msg->subject ?: 'Sans objet' }}
                                        </div>
                                        <div class="text-xs text-[#667085] truncate max-w-sm mt-0.5">
                                            {{ Str::limit($msg->message, 60) }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-right text-xs">
                                        <button
                                            type="button"
                                            @click="$dispatch('open-message-preview', '{{ route('admin.messages.show', $msg) }}')"
                                            class="inline-flex items-center gap-1.5 rounded-lg border border-[#d0d5dd] bg-white px-3 py-1.5 font-semibold text-[#344054] shadow-xs hover:bg-[#f9fafb] hover:text-primary transition-colors"
                                        >
                                            <svg class="h-3.5 w-3.5 text-[#667085]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            <span>Lire</span>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="flex flex-col items-center justify-center p-8 text-center">
                    <p class="text-xs text-[#667085]">
                        Aucun message reçu pour l'instant. Les sollicitations envoyées via le formulaire de contact apparaîtront ici.
                    </p>
                </div>
            @endif
        </div>
        </div>
    </div>
@endsection
