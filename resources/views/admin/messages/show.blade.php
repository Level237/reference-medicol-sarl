@extends('admin.layout')

@section('title', 'Message de ' . $message->name)

@section('content')
    <div class="max-w-3xl mx-auto space-y-6">
        <div class="flex items-center justify-between">
            <a href="{{ route('admin.messages.index') }}" class="inline-flex items-center gap-2 text-xs font-semibold text-[#667085] hover:text-[#101828]">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                <span>Retour aux messages</span>
            </a>

            <div class="flex items-center gap-2">
                <span class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-0.5 text-xs font-semibold {{ $message->statusBadgeClasses() }}">
                    <span class="h-1.5 w-1.5 rounded-full {{ $message->statusDotColor() }}"></span>
                    {{ $message->statusLabel() }}
                </span>

                <form method="POST" action="{{ route('admin.messages.toggle-read', $message) }}">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="rounded-lg border border-[#eaecf0] bg-white px-2.5 py-1 text-xs font-medium text-[#344054] shadow-xs hover:bg-[#f9fafb]">
                        {{ $message->is_read ? 'Marquer comme non lu' : 'Marquer comme lu' }}
                    </button>
                </form>
            </div>
        </div>

        <div class="rounded-2xl border border-[#eaecf0] bg-white p-6 shadow-xs space-y-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between border-b border-[#eaecf0] pb-5">
                <div>
                    <h1 class="text-xl font-bold text-[#101828]">{{ $message->subject ?: 'Message sans objet' }}</h1>
                    <p class="text-xs text-[#667085] mt-1">Reçu le {{ $message->created_at->format('d/m/Y à H:i') }}</p>
                </div>
            </div>

            <!-- Expéditeur -->
            <div class="bg-[#f8fafc] p-5 rounded-xl border border-[#eaecf0] grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                <div>
                    <span class="text-[#667085] block">Nom</span>
                    <span class="font-bold text-sm text-[#101828] mt-0.5 block">{{ $message->name }}</span>
                    @if($message->organization)
                        <span class="text-[#667085] mt-1 block">Établissement: <strong class="text-[#344054]">{{ $message->organization }}</strong></span>
                    @endif
                </div>
                <div>
                    <span class="text-[#667085] block">Coordonnées</span>
                    <div class="mt-1 space-y-1">
                        <a href="mailto:{{ $message->email }}" class="text-primary hover:underline font-medium block">
                            📧 {{ $message->email }}
                        </a>
                        @if($message->phone)
                            <a href="tel:{{ $message->phone }}" class="text-[#344054] hover:text-primary font-medium block">
                                📞 {{ $message->phone }}
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Contenu -->
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-[#667085] block mb-2">Message</span>
                <div class="bg-[#fcfcfd] p-5 rounded-xl border border-[#eaecf0] text-sm text-[#1d2939] whitespace-pre-line leading-relaxed">
                    {{ $message->message }}
                </div>
            </div>

            <!-- Actions de réponse -->
            <div class="flex items-center gap-3 pt-2">
                <a
                    href="mailto:{{ $message->email }}?subject={{ rawurlencode('RE: ' . ($message->subject ?: 'Votre message')) }}"
                    class="inline-flex items-center gap-2 rounded-xl bg-primary px-4 py-2 text-xs font-semibold text-white shadow-xs hover:bg-primary-hover transition-colors"
                >
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6" />
                    </svg>
                    <span>Répondre par e-mail</span>
                </a>
            </div>

            <!-- Notes internes -->
            <form action="{{ route('admin.messages.update', $message) }}" method="POST" class="border-t border-[#eaecf0] pt-6 space-y-3">
                @csrf
                @method('PUT')
                <label class="block text-xs font-bold uppercase tracking-wider text-[#101828]">
                    Notes internes de suivi
                </label>
                <textarea
                    name="admin_notes"
                    rows="3"
                    placeholder="Commentaire de suivi..."
                    class="w-full rounded-xl border border-[#d0d5dd] p-3 text-xs text-[#101828] focus:border-primary focus:ring-1 focus:ring-primary shadow-xs"
                >{{ old('admin_notes', $message->admin_notes) }}</textarea>
                <div class="flex items-center justify-between">
                    <button type="submit" class="rounded-xl bg-[#344054] px-4 py-2 text-xs font-semibold text-white hover:bg-[#1d2939]">
                        Enregistrer les notes
                    </button>

                    <button
                        type="button"
                        onclick="if(confirm('Confirmez-vous la suppression de ce message ?')) document.getElementById('delete-message-form').submit();"
                        class="text-xs font-medium text-[#d92d20] hover:underline"
                    >
                        Supprimer le message
                    </button>
                </div>
            </form>

            <form id="delete-message-form" action="{{ route('admin.messages.destroy', $message) }}" method="POST" class="hidden">
                @csrf
                @method('DELETE')
            </form>
        </div>
    </div>
@endsection
