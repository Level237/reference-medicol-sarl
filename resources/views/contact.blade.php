@extends('layouts.public')

@section('title', 'Contact')
@section('meta_description', 'Écrivez à Référence Médico Sarl pour un équipement, un projet ou une question. Douala, Cameroun.')

@section('content')
<section class="relative flex min-h-[320px] items-center justify-center overflow-hidden sm:min-h-[380px] lg:min-h-[440px]">
    <div
        class="absolute inset-0 scale-105 bg-cover bg-center bg-no-repeat"
        style="background-image: url('{{ asset('assets/images/hero-about.jpg') }}');"
        aria-hidden="true"
    ></div>

    <div
        class="absolute inset-0 bg-gradient-to-b from-[#0f172a]/55 via-[#0f172a]/45 to-[#0f172a]/60"
        aria-hidden="true"
    ></div>

    <div class="relative z-10 mx-auto max-w-4xl px-4 py-16 text-center sm:px-6 lg:px-8">
        <nav aria-label="Fil d'Ariane" class="mb-6 inline-flex items-center justify-center gap-1.5 text-xs font-medium text-white/75">
            <a href="{{ route('home') }}" class="text-white/90 transition-colors hover:text-white hover:underline">Accueil</a>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-white/50" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
            </svg>
            <span class="text-white">Contact</span>
        </nav>

        <h1 class="text-3xl font-extrabold tracking-tight text-white sm:text-4xl md:text-5xl lg:text-[3.25rem] lg:leading-tight">
            Contactez-nous
        </h1>

        <div class="mx-auto mt-5 h-1 w-16 rounded-full bg-[#029e55]" aria-hidden="true"></div>
    </div>
</section>

