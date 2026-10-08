@extends('admin.layout')

@section('title', 'Produits')

@section('content')
    <div class="space-y-6">
        <!-- En-tête de section -->
        <section class="flex flex-col gap-4 border-b border-[#eaecf0] pb-6 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <div class="flex items-center gap-2.5">
                    <h1 class="text-2xl font-bold tracking-tight text-[#101828] sm:text-[28px]">Produits</h1>
                    <span class="inline-flex items-center rounded-full bg-[#f2f4f7] px-2.5 py-0.5 text-xs font-semibold text-[#344054]">
                        {{ $products->total() }} au total
                    </span>
                </div>
                <p class="mt-1 text-sm text-[#475467]">
                    Catalogue des équipements et appareils médicaux proposés aux hôpitaux et cliniques.
                </p>
            </div>

            <div class="flex items-center gap-3">
                <a
                    href="{{ route('admin.categories.index') }}"
                    class="inline-flex items-center gap-2 rounded-xl border border-[#d0d5dd] bg-white px-3.5 py-2 text-xs font-semibold text-[#344054] shadow-xs transition-colors hover:bg-[#f9fafb] hover:text-[#1d2939] sm:text-sm"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4 text-[#667085]">
                        <path fill-rule="evenodd" d="M3.75 3A1.75 1.75 0 0 0 2 4.75v10.5c0 .966.784 1.75 1.75 1.75h12.5A1.75 1.75 0 0 0 18 15.25V4.75A1.75 1.75 0 0 0 16.25 3H3.75Zm0 1.5h12.5c.138 0 .25.112.25.25v2.25H3.5V4.75c0-.138.112-.25.25-.25ZM3.5 8.5h13v6.75a.25.25 0 0 1-.25.25H3.75a.25.25 0 0 1-.25-.25V8.5Z" clip-rule="evenodd" />
                    </svg>
                    <span>Gérer les catégories</span>
                </a>
                <a
                    href="{{ route('admin.products.create') }}"
                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-primary px-3.5 py-2 text-xs font-semibold text-white shadow-xs transition-colors hover:bg-primary-hover focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary sm:text-sm"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4" aria-hidden="true">
                        <path d="M10.75 4.75a.75.75 0 0 0-1.5 0v4.5h-4.5a.75.75 0 0 0 0 1.5h4.5v4.5a.75.75 0 0 0 1.5 0v-4.5h4.5a.75.75 0 0 0 0-1.5h-4.5v-4.5Z" />
                    </svg>
                    <span>Nouveau produit</span>
                </a>
            </div>
        </section>

        <!-- Barre de recherche -->
        <form method="GET" action="{{ route('admin.products.index') }}" class="flex flex-col gap-3 sm:flex-row sm:items-center">
            <label for="product-search" class="sr-only">Rechercher un produit</label>
            <div class="relative w-full max-w-md">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-[#98a2b3]">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4" aria-hidden="true">
                        <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 1 0 0 11 5.5 5.5 0 0 0 0-11ZM2 9a7 7 0 1 1 12.452 4.391l3.328 3.329a.75.75 0 1 1-1.06 1.06l-3.329-3.328A7 7 0 0 1 2 9Z" clip-rule="evenodd" />
                    </svg>
                </div>
                <input
                    type="search"
                    id="product-search"
                    name="q"
                    value="{{ $search }}"
                    placeholder="Rechercher par nom ou référence technique..."
                    class="w-full rounded-xl border border-[#d0d5dd] bg-white py-2.5 pr-3 pl-9.5 text-sm text-[#101828] placeholder:text-[#98a2b3] shadow-xs outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/15"
                >
            </div>
            <div class="flex items-center gap-2">
                <button type="submit" class="cursor-pointer rounded-xl border border-[#d0d5dd] bg-white px-4 py-2.5 text-sm font-semibold text-[#344054] shadow-xs transition-colors hover:bg-[#f9fafb] hover:text-[#101828]">
                    Rechercher
                </button>
                @if ($search !== '')
                    <a href="{{ route('admin.products.index') }}" class="rounded-xl px-3 py-2.5 text-sm font-semibold text-[#667085] hover:text-[#101828]">
                        Réinitialiser
                    </a>
                @endif
            </div>
        </form>

        <!-- Tableau des produits -->
        <section class="overflow-hidden rounded-2xl border border-[#eaecf0] bg-white shadow-xs">
            <div class="flex items-center justify-between border-b border-[#eaecf0] px-6 py-4">
                <h2 class="text-base font-semibold text-[#101828]">Catalogue</h2>
                <span class="text-xs font-semibold text-[#667085]">{{ $products->total() }} produit(s)</span>
            </div>

            @if ($products->isEmpty())
                <div class="flex flex-col items-center justify-center px-6 py-16 text-center">
                    <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-[#f2f4f7] text-[#667085]">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" class="h-7 w-7" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                        </svg>
                    </div>
                    <h3 class="mt-3.5 text-base font-semibold text-[#101828]">
                        {{ $search !== '' ? 'Aucun produit ne correspond à cette recherche.' : 'Aucun produit pour le moment.' }}
                    </h3>
                    <p class="mt-1 max-w-sm text-xs leading-relaxed text-[#667085]">
                        Les appareils ajoutés ici pourront ensuite être publiés sur le catalogue.
                    </p>
                    <div class="mt-5">
                        <a
                            href="{{ route('admin.products.create') }}"
                            class="inline-flex items-center gap-2 rounded-xl bg-primary px-3.5 py-2 text-xs font-semibold text-white shadow-xs transition-colors hover:bg-primary-hover"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4">
                                <path d="M10.75 4.75a.75.75 0 0 0-1.5 0v4.5h-4.5a.75.75 0 0 0 0 1.5h4.5v4.5a.75.75 0 0 0 1.5 0v-4.5h4.5a.75.75 0 0 0 0-1.5h-4.5v-4.5Z" />
                            </svg>
                            <span>Ajouter un premier équipement</span>
                        </a>
                    </div>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-[#475467]">
                        <thead class="border-b border-[#eaecf0] bg-[#f9fafb] text-xs font-medium text-[#475467]">
                            <tr>
                                <th scope="col" class="px-6 py-3.5">Produit</th>
                                <th scope="col" class="px-4 py-3.5">Catégorie</th>
                                <th scope="col" class="px-4 py-3.5">Prix indicatif</th>
                                <th scope="col" class="px-4 py-3.5">Statut</th>
                                <th scope="col" class="px-6 py-3.5 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#eaecf0]">
                            @foreach ($products as $product)
                                <tr class="transition-colors hover:bg-[#f9fafb]/80">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3.5">
                                            @if ($product->coverImage)
                                                <img
                                                    src="{{ Storage::disk('public')->url($product->coverImage->path) }}"
                                                    alt="{{ $product->coverImage->alt }}"
                                                    class="h-12 w-12 rounded-xl border border-[#eaecf0] object-cover shadow-2xs"
                                                >
                                            @else
                                                <span class="flex h-12 w-12 items-center justify-center rounded-xl border border-[#eaecf0] bg-[#f8fafc] text-xs font-bold text-[#667085]" aria-hidden="true">
                                                    {{ mb_strtoupper(mb_substr($product->name, 0, 2)) }}
                                                </span>
                                            @endif
                                            <div class="min-w-0">
                                                <div class="truncate font-semibold text-[#101828]">{{ $product->name }}</div>
                                                @if ($product->reference)
                                                    <div class="text-xs font-medium text-[#667085]">Réf. {{ $product->reference }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 text-xs">
                                        <span class="inline-flex items-center rounded-md bg-[#f2f4f7] px-2.5 py-1 font-medium text-[#344054]">
                                            {{ $product->category?->name ?? 'Général' }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-4 text-xs font-medium text-[#101828]">
                                        @if ($product->effectivePrice())
                                            <div class="font-semibold">{{ number_format((float) $product->effectivePrice(), 2, ',', ' ') }} €</div>
                                            @if ($product->compareAtPrice())
                                                <div class="font-normal text-[#98a2b3] line-through text-[11px]">
                                                    {{ number_format((float) $product->compareAtPrice(), 2, ',', ' ') }} €
                                                </div>
                                            @endif
                                        @else
                                            <span class="font-normal text-[#98a2b3] italic">Sur devis</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-4">
                                        <div class="flex flex-wrap gap-1.5">
                                            @if ($product->is_published)
                                                <span class="inline-flex items-center gap-1 rounded-full bg-[#ecfdf3] px-2.5 py-0.5 text-xs font-medium text-[#027a48] border border-[#a6f4c5]">
                                                    <span class="h-1.5 w-1.5 rounded-full bg-[#12b76a]"></span>
                                                    En ligne
                                                </span>
                                            @else
                                                <span class="inline-flex items-center rounded-full bg-[#f2f4f7] px-2.5 py-0.5 text-xs font-medium text-[#667085] border border-[#e4e7ec]">
                                                    Brouillon
                                                </span>
                                            @endif
                                            @if ($product->is_featured)
                                                <span class="inline-flex items-center rounded-full bg-[#fffaeb] px-2.5 py-0.5 text-xs font-semibold text-[#b54708] border border-[#fedf89]">
                                                    Mis en avant
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-end gap-3">
                                            <a
                                                href="{{ route('admin.products.edit', $product) }}"
                                                class="font-semibold text-xs text-primary transition-colors hover:text-primary-hover"
                                            >
                                                Modifier
                                            </a>
                                            <form method="POST" action="{{ route('admin.products.destroy', $product) }}" onsubmit="return confirm('Supprimer ce produit et ses photos ?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="cursor-pointer text-xs font-semibold text-[#d92d20] transition-colors hover:text-[#b42318]">
                                                    Supprimer
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if ($products->hasPages())
                    <div class="border-t border-[#eaecf0] px-6 py-4">
                        {{ $products->links() }}
                    </div>
                @endif
            @endif
        </section>
    </div>
@endsection
