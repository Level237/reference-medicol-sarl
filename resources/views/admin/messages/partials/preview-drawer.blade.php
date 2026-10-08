<!-- Tiroir Slide-Over d'aperçu rapide de message de contact -->
<div
    x-data="messagePreviewModal()"
    x-show="isOpen"
    @open-message-preview.window="open($event.detail)"
    @keydown.escape.window="close()"
    class="relative z-50"
    style="display: none;"
    aria-labelledby="message-slide-over-title"
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
                                        <h2 class="text-lg font-bold tracking-tight text-[#101828]" id="message-slide-over-title">
                                            Message reçu
                                        </h2>
                                        <template x-if="msg">
                                            <span
                                                :class="msg.status_badge"
                                                class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-0.5 text-xs font-semibold"
                                            >
                                                <span :class="msg.status_dot" class="h-1.5 w-1.5 rounded-full"></span>
                                                <span x-text="msg.status_label"></span>
                                            </span>
                                        </template>
                                    </div>
                                    <p class="text-xs text-[#667085]">
                                        Reçu le <span class="font-medium text-[#344054]" x-text="msg?.created_at"></span> (<span x-text="msg?.created_at_human"></span>)
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
                            <p class="mt-3 text-xs font-medium text-[#667085]">Chargement du message...</p>
                        </div>

                        <!-- Corps du message -->
                        <div x-show="!loading && msg" class="flex-1 px-6 py-6 space-y-6">
                            <!-- 1. Carte Expéditeur & Établissement -->
                            <div class="rounded-2xl border border-[#eaecf0] bg-[#f8fafc]/50 p-5 space-y-4">
                                <div class="flex items-center justify-between border-b border-[#eaecf0] pb-3">
                                    <span class="text-xs font-bold uppercase tracking-wider text-[#667085]">
                                        Expéditeur
                                    </span>
                                    <template x-if="msg?.organization">
                                        <span
                                            x-text="msg.organization"
                                            class="rounded-md bg-white border border-[#e4e7ec] px-2 py-0.5 text-[11px] font-medium text-[#344054]"
                                        ></span>
                                    </template>
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                                    <div>
                                        <span class="text-[#667085] block">Nom du contact</span>
                                        <span class="font-bold text-sm text-[#101828] mt-0.5 block" x-text="msg?.name"></span>
                                        <template x-if="msg?.organization">
                                            <span class="text-[#667085] mt-1 block">Établissement: <span class="font-medium text-[#344054]" x-text="msg.organization"></span></span>
                                        </template>
                                    </div>
                                    <div>
                                        <span class="text-[#667085] block">Coordonnées directes</span>
                                        <div class="mt-1 space-y-1.5">
                                            <a :href="'mailto:' + msg?.email" class="inline-flex items-center gap-1.5 text-primary hover:underline font-medium">
                                                <svg class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="currentColor">
                                                    <path d="M3 4a2 2 0 0 0-2 2v1.161l8.441 4.221a1.25 1.25 0 0 0 1.118 0L19 7.162V6a2 2 0 0 0-2-2H3Z" />
                                                    <path d="m19 8.839-7.77 3.885a2.75 2.75 0 0 1-2.46 0L1 8.839V14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V8.839Z" />
                                                </svg>
                                                <span x-text="msg?.email"></span>
                                            </a>
                                            <br>
                                            <template x-if="msg?.phone">
                                                <a :href="'tel:' + msg.phone" class="inline-flex items-center gap-1.5 text-[#344054] hover:text-primary font-medium">
                                                    <svg class="h-3.5 w-3.5 text-[#667085]" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M2 3.5A1.5 1.5 0 0 1 3.5 2h1.148a1.5 1.5 0 0 1 1.465 1.175l.716 3.223a1.5 1.5 0 0 1-1.052 1.767l-.933.267c-.41.117-.643.555-.48.95a11.542 11.542 0 0 0 6.254 6.254c.395.163.833-.07.95-.48l.267-.933a1.5 1.5 0 0 1 1.767-1.052l3.223.716A1.5 1.5 0 0 1 18 15.352V16.5a1.5 1.5 0 0 1-1.5 1.5H15c-1.149 0-2.263-.15-3.326-.43A13.022 13.022 0 0 1 2.43 8.326 13.019 13.019 0 0 1 2 5V3.5Z" clip-rule="evenodd" />
                                                    </svg>
                                                    <span x-text="msg.phone"></span>
                                                </a>
                                            </template>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- 2. Objet et Contenu du Message -->
                            <div class="rounded-2xl border border-[#eaecf0] bg-white p-5 space-y-3">
                                <div>
                                    <span class="text-xs font-bold uppercase tracking-wider text-[#667085] block mb-1">
                                        Objet
                                    </span>
                                    <h3 class="text-sm font-bold text-[#101828]" x-text="msg?.subject"></h3>
                                </div>

                                <div class="pt-2 border-t border-[#eaecf0]">
                                    <span class="text-xs font-bold uppercase tracking-wider text-[#667085] block mb-2">
                                        Corps du message
                                    </span>
                                    <div class="rounded-xl border border-[#eaecf0] bg-[#f9fafb] p-4 text-xs text-[#1d2939] whitespace-pre-line leading-relaxed" x-text="msg?.message"></div>
                                </div>

                                <div class="pt-2 flex flex-wrap gap-2">
                                    <a
                                        :href="'mailto:' + msg?.email + '?subject=' + encodeURIComponent('RE: ' + (msg?.subject || 'Votre message'))"
                                        class="inline-flex items-center gap-1.5 rounded-xl bg-primary px-3 py-1.5 text-xs font-semibold text-white shadow-xs hover:bg-primary-hover transition-colors"
                                    >
                                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6" />
                                        </svg>
                                        <span>Répondre par e-mail</span>
                                    </a>

                                    <button
                                        type="button"
                                        @click="toggleReadState()"
                                        class="inline-flex items-center gap-1.5 rounded-xl border border-[#d0d5dd] bg-white px-3 py-1.5 text-xs font-semibold text-[#344054] shadow-xs hover:bg-[#f9fafb] transition-colors"
                                    >
                                        <svg class="h-3.5 w-3.5 text-[#667085]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        <span x-text="msg?.is_read ? 'Marquer comme non lu' : 'Marquer comme lu'"></span>
                                    </button>
                                </div>
                            </div>

                            <!-- 3. Notes internes de suivi -->
                            <form :action="msg?.update_url" method="POST" class="rounded-2xl border border-[#eaecf0] bg-white p-5 space-y-4">
                                @csrf
                                @method('PUT')

                                <h3 class="text-xs font-bold uppercase tracking-wider text-[#101828] pb-2 border-b border-[#eaecf0]">
                                    Suivi interne
                                </h3>

                                <div>
                                    <label class="block text-xs font-medium text-[#344054] mb-1">
                                        Notes réservées à l'équipe
                                    </label>
                                    <textarea
                                        name="admin_notes"
                                        rows="2"
                                        x-model="adminNotes"
                                        placeholder="Ex: Établissement rappelé le 08/10, intéressé par le catalogue blocs opératoires..."
                                        class="block w-full rounded-xl border border-[#d0d5dd] px-3 py-2 text-xs text-[#101828] focus:border-primary focus:ring-1 focus:ring-primary shadow-xs"
                                    ></textarea>
                                </div>

                                <div class="flex items-center justify-between pt-1">
                                    <button
                                        type="submit"
                                        class="inline-flex items-center justify-center rounded-xl bg-[#344054] px-3.5 py-1.5 text-xs font-semibold text-white shadow-xs hover:bg-[#1d2939] focus:outline-none transition-colors"
                                    >
                                        Enregistrer les notes
                                    </button>

                                    <template x-if="msg?.destroy_url">
                                        <button
                                            type="button"
                                            @click="deleteMessage()"
                                            class="text-xs font-medium text-[#d92d20] hover:underline"
                                        >
                                            Supprimer le message
                                        </button>
                                    </template>
                                </div>
                            </form>
                        </div>

                        <!-- Formulaire caché de suppression -->
                        <form x-ref="deleteMsgForm" :action="msg?.destroy_url" method="POST" class="hidden">
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
    function messagePreviewModal() {
        return {
            isOpen: false,
            loading: false,
            msg: null,
            adminNotes: '',

            open(payload) {
                this.isOpen = true;
                if (typeof payload === 'object' && payload.message) {
                    this.setMessage(payload);
                    return;
                }

                const url = typeof payload === 'string' ? payload : payload.url;
                if (url) {
                    this.fetchMessage(url);
                }
            },

            close() {
                this.isOpen = false;
                this.msg = null;
            },

            async fetchMessage(url) {
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
                        this.setMessage(data);
                    }
                } catch (error) {
                    console.error('Erreur lors du chargement du message:', error);
                } finally {
                    this.loading = false;
                }
            },

            setMessage(data) {
                this.msg = data;
                this.adminNotes = data.admin_notes || '';
                this.loading = false;
            },

            async toggleReadState() {
                if (!this.msg?.toggle_read_url) return;
                try {
                    const response = await fetch(this.msg.toggle_read_url, {
                        method: 'PATCH',
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    });
                    if (response.ok) {
                        const res = await response.json();
                        this.msg.is_read = res.is_read;
                        this.msg.status_label = res.status_label;
                        this.msg.status_badge = res.status_badge;
                        this.msg.status_dot = res.status_dot;
                    }
                } catch (err) {
                    console.error('Erreur lors du basculement d\'état:', err);
                }
            },

            deleteMessage() {
                if (confirm(`Confirmez-vous la suppression du message de ${this.msg?.name} ?`)) {
                    this.$refs.deleteMsgForm.submit();
                }
            }
        };
    }
</script>