<div class="bg-white py-12 sm:py-16">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <p class="max-w-2xl text-sm leading-relaxed text-[#667085] sm:text-base">
            Une question sur un équipement ou un projet d'établissement ? Écrivez-nous. L'équipe répond depuis Douala.
        </p>

        <div class="mt-10 grid grid-cols-1 items-start gap-12 lg:mt-12 lg:grid-cols-12 lg:gap-16">
            <form action="{{ route('contact.store') }}" method="POST" class="order-2 space-y-5 lg:order-1 lg:col-span-7" onsubmit="const button = this.querySelector('[type=submit]'); if (button) button.disabled = true;">
                @csrf

                @if (session('status'))
                    <p class="rounded-xl border border-[#029e55] bg-white px-4 py-3 text-sm font-medium text-[#029e55]" role="status">
                        {{ session('status') }}
                    </p>
                @endif

                <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                    <div class="flex flex-col gap-2">
                        <label for="name" class="text-sm font-semibold text-[#1d2939]">Nom</label>
                        <input
                            id="name"
                            name="name"
                            type="text"
                            value="{{ old('name') }}"
                            required
                            autocomplete="name"
                            class="rounded-xl border border-[#e4e7ec] bg-white px-4 py-3 text-sm text-[#1d2939] outline-none transition-[border-color,box-shadow] duration-150 placeholder:text-[#98a2b3] focus:border-[#029e55] focus:ring-2 focus:ring-[#029e55]/20"
                        >
                        @error('name')
                            <p class="text-sm text-[#d92d20]">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex flex-col gap-2">
                        <label for="organization" class="text-sm font-semibold text-[#1d2939]">Établissement <span class="font-normal text-[#98a2b3]">(facultatif)</span></label>
                        <input
                            id="organization"
                            name="organization"
                            type="text"
                            value="{{ old('organization') }}"
                            autocomplete="organization"
                            class="rounded-xl border border-[#e4e7ec] bg-white px-4 py-3 text-sm text-[#1d2939] outline-none transition-[border-color,box-shadow] duration-150 placeholder:text-[#98a2b3] focus:border-[#029e55] focus:ring-2 focus:ring-[#029e55]/20"
                        >
                        @error('organization')
                            <p class="text-sm text-[#d92d20]">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                    <div class="flex flex-col gap-2">
                        <label for="email" class="text-sm font-semibold text-[#1d2939]">E-mail</label>
                        <input
                            id="email"
                            name="email"
                            type="email"
                            value="{{ old('email') }}"
                            required
                            autocomplete="email"
                            placeholder="contact@exemple.cm"
                            class="rounded-xl border border-[#e4e7ec] bg-white px-4 py-3 text-sm text-[#1d2939] outline-none transition-[border-color,box-shadow] duration-150 placeholder:text-[#98a2b3] focus:border-[#029e55] focus:ring-2 focus:ring-[#029e55]/20"
                        >
                        @error('email')
                            <p class="text-sm text-[#d92d20]">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex flex-col gap-2">
                        <label for="phone" class="text-sm font-semibold text-[#1d2939]">Téléphone <span class="font-normal text-[#98a2b3]">(facultatif)</span></label>
                        <input
                            id="phone"
                            name="phone"
                            type="tel"
                            value="{{ old('phone') }}"
                            autocomplete="tel"
                            inputmode="tel"
                            placeholder="+237 6XX XXX XXX"
                            class="rounded-xl border border-[#e4e7ec] bg-white px-4 py-3 text-sm text-[#1d2939] outline-none transition-[border-color,box-shadow] duration-150 placeholder:text-[#98a2b3] focus:border-[#029e55] focus:ring-2 focus:ring-[#029e55]/20"
                        >
                        @error('phone')
                            <p class="text-sm text-[#d92d20]">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex flex-col gap-2">
                    <label for="message" class="text-sm font-semibold text-[#1d2939]">Message</label>
                    <textarea
                        id="message"
                        name="message"
                        rows="6"
                        required
                        class="rounded-xl border border-[#e4e7ec] bg-white px-4 py-3 text-sm text-[#1d2939] outline-none transition-[border-color,box-shadow] duration-150 placeholder:text-[#98a2b3] focus:border-[#029e55] focus:ring-2 focus:ring-[#029e55]/20"
                    >{{ old('message') }}</textarea>
                    @error('message')
                        <p class="text-sm text-[#d92d20]">{{ $message }}</p>
                    @enderror
                </div>

                <button
                    type="submit"
                    class="inline-flex w-full items-center justify-center rounded-xl bg-[#0f172a] px-6 py-3.5 text-sm font-semibold text-white transition-[transform,background-color] duration-150 ease-out hover:bg-[#029e55] active:scale-[0.97] sm:w-auto"
                >
                    Envoyer le message
                </button>
            </form>

            <aside class="order-1 lg:order-2 lg:col-span-5 lg:pt-1">
                <h2 class="text-lg font-bold tracking-tight text-[#1d2939]">Joindre l'équipe directement</h2>
                <p class="mt-2 text-sm leading-relaxed text-[#667085]">
                    Pour un besoin urgent, l'appel reste le plus simple.
                </p>
                <div class="mt-6 space-y-4 text-sm">
                    <a href="tel:+237699850500" class="flex items-center gap-3 font-medium text-[#1d2939] transition-colors hover:text-[#029e55]">
                        <svg class="h-5 w-5 shrink-0 text-[#029e55]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                        <span>+237 699 850 500</span>
                    </a>
                    <a href="mailto:jacquesmaud@referencemedicosarl.com" class="flex items-center gap-3 text-[#667085] transition-colors hover:text-[#029e55]">
                        <svg class="h-5 w-5 shrink-0 text-[#029e55]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        <span class="break-all">jacquesmaud@referencemedicosarl.com</span>
                    </a>
                    <p class="flex items-center gap-3 text-[#667085]">
                        <svg class="h-5 w-5 shrink-0 text-[#029e55]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span>Douala, Cameroun</span>
                    </p>
                </div>
            </aside>
        </div>
    </div>
</div>
@endsection
