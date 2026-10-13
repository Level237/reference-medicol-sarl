@extends('layouts.public')

@section('title', 'Demande de devis')
@section('meta_description', 'Transmettez vos coordonnées pour recevoir une cotation sur les équipements sélectionnés. Référence Médico Sarl.')
@section('robots', 'noindex, nofollow')

@php
    $itemCount = $cart->count();
    $totalAmount = $cart->totalAmount();
@endphp

@section('content')
<div class="bg-white py-10 pb-28 sm:py-14 sm:pb-32 lg:pb-14">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <header class="text-left">
            <h1 class="text-3xl font-extrabold tracking-tight text-[#1d2939] sm:text-4xl">
                Votre demande
            </h1>
            <p class="mt-2 max-w-2xl text-sm text-[#667085] sm:text-base">
                Indiquez qui contacter. La sélection à droite part avec le message.
            </p>
        </header>

        <div class="mt-10 grid grid-cols-1 items-start gap-10 lg:mt-12 lg:grid-cols-12 lg:gap-14">
            <form id="quote-form" action="{{ route('quotes.store') }}" method="POST" class="space-y-5 lg:col-span-8">
                @csrf

                <div class="flex flex-col gap-2">
                    <label for="organization_name" class="text-sm font-semibold text-[#1d2939]">Établissement</label>
                    <input
                        id="organization_name"
                        name="organization_name"
                        type="text"
                        value="{{ old('organization_name') }}"
                        required
                        autocomplete="organization"
                        class="quote-required-field rounded-xl border border-[#e4e7ec] bg-white px-4 py-3 text-sm text-[#1d2939] outline-none transition-[border-color,box-shadow] duration-150 focus:border-[#029e55] focus:ring-2 focus:ring-[#029e55]/20"
                    >
                    <p class="text-xs text-[#667085]">Hôpital, clinique, cabinet ou laboratoire.</p>
                    @error('organization_name')
                        <p class="text-sm text-[#d92d20]">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                    <div class="flex flex-col gap-2">
                        <label for="contact_name" class="text-sm font-semibold text-[#1d2939]">Nom</label>
                        <input
                            id="contact_name"
                            name="contact_name"
                            type="text"
                            value="{{ old('contact_name') }}"
                            required
                            autocomplete="name"
                            class="quote-required-field rounded-xl border border-[#e4e7ec] bg-white px-4 py-3 text-sm text-[#1d2939] outline-none transition-[border-color,box-shadow] duration-150 focus:border-[#029e55] focus:ring-2 focus:ring-[#029e55]/20"
                        >
                        @error('contact_name')
                            <p class="text-sm text-[#d92d20]">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex flex-col gap-2">
                        <label for="phone" class="text-sm font-semibold text-[#1d2939]">Téléphone</label>
                        <input
                            id="phone"
                            name="phone"
                            type="tel"
                            value="{{ old('phone') }}"
                            required
                            autocomplete="tel"
                            inputmode="tel"
                            class="quote-required-field rounded-xl border border-[#e4e7ec] bg-white px-4 py-3 text-sm text-[#1d2939] outline-none transition-[border-color,box-shadow] duration-150 focus:border-[#029e55] focus:ring-2 focus:ring-[#029e55]/20"
                        >
                        @error('phone')
                            <p class="text-sm text-[#d92d20]">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex flex-col gap-2">
                    <label for="email" class="text-sm font-semibold text-[#1d2939]">E-mail</label>
                    <input
                        id="email"
                        name="email"
                        type="email"
                        value="{{ old('email') }}"
                        required
                        autocomplete="email"
                        class="quote-required-field rounded-xl border border-[#e4e7ec] bg-white px-4 py-3 text-sm text-[#1d2939] outline-none transition-[border-color,box-shadow] duration-150 focus:border-[#029e55] focus:ring-2 focus:ring-[#029e55]/20"
                    >
                    <p class="text-xs text-[#667085]">La réponse part sur cette adresse.</p>
                    @error('email')
                        <p class="text-sm text-[#d92d20]">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex flex-col gap-2">
                    <label for="message" class="text-sm font-semibold text-[#1d2939]">Message</label>
                    <textarea
                        id="message"
                        name="message"
                        rows="6"
                        required
                        class="quote-required-field rounded-xl border border-[#e4e7ec] bg-white px-4 py-3 text-sm text-[#1d2939] outline-none transition-[border-color,box-shadow] duration-150 focus:border-[#029e55] focus:ring-2 focus:ring-[#029e55]/20"
                    >{{ old('message') }}</textarea>
                    <p class="text-xs text-[#667085]">Délai, lieu de livraison, contraintes de plateau.</p>
                    @error('message')
                        <p class="text-sm text-[#d92d20]">{{ $message }}</p>
                    @enderror
                </div>
            </form>

            <aside class="lg:col-span-4">
                <div class="sticky top-28 rounded-2xl border border-[#e4e7ec] bg-white p-6 sm:p-8">
                    <h2 class="text-xl font-bold tracking-tight text-[#1d2939]">Votre sélection</h2>

                    <p class="mt-2 text-sm font-semibold text-[#1d2939]">
                        {{ $itemCount }} {{ $itemCount > 1 ? 'articles' : 'article' }}
                    </p>

                    <ul class="mt-5 divide-y divide-[#e4e7ec] border-y border-[#e4e7ec]">
                        @foreach ($items as $item)
                            <li class="flex items-center gap-3 py-3">
                                <div class="flex h-14 w-14 shrink-0 items-center justify-center overflow-hidden rounded-lg border border-[#e4e7ec] bg-[#f8fafc] p-1">
                                    @if (! empty($item['image']))
                                        <img src="{{ asset('storage/'.$item['image']) }}" alt="" class="h-full w-full object-contain" loading="lazy">
                                    @else
                                        <span class="text-[10px] font-semibold text-[#98a2b3]">Réf.</span>
                                    @endif
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="truncate text-sm font-semibold text-[#1d2939]">{{ $item['name'] }}</p>
                                    <p class="text-xs text-[#667085]">Qté {{ $item['quantity'] }}</p>
                                </div>
                                <p class="shrink-0 text-right text-xs font-semibold text-[#1d2939]">
                                    @if (! empty($item['price']))
                                        {{ number_format((float) $item['price'] * (int) $item['quantity'], 0, ',', ' ') }} FCFA
                                    @else
                                        Prix sur devis
                                    @endif
                                </p>
                            </li>
                        @endforeach
                    </ul>

                    <div class="mt-5">
                        <p class="text-xs font-semibold uppercase tracking-wider text-[#667085]">Montant</p>
                        <p class="mt-1 text-2xl font-extrabold tracking-tight text-[#1d2939]">
                            @if ($totalAmount !== null)
                                {{ number_format($totalAmount, 0, ',', ' ') }} <span class="text-sm font-bold text-[#667085]">FCFA</span>
                            @else
                                sur devis
                            @endif
                        </p>
                        <p class="mt-2 text-xs leading-relaxed text-[#667085]">
                            Les prix et délais seront précisés par notre équipe.
                        </p>
                    </div>

                    <button
                        id="sidebar-submit-btn"
                        type="submit"
                        form="quote-form"
                        class="quote-submit-btn mt-6 inline-flex w-full items-center justify-center gap-2 rounded-xl bg-[#0f172a] px-6 py-3.5 text-sm font-semibold text-white transition-[transform,background-color,color] duration-150 ease-out active:scale-[0.97] disabled:cursor-not-allowed disabled:bg-[#e4e7ec] disabled:text-[#98a2b3] disabled:active:scale-100"
                    >
                        <span>Finaliser ma demande</span>
                        <span aria-hidden="true">&rarr;</span>
                    </button>

                    <a href="{{ route('cart.index') }}" class="mt-4 inline-flex text-sm font-semibold text-[#029e55] hover:text-[#028347]">
                        &larr; Modifier le panier
                    </a>

                    <div class="mt-8 border-t border-[#e4e7ec] pt-6">
                        <p class="text-xs font-bold text-[#1d2939]">Besoin d'un conseil ?</p>
                        <p class="text-xs text-[#667085]">Notre équipe est à votre écoute.</p>
                        <a href="tel:+237699850500" class="mt-2 inline-block text-xs font-bold text-[#1d2939] hover:text-[#029e55]">
                            +237 699 850 500
                        </a>
                    </div>
                </div>
            </aside>
        </div>
    </div>
