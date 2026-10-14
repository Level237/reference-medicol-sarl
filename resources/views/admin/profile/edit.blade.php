@extends('admin.layout')

@section('title', 'Profil')

@section('content')
    @php
        $field = 'w-full rounded-xl border border-[#d0d5dd] bg-white px-3.5 py-2.5 text-sm text-[#101828] shadow-xs outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/15';
        $label = 'mb-1.5 block text-sm font-medium text-[#344054]';
    @endphp

    <div class="space-y-6">
        <section class="border-b border-[#eaecf0] pb-6">
            <h1 class="text-2xl font-bold tracking-tight text-[#101828] sm:text-[28px]">Profil</h1>
            <p class="mt-1 text-sm text-[#475467]">
                Nom, adresse e-mail et mot de passe de votre compte administrateur.
            </p>
        </section>

        @if ($errors->any())
            <div role="alert" class="rounded-2xl border border-[#fecdca] bg-[#fef3f2] p-4 text-sm text-[#b42318] shadow-xs">
                <p class="font-semibold">Veuillez corriger les informations suivantes :</p>
                <ul class="mt-2 list-disc space-y-1 pl-5 text-xs sm:text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.profile.update') }}" class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            @csrf
            @method('PUT')

            <div class="space-y-6 lg:col-span-2">
                <section class="rounded-2xl border border-[#eaecf0] bg-white p-5 shadow-xs sm:p-6">
                    <div class="border-b border-[#eaecf0] pb-4">
                        <h2 class="text-base font-semibold text-[#101828]">Informations personnelles</h2>
                        <p class="mt-0.5 text-xs text-[#667085]">Ces informations identifient votre compte dans l’espace de gestion.</p>
                    </div>

                    <div class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-2">
                        <div class="sm:col-span-2">
                            <label for="name" class="{{ $label }}">
                                Nom <span class="text-[#d92d20]">*</span>
                            </label>
                            <input
                                id="name"
                                name="name"
                                type="text"
                                value="{{ old('name', $admin->name) }}"
                                required
                                autocomplete="name"
                                class="{{ $field }}"
                            >
                        </div>

                        <div class="sm:col-span-2">
                            <label for="email" class="{{ $label }}">
                                Adresse e-mail <span class="text-[#d92d20]">*</span>
                            </label>
                            <input
                                id="email"
                                name="email"
                                type="email"
                                value="{{ old('email', $admin->email) }}"
                                required
                                autocomplete="email"
                                class="{{ $field }}"
                            >
                        </div>
                    </div>
                </section>

                <section class="rounded-2xl border border-[#eaecf0] bg-white p-5 shadow-xs sm:p-6">
                    <div class="border-b border-[#eaecf0] pb-4">
                        <h2 class="text-base font-semibold text-[#101828]">Mot de passe</h2>
                        <p class="mt-0.5 text-xs text-[#667085]">Le mot de passe actuel confirme chaque enregistrement. Laissez le nouveau mot de passe vide pour le conserver.</p>
                    </div>

                    <div class="mt-5 grid grid-cols-1 gap-5">
                        <div>
                            <label for="current_password" class="{{ $label }}">
                                Mot de passe actuel <span class="text-[#d92d20]">*</span>
                            </label>
                            <input
                                id="current_password"
                                name="current_password"
                                type="password"
                                required
                                autocomplete="current-password"
                                class="{{ $field }}"
                            >
                        </div>

                        <div>
                            <label for="password" class="{{ $label }}">Nouveau mot de passe</label>
                            <input
                                id="password"
                                name="password"
                                type="password"
                                autocomplete="new-password"
                                class="{{ $field }}"
                            >
                        </div>

                        <div>
                            <label for="password_confirmation" class="{{ $label }}">Confirmer le nouveau mot de passe</label>
                            <input
                                id="password_confirmation"
                                name="password_confirmation"
                                type="password"
                                autocomplete="new-password"
                                class="{{ $field }}"
                            >
                        </div>
                    </div>
                </section>

                <div class="flex justify-end">
                    <button
                        type="submit"
                        class="inline-flex items-center justify-center rounded-xl bg-primary px-4 py-2.5 text-sm font-semibold text-white shadow-xs transition-colors hover:bg-primary-hover focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary"
                    >
                        Enregistrer
                    </button>
                </div>
            </div>

            <aside class="h-fit rounded-2xl border border-[#eaecf0] bg-white p-5 shadow-xs">
                <div class="flex items-center gap-3">
                    <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-primary text-lg font-semibold text-white" aria-hidden="true">
                        {{ $initial }}
                    </span>
                    <div class="min-w-0">
                        <p class="truncate text-sm font-semibold text-[#101828]">{{ $admin->name }}</p>
                        <p class="truncate text-xs text-[#667085]">{{ $admin->email }}</p>
                    </div>
                </div>
                <p class="mt-4 text-xs leading-relaxed text-[#667085]">
                    Administrateur de Référence Médico Sarl. Le rôle du compte n’est pas modifiable depuis cette page.
                </p>
            </aside>
        </form>
    </div>
@endsection
