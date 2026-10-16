@extends('layouts.public')

@section('title', 'Où en est votre demande ?')
@section('meta_description', 'Consultez rapidement l\'avancement de votre demande de devis. Référence Médico Sarl.')
@section('robots', 'noindex, nofollow')

@section('content')
<div class="bg-white">
    @unless ($searched)
        <div class="py-12 sm:py-16">
            <div class="mx-auto max-w-lg px-4 sm:px-6">
                <h1 class="text-3xl font-extrabold tracking-tight text-[#1d2939] sm:text-4xl">
                    Où en est votre demande ?
                </h1>
                <p class="mt-2 text-sm leading-relaxed text-[#667085] sm:text-base">
                    Consultez rapidement l'avancement de votre demande de devis.
                </p>

                <form action="{{ route('quotes.track') }}" method="POST" class="mt-8 space-y-5">
                    @csrf
                    <div class="flex flex-col gap-2">
                        <label for="reference" class="text-sm font-semibold text-[#1d2939]">Référence de la demande</label>
                        <input
                            id="reference"
                            name="reference"
                            type="text"
                            value="{{ $reference }}"
                            required
                            autocomplete="off"
                            spellcheck="false"
                            placeholder="DEV-EXEMPLE"
                            class="rounded-xl border border-[#e4e7ec] bg-white px-4 py-3 text-sm text-[#1d2939] outline-none transition-[border-color,box-shadow] duration-150 placeholder:text-[#667085] focus:border-[#029e55] focus:ring-2 focus:ring-[#029e55]/20"
                        >
                    </div>

                    <div class="flex flex-col gap-2">
                        <label for="email" class="text-sm font-semibold text-[#1d2939]">E-mail</label>
                        <input
                            id="email"
                            name="email"
                            type="email"
                            value="{{ $email }}"
                            required
                            autocomplete="email"
                            placeholder="contact@exemple.cm"
                            class="rounded-xl border border-[#e4e7ec] bg-white px-4 py-3 text-sm text-[#1d2939] outline-none transition-[border-color,box-shadow] duration-150 placeholder:text-[#667085] focus:border-[#029e55] focus:ring-2 focus:ring-[#029e55]/20"
                        >
                    </div>

                    @if ($lookupError || $errors->has('reference'))
                        <p class="text-sm font-medium text-[#d92d20]" role="alert">{{ $lookupError ?: $errors->first('reference') }}</p>
                    @endif

                    <button
                        type="submit"
                        class="inline-flex w-full items-center justify-center rounded-xl bg-[#0f172a] px-6 py-3.5 text-sm font-semibold text-white transition-[transform,background-color] duration-150 ease-out hover:bg-[#029e55] active:scale-[0.97] sm:w-auto"
                    >
                        Consulter le suivi
                    </button>
                </form>
            </div>
        </div>
    @else
    <section class="relative border-b border-[#e4e7ec] bg-white sm:min-h-[340px] lg:min-h-[370px]">
        <div
            class="absolute inset-0 bg-cover bg-no-repeat bg-[position:85%_center] sm:bg-[position:right_center]"
            style="background-image: url('{{ asset('assets/images/hero.png') }}');"
            aria-hidden="true"
        ></div>

        <div
            class="pointer-events-none absolute inset-0 bg-gradient-to-r from-white via-white/95 to-transparent lg:via-white/75 xl:via-white/60"
            aria-hidden="true"
        ></div>

        <div class="relative mx-auto flex max-w-7xl flex-col justify-between px-4 py-6 sm:min-h-[340px] sm:px-6 sm:py-8 lg:min-h-[370px] lg:px-8 lg:py-10">
            <nav aria-label="Fil d'Ariane" class="inline-flex items-center gap-1.5 text-xs font-medium text-[#667085]">
                <a href="{{ route('home') }}" class="text-[#029e55] transition-colors hover:underline">Accueil</a>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-[#98a2b3]" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                </svg>
                <span class="text-[#667085]">Suivi de demande</span>
            </nav>

            <div class="my-auto max-w-2xl py-4 sm:py-6">
                <h1 class="text-3xl font-extrabold tracking-tight text-[#1d2939] leading-[1.15] sm:text-4xl lg:text-[40px]">
                    Où en est votre demande ?
                </h1>
                <p class="mt-2 text-sm text-[#667085] leading-relaxed sm:text-base">
                    Consultez rapidement l'avancement de votre demande de devis.
                </p>

                <form action="{{ route('quotes.track') }}" method="POST" class="mt-5 max-w-2xl sm:mt-6">
                    @csrf
                    <div class="flex flex-col gap-2 rounded-2xl bg-white p-2 sm:p-2.5 shadow-lg shadow-black/5 ring-1 ring-[#e4e7ec] transition-all focus-within:ring-2 focus-within:ring-[#029e55] sm:flex-row sm:items-center">
                        <div class="min-w-0 flex-1 px-2 py-1">
                            <label for="reference" class="block text-[11px] font-semibold uppercase tracking-wider text-[#667085]">
                                Référence de la demande
                            </label>
                            <input
                                id="reference"
                                name="reference"
                                type="text"
                                value="{{ $reference }}"
                                required
                                autocomplete="off"
                                spellcheck="false"
                                placeholder="DEV-EXEMPLE"
                                class="mt-0.5 w-full bg-transparent text-sm font-semibold text-[#1d2939] placeholder:font-normal placeholder:text-[#667085] outline-none"
                            >
                        </div>

                        <div class="min-w-0 flex-1 px-2 py-1 sm:border-l sm:border-[#e4e7ec]">
                            <label for="email" class="block text-[11px] font-semibold uppercase tracking-wider text-[#667085]">
                                E-mail
                            </label>
                            <input
                                id="email"
                                name="email"
                                type="email"
                                value="{{ $email }}"
                                required
                                autocomplete="email"
                                placeholder="contact@exemple.cm"
                                class="mt-0.5 w-full bg-transparent text-sm font-semibold text-[#1d2939] placeholder:font-normal placeholder:text-[#667085] outline-none"
                            >
                        </div>

                        <button
                            type="submit"
                            class="shrink-0 rounded-xl bg-[#0f172a] px-5 py-3 text-sm font-semibold text-white shadow-sm transition-all duration-150 ease-out hover:bg-[#029e55] active:scale-[0.97]"
                        >
                            Consulter le suivi
                        </button>
                    </div>

                    @if ($lookupError)
                        <p class="mt-3 text-sm font-medium text-[#d92d20]">{{ $lookupError }}</p>
                    @endif
                </form>
            </div>
        </div>
    </section>

    @if ($quote)
        @php
            $steps = $quote->trackingSteps();
            $states = collect($steps)->pluck('state');
            $progressPercent = match (true) {
                $states->every(fn ($state) => $state === 'done') => 100,
                $states->contains('current') || $states->contains('cancelled') => 50,
                default => 0,
            };
        @endphp
        <section class="pb-16 pt-8 sm:pt-12" aria-labelledby="track-result-heading">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col justify-between gap-6 sm:flex-row sm:items-start">
                    <div>
                        <h2 id="track-result-heading" class="text-xl font-extrabold tracking-tight text-[#1d2939] sm:text-2xl">
                            Résultat de votre demande
                        </h2>
                        <div class="mt-2 flex flex-wrap items-center gap-x-4 gap-y-1 text-sm text-[#667085]">
                            <span>Référence : <strong class="font-bold text-[#1d2939]">{{ $quote->reference }}</strong></span>
                            <span class="hidden sm:inline text-[#e4e7ec]">•</span>
                            <span>E-mail : <strong class="font-semibold text-[#1d2939]">{{ $email }}</strong></span>
                        </div>
                    </div>

                    <div class="flex items-center gap-3 rounded-2xl border border-[#e4e7ec] bg-white p-3.5 sm:p-4 shadow-sm">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#029e55]/10 text-[#029e55]">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-[#1d2939]">{{ $quote->trackingStatusTitle() }}</p>
                            <p class="mt-0.5 text-xs text-[#667085]">{{ $quote->trackingSummary() }}</p>
                        </div>
                    </div>
                </div>

                <div class="relative mt-10">
                    <div class="relative">
                        <div class="absolute top-5 right-[16.66%] left-[16.66%] hidden h-1 rounded-full bg-[#e4e7ec] sm:block" aria-hidden="true">
                            <div
                                class="h-full rounded-full bg-[#029e55] transition-all duration-700 ease-out"
                                style="width: {{ $progressPercent }}%;"
                            ></div>
                        </div>

                        <div class="relative grid grid-cols-1 gap-6 sm:grid-cols-3 sm:gap-4">
                            @foreach ($steps as $index => $step)
                                @php
                                    $isDone = $step['state'] === 'done';
                                    $isCurrent = $step['state'] === 'current';
                                    $isCancelled = $step['state'] === 'cancelled';
                                    $isUpcoming = $step['state'] === 'upcoming';
                                    $nextState = $steps[$index + 1]['state'] ?? null;
                                    $linkReached = $isDone && in_array($nextState, ['done', 'current'], true);
                                @endphp

                                <div class="relative flex gap-4 text-left sm:flex-col sm:items-center sm:gap-0 sm:text-center">
                                    @if (! $loop->last)
                                        <div
                                            class="absolute top-10 bottom-0 left-5 -ml-px w-0.5 sm:hidden {{ $linkReached ? 'bg-[#029e55]' : 'bg-[#e4e7ec]' }}"
                                            aria-hidden="true"
                                        ></div>
                                    @endif

                                    <div class="relative z-10 flex shrink-0 items-center justify-center">
                                        @if ($isDone)
                                            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-[#029e55] text-white ring-4 ring-white">
                                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                                </svg>
                                            </div>
                                        @elseif ($isCurrent)
                                            <div class="flex h-10 w-10 items-center justify-center rounded-full border-2 border-[#029e55] bg-white text-xs font-extrabold text-[#029e55] ring-4 ring-white">
                                                {{ $step['number'] }}
                                            </div>
                                        @elseif ($isCancelled)
                                            <div class="flex h-10 w-10 items-center justify-center rounded-full border border-[#e4e7ec] bg-white text-[#667085] ring-4 ring-white">
                                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </div>
                                        @else
                                            <div class="flex h-10 w-10 items-center justify-center rounded-full border-2 border-[#e4e7ec] bg-white text-xs font-bold text-[#98a2b3] ring-4 ring-white">
                                                {{ $step['number'] }}
                                            </div>
                                        @endif
                                    </div>

                                    <div class="min-w-0 flex-1 sm:mt-4">
                                        <p @class([
                                            'text-sm tracking-tight',
                                            'font-bold text-[#1d2939]' => $isDone || $isCurrent,
                                            'font-medium text-[#667085]' => $isUpcoming || $isCancelled,
                                        ])>
                                            {{ $step['label'] }}
                                        </p>
                                        <p @class([
                                            'mt-1 text-xs',
                                            'font-semibold text-[#029e55]' => $isCurrent,
                                            'text-[#667085]' => $isDone,
                                            'text-[#98a2b3]' => $isUpcoming || $isCancelled,
                                        ])>{{ $step['subtext'] }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="mt-14 grid grid-cols-1 items-start gap-12 lg:grid-cols-12 lg:gap-16">
                    <div class="lg:col-span-7">
                        <h3 class="text-lg font-bold tracking-tight text-[#1d2939]">Récapitulatif de votre demande</h3>
                        <ul class="mt-6 space-y-6">
                            @forelse ($quote->items as $item)
                                @php
                                    $image = $item->product?->coverImage?->path ?? $item->product?->meta_image;
                                    $summary = $item->product?->summary;
                                @endphp
                                <li class="flex items-center gap-4">
                                    <div class="relative flex h-16 w-16 shrink-0 items-center justify-center overflow-hidden rounded-lg bg-[#e4e7ec]">
                                        @if ($image)
                                            <img src="{{ asset('storage/'.$image) }}" alt="" class="absolute inset-0 h-full w-full object-cover" loading="lazy">
                                        @else
                                            <span class="text-[10px] font-semibold text-[#98a2b3]">Réf.</span>
                                        @endif
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <p class="text-sm font-bold text-[#1d2939]">{{ $item->product_name }}</p>
                                        @if ($summary)
                                            <p class="mt-0.5 line-clamp-2 text-xs leading-relaxed text-[#667085]">{{ $summary }}</p>
                                        @endif
                                    </div>
                                    <div class="shrink-0 text-right">
                                        <p class="text-[11px] text-[#667085]">Quantité</p>
                                        <p class="text-sm font-medium text-[#1d2939]">{{ $item->quantity }}</p>
                                    </div>
                                </li>
                            @empty
                                <li class="text-xs text-[#667085]">Sélection transmise pour étude personnalisée.</li>
                            @endforelse
                        </ul>
                    </div>

                    <div class="lg:col-span-5">
                        <div class="flex items-start gap-3">
                            <svg class="mt-0.5 h-6 w-6 shrink-0 text-[#1d2939]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 18v-6a9 9 0 0118 0v6" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 19a2 2 0 01-2 2h-1a2 2 0 01-2-2v-3a2 2 0 012-2h3v5zM3 19a2 2 0 002 2h1a2 2 0 002-2v-3a2 2 0 00-2-2H3v5z" />
                            </svg>
                            <div class="min-w-0 flex-1">
                                <h3 class="text-lg font-bold tracking-tight text-[#1d2939]">Une précision à apporter ?</h3>
                                <p class="mt-1 text-sm leading-relaxed text-[#667085]">
                                    Notre équipe est à votre écoute pour répondre à vos questions ou compléter votre demande.
                                </p>
                                <a
                                    href="tel:+237699850500"
                                    class="mt-5 inline-flex items-center justify-center gap-2 rounded-lg bg-[#0f172a] px-5 py-3 text-sm font-semibold text-white transition-[transform] duration-150 ease-out active:scale-[0.97]"
                                >
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                    <span>Contacter l'équipe</span>
                                </a>
                                <div class="mt-5 space-y-2 text-sm">
                                    <a href="tel:+237699850500" class="flex items-center gap-2 font-medium text-[#1d2939] transition-colors hover:text-[#029e55]">
                                        <svg class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                        </svg>
                                        <span>+237 699 850 500</span>
                                    </a>
                                    <a href="mailto:lecpaarnaud@referencemedicosarl.com" class="flex items-center gap-2 text-[#667085] transition-colors hover:text-[#029e55]">
                                        <svg class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                        <span class="truncate">lecpaarnaud@referencemedicosarl.com</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
    @endunless
</div>
@endsection