</div>

{{-- Barre fixe mobile (sous lg seulement) : prix à gauche + CTA à droite --}}
<div
    id="mobile-sticky-cta"
    class="fixed inset-x-0 bottom-0 z-30 border-t border-[#e4e7ec] bg-white px-4 py-3 pb-[calc(0.75rem+env(safe-area-inset-bottom))] transition-transform duration-200 ease-out sm:px-6 lg:hidden"
    aria-label="Validation mobile"
>
    <div class="mx-auto flex max-w-7xl items-center justify-between gap-4">
        <div class="min-w-0">
            <p class="text-[11px] font-semibold uppercase tracking-wider text-[#667085]">Montant</p>
            <p class="truncate text-base font-extrabold tracking-tight text-[#1d2939]">
                @if ($totalAmount !== null)
                    {{ number_format($totalAmount, 0, ',', ' ') }} <span class="text-xs font-bold text-[#667085]">FCFA</span>
                @else
                    sur devis
                @endif
            </p>
        </div>

        <button
            type="submit"
            form="quote-form"
            class="quote-submit-btn inline-flex shrink-0 items-center justify-center gap-1.5 rounded-xl bg-[#0f172a] px-5 py-3 text-sm font-semibold text-white transition-[transform,background-color,color] duration-150 ease-out active:scale-[0.97] disabled:cursor-not-allowed disabled:bg-[#e4e7ec] disabled:text-[#98a2b3] disabled:active:scale-100"
        >
            <span>Finaliser</span>
            <span aria-hidden="true">&rarr;</span>
        </button>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const requiredFields = Array.from(document.querySelectorAll('.quote-required-field'));
        const submitButtons = Array.from(document.querySelectorAll('.quote-submit-btn'));
        const sidebarBtn = document.getElementById('sidebar-submit-btn');
        const mobileBar = document.getElementById('mobile-sticky-cta');

        function isFormFilled() {
            return requiredFields.every(field => field.value.trim().length > 0);
        }

        function syncButtonState() {
            const filled = isFormFilled();
            submitButtons.forEach(btn => {
                btn.disabled = !filled;
            });
        }

        requiredFields.forEach(field => {
            field.addEventListener('input', syncButtonState);
            field.addEventListener('change', syncButtonState);
        });
        syncButtonState();

        if (sidebarBtn && mobileBar && 'IntersectionObserver' in window) {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        mobileBar.classList.add('translate-y-full');
                    } else {
                        mobileBar.classList.remove('translate-y-full');
                    }
                });
            }, {
                root: null,
                threshold: 0.1,
            });

            observer.observe(sidebarBtn);
        }
    });
</script>
@endsection
