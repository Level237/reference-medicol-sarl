<!-- Tiroir Slide-Over d'aperçu rapide de devis -->
<div
    x-data="quotePreviewModal()"
    x-show="isOpen"
    @open-quote-preview.window="open($event.detail)"
    @keydown.escape.window="close()"
    class="relative z-50"
    style="display: none;"
    aria-labelledby="slide-over-title"
    role="dialog"
    aria-modal="true"
>
    <!-- Arrière-plan assombri -->
    <div
        x-show="isOpen"
        x-transition:enter="ease-in-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in-out duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-[#0f172a]/40 backdrop-blur-xs transition-opacity"
        @click="close()"
    ></div>

    <div class="fixed inset-0 overflow-hidden">
        <div class="absolute inset-0 overflow-hidden">
            <div class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-10 sm:pl-16">
                <div
                    x-show="isOpen"
                    x-transition:enter="transform transition ease-in-out duration-300"
                    x-transition:enter-start="translate-x-full"
                    x-transition:enter-end="translate-x-0"
                    x-transition:leave="transform transition ease-in-out duration-200"
                    x-transition:leave-start="translate-x-0"
                    x-transition:leave-end="translate-x-full"
                    class="pointer-events-auto w-screen max-w-xl"
                >
                    <div class="flex h-full flex-col overflow-y-scroll bg-white shadow-2xl border-l border-[#eaecf0]">
                        <!-- En-tête du panneau -->
                        <div class="bg-[#fcfcfd] border-b border-[#eaecf0] px-6 py-5">
                            <div class="flex items-start justify-between">
                                <div class="space-y-1">
                                    <div class="flex items-center gap-2.5">
                                        <h2 class="text-lg font-bold tracking-tight text-[#101828]" id="slide-over-title">
                                            Demande <span x-text="quote?.reference"></span>
                                        </h2>
                                        <template x-if="quote">
                                            <span
                                                :class="quote.status_badge"
                                                class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-0.5 text-xs font-semibold"
                                            >
                                                <span :class="quote.status_dot" class="h-1.5 w-1.5 rounded-full"></span>
                                                <span x-text="quote.status_label"></span>
                                            </span>
                                        </template>
                                    </div>
                                    <p class="text-xs text-[#667085]">
                                        Reçue le <span class="font-medium text-[#344054]" x-text="quote?.created_at"></span> (<span x-text="quote?.created_at_human"></span>)
                                    </p>
                                </div>
                                <button
                                    type="button"
                                    @click="close()"
                                    class="rounded-lg p-1.5 text-[#667085] hover:bg-[#f2f4f7] hover:text-[#101828] transition-colors"
                                    aria-label="Fermer"
                                >
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- État de chargement -->
                        <div x-show="loading" class="flex-1 p-12 flex flex-col items-center justify-center text-center">
                            <div class="inline-block h-8 w-8 animate-spin rounded-full border-4 border-solid border-primary border-r-transparent align-[-0.125em] motion-reduce:animate-[spin_1.5s_linear_infinite]"></div>
                            <p class="mt-3 text-xs font-medium text-[#667085]">Chargement des détails du devis...</p>
                        </div>

                        <!-- Corps du devis -->
                        <div x-show="!loading && quote" class="flex-1 px-6 py-6 space-y-6">
                            <!-- 1. Fiche Coordonnées Client / Établissement -->
                            <div class="rounded-2xl border border-[#eaecf0] bg-[#f8fafc]/50 p-5 space-y-4">
                                <div class="flex items-center justify-between border-b border-[#eaecf0] pb-3">
                                    <span class="text-xs font-bold uppercase tracking-wider text-[#667085]">
                                        Établissement & Contact
                                    </span>
                                    <span
                                        x-show="quote?.organization_type"
                                        x-text="quote?.organization_type"
                                        class="rounded-md bg-white border border-[#e4e7ec] px-2 py-0.5 text-[11px] font-medium text-[#344054]"
                                    ></span>
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                                    <div>
                                        <span class="text-[#667085] block">Établissement</span>
                                        <span class="font-bold text-sm text-[#101828] mt-0.5 block" x-text="quote?.organization_name"></span>
                                        <span class="text-[#667085] mt-1 block" x-text="[quote?.address, quote?.postal_code, quote?.city].filter(Boolean).join(', ') || 'Adresse non renseignée'"></span>
                                    </div>
                                    <div>
                                        <span class="text-[#667085] block">Responsable de la demande</span>
                                        <span class="font-semibold text-sm text-[#101828] mt-0.5 block" x-text="quote?.contact_name"></span>
                                        <div class="mt-2 space-y-1">
                                            <a :href="'mailto:' + quote?.email" class="inline-flex items-center gap-1.5 text-primary hover:underline font-medium">
                                                <svg class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="currentColor">
                                                    <path d="M3 4a2 2 0 0 0-2 2v1.161l8.441 4.221a1.25 1.25 0 0 0 1.118 0L19 7.162V6a2 2 0 0 0-2-2H3Z" />
                                                    <path d="m19 8.839-7.77 3.885a2.75 2.75 0 0 1-2.46 0L1 8.839V14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V8.839Z" />
                                                </svg>
                                                <span x-text="quote?.email"></span>
                                            </a>
                                            <br>
                                            <a :href="'tel:' + quote?.phone" class="inline-flex items-center gap-1.5 text-[#344054] hover:text-primary font-medium">
                                                <svg class="h-3.5 w-3.5 text-[#667085]" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M2 3.5A1.5 1.5 0 0 1 3.5 2h1.148a1.5 1.5 0 0 1 1.465 1.175l.716 3.223a1.5 1.5 0 0 1-1.052 1.767l-.933.267c-.41.117-.643.555-.48.95a11.542 11.542 0 0 0 6.254 6.254c.395.163.833-.07.95-.48l.267-.933a1.5 1.5 0 0 1 1.767-1.052l3.223.716A1.5 1.5 0 0 1 18 15.352V16.5a1.5 1.5 0 0 1-1.5 1.5H15c-1.149 0-2.263-.15-3.326-.43A13.022 13.022 0 0 1 2.43 8.326 13.019 13.019 0 0 1 2 5V3.5Z" clip-rule="evenodd" />
                                                </svg>
                                                <span x-text="quote?.phone"></span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- 2. Message et spécifications du demandeur -->
                            <div x-show="quote?.message" class="rounded-2xl border border-[#eaecf0] bg-white p-5">
                                <span class="text-xs font-bold uppercase tracking-wider text-[#667085] block mb-2">
                                    Message & Remarques du client
                                </span>
                                <p class="text-xs text-[#344054] whitespace-pre-line leading-relaxed bg-[#f9fafb] p-3.5 rounded-xl border border-[#eaecf0]" x-text="quote?.message"></p>
                            </div>

                            <!-- 3. Liste des appareils médicaux demandés -->
                            <div class="rounded-2xl border border-[#eaecf0] bg-white overflow-hidden shadow-2xs">
                                <div class="bg-[#f9fafb] px-5 py-3 border-b border-[#eaecf0] flex items-center justify-between">
                                    <span class="text-xs font-bold uppercase tracking-wider text-[#475467]">
                                        Équipements demandés (<span x-text="quote?.items?.length || 0"></span>)
                                    </span>
                                    <span class="text-xs font-semibold text-[#101828]">
                                        Total indicatif : <span class="text-primary font-bold" x-text="quote?.estimated_total"></span>
                                    </span>
                                </div>

                                <div class="divide-y divide-[#eaecf0]">
                                    <template x-for="item in quote?.items" :key="item.id">
                                        <div class="p-4 flex items-center justify-between gap-4 hover:bg-[#fcfcfd]">
                                            <div class="flex items-center gap-3 min-w-0">
                                                <template x-if="item.image_url">
                                                    <img :src="item.image_url" :alt="item.product_name" class="h-11 w-11 rounded-lg object-cover border border-[#eaecf0] shrink-0" />
                                                </template>
                                                <template x-if="!item.image_url">
                                                    <div class="h-11 w-11 rounded-lg bg-[#f2f4f7] border border-[#eaecf0] flex items-center justify-center text-[#98a2b3] shrink-0">
                                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                                                        </svg>
                                                    </div>
                                                </template>
                                                <div class="min-w-0">
                                                    <h4 class="text-xs font-semibold text-[#101828] truncate" x-text="item.product_name"></h4>
                                                    <template x-if="item.product_reference">
                                                        <span class="text-[11px] text-[#667085] block truncate">Réf: <span x-text="item.product_reference"></span></span>
                                                    </template>
                                                </div>
                                            </div>

                                            <div class="text-right shrink-0">
                                                <span class="inline-flex items-center rounded-md bg-[#f2f4f7] px-2 py-0.5 text-xs font-bold text-[#344054]">
                                                    Qté: <span class="ml-1" x-text="item.quantity"></span>
                                                </span>
                                                <template x-if="item.total_price">
                                                    <span class="block text-xs font-semibold text-[#101828] mt-1" x-text="item.total_price"></span>
                                                </template>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </div>

                            <!-- 4. Formulaire d'action directe : Mise à jour du statut & Notes admin -->
                            <form :action="quote?.update_url" method="POST" class="rounded-2xl border border-[#eaecf0] bg-white p-5 space-y-4">
                                @csrf
                                @method('PUT')

                                <h3 class="text-xs font-bold uppercase tracking-wider text-[#101828] pb-2 border-b border-[#eaecf0]">
                                    Gestion opérationnelle du devis
                                </h3>

                                <div>
                                    <label class="block text-xs font-medium text-[#344054] mb-1">
                                        Statut de traitement
                                    </label>
                                    <select
                                        name="status"
                                        x-model="status"
                                        class="block w-full rounded-xl border border-[#d0d5dd] bg-white px-3.5 py-2 text-xs font-semibold text-[#101828] focus:border-primary focus:ring-1 focus:ring-primary shadow-xs"
                                    >
                                        <option value="pending">⏳ En attente de traitement</option>
                                        <option value="processing">🔍 En cours d'étude biomédicale</option>
                                        <option value="processed">✅ Devis chiffré et envoyé au client</option>
                                        <option value="rejected">❌ Demande rejetée / Sans suite</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-xs font-medium text-[#344054] mb-1">
                                        Notes internes (visibles uniquement par l'équipe)
                                    </label>
                                    <textarea
                                        name="admin_notes"
                                        rows="2"
                                        x-model="adminNotes"
                                        placeholder="Ex: Devis envoyé par email le 08/10, relance prévue le 15/10..."
                                        class="block w-full rounded-xl border border-[#d0d5dd] px-3 py-2 text-xs text-[#101828] focus:border-primary focus:ring-1 focus:ring-primary shadow-xs"
                                    ></textarea>
                                </div>

                                <div class="flex items-center justify-between pt-2">
                                    <button
                                        type="submit"
                                        class="inline-flex items-center justify-center rounded-xl bg-primary px-4 py-2 text-xs font-semibold text-white shadow-xs hover:bg-primary-hover focus:outline-none"
                                    >
                                        Enregistrer les modifications
                                    </button>

                                    <template x-if="quote?.destroy_url">
                                        <button
                                            type="button"
                                            @click="deleteQuote()"
                                            class="text-xs font-medium text-[#d92d20] hover:underline"
                                        >
                                            Supprimer
                                        </button>
                                    </template>
                                </div>
                            </form>
                        </div>

                        <!-- Formulaire caché de suppression -->
                        <form x-ref="deleteForm" :action="quote?.destroy_url" method="POST" class="hidden">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function quotePreviewModal() {
        return {
            isOpen: false,
            loading: false,
            quote: null,
            status: 'pending',
            adminNotes: '',

            open(payload) {
                this.isOpen = true;
                if (typeof payload === 'object' && payload.items) {
                    this.setQuote(payload);
                    return;
                }

                const url = typeof payload === 'string' ? payload : payload.url;
                if (url) {
                    this.fetchQuote(url);
                }
            },

            close() {
                this.isOpen = false;
                this.quote = null;
            },

            async fetchQuote(url) {
                this.loading = true;
                try {
                    const response = await fetch(url, {
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });
                    if (response.ok) {
                        const data = await response.json();
                        this.setQuote(data);
                    }
                } catch (error) {
                    console.error('Erreur lors du chargement du devis:', error);
                } finally {
                    this.loading = false;
                }
            },

            setQuote(data) {
                this.quote = data;
                this.status = data.status;
                this.adminNotes = data.admin_notes || '';
                this.loading = false;
            },

            deleteQuote() {
                if (confirm(`Confirmez-vous la suppression définitive du devis ${this.quote?.reference} ?`)) {
                    this.$refs.deleteForm.submit();
                }
            }
        };
    }
</script>
