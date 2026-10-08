@extends('admin.layout')

@section('title', 'Catégories')

@section('content')
    <div class="space-y-6">
        <!-- En-tête de section -->
        <section class="flex flex-col gap-4 border-b border-[#eaecf0] pb-6 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <div class="flex items-center gap-2.5">
                    <h1 class="text-2xl font-bold tracking-tight text-[#101828] sm:text-[28px]">Catégories</h1>
                    <span class="inline-flex items-center rounded-full bg-[#f2f4f7] px-2.5 py-0.5 text-xs font-semibold text-[#344054]">
                        {{ $categories->total() }} au total
                    </span>
                </div>
                <p class="mt-1 text-sm text-[#475467]">
                    Structurez l’arborescence des appareils médicaux proposés aux hôpitaux et cliniques.
                </p>
            </div>

            <div class="flex items-center gap-3">
                <a
                    href="{{ route('admin.products.index') }}"
                    class="inline-flex items-center gap-2 rounded-xl border border-[#d0d5dd] bg-white px-3.5 py-2 text-xs font-semibold text-[#344054] shadow-xs transition-colors hover:bg-[#f9fafb] hover:text-[#1d2939] sm:text-sm"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4 text-[#667085]">
                        <path fill-rule="evenodd" d="M9.75 3a.75.75 0 0 1 .75.75v12.5a.75.75 0 0 1-1.5 0V3.75a.75.75 0 0 1 .75-.75ZM3 9.75a.75.75 0 0 1 .75-.75h12.5a.75.75 0 0 1 0 1.5H3.75A.75.75 0 0 1 3 9.75Z" clip-rule="evenodd" />
                    </svg>
                    <span>Voir les produits</span>
                </a>
                <a
                    href="{{ route('admin.categories.create') }}"
                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-primary px-3.5 py-2 text-xs font-semibold text-white shadow-xs transition-colors hover:bg-primary-hover focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary sm:text-sm"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4" aria-hidden="true">
                        <path d="M10.75 4.75a.75.75 0 0 0-1.5 0v4.5h-4.5a.75.75 0 0 0 0 1.5h4.5v4.5a.75.75 0 0 0 1.5 0v-4.5h4.5a.75.75 0 0 0 0-1.5h-4.5v-4.5Z" />
                    </svg>
                    <span>Nouvelle catégorie</span>
                </a>
            </div>
        </section>

        <!-- Barre de recherche -->
        <form method="GET" action="{{ route('admin.categories.index') }}" class="flex flex-col gap-3 sm:flex-row sm:items-center">
            <label for="category-search" class="sr-only">Rechercher une catégorie</label>
            <div class="relative w-full max-w-md">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-[#98a2b3]">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4" aria-hidden="true">
                        <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 1 0 0 11 5.5 5.5 0 0 0 0-11ZM2 9a7 7 0 1 1 12.452 4.391l3.328 3.329a.75.75 0 1 1-1.06 1.06l-3.329-3.328A7 7 0 0 1 2 9Z" clip-rule="evenodd" />
                    </svg>
                </div>
                <input
                    type="search"
                    id="category-search"
                    name="q"
                    value="{{ $search }}"
                    placeholder="Rechercher par nom de catégorie..."
                    class="w-full rounded-xl border border-[#d0d5dd] bg-white py-2.5 pr-3 pl-9.5 text-sm text-[#101828] placeholder:text-[#98a2b3] shadow-xs outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/15"
                >
            </div>
            <div class="flex items-center gap-2">
                <button type="submit" class="cursor-pointer rounded-xl border border-[#d0d5dd] bg-white px-4 py-2.5 text-sm font-semibold text-[#344054] shadow-xs transition-colors hover:bg-[#f9fafb] hover:text-[#101828]">
                    Rechercher
                </button>
                @if ($search !== '')
                    <a href="{{ route('admin.categories.index') }}" class="rounded-xl px-3 py-2.5 text-sm font-semibold text-[#667085] hover:text-[#101828]">
                        Réinitialiser
                    </a>
                @endif
            </div>
        </form>

        <!-- Tableau des catégories -->
        <section class="overflow-hidden rounded-2xl border border-[#eaecf0] bg-white shadow-xs">
            <div class="flex items-center justify-between border-b border-[#eaecf0] px-6 py-4">
                <h2 class="text-base font-semibold text-[#101828]">Familles médicales</h2>
                <span class="text-xs font-semibold text-[#667085]">{{ $categories->total() }} catégorie(s)</span>
            </div>

            @if ($categories->isEmpty())
                <div class="flex flex-col items-center justify-center px-6 py-16 text-center">
                    <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-[#f2f4f7] text-[#667085]">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" class="h-7 w-7" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 0 1 0 3.75H5.625a1.875 1.875 0 0 1 0-3.75Z" />
                        </svg>
                    </div>
                    <h3 class="mt-3.5 text-base font-semibold text-[#101828]">
                        {{ $search !== '' ? 'Aucune catégorie ne correspond à cette recherche.' : 'Aucune catégorie pour le moment.' }}
                    </h3>
                    <p class="mt-1 max-w-sm text-xs leading-relaxed text-[#667085]">
                        Un produit doit appartenir à une catégorie. Créez la première famille du catalogue.
                    </p>
                    <div class="mt-5">
                        <a
                            href="{{ route('admin.categories.create') }}"
                            class="inline-flex items-center gap-2 rounded-xl bg-primary px-3.5 py-2 text-xs font-semibold text-white shadow-xs transition-colors hover:bg-primary-hover"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4">
                                <path d="M10.75 4.75a.75.75 0 0 0-1.5 0v4.5h-4.5a.75.75 0 0 0 0 1.5h4.5v4.5a.75.75 0 0 0 1.5 0v-4.5h4.5a.75.75 0 0 0 0-1.5h-4.5v-4.5Z" />
                            </svg>
                            <span>Créer une première catégorie</span>
                        </a>
                    </div>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-[#475467]">
                        <thead class="border-b border-[#eaecf0] bg-[#f9fafb] text-xs font-medium text-[#475467]">
                            <tr>
                                <th scope="col" class="px-6 py-3.5">Catégorie</th>
                                <th scope="col" class="px-4 py-3.5">Slug</th>
                                <th scope="col" class="px-4 py-3.5 text-center">Équipements</th>
                                <th scope="col" class="px-4 py-3.5">Statut</th>
                                <th scope="col" class="px-6 py-3.5 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#eaecf0]">
                            @foreach ($categories as $category)
                                <tr class="transition-colors hover:bg-[#f9fafb]/80">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3.5">
                                            @if ($category->image)
                                                <img
                                                    src="{{ Storage::disk('public')->url($category->image) }}"
                                                    alt="{{ $category->image_alt }}"
                                                    class="h-12 w-12 rounded-xl border border-[#eaecf0] object-cover shadow-2xs"
                                                >
                                            @else
                                                <span class="flex h-12 w-12 items-center justify-center rounded-xl border border-[#eaecf0] bg-[#f8fafc] text-xs font-bold text-[#667085]" aria-hidden="true">
                                                    {{ mb_strtoupper(mb_substr($category->name, 0, 2)) }}
                                                </span>
                                            @endif
                                            <div class="min-w-0">
                                                <div class="truncate font-semibold text-[#101828]">{{ $category->name }}</div>
                                                @if ($category->description)
                                                    <p class="truncate text-xs text-[#667085] max-w-xs">{{ $category->description }}</p>
                                                @else
                                                    <span class="text-[11px] text-[#98a2b3] italic">Sans description</span>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 text-xs font-mono text-[#667085]">
                                        {{ $category->slug }}
                                    </td>
                                    <td class="px-4 py-4 text-center">
                                        <span class="inline-flex items-center rounded-md bg-[#f2f4f7] px-2.5 py-1 text-xs font-semibold text-[#344054]">
                                            {{ $category->products_count }} {{ $category->products_count > 1 ? 'appareils' : 'appareil' }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-4">
                                        @if ($category->is_published)
                                            <span class="inline-flex items-center gap-1.5 rounded-full bg-[#ecfdf3] px-2.5 py-0.5 text-xs font-medium text-[#027a48] border border-[#a6f4c5]">
                                                <span class="h-1.5 w-1.5 rounded-full bg-[#12b76a]"></span>
                                                Publiée
                                            </span>
                                        @else
                                            <span class="inline-flex items-center rounded-full bg-[#f2f4f7] px-2.5 py-0.5 text-xs font-medium text-[#667085] border border-[#e4e7ec]">
                                                Masquée
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-end gap-3">
                                            <a
                                                href="{{ route('admin.categories.edit', $category) }}"
                                                class="font-semibold text-xs text-primary transition-colors hover:text-primary-hover"
                                            >
                                                Modifier
                                            </a>
                                            @if ($category->products_count < 1)
                                                <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" onsubmit="return confirm('Supprimer cette catégorie ?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="cursor-pointer text-xs font-semibold text-[#d92d20] transition-colors hover:text-[#b42318]">
                                                        Supprimer
                                                    </button>
                                                </form>
                                            @else
                                                <span class="text-xs text-[#98a2b3] cursor-not-allowed" title="Contient des produits">
                                                    Liée
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if ($categories->hasPages())
                    <div class="border-t border-[#eaecf0] px-6 py-4">
                        {{ $categories->links() }}
                    </div>
                @endif
            @endif
        </section>
    </div>
@endsection
