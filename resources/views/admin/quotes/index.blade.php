@extends('admin.layout')

@section('title', 'Demandes de devis')

@section('content')
    <div class="space-y-6">
        <!-- 1. En-tête de section -->
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between border-b border-[#eaecf0] pb-6">
            <div>
                <div class="flex items-center gap-2.5">
                    <h1 class="text-2xl font-bold tracking-tight text-[#101828]">
                        Demandes de devis
                    </h1>
                    <span class="inline-flex items-center rounded-full bg-[#f2f4f7] px-2.5 py-0.5 text-xs font-semibold text-[#344054]">
                        {{ $quotes->total() }} au total
                    </span>
                </div>
                <p class="mt-1 text-sm text-[#475467]">
                    Consultez, étudiez et répondez aux demandes d'équipements transmises par les établissements hospitaliers.
                </p>
            </div>
        </div>

        <!-- 2. Filtres par statut (tabs) & Recherche -->
        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <!-- Onglets de statut -->
            <div class="flex flex-wrap items-center gap-1.5 rounded-xl border border-[#eaecf0] bg-[#f9fafb] p-1">
                <a
                    href="{{ route('admin.quotes.index', array_filter(['search' => $search])) }}"
                    @class([
                        'rounded-lg px-3 py-1.5 text-xs font-semibold transition-colors',
                        'bg-white text-[#101828] shadow-xs' => empty($currentStatus),
                        'text-[#667085] hover:text-[#101828]' => !empty($currentStatus),
                    ])
                >
                    Tous ({{ $counts['all'] }})
                </a>
                <a
                    href="{{ route('admin.quotes.index', array_filter(['status' => 'pending', 'search' => $search])) }}"
                    @class([
                        'inline-flex items-center gap-1.5 rounded-lg px-3 py-1.5 text-xs font-semibold transition-colors',
                        'bg-white text-[#b54708] shadow-xs' => $currentStatus === 'pending',
                        'text-[#667085] hover:text-[#101828]' => $currentStatus !== 'pending',
                    ])
                >
                    <span class="h-1.5 w-1.5 rounded-full bg-[#f79009]"></span>
                    En attente ({{ $counts['pending'] }})
                </a>
                <a
                    href="{{ route('admin.quotes.index', array_filter(['status' => 'processing', 'search' => $search])) }}"
                    @class([
                        'inline-flex items-center gap-1.5 rounded-lg px-3 py-1.5 text-xs font-semibold transition-colors',
                        'bg-white text-[#175cd3] shadow-xs' => $currentStatus === 'processing',
                        'text-[#667085] hover:text-[#101828]' => $currentStatus !== 'processing',
                    ])
                >
                    <span class="h-1.5 w-1.5 rounded-full bg-[#2e90fa]"></span>
                    En cours ({{ $counts['processing'] }})
                </a>
                <a
                    href="{{ route('admin.quotes.index', array_filter(['status' => 'processed', 'search' => $search])) }}"
                    @class([
                        'inline-flex items-center gap-1.5 rounded-lg px-3 py-1.5 text-xs font-semibold transition-colors',
                        'bg-white text-[#027a48] shadow-xs' => $currentStatus === 'processed',
                        'text-[#667085] hover:text-[#101828]' => $currentStatus !== 'processed',
                    ])
                >
                    <span class="h-1.5 w-1.5 rounded-full bg-[#12b76a]"></span>
                    Traités ({{ $counts['processed'] }})
                </a>
                <a
                    href="{{ route('admin.quotes.index', array_filter(['status' => 'rejected', 'search' => $search])) }}"
                    @class([
                        'inline-flex items-center gap-1.5 rounded-lg px-3 py-1.5 text-xs font-semibold transition-colors',
                        'bg-white text-[#344054] shadow-xs' => $currentStatus === 'rejected',
                        'text-[#667085] hover:text-[#101828]' => $currentStatus !== 'rejected',
                    ])
                >
                    Sans suite ({{ $counts['rejected'] }})
                </a>
            </div>

            <!-- Formulaire de recherche -->
            <form method="GET" action="{{ route('admin.quotes.index') }}" class="flex items-center gap-2">
                @if($currentStatus)
                    <input type="hidden" name="status" value="{{ $currentStatus }}">
                @endif
                <div class="relative w-full sm:w-80">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                        <svg class="h-4 w-4 text-[#667085]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input
                        type="search"
                        name="search"
                        value="{{ $search }}"
                        placeholder="Réf, établissement, contact, e-mail..."
                        class="block w-full rounded-xl border border-[#d0d5dd] bg-white py-2 pl-9 pr-3 text-xs sm:text-sm text-[#101828] placeholder-[#667085] focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary shadow-xs"
                    >
                </div>
                <button
                    type="submit"
                    class="rounded-xl border border-[#d0d5dd] bg-white px-3.5 py-2 text-xs sm:text-sm font-semibold text-[#344054] shadow-xs hover:bg-[#f9fafb]"
                >
                    Filtrer
                </button>
                @if($search)
                    <a
                        href="{{ route('admin.quotes.index', array_filter(['status' => $currentStatus])) }}"
                        class="rounded-xl border border-[#eaecf0] bg-[#f2f4f7] px-3 py-2 text-xs font-semibold text-[#667085] hover:bg-[#e4e7ec]"
                    >
                        Effacer
                    </a>
                @endif
            </form>
        </div>

        <!-- 3. Tableau des demandes de devis -->
        <div class="rounded-2xl border border-[#eaecf0] bg-white shadow-xs overflow-hidden">
            @if($quotes->isNotEmpty())
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-[#475467]">
                        <thead class="bg-[#f9fafb] text-xs font-medium text-[#475467] border-b border-[#eaecf0]">
                            <tr>
                                <th scope="col" class="px-6 py-3.5">Référence & Date</th>
                                <th scope="col" class="px-4 py-3.5">Établissement & Contact</th>
                                <th scope="col" class="px-4 py-3.5">Équipements</th>
                                <th scope="col" class="px-4 py-3.5">Montant indicatif</th>
                                <th scope="col" class="px-4 py-3.5">Statut</th>
                                <th scope="col" class="px-6 py-3.5 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#eaecf0]">
                            @foreach($quotes as $quote)
                                <tr class="hover:bg-[#f9fafb]/80 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="font-bold text-[#101828]">{{ $quote->reference }}</div>
                                        <div class="text-xs text-[#667085] mt-0.5">
                                            {{ $quote->created_at->format('d/m/Y H:i') }}
                                        </div>
                                    </td>
                                    <td class="px-4 py-4">
                                        <div class="font-semibold text-[#101828]">{{ $quote->organization_name }}</div>
                                        <div class="text-xs text-[#667085]">
                                            {{ $quote->contact_name }} • {{ $quote->phone }}
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 text-xs">
                                        <span class="inline-flex items-center rounded-md bg-[#f2f4f7] px-2 py-1 font-medium text-[#344054]">
                                            {{ $quote->items->count() }} appareil(s)
                                        </span>
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
                                    <td class="px-6 py-4 text-right text-xs space-x-2">
                                        <!-- Bouton Déclencheur Slide-over Aperçu Temps Réel -->
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

                @if($quotes->hasPages())
                    <div class="border-t border-[#eaecf0] px-6 py-4">
                        {{ $quotes->links() }}
                    </div>
                @endif
            @else
                <div class="flex flex-col items-center justify-center p-12 text-center">
                    <div class="flex h-12 w-12 items-center justify-center rounded-full bg-[#f2f4f7] text-[#667085]">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                        </svg>
                    </div>
                    <h3 class="mt-3 text-sm font-semibold text-[#101828]">Aucune demande de devis trouvée</h3>
                    <p class="mt-1 max-w-sm text-xs text-[#667085] leading-relaxed">
                        @if($search || $currentStatus)
                            Aucun devis ne correspond à vos critères de recherche.
                        @else
                            Les demandes envoyées par les professionnels de santé depuis le panier du site apparaîtront ici.
                        @endif
                    </p>
                </div>
            @endif
        </div>
    </div>
@endsection
