@extends('admin.layout')

@section('title', 'Messages de contact')

@section('content')
    <div class="space-y-6">
        <!-- 1. En-tête de section -->
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between border-b border-[#eaecf0] pb-6">
            <div>
                <div class="flex items-center gap-2.5">
                    <h1 class="text-2xl font-bold tracking-tight text-[#101828]">
                        Messages de contact
                    </h1>
                    <span class="inline-flex items-center rounded-full bg-[#f2f4f7] px-2.5 py-0.5 text-xs font-semibold text-[#344054]">
                        {{ $messages->total() }} au total
                    </span>
                </div>
                <p class="mt-1 text-sm text-[#475467]">
                    Consultez, lisez et répondez aux messages adressés via le formulaire de contact du site vitrine.
                </p>
            </div>
        </div>

        <!-- 2. Filtres par statut & Recherche -->
        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <!-- Onglets de statut -->
            <div class="flex flex-wrap items-center gap-1.5 rounded-xl border border-[#eaecf0] bg-[#f9fafb] p-1">
                <a
                    href="{{ route('admin.messages.index', array_filter(['search' => $search])) }}"
                    @class([
                        'rounded-lg px-3 py-1.5 text-xs font-semibold transition-colors',
                        'bg-white text-[#101828] shadow-xs' => empty($currentStatus),
                        'text-[#667085] hover:text-[#101828]' => !empty($currentStatus),
                    ])
                >
                    Tous ({{ $counts['all'] }})
                </a>
                <a
                    href="{{ route('admin.messages.index', array_filter(['status' => 'unread', 'search' => $search])) }}"
                    @class([
                        'inline-flex items-center gap-1.5 rounded-lg px-3 py-1.5 text-xs font-semibold transition-colors',
                        'bg-white text-[#b54708] shadow-xs' => $currentStatus === 'unread',
                        'text-[#667085] hover:text-[#101828]' => $currentStatus !== 'unread',
                    ])
                >
                    <span class="h-1.5 w-1.5 rounded-full bg-[#f79009]"></span>
                    Non lus ({{ $counts['unread'] }})
                </a>
                <a
                    href="{{ route('admin.messages.index', array_filter(['status' => 'read', 'search' => $search])) }}"
                    @class([
                        'inline-flex items-center gap-1.5 rounded-lg px-3 py-1.5 text-xs font-semibold transition-colors',
                        'bg-white text-[#344054] shadow-xs' => $currentStatus === 'read',
                        'text-[#667085] hover:text-[#101828]' => $currentStatus !== 'read',
                    ])
                >
                    <span class="h-1.5 w-1.5 rounded-full bg-[#98a2b3]"></span>
                    Lus ({{ $counts['read'] }})
                </a>
            </div>

            <!-- Formulaire de recherche -->
            <form method="GET" action="{{ route('admin.messages.index') }}" class="flex items-center gap-2">
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
                        placeholder="Nom, établissement, e-mail, objet..."
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
                        href="{{ route('admin.messages.index', array_filter(['status' => $currentStatus])) }}"
                        class="rounded-xl border border-[#eaecf0] bg-[#f2f4f7] px-3 py-2 text-xs font-semibold text-[#667085] hover:bg-[#e4e7ec]"
                    >
                        Effacer
                    </a>
                @endif
            </form>
        </div>

        <!-- 3. Tableau des messages -->
        <div class="rounded-2xl border border-[#eaecf0] bg-white shadow-xs overflow-hidden">
            @if($messages->isNotEmpty())
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-[#475467]">
                        <thead class="bg-[#f9fafb] text-xs font-medium text-[#475467] border-b border-[#eaecf0]">
                            <tr>
                                <th scope="col" class="px-6 py-3.5">Statut & Date</th>
                                <th scope="col" class="px-4 py-3.5">Expéditeur & Établissement</th>
                                <th scope="col" class="px-4 py-3.5">Objet & Extrait</th>
                                <th scope="col" class="px-6 py-3.5 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#eaecf0]">
                            @foreach($messages as $msg)
                                <tr @class([
                                    'transition-colors hover:bg-[#f9fafb]/80',
                                    'bg-[#fffcf5]/50' => !$msg->is_read,
                                ])>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2">
                                            <span class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-0.5 text-xs font-semibold {{ $msg->statusBadgeClasses() }}">
                                                <span class="h-1.5 w-1.5 rounded-full {{ $msg->statusDotColor() }}"></span>
                                                {{ $msg->statusLabel() }}
                                            </span>
                                        </div>
                                        <div class="text-[11px] text-[#667085] mt-1">
                                            {{ $msg->created_at->format('d/m/Y H:i') }}
                                        </div>
                                    </td>
                                    <td class="px-4 py-4">
                                        <div class="font-bold text-[#101828]">{{ $msg->name }}</div>
                                        @if($msg->organization)
                                            <div class="text-xs font-medium text-[#344054]">{{ $msg->organization }}</div>
                                        @endif
                                        <div class="text-xs text-[#667085]">
                                            {{ $msg->email }} @if($msg->phone) • {{ $msg->phone }} @endif
                                        </div>
                                    </td>
                                    <td class="px-4 py-4">
                                        <div class="font-semibold text-xs text-[#101828] truncate max-w-md">
                                            {{ $msg->subject ?: 'Sans objet' }}
                                        </div>
                                        <div class="text-xs text-[#667085] truncate max-w-md mt-0.5">
                                            {{ Str::limit($msg->message, 80) }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-right text-xs space-x-2">
                                        <!-- Bouton Déclencheur Slide-over Aperçu Temps Réel -->
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

                                        <form method="POST" action="{{ route('admin.messages.toggle-read', $msg) }}" class="inline-block">
                                            @csrf
                                            @method('PATCH')
                                            <button
                                                type="submit"
                                                class="rounded-lg border border-[#eaecf0] bg-[#f9fafb] px-2.5 py-1.5 text-xs font-medium text-[#475467] hover:bg-[#f2f4f7]"
                                                title="{{ $msg->is_read ? 'Marquer comme non lu' : 'Marquer comme lu' }}"
                                            >
                                                {{ $msg->is_read ? 'Marquer non lu' : 'Marquer lu' }}
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if($messages->hasPages())
                    <div class="border-t border-[#eaecf0] px-6 py-4">
                        {{ $messages->links() }}
                    </div>
                @endif
            @else
                <div class="flex flex-col items-center justify-center p-12 text-center">
                    <div class="flex h-12 w-12 items-center justify-center rounded-full bg-[#f2f4f7] text-[#667085]">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                        </svg>
                    </div>
                    <h3 class="mt-3 text-sm font-semibold text-[#101828]">Aucun message trouvé</h3>
                    <p class="mt-1 max-w-sm text-xs text-[#667085] leading-relaxed">
                        @if($search || $currentStatus)
                            Aucun message ne correspond à vos critères de recherche.
                        @else
                            Les messages envoyés par les visiteurs via le formulaire de contact apparaîtront ici.
                        @endif
                    </p>
                </div>
            @endif
        </div>
    </div>
@endsection
