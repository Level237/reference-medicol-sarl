@extends('layouts.public')

@section('title', 'Mon panier de devis')
@section('meta_description', 'Rassemblez vos équipements dans une seule demande de cotation. Référence Médico Sarl.')
@section('robots', 'noindex, nofollow')

@php
    $itemCount = $cart->count();
    $totalAmount = $cart->totalAmount();
@endphp

@section('content')
<div class="bg-white py-10 sm:py-14 lg:py-18">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        {{-- En-tête de page conforme à la maquette --}}
        <header class="text-left">
            <h1 class="text-3xl font-extrabold tracking-tight text-[#1d2939] sm:text-4xl lg:text-[2.6rem] lg:leading-tight">
                Mon panier de devis
            </h1>
            <p class="mt-2 text-sm text-[#667085] sm:text-base">
                Rassemblez vos équipements dans une seule demande.
            </p>
        </header>

        {{-- Zone Principale : Grille Panier ou État Vide --}}
        <div id="cart-content-wrapper" class="mt-10 lg:mt-14">
            {{-- État Vide (affiché si aucun article) --}}
            <div id="cart-empty-state" class="{{ $itemCount === 0 ? '' : 'hidden' }} rounded-2xl border border-[#e4e7ec] bg-[#f8fafc] py-16 px-6 text-center">
                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-white text-[#98a2b3] shadow-xs ring-1 ring-[#e4e7ec]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119.993z" />
                    </svg>
                </div>
                <h2 class="mt-4 text-lg font-bold text-[#1d2939]">Votre panier de devis est vide</h2>
                <p class="mx-auto mt-2 max-w-md text-sm text-[#667085]">
                    Explorez notre catalogue de matériel médical pour sélectionner les appareils et consommables adaptés à votre établissement.
                </p>
                <div class="mt-6">
                    <a
                        href="{{ route('catalogue') }}"
                        class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#029e55] px-6 py-3 text-sm font-semibold text-white shadow-sm transition-[transform,background-color] duration-150 ease-out hover:bg-[#028347] active:scale-[0.97]"
                    >
                        <span>Parcourir le catalogue</span>
                        <span aria-hidden="true">&rarr;</span>
                    </a>
                </div>
            </div>

            {{-- État Avec Articles (Mise en page conforme à la maquette) --}}
            <div id="cart-active-state" class="{{ $itemCount > 0 ? '' : 'hidden' }}">
                <div class="grid grid-cols-1 items-start gap-10 lg:grid-cols-12 lg:gap-14">
                    {{-- Colonne GAUCHE : Tableau / Liste des articles (lg:col-span-8) --}}
                    <div class="lg:col-span-8">
                        {{-- En-tête des colonnes Desktop (Produit, Quantité, Prix, Action) --}}
                        <div class="hidden border-b border-[#e4e7ec] pb-4 sm:grid sm:grid-cols-12 sm:gap-4 text-xs font-semibold uppercase tracking-wider text-[#98a2b3]">
                            <div class="sm:col-span-6">Produit</div>
                            <div class="sm:col-span-2 text-center">Quantité</div>
                            <div class="sm:col-span-3 text-right">Prix</div>
                            <div class="sm:col-span-1 text-right">Action</div>
                        </div>

                        {{-- Lignes du panier --}}
                        <ul id="cart-items-list" class="divide-y divide-[#e4e7ec] border-b border-[#e4e7ec] sm:border-t-0">
                            @foreach($items as $productId => $item)
                                <li id="cart-row-{{ $productId }}" class="py-6 sm:py-8 transition-opacity duration-200" data-product-id="{{ $productId }}">
                                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-12 sm:items-center sm:gap-4">
                                        {{-- Colonne Produit (Image + Nom + Résumé) (sm:col-span-6) --}}
                                        <div class="flex items-start gap-4 sm:col-span-6">
                                            {{-- Miniature produit --}}
                                            <div class="relative h-18 w-18 shrink-0 overflow-hidden rounded-xl border border-[#e4e7ec] bg-[#e4e7ec] sm:h-20 sm:w-20">
                                                @if(!empty($item['image']))
                                                    <img
                                                        src="{{ asset('storage/' . $item['image']) }}"
                                                        alt="{{ $item['name'] }}"
                                                        class="absolute inset-0 h-full w-full object-cover"
                                                        loading="lazy"
                                                    >
                                                @else
                                                    <div class="flex h-full w-full items-center justify-center text-[#98a2b3]">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-[#029e55]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                                                        </svg>
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="min-w-0 flex-1">
                                                <h3 class="text-base font-bold text-[#1d2939] hover:text-[#029e55] transition-colors leading-snug">
                                                    <a href="{{ route('products.show', $item['slug']) }}">
                                                        {{ $item['name'] }}
                                                    </a>
                                                </h3>
                                                @if(!empty($item['reference']))
                                                    <p class="font-mono text-xs font-semibold text-[#1d2939]">
                                                        {{ $item['reference'] }}
                                                    </p>
                                                @endif
                                                @if(!empty($item['summary']))
                                                    <p class="mt-1 line-clamp-2 text-xs leading-relaxed text-[#667085]">
                                                        {{ $item['summary'] }}
                                                    </p>
                                                @endif
                                            </div>
                                        </div>

                                        {{-- Colonne Quantité (- 1 +) (sm:col-span-2) --}}
                                        <div class="flex items-center justify-between sm:justify-center sm:col-span-2">
                                            <span class="text-xs text-[#98a2b3] sm:hidden">Quantité:</span>
                                            <div class="inline-flex items-center gap-2 rounded-lg border border-[#e4e7ec] bg-white px-2 py-1 shadow-2xs">
                                                <button
                                                    type="button"
                                                    onclick="updateCartItemQuantity({{ $productId }}, -1)"
                                                    class="flex h-6 w-6 items-center justify-center rounded text-sm font-bold text-[#667085] hover:bg-[#f2f4f7] hover:text-[#1d2939] active:scale-95 transition-all"
                                                    aria-label="Diminuer"
                                                >
                                                    &minus;
                                                </button>
                                                <span id="qty-val-{{ $productId }}" class="w-6 text-center text-sm font-bold text-[#1d2939]">
                                                    {{ $item['quantity'] }}
                                                </span>
                                                <button
                                                    type="button"
                                                    onclick="updateCartItemQuantity({{ $productId }}, 1)"
                                                    class="flex h-6 w-6 items-center justify-center rounded text-sm font-bold text-[#667085] hover:bg-[#f2f4f7] hover:text-[#1d2939] active:scale-95 transition-all"
                                                    aria-label="Augmenter"
                                                >
                                                    +
                                                </button>
                                            </div>
                                        </div>

                                        {{-- Colonne Prix (sm:col-span-3) --}}
                                        <div class="flex items-center justify-between sm:justify-end sm:col-span-3 text-right">
                                            <span class="text-xs text-[#98a2b3] sm:hidden">Prix:</span>
                                            @if(!empty($item['price']))
                                                <div class="flex flex-col">
                                                    <span class="text-sm font-bold text-[#1d2939]">
                                                        {{ number_format((float) $item['price'] * (int) $item['quantity'], 0, ',', ' ') }} FCFA
                                                    </span>
                                                    @if((int)$item['quantity'] > 1)
                                                        <span class="text-[11px] text-[#98a2b3]">
                                                            {{ number_format((float) $item['price'], 0, ',', ' ') }} FCFA / u
                                                        </span>
                                                    @endif
                                                </div>
                                            @else
                                                <span class="text-sm font-semibold text-[#1d2939]">
                                                    Prix sur devis
                                                </span>
                                            @endif
                                        </div>

                                        {{-- Colonne Action Retirer (sm:col-span-1) --}}
                                        <div class="flex items-center justify-end sm:col-span-1">
                                            <button
                                                type="button"
                                                onclick="removeCartItem({{ $productId }})"
                                                class="group inline-flex items-center gap-1 text-xs font-medium text-[#98a2b3] hover:text-[#d92d20] transition-colors"
                                                title="Retirer ce produit"
                                            >
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                </svg>
                                                <span class="sm:hidden">Retirer</span>
                                            </button>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>

                        {{-- Lien retour catalogue en bas à gauche conforme maquette --}}
                        <div class="mt-8 text-left">
                            <a
                                href="{{ route('catalogue') }}"
                                class="inline-flex items-center gap-2 text-sm font-semibold text-[#029e55] transition-colors hover:text-[#028347]"
                            >
                                <span aria-hidden="true">&larr;</span>
                                <span class="underline underline-offset-4">Continuer mes recherches</span>
                            </a>
                        </div>
                    </div>

                    {{-- Colonne DROITE : "Votre sélection" (lg:col-span-4) --}}
                    <div class="lg:col-span-4">
                        <div class="sticky top-28 rounded-2xl border border-[#e4e7ec] bg-white p-6 sm:p-8 shadow-xs">
                            <h2 class="text-xl font-bold tracking-tight text-[#1d2939]">
                                Votre sélection
                            </h2>

                            {{-- Nombre d'articles avec icône panier --}}
                            <div class="mt-4 flex items-center gap-2.5 text-sm font-semibold text-[#1d2939]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#029e55]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119.993z" />
                                </svg>
                                <span id="summary-article-count">
                                    {{ $itemCount }} {{ $itemCount > 1 ? 'articles' : 'article' }}
                                </span>
                            </div>

                            {{-- Montant estimatif ou sur devis --}}
                            <div class="mt-6 border-t border-[#e4e7ec] pt-5">
                                <span class="text-xs font-semibold uppercase tracking-wider text-[#667085]">
                                    Montant :
                                </span>
                                <div class="mt-1">
                                    <span id="summary-total-amount" class="text-2xl font-extrabold tracking-tight text-[#1d2939]">
                                        @if($totalAmount !== null)
                                            {{ number_format($totalAmount, 0, ',', ' ') }} <span class="text-sm font-bold text-[#667085]">FCFA</span>
                                        @else
                                            sur devis
                                        @endif
                                    </span>
                                </div>
                                <p class="mt-2 text-xs leading-relaxed text-[#667085]">
                                    Les prix et délais seront précisés par notre équipe.
                                </p>
                            </div>

                            {{-- Bouton d'action Finaliser la demande --}}
                            <div class="mt-6">
                                <a
                                    href="{{ route('quotes.create') }}"
                                    class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-[#0f172a] px-6 py-3.5 text-center text-sm font-semibold text-white shadow-sm transition-[transform,background-color] duration-150 ease-out hover:bg-[#1e293b] active:scale-[0.98]"
                                >
                                    <span>Finaliser ma demande</span>
                                    <span aria-hidden="true">&rarr;</span>
                                </a>
                            </div>

                            {{-- Bloc d'assistance téléphonique conforme maquette --}}
                            <div class="mt-8 border-t border-[#e4e7ec] pt-6">
                                <div class="flex items-start gap-3">
                                    <div class="shrink-0 text-[#1d2939]">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#1d2939]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 18.75a6 6 0 006-6v-1.5m-6 7.5a6 6 0 01-6-6v-1.5m6 7.5v3.75m-3.75 0h7.5M12 15.75a3 3 0 01-3-3V4.5a3 3 0 116 0v8.25a3 3 0 01-3 3z" />
                                        </svg>
                                    </div>
                                    <div class="text-left">
                                        <h3 class="text-xs font-bold text-[#1d2939]">
                                            Besoin d'un conseil ?
                                        </h3>
                                        <p class="text-xs text-[#667085]">
                                            Notre équipe est à votre écoute.
                                        </p>
                                        <a href="tel:+237699850500" class="mt-2 inline-flex items-center gap-1.5 text-xs font-bold text-[#1d2939] hover:text-[#029e55] transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-3.5 w-3.5 text-[#029e55]">
                                                <path fill-rule="evenodd" d="M2 3.5A1.5 1.5 0 0 1 3.5 2h1.148a1.5 1.5 0 0 1 1.465 1.175l.716 3.223a1.5 1.5 0 0 1-1.052 1.767l-.933.267c-.41.117-.643.555-.48.95a11.542 11.542 0 0 0 6.254 6.254c.395.163.833-.07.95-.48l.267-.933a1.5 1.5 0 0 1 1.767-1.052l3.223.716A1.5 1.5 0 0 1 18 15.352V16.5a1.5 1.5 0 0 1-1.5 1.5H15c-1.149 0-2.263-.15-3.326-.43A13.022 13.022 0 0 1 2.43 8.326 13.019 13.019 0 0 1 2 5V3.5Z" clip-rule="evenodd" />
                                            </svg>
                                            <span>+237 699 850 500</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Gestion dynamique AJAX du panier --}}
<script>
    const csrfToken = '{{ csrf_token() }}';

    function updateHeaderBadges(count) {
        const badge = document.getElementById('cart-counter-badge');
        const mobileBadge = document.querySelector('.mobile-cart-badge');

        [badge, mobileBadge].forEach(el => {
            if (el) {
                el.textContent = count;
                if (count > 0) {
                    el.classList.remove('hidden');
                } else {
                    el.classList.add('hidden');
                }
            }
        });
    }

    function checkEmptyCart(count) {
        if (count === 0) {
            const activeState = document.getElementById('cart-active-state');
            const emptyState = document.getElementById('cart-empty-state');
            if (activeState && emptyState) {
                activeState.classList.add('hidden');
                emptyState.classList.remove('hidden');
            }
        }
    }

    function updateCartItemQuantity(productId, delta) {
        const qtySpan = document.getElementById(`qty-val-${productId}`);
        if (!qtySpan) return;

        const currentQty = parseInt(qtySpan.textContent.trim()) || 1;
        const newQty = currentQty + delta;

        if (newQty <= 0) {
            removeCartItem(productId);
            return;
        }

        fetch(`/panier/${productId}`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            },
            body: JSON.stringify({ quantity: newQty }),
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                qtySpan.textContent = data.quantity;

                // Mise à jour résumé droit
                const summaryCount = document.getElementById('summary-article-count');
                if (summaryCount) {
                    summaryCount.textContent = `${data.count} ${data.count > 1 ? 'articles' : 'article'}`;
                }

                if (data.formatted_total) {
                    const summaryTotal = document.getElementById('summary-total-amount');
                    if (summaryTotal) summaryTotal.textContent = data.formatted_total;
                }

                updateHeaderBadges(data.count);
            }
        })
        .catch(err => console.error('Erreur mise à jour panier:', err));
    }

    function removeCartItem(productId) {
        const row = document.getElementById(`cart-row-${productId}`);
        if (row) {
            row.style.opacity = '0.4';
        }

        fetch(`/panier/${productId}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            },
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                if (row) {
                    row.remove();
                }

                const summaryCount = document.getElementById('summary-article-count');
                if (summaryCount) {
                    summaryCount.textContent = `${data.count} ${data.count > 1 ? 'articles' : 'article'}`;
                }

                if (data.formatted_total) {
                    const summaryTotal = document.getElementById('summary-total-amount');
                    if (summaryTotal) summaryTotal.textContent = data.formatted_total;
                }

                updateHeaderBadges(data.count);
                checkEmptyCart(data.count);
            }
        })
        .catch(err => {
            if (row) row.style.opacity = '1';
            console.error('Erreur suppression article:', err);
        });
    }
</script>
@endsection
