<!DOCTYPE html>
<html lang="fr" class="h-full bg-white">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="robots" content="noindex, nofollow">
        <title>Connexion</title>
        @fonts
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-white font-sans text-[#1d2939] antialiased">
        <main class="grid min-h-screen lg:grid-cols-2">
            <!-- Formulaire gauche -->
            <section class="flex items-center justify-center px-6 py-12 sm:px-10 lg:px-12">
                <div class="w-full max-w-[420px]">
                    <div class="mb-8 flex">
                        <a href="{{ route('home') }}" class="inline-block transition-opacity hover:opacity-90">
                            <img
                                src="{{ asset('assets/images/logo.png') }}"
                                alt="Référence Médico SARL"
                                class="h-20 w-auto object-contain"
                            >
                            <img
                                src="{{ asset('assets/images/logo.jpeg') }}"
                                alt=""
                                class="hidden"
                                aria-hidden="true"
                            >
                        </a>
                    </div>

                    <p class="text-[11px] font-semibold tracking-[0.22em] text-[#667085] uppercase">Connexion</p>
                    <h1 class="mt-3 text-[2.65rem] font-bold leading-[1.05] tracking-[-0.03em] text-[#1d2939]">
                        Heureux de vous<br>retrouver.
                    </h1>
                    <p class="mt-4 text-[15px] italic leading-relaxed text-[#667085]">
                        Connectez-vous à votre espace pour suivre vos demandes et gérer vos équipements.
                    </p>

                    <form method="POST" action="{{ route('access.store') }}" class="mt-9">
                        @csrf

                        <div>
                            <label for="email" class="text-sm font-medium text-[#344054]">E-mail</label>
                            <input
                                id="email"
                                name="email"
                                type="email"
                                value="{{ old('email') }}"
                                autocomplete="username"
                                required
                                placeholder="Votre e-mail"
                                class="mt-2 block w-full border-0 border-b border-[#e4e7ec] bg-transparent px-0 py-2 text-sm text-[#1d2939] placeholder:text-[#98a2b3] outline-none transition-colors duration-150 focus:border-[#029e55] focus:ring-0"
                            >
                        </div>

                        <div class="mt-7">
                            <label for="password" class="text-sm font-medium text-[#344054]">Mot de passe</label>
                            <div class="relative">
                                <input
                                    id="password"
                                    name="password"
                                    type="password"
                                    autocomplete="current-password"
                                    required
                                    placeholder="Votre mot de passe"
                                    class="mt-2 block w-full border-0 border-b border-[#e4e7ec] bg-transparent py-2 pr-10 pl-0 text-sm text-[#1d2939] placeholder:text-[#98a2b3] outline-none transition-colors duration-150 focus:border-[#029e55] focus:ring-0"
                                >
                                <button
                                    type="button"
                                    id="toggle-password"
                                    class="absolute right-0 bottom-2 text-[#98a2b3] transition-colors duration-150 hover:text-[#029e55]"
                                    aria-label="Afficher le mot de passe"
                                    aria-pressed="false"
                                >
                                    <svg data-icon="show" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" class="h-5 w-5" aria-hidden="true">
                                        <path d="M2 12s3.5-6 10-6 10 6 10 6-3.5 6-10 6S2 12 2 12Z" />
                                        <circle cx="12" cy="12" r="2.5" />
                                    </svg>
                                    <svg data-icon="hide" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" class="hidden h-5 w-5" aria-hidden="true">
                                        <path d="M3 3l18 18" />
                                        <path d="M10.5 10.7A2.5 2.5 0 0 0 12 14.5c.4 0 .8-.1 1.1-.3" />
                                        <path d="M9.9 5.2A10.8 10.8 0 0 1 12 5c6.5 0 10 7 10 7a18 18 0 0 1-4.1 4.8" />
                                        <path d="M6.1 6.3C3.8 7.8 2 12 2 12a18.4 18.4 0 0 0 6.2 6.2" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        @error('email')
                            <p class="mt-4 text-sm text-[#d92d20]" role="alert">{{ $message }}</p>
                        @enderror
                        @error('password')
                            <p class="mt-4 text-sm text-[#d92d20]" role="alert">{{ $message }}</p>
                        @enderror

                        <div class="mt-6 flex items-center justify-between gap-4 text-sm text-[#667085]">
                            <label class="inline-flex cursor-pointer items-center gap-2" for="remember">
                                <input
                                    id="remember"
                                    name="remember"
                                    type="checkbox"
                                    value="1"
                                    @checked(old('remember'))
                                    class="h-4 w-4 rounded-sm border-[#d0d5dd] text-[#029e55] accent-[#029e55] focus:ring-[#029e55]"
                                >
                                <span>Se souvenir de moi</span>
                            </label>
                            <span class="font-medium text-[#029e55] underline underline-offset-2 transition-colors hover:text-[#028347]">Mot de passe oublié ?</span>
                        </div>

                        <button
                            type="submit"
                            class="mt-6 w-full cursor-pointer rounded-lg bg-[#029e55] px-4 py-3 text-sm font-semibold text-white transition-colors duration-150 hover:bg-[#028347]"
                        >
                            Se connecter
                        </button>
                    </form>

                    <p class="mt-8 text-center">
                        <a href="{{ route('home') }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-[#029e55] transition-colors hover:text-[#028347] hover:underline hover:underline-offset-2">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4" aria-hidden="true">
                                <path fill-rule="evenodd" d="M17 10a.75.75 0 0 1-.75.75H5.612l4.158 3.96a.75.75 0 1 1-1.04 1.08l-5.5-5.25a.75.75 0 0 1 0-1.08l5.5-5.25a.75.75 0 1 1 1.04 1.08L5.612 9.25H16.25A.75.75 0 0 1 17 10Z" clip-rule="evenodd" />
                            </svg>
                            Retour à la page d'accueil
                        </a>
                    </p>
                </div>
            </section>

            <!-- Visuel droit -->
            <aside class="relative min-h-72 bg-[#f8fafc] lg:min-h-screen">
                <img
                    src="{{ asset('assets/images/login.jpeg') }}"
                    alt=""
                    class="absolute inset-0 h-full w-full object-cover object-[70%_center]"
                >
                <div class="relative flex h-full min-h-72 items-center px-8 sm:px-12 lg:min-h-screen lg:px-14">
                    <div class="max-w-[250px]">
                        <h2 class="text-[1.85rem] font-bold leading-[1.15] tracking-[-0.02em] text-[#1d2939]">
                            Votre espace professionnel
                        </h2>
                        <span class="mt-3.5 block h-[3px] w-11 rounded-sm bg-[#edbb45]" aria-hidden="true"></span>
                        <p class="mt-4 text-sm leading-relaxed text-[#475467]">
                            Retrouvez vos demandes et vos équipements enregistrés.
                        </p>
                    </div>
                </div>
            </aside>
        </main>
        <script>
            const password = document.getElementById('password');
            const toggle = document.getElementById('toggle-password');

            toggle.addEventListener('click', () => {
                const show = password.type === 'password';
                password.type = show ? 'text' : 'password';
                toggle.setAttribute('aria-pressed', show ? 'true' : 'false');
                toggle.setAttribute('aria-label', show ? 'Masquer le mot de passe' : 'Afficher le mot de passe');
                toggle.querySelector('[data-icon="show"]').classList.toggle('hidden', show);
                toggle.querySelector('[data-icon="hide"]').classList.toggle('hidden', !show);
            });
        </script>
    </body>
</html>
