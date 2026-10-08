@extends('admin.layout')

@section('title', 'Détails du devis ' . $quote->reference)

@section('content')
    <div class="max-w-4xl mx-auto space-y-6">
        <div class="flex items-center justify-between">
            <a href="{{ route('admin.quotes.index') }}" class="inline-flex items-center gap-2 text-xs font-semibold text-[#667085] hover:text-[#101828]">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                <span>Retour aux devis</span>
            </a>

            <span class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-0.5 text-xs font-semibold {{ $quote->statusBadgeClasses() }}">
                <span class="h-1.5 w-1.5 rounded-full {{ $quote->statusDotColor() }}"></span>
                {{ $quote->statusLabel() }}
            </span>
        </div>

        <div class="rounded-2xl border border-[#eaecf0] bg-white p-6 shadow-xs space-y-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between border-b border-[#eaecf0] pb-5">
                <div>
                    <h1 class="text-xl font-bold text-[#101828]">Devis {{ $quote->reference }}</h1>
                    <p class="text-xs text-[#667085] mt-1">Reçu le {{ $quote->created_at->format('d/m/Y à H:i') }}</p>
                </div>
                <div class="mt-4 sm:mt-0 text-left sm:text-right">
                    <span class="text-xs text-[#667085] block">Montant indicatif</span>
                    <span class="text-lg font-bold text-primary">
                        {{ $quote->estimated_total ? number_format((float) $quote->estimated_total, 2, ',', ' ') . ' €' : 'Sur devis' }}
                    </span>
                </div>
            </div>

            <!-- Client & Contact -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 bg-[#f9fafb] p-5 rounded-xl border border-[#eaecf0]">
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-[#667085] block mb-2">Établissement</span>
                    <h3 class="font-bold text-sm text-[#101828]">{{ $quote->organization_name }}</h3>
                    @if($quote->organization_type)
                        <span class="inline-block rounded bg-white px-2 py-0.5 text-[11px] font-medium text-[#475467] border border-[#e4e7ec] mt-1">
                            {{ $quote->organization_type }}
                        </span>
                    @endif
                    <p class="text-xs text-[#667085] mt-2">
                        {{ implode(', ', array_filter([$quote->address, $quote->postal_code, $quote->city])) ?: 'Adresse non renseignée' }}
                    </p>
                </div>

                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-[#667085] block mb-2">Interlocuteur</span>
                    <h3 class="font-bold text-sm text-[#101828]">{{ $quote->contact_name }}</h3>
                    <div class="mt-2 space-y-1.5 text-xs">
                        <a href="mailto:{{ $quote->email }}" class="flex items-center gap-2 text-primary hover:underline">
                            <span>📧 {{ $quote->email }}</span>
                        </a>
                        <a href="tel:{{ $quote->phone }}" class="flex items-center gap-2 text-[#344054] hover:text-primary">
                            <span>📞 {{ $quote->phone }}</span>
                        </a>
                    </div>
                </div>
            </div>

            @if($quote->message)
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-[#667085] block mb-2">Message & Spécifications</span>
                    <div class="bg-[#fcfcfd] p-4 rounded-xl border border-[#eaecf0] text-xs text-[#344054] leading-relaxed whitespace-pre-line">
                        {{ $quote->message }}
                    </div>
                </div>
            @endif

            <!-- Équipements -->
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-[#667085] block mb-3">Équipements demandés</span>
                <div class="border border-[#eaecf0] rounded-xl overflow-hidden divide-y divide-[#eaecf0]">
                    @foreach($quote->items as $item)
                        <div class="p-4 flex items-center justify-between gap-4">
                            <div class="flex items-center gap-3">
                                @if($item->product?->coverImage)
                                    <img src="{{ asset('storage/' . $item->product->coverImage->file_path) }}" alt="{{ $item->product_name }}" class="h-10 w-10 rounded-lg object-cover border border-[#eaecf0]" />
                                @else
                                    <div class="h-10 w-10 rounded-lg bg-[#f2f4f7] border border-[#eaecf0] flex items-center justify-center text-[#98a2b3]">
                                        🏥
                                    </div>
                                @endif
                                <div>
                                    <div class="text-xs font-bold text-[#101828]">{{ $item->product_name }}</div>
                                    @if($item->product_reference)
                                        <div class="text-[11px] text-[#667085]">Réf: {{ $item->product_reference }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="text-right text-xs">
                                <span class="font-bold text-[#101828]">Qté: {{ $item->quantity }}</span>
                                @if($item->total_price)
                                    <span class="block text-primary font-semibold">{{ number_format((float) $item->total_price, 2, ',', ' ') }} €</span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Formulaire de statut -->
            <form action="{{ route('admin.quotes.update-status', $quote) }}" method="POST" class="border-t border-[#eaecf0] pt-6 space-y-4">
                @csrf
                @method('PUT')

                <h3 class="text-xs font-bold uppercase tracking-wider text-[#101828]">Mise à jour du statut</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-[#344054] mb-1">Statut</label>
                        <select name="status" class="w-full rounded-xl border border-[#d0d5dd] p-2 text-xs font-medium">
                            <option value="pending" @selected($quote->status === 'pending')>⏳ En attente</option>
                            <option value="processing" @selected($quote->status === 'processing')>🔍 En cours d'étude</option>
                            <option value="processed" @selected($quote->status === 'processed')>✅ Devis envoyé</option>
                            <option value="rejected" @selected($quote->status === 'rejected')>❌ Sans suite</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-[#344054] mb-1">Notes internes</label>
                        <input type="text" name="admin_notes" value="{{ old('admin_notes', $quote->admin_notes) }}" placeholder="Commentaire..." class="w-full rounded-xl border border-[#d0d5dd] p-2 text-xs" />
                    </div>
                </div>

                <div class="flex items-center justify-between pt-2">
                    <button type="submit" class="rounded-xl bg-primary px-4 py-2 text-xs font-semibold text-white hover:bg-primary-hover">
                        Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
