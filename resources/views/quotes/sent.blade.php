@extends('layouts.public')

@section('title', 'Demande envoyée')
@section('meta_description', 'Votre demande de devis a été enregistrée — Référence Médico Sarl.')

@php
    $items = $quote?->items ?? collect();
@endphp

@section('content')
<div class="bg-white py-12 sm:py-16">
    <div class="mx-auto max-w-xl px-4 sm:px-6">
        {{-- En-tête statut centré --}}
        <div class="text-center">
            <div class="mx-auto flex h-12 w-12 items-center justify-center text-[#029e55]">
                <svg class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                </svg>
            </div>

            <h1 class="mt-4 text-2xl font-extrabold tracking-tight text-[#1d2939] sm:text-3xl">
                Votre demande a bien été envoyée
            </h1>
            <p class="mt-2 text-sm text-[#667085] sm:text-base">
                Notre équipe va étudier votre sélection et vous recontacter
            </p>

            <div class="mt-4 inline-flex items-center gap-2 rounded-xl border border-[#e4e7ec] bg-white px-3.5 py-2 text-xs text-[#667085]">
                <span>Référence :</span>
                <span id="quote-reference-value" class="font-bold text-[#1d2939]">{{ $reference }}</span>
                <button
                    id="copy-ref-btn"
                    type="button"
                    class="ml-1 inline-flex items-center gap-1 rounded-md border border-[#e4e7ec] bg-white px-2 py-0.5 text-[11px] font-semibold text-[#1d2939] transition-[background-color,color] duration-150 hover:border-[#029e55] hover:text-[#029e55] active:scale-[0.97]"
                    title="Copier la référence"
                >
                    <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                    </svg>
                    <span id="copy-ref-label">Copier</span>
                </button>
            </div>
        </div>

        {{-- Votre sélection --}}
        <div class="mt-10">
            <h2 class="text-base font-bold tracking-tight text-[#1d2939]">Votre sélection</h2>

            <ul class="mt-4 divide-y divide-[#e4e7ec] border-y border-[#e4e7ec]">
                @forelse ($items as $item)
                    @php
                        $image = $item->product?->coverImage?->path ?? $item->product?->meta_image;
                    @endphp
                    <li class="flex items-center gap-4 py-3.5">
                        <div class="flex h-14 w-14 shrink-0 items-center justify-center overflow-hidden rounded-lg border border-[#e4e7ec] bg-white p-1">
                            @if ($image)
                                <img src="{{ asset('storage/'.$image) }}" alt="" class="h-full w-full object-contain" loading="lazy">
                            @else
                                <span class="text-[10px] font-semibold text-[#98a2b3]">Réf.</span>
                            @endif
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="truncate text-sm font-semibold text-[#1d2939]">{{ $item->product_name }}</p>
                            <p class="mt-0.5 text-xs text-[#667085]">Quantité : {{ $item->quantity }}</p>
                        </div>
                    </li>
                @empty
                    <li class="py-3 text-xs text-[#667085]">
                        Sélection transmise pour étude personnalisée.
                    </li>
                @endforelse
            </ul>
        </div>

        {{-- 3 étapes du processus --}}
        <div class="mt-10 border-t border-[#e4e7ec] pt-8">
            <div class="grid grid-cols-3 gap-2 text-center sm:gap-4">
                {{-- Étape 1 : Active / Terminée --}}
                <div class="flex flex-col items-center">
                    <div class="flex h-8 w-8 items-center justify-center rounded-full bg-[#0f172a] text-white">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <p class="mt-2 text-xs font-bold text-[#1d2939]">Demande reçue</p>
                </div>

                {{-- Étape 2 : À venir --}}
                <div class="flex flex-col items-center">
                    <div class="flex h-8 w-8 items-center justify-center rounded-full border border-[#e4e7ec] bg-white text-xs font-semibold text-[#98a2b3]">
                        2
                    </div>
                    <p class="mt-2 text-xs text-[#667085]">Étude du besoin</p>
                </div>

                {{-- Étape 3 : À venir --}}
                <div class="flex flex-col items-center">
                    <div class="flex h-8 w-8 items-center justify-center rounded-full border border-[#e4e7ec] bg-white text-xs font-semibold text-[#98a2b3]">
                        3
                    </div>
                    <p class="mt-2 text-xs text-[#667085]">Proposition de devis</p>
                </div>
            </div>
        </div>

        {{-- Actions --}}
        <div class="mt-8 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-center">
            <a
                href="{{ route('quotes.track', ['reference' => $reference, 'email' => $quote?->email]) }}"
                class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#0f172a] px-6 py-3.5 text-sm font-semibold text-white transition-[transform,background-color] duration-150 ease-out active:scale-[0.97]"
            >
                <span>Suivre ma demande</span>
                <span aria-hidden="true">&rarr;</span>
            </a>

            <a
                href="{{ route('catalogue') }}"
                class="inline-flex items-center justify-center rounded-xl border border-[#e4e7ec] bg-white px-6 py-3.5 text-sm font-semibold text-[#1d2939] transition-[transform,background-color,border-color] duration-150 ease-out hover:border-[#98a2b3] active:scale-[0.97]"
            >
                Retour au catalogue
            </a>
        </div>

        {{-- Contact direct --}}
        <div class="mt-10 text-center">
            <p class="text-xs text-[#667085]">Une question ? Contactez-nous</p>
            <a
                href="tel:+237699850500"
                class="mt-1.5 inline-flex items-center justify-center gap-1.5 text-sm font-bold text-[#1d2939] transition-colors duration-150 hover:text-[#029e55]"
            >
                <svg class="h-4 w-4 shrink-0 text-[#029e55]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                </svg>
                <span>+237 699 850 500</span>
            </a>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const refValue = @js($reference);
        const copyRefBtn = document.getElementById('copy-ref-btn');
        const copyRefLabel = document.getElementById('copy-ref-label');

        if (! copyRefBtn || ! copyRefLabel) {
            return;
        }

        copyRefBtn.addEventListener('click', async function () {
            try {
                await navigator.clipboard.writeText(refValue);
                copyRefLabel.textContent = 'Copié !';
                setTimeout(function () {
                    copyRefLabel.textContent = 'Copier';
                }, 2200);
            } catch (e) {
                // Le texte de la référence reste sélectionnable.
            }
        });
    });
</script>
@endsection
