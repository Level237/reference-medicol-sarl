{{-- Footer Public — Référence Médico Sarl — Conforme docs/DESIGN.md (#0F172A, #029E55, Instrument Sans) --}}
<footer class="border-t border-white/10 bg-[#0f172a] text-white" aria-labelledby="footer-heading">
    <h2 id="footer-heading" class="sr-only">Pied de page</h2>

    {{-- Bloc principal --}}
    <div class="mx-auto max-w-7xl px-4 pt-14 pb-12 sm:px-6 lg:px-8 lg:pt-16 lg:pb-14">
        <div class="grid grid-cols-1 gap-10 sm:grid-cols-2 lg:grid-cols-12 lg:gap-8">
            {{-- Colonne 1 : Marque & Positionnement B2B (lg:col-span-4) --}}
            <div class="flex flex-col lg:col-span-4">
                <a href="{{ route('home') }}" class="group inline-flex items-center gap-3">
                    <img
                        src="{{ asset('assets/images/logo.png') }}"
                        alt="Référence Médico Sarl"
                        class="h-11 w-11 rounded-full object-contain transition-transform duration-150 ease-out group-hover:scale-105"
                        width="44"
                        height="44"
                        loading="lazy"
                    >
                    <div class="flex flex-col">
                        <span class="text-base font-bold tracking-tight text-white transition-colors duration-150 group-hover:text-[#029e55]">
                            Référence Médico Sarl
                        </span>
                        <span class="text-xs text-[#98a2b3]">
                            Matériel médical & hospitalier
                        </span>
                    </div>
                </a>

                <p class="mt-4 max-w-sm text-sm leading-relaxed text-[#98a2b3]">
                    Partenaire de référence pour l'équipement, l'approvisionnement et la maintenance de plateaux techniques en Afrique centrale.
                </p>

                <p class="mt-5 text-xs text-[#98a2b3]">
                    Siège social : Douala, Cameroun
                </p>
            </div>

            {{-- Colonne 2 : Navigation (lg:col-span-2) --}}
            <div class="flex flex-col lg:col-span-2 lg:pl-2">
                <h3 class="text-xs font-bold uppercase tracking-widest text-white">
                    Navigation
                </h3>
                <ul class="mt-4 space-y-2.5 text-sm">
                    <li>
                        <a href="{{ route('catalogue') }}" class="text-[#98a2b3] transition-colors duration-150 ease-out hover:text-[#029e55]">
                            Catalogue
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('about') }}" class="text-[#98a2b3] transition-colors duration-150 ease-out hover:text-[#029e55]">
                            À propos
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('services') }}" class="text-[#98a2b3] transition-colors duration-150 ease-out hover:text-[#029e55]">
                            Nos services
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('quotes.create') }}" class="text-[#98a2b3] transition-colors duration-150 ease-out hover:text-[#029e55]">
                            Demander un devis
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('contact') }}" class="text-[#98a2b3] transition-colors duration-150 ease-out hover:text-[#029e55]">
                            Contact
                        </a>
                    </li>
                </ul>
            </div>

            {{-- Colonne 3 : Établissements & Secteurs (lg:col-span-3) --}}
            <div class="flex flex-col lg:col-span-3">
                <h3 class="text-xs font-bold uppercase tracking-widest text-white">
                    Secteurs servis
                </h3>
                <ul class="mt-4 space-y-2.5 text-sm text-[#98a2b3]">
                    <li>Hôpitaux régionaux & généraux</li>
                    <li>Cliniques & centres médico-chirurgicaux</li>
                    <li>Cabinets de consultation</li>
                    <li>Laboratoires d'analyses médicales</li>
                </ul>
            </div>

            {{-- Colonne 4 : Contact direct (lg:col-span-3) --}}
            <div class="flex flex-col lg:col-span-3">
                <h3 class="text-xs font-bold uppercase tracking-widest text-white">
                    Contact direct
                </h3>
                <ul class="mt-4 space-y-3 text-sm">
                    <li>
                        <a href="tel:+237699850500" class="group flex items-start gap-2.5 text-[#98a2b3] transition-colors duration-150 ease-out hover:text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="mt-0.5 h-4 w-4 shrink-0 text-[#029e55]" aria-hidden="true">
                                <path fill-rule="evenodd" d="M2 3.5A1.5 1.5 0 0 1 3.5 2h1.148a1.5 1.5 0 0 1 1.465 1.175l.716 3.223a1.5 1.5 0 0 1-1.052 1.767l-.933.267c-.41.117-.643.555-.48.95a11.542 11.542 0 0 0 6.254 6.254c.395.163.833-.07.95-.48l.267-.933a1.5 1.5 0 0 1 1.767-1.052l3.223.716A1.5 1.5 0 0 1 18 15.352V16.5a1.5 1.5 0 0 1-1.5 1.5H15c-1.149 0-2.263-.15-3.326-.43A13.022 13.022 0 0 1 2.43 8.326 13.019 13.019 0 0 1 2 5V3.5Z" clip-rule="evenodd" />
                            </svg>
                            <span class="font-medium text-white transition-colors duration-150 group-hover:text-[#029e55]">+237 699 850 500</span>
                        </a>
                    </li>
                    <li>
                        <a href="mailto:jacquesmaud@referencemedicosarl.com" class="group flex items-start gap-2.5 text-[#98a2b3] transition-colors duration-150 ease-out hover:text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="mt-0.5 h-4 w-4 shrink-0 text-[#029e55]" aria-hidden="true">
                                <path d="M3 4a2 2 0 0 0-2 2v1.161l8.441 4.221a1.25 1.25 0 0 0 1.118 0L19 7.162V6a2 2 0 0 0-2-2H3Z" />
                                <path d="m19 8.839-7.77 3.885a2.75 2.75 0 0 1-2.46 0L1 8.839V14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V8.839Z" />
                            </svg>
                            <span class="truncate transition-colors duration-150 group-hover:text-[#029e55]">jacquesmaud@referencemedicosarl.com</span>
                        </a>
                    </li>
                    <li class="flex items-start gap-2.5 text-[#98a2b3]">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="mt-0.5 h-4 w-4 shrink-0 text-[#029e55]" aria-hidden="true">
                            <path fill-rule="evenodd" d="m9.69 18.933.003.001C9.89 19.02 10 19 10 19s.11.02.308-.066l.002-.001.006-.003.018-.008a5.741 5.741 0 0 0 .281-.14c.186-.096.446-.24.757-.433.62-.384 1.445-.966 2.274-1.765C15.302 14.988 17 12.493 17 9A7 7 0 1 0 3 9c0 3.492 1.698 5.988 3.355 7.584a13.731 13.731 0 0 0 2.273 1.765 11.79 11.79 0 0 0 1.04 574l.018.008.006.003ZM10 11.25a2.25 2.25 0 1 0 0-4.5 2.25 2.25 0 0 0 0 4.5Z" clip-rule="evenodd" />
                        </svg>
                        <span>Douala, Région du Littoral, Cameroun</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    {{-- Ligne inférieure : Copyright & Mentions --}}
    <div class="border-t border-white/10 bg-[#0f172a]">
        <div class="mx-auto flex max-w-7xl flex-col items-center justify-between gap-3 px-4 py-6 sm:flex-row sm:px-6 lg:px-8">
            <p class="text-xs text-[#98a2b3]">
                &copy; {{ date('Y') }} Référence Médico Sarl. Tous droits réservés.
            </p>

            <div class="flex items-center gap-5 text-xs text-[#98a2b3]">
                <a href="{{ route('home') }}#mentions" class="transition-colors duration-150 hover:text-white">
                    Mentions légales
                </a>
                <span class="text-white/20" aria-hidden="true">&bull;</span>
                <a href="{{ route('home') }}#confidentialite" class="transition-colors duration-150 hover:text-white">
                    Confidentialité
                </a>
                <span class="text-white/20" aria-hidden="true">&bull;</span>
                <a href="{{ route('access.create') }}" class="transition-colors duration-150 hover:text-white">
                    Espace pro
                </a>
            </div>
        </div>
    </div>
</footer>
