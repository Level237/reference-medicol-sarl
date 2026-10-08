# DECISIONS — journal des choix du projet

Règles d'utilisation :
- Toute décision importante est écrite ici LE JOUR où elle est prise, avec
  sa raison.
- On ne supprime JAMAIS une ligne : une décision annulée est suivie d'une
  nouvelle ligne marquée "ANNULE D-00X".
- Marco et Julio doivent relire ce fichier avant de proposer ou juger une
  solution technique — ça évite de rediscuter dix fois le même choix.

| ID | Date | Décision | Raison | Alternative écartée |
|----|------|----------|--------|----------------------|
| D-001 | JJ/MM | Stack : Laravel + SQLite pour démarrer | Zéro configuration, on se concentre sur le contenu du site | MySQL dès le départ : mise en place inutile à ce stade |
| D-002 | 08/10 | Catalogue : une catégorie a une image de profil nullable ; un produit n’a pas de colonne image ; ses photos vivent dans `product_images` (chemin, texte alternatif, ordre). `meta_title`, `meta_description` et `meta_image` sont sur la catégorie et sur le produit. La première photo selon `sort_order` est celle de la carte. | Validé par le porteur le 08/10, après revue de Julio | Plusieurs chemins dans une seule colonne produit ; image de catégorie obligatoire |
| D-003 | 08/10 | Produit : `price` et `promo_price` décimaux, vides autorisés ; `reference` unique et vide autorisée ; `is_featured` à non par défaut ; `sort_order` à 0. Le promo s’applique seulement s’il est strictement inférieur au prix. | Validé par le porteur le 08/10, après revue de Julio | Prix obligatoire ; stock ; calendrier de promotion |
| D-004 | 08/10 | Connexion admin à l’adresse `/k8f3c1a9e2`, absente du menu et des adresses `/login` et `/admin/login`. La page suit le rendu fourni. L’inscription publique n’est pas ouverte. | Le porteur a demandé une adresse difficile à trouver | `/admin/login` ; Breeze |
| D-005 | 08/10 | Charte graphique globale & page de connexion : validation de l'Option B. La maquette est déclinée avec la palette officielle de `docs/DESIGN.md` (primaire `#029e55`, accent `#edbb45`, texte `#1D2939`/`#667085`, fond `#FFFFFF`). Ajout du filet d'accent `#edbb45` sous le titre droit. | Cohérence avec l'identité de marque du projet médical | Conserver la palette bleue isolée de la capture |
| D-006 | 08/10 | Framework CSS : utilisation exclusive de Tailwind CSS pour tout le projet (compilation via Vite). Aucun fichier CSS pur / vanilla dédié par vue. | Demande explicite du porteur : homogénéité, rapidité de prototypage et cohérence avec le design system | CSS pur par page / scoped CSS classique |
| D-007 | 08/10 | Compte admin : un booléen `is_admin`, créé par `AdminSeeder` depuis `ADMIN_EMAIL` et `ADMIN_PASSWORD` (hors dépôt). Seul ce compte ouvre une session. Les écrans d’administration passent par le middleware `admin`. Cinq tentatives de connexion par minute, par e-mail et par adresse IP. | Le porteur a demandé le seeder, la connexion, le middleware et la limite. Pas de package de rôles. | Mot de passe écrit dans le seeder ; Spatie Permission |
| D-008 | 08/10 | Tableau de bord à `/k8f3c1a9e2/board`, derrière le middleware `admin`. Après connexion, l’admin y arrive. `/admin` et `/dashboard` n’existent pas. Le cadre (barre latérale, en-tête, contenu) est statique et suit `docs/DESIGN.md`. | Le porteur a demandé un espace protégé. Une adresse `/admin` renverrait les inconnus vers le chemin secret et le rendrait visible. | `/admin` ; page publique après connexion |
| D-009 | 08/10 | Administration produit : caractéristiques en liste nom → valeur. Slug généré depuis le nom s’il est vide, conservé tel quel lors d’une modification, suffixé s’il est déjà pris. Photos sur le disque `public`. Prix promo refusé s’il n’est pas strictement inférieur au prix. Pas de package supplémentaire. | Validé par le porteur le 08/10, après revue de Julio | JSON libre ; bibliothèque d’images |
| D-010 | 08/10 | Administration catégorie : même règle de slug que le produit. Image de profil facultative, avec texte alternatif si elle est présente. Fichiers sur le disque `public`, dans `categories/`. Suppression refusée tant que la catégorie a des produits. Une catégorie neuve est publiée. | Le porteur a demandé le même CRUD que pour les produits. La table existait déjà (D-002). | Nouvelle migration ; suppression en cascade des produits |
| D-011 | 08/10 | Demandes de devis : tables `quote_requests` et `quote_request_items`. Clé étrangère produit `nullOnDelete` avec duplication des noms/références/prix au moment de la demande pour préserver l'historique légal. Prévisualisation interactive par slide-over drawer Alpine.js sans rechargement de page sur le dashboard et sur l'index des devis. | Validé par le porteur le 08/10, après revue de Julio | Page dédiée obligatoire pour un simple coup d'œil ; suppression en cascade effaçant l'historique |

## Décisions à prendre plus tard (en attente)
- Devise unique du catalogue (pas de colonne devise sur le produit)
- Les montants sont-ils hors taxe ou toutes taxes comprises ?
- Faut-il passer à MySQL avant la mise en ligne ?
