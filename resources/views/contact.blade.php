@extends('layouts.public')

@section('title', 'Contact')
@section('meta_description', 'Écrivez à Référence Médico Sarl pour un équipement, un projet ou une question. Douala, Cameroun.')

@section('content')
    <section class="relative flex min-h-[320px] items-center justify-center overflow-hidden sm:min-h-[380px] lg:min-h-[440px]">
        <div
            class="absolute inset-0 scale-105 bg-cover bg-center bg-no-repeat"
            style="background-image: url('{{ asset('assets/images/about/hopital.jpg') }}');"
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

    <section class="bg-white pt-12 sm:pt-16">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 items-start gap-10 lg:grid-cols-[minmax(0,1.4fr)_minmax(17rem,0.72fr)] lg:gap-14 xl:gap-16">
                <div>
                    <p class="text-sm text-[#667085] sm:text-base">Une question ou besoin d'aide ? Nous sommes là.</p>

                    <form action="{{ route('contact.store') }}" method="POST" class="mt-8" onsubmit="const button = this.querySelector('[type=submit]'); if (button) button.disabled = true;">
                        @csrf

                        @if (session('status'))
                            <p class="mb-6 rounded-xl border border-[#029e55] bg-white px-4 py-3 text-sm font-medium text-[#1d2939]" role="status">
                                {{ session('status') }}
                            </p>
                        @endif

                        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                            <div class="flex flex-col gap-2">
                                <label for="name" class="text-sm font-semibold text-[#1d2939]">Nom <span aria-hidden="true">*</span></label>
                                <input
                                    id="name"
                                    name="name"
                                    type="text"
                                    value="{{ old('name') }}"
                                    required
                                    autocomplete="name"
                                    placeholder="Nom"
                                    class="rounded-lg border border-[#e4e7ec] bg-white px-3.5 py-2.5 text-sm text-[#1d2939] outline-none transition-[border-color,box-shadow] duration-150 placeholder:text-[#667085] focus:border-[#029e55] focus:ring-2 focus:ring-[#029e55]/20"
                                >
                                @error('name')
                                    <p class="text-sm text-[#d92d20]">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex flex-col gap-2">
                                <label for="email" class="text-sm font-semibold text-[#1d2939]">E-mail <span aria-hidden="true">*</span></label>
                                <input
                                    id="email"
                                    name="email"
                                    type="email"
                                    value="{{ old('email') }}"
                                    required
                                    autocomplete="email"
                                    placeholder="E-mail"
                                    class="rounded-lg border border-[#e4e7ec] bg-white px-3.5 py-2.5 text-sm text-[#1d2939] outline-none transition-[border-color,box-shadow] duration-150 placeholder:text-[#667085] focus:border-[#029e55] focus:ring-2 focus:ring-[#029e55]/20"
                                >
                                @error('email')
                                    <p class="text-sm text-[#d92d20]">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-2">
                            <div class="flex flex-col gap-2">
                                <label for="phone" class="text-sm font-semibold text-[#1d2939]">Numéro WhatsApp</label>
                                <input
                                    id="phone"
                                    name="phone"
                                    type="tel"
                                    value="{{ old('phone') }}"
                                    autocomplete="tel"
                                    inputmode="tel"
                                    placeholder="+237 6XX XXX XXX"
                                    class="rounded-lg border border-[#e4e7ec] bg-white px-3.5 py-2.5 text-sm text-[#1d2939] outline-none transition-[border-color,box-shadow] duration-150 placeholder:text-[#667085] focus:border-[#029e55] focus:ring-2 focus:ring-[#029e55]/20"
                                >
                                @error('phone')
                                    <p class="text-sm text-[#d92d20]">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-5 flex flex-col gap-2">
                            <label for="message" class="text-sm font-semibold text-[#1d2939]">Message <span aria-hidden="true">*</span></label>
                            <textarea
                                id="message"
                                name="message"
                                rows="8"
                                required
                                placeholder="Écrivez ici"
                                class="rounded-lg border border-[#e4e7ec] bg-white px-3.5 py-2.5 text-sm text-[#1d2939] outline-none transition-[border-color,box-shadow] duration-150 placeholder:text-[#667085] focus:border-[#029e55] focus:ring-2 focus:ring-[#029e55]/20"
                            >{{ old('message') }}</textarea>
                            @error('message')
                                <p class="text-sm text-[#d92d20]">{{ $message }}</p>
                            @enderror
                        </div>

                        <button
                            type="submit"
                            class="mt-6 inline-flex items-center justify-center rounded-full bg-[#0f172a] px-6 py-3 text-sm font-semibold text-white transition-[transform,background-color] duration-150 ease-out hover:bg-[#029e55] active:scale-[0.97]"
                        >
                            Envoyer le message
                        </button>
                    </form>
                </div>

                <aside class="rounded-3xl bg-[#0f172a] px-7 py-8 text-white sm:px-8 sm:py-9">
                    <h2 class="text-lg font-bold tracking-tight">Adresse</h2>
                    <p class="mt-2 text-sm text-white/80">Douala, Cameroun</p>

                    <h2 class="mt-8 text-lg font-bold tracking-tight">Contact</h2>
                    <div class="mt-3 space-y-2 text-sm text-white/80">
                        <p>
                            Téléphone :
                            <a href="tel:+237699850500" class="text-white transition-colors hover:text-[#029e55]">+237 699 850 500</a>
                        </p>
                        <p>
                            E-mail :<br>
                            <a href="mailto:jacquesmaud@referencemedicosarl.com" class="text-white transition-colors hover:text-[#029e55]">jacquesmaud@referencemedicosarl.com</a>
                        </p>
                    </div>
                </aside>
            </div>
        </div>

        <div class="relative z-0 mt-16 sm:mt-20">
            <div id="contact-map" class="h-80 w-full bg-[#e4e7ec] sm:h-[440px]" role="region" aria-label="Localisation à Douala"></div>
            <p class="pointer-events-none absolute bottom-4 left-4 rounded-lg bg-white px-3 py-2 text-sm font-semibold text-[#1d2939] shadow-sm">
                Douala, Cameroun
            </p>
        </div>
    </section>
@endsection
