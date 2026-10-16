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

                <p class="mt-4 text-sm leading-relaxed text-[#98a2b3]">
                    RMS, votre partenaire de référence pour tous vos besoins de matériels et consommables médicaux. Nous intervenons aussi bien dans la formation du personnel que dans la maintenance de vos appareils médicaux. Nous livrons partout au Cameroun et dans l'Afrique centrale.
                </p>

                <nav aria-label="Réseaux sociaux" class="mt-5 flex items-center gap-2.5">
                    <a
                        href="https://www.facebook.com/share/1E1Joi9BnE/"
                        target="_blank"
                        rel="noopener noreferrer"
                        aria-label="Facebook"
                        class="inline-flex h-9 w-9 items-center justify-center rounded-full border border-white/15 text-[#98a2b3] transition-colors duration-150 hover:border-[#029e55] hover:text-[#029e55]"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-4 w-4" aria-hidden="true">
                            <path d="M14.5 8.5V6.75A1.25 1.25 0 0 1 15.75 5.5H17.5V3h-2.1C12.9 3 11 4.9 11 7.4v1.1H9v2.5h2V21h3v-9.999h2.4l.35-2.5H14.5Z" />
                        </svg>
                    </a>
                    <a
                        href="{{ 'https://www.instagram.com/p/DXWx1PDjDcX/?utm_source=ig_web_copy_link&igsh=MzRlODBiNWFlZA==' }}"
                        target="_blank"
                        rel="noopener noreferrer"
                        aria-label="Instagram"
                        class="inline-flex h-9 w-9 items-center justify-center rounded-full border border-white/15 text-[#98a2b3] transition-colors duration-150 hover:border-[#029e55] hover:text-[#029e55]"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="h-4 w-4" aria-hidden="true">
                            <rect x="4" y="4" width="16" height="16" rx="4" />
                            <circle cx="12" cy="12" r="3.5" />
                            <circle cx="17.2" cy="6.8" r="0.8" fill="currentColor" stroke="none" />
                        </svg>
                    </a>
                    <a
                        href="https://cm.linkedin.com/company/reference-medico-sarl"
                        target="_blank"
                        rel="noopener noreferrer"
                        aria-label="LinkedIn"
                        class="inline-flex h-9 w-9 items-center justify-center rounded-full border border-white/15 text-[#98a2b3] transition-colors duration-150 hover:border-[#029e55] hover:text-[#029e55]"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-4 w-4" aria-hidden="true">
                            <path d="M6.2 9H3.6v11.2h2.6V9ZM4.9 3.6A1.6 1.6 0 1 0 4.9 6.8 1.6 1.6 0 0 0 4.9 3.6ZM20.4 13.3c0-3.2-1.7-4.7-4-4.7-1.8 0-2.7 1-3.2 1.7V9H10.6v11.2h2.6v-6.2c0-.3.1-.7.2-1 .3-.7 1-1.5 2.1-1.5 1.5 0 2.1 1.1 2.1 2.8v5.9h2.6v-6.9Z" />
                        </svg>
                    </a>
                </nav>

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
                        <a href="mailto:lecpaarnaud@referencemedicosarl.com" class="group flex items-start gap-2.5 text-[#98a2b3] transition-colors duration-150 ease-out hover:text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="mt-0.5 h-4 w-4 shrink-0 text-[#029e55]" aria-hidden="true">
                                <path d="M3 4a2 2 0 0 0-2 2v1.161l8.441 4.221a1.25 1.25 0 0 0 1.118 0L19 7.162V6a2 2 0 0 0-2-2H3Z" />
                                <path d="m19 8.839-7.77 3.885a2.75 2.75 0 0 1-2.46 0L1 8.839V14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V8.839Z" />
                            </svg>
                            <span class="truncate transition-colors duration-150 group-hover:text-[#029e55]">lecpaarnaud@referencemedicosarl.com</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ 'https://maps.google.com/?cid=16209078626882780232&g_mp=CiVnb29nbGUubWFwcy5wbGFjZXMudjEuUGxhY2VzLkdldFBsYWNlEAMYASAF' }}" target="_blank" rel="noopener noreferrer" class="group flex items-start gap-2.5 text-[#98a2b3] transition-colors duration-150 ease-out hover:text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="mt-0.5 h-4 w-4 shrink-0 text-[#029e55]" aria-hidden="true">
                                <path fill-rule="evenodd" d="m9.69 18.933.003.001C9.89 19.02 10 19 10 19s.11.02.308-.066l.002-.001.006-.003.018-.008a5.741 5.741 0 0 0 .281-.14c.186-.096.446-.24.757-.433.62-.384 1.445-.966 2.274-1.765C15.302 14.988 17 12.493 17 9A7 7 0 1 0 3 9c0 3.492 1.698 5.988 3.355 7.584a13.731 13.731 0 0 0 2.273 1.765 11.79 11.79 0 0 0 1.04 574l.018.008.006.003ZM10 11.25a2.25 2.25 0 1 0 0-4.5 2.25 2.25 0 0 0 0 4.5Z" clip-rule="evenodd" />
                            </svg>
                            <span class="transition-colors duration-150 group-hover:text-[#029e55]">Douala, Région du Littoral, Cameroun</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="border-t border-white/10 bg-[#0f172a]">
        <p class="px-4 py-6 text-center text-xs text-[#98a2b3]">
            &copy; {{ date('Y') }} Référence Médico Sarl. Tous droits réservés.
        </p>
    </div>
</footer>
