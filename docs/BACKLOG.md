# Backlog du site vitrine

Liste des pages et fonctionnalités à construire, dans l’ordre.
Marco lit ce fichier avant de construire quoi que ce soit.

Le site est une vitrine B2B d’appareils médicaux (hôpitaux et cliniques).
Le panier prépare une demande de devis : pas de paiement.
Brief : `docs/PRODUCT.md`. Couleurs déjà fixées : primaire `#029e55`, secondaire `#edbb45`.

## À faire

### 1. Socle (à faire en premier)

Le rendu des pages arrivera au fil de l’eau. On ne commence pas par l’accueil pixel-perfect.

- [ ] Charte : couleurs `#029e55` et `#edbb45` reportées dans `docs/DESIGN.md`, puis layout public (en-tête, pied de page, navigation)
- [ ] Navigation : Accueil, Catalogue, À propos, Contact, Demander un devis, accès Panier
- [x] Modèles Catégorie, Produit et galerie d’images (metas titre, description, image inclus)
- [ ] Modèles Demande de devis (+ lignes), Message de contact, compte Admin
- [ ] SEO de base sur chaque page dès qu’elle existe : `<title>`, meta description, un seul `h1`, URL en slug, texte alternatif des images

### 2. Catalogue

Cœur du site. Indépendant du rendu final de l’accueil.

- [ ] Page Catalogue : liste des produits publiés, filtre par catégorie, état vide
- [ ] Fiche produit : nom, catégorie, description, visuel, caractéristiques, bouton « Ajouter au panier »
- [ ] Ajout au panier depuis la fiche (et depuis la liste si le rendu le prévoit)

### 3. Panier et demande de devis

- [ ] Page Panier : lignes, quantités, retrait, total indicatif s’il est affiché, lien vers la demande de devis
- [ ] Page Demander un devis : formulaire établissement + contact, prérempli avec le contenu du panier
- [ ] Enregistrement de la demande et accusé visible pour le visiteur (e-mail de notification : à brancher quand l’adresse d’expédition est connue)

### 4. Pages vitrine

À construire dans cet ordre, en calant le HTML sur le rendu fourni pour chaque page.

- [ ] Page d’accueil (hero, catégories ou produits mis en avant, appel vers le catalogue et le devis)
- [ ] Page À propos
- [ ] Page Contact avec formulaire (nom, établissement, e-mail, téléphone, message) et enregistrement du message

### 5. Administration

- [x] Page de connexion admin sur `/k8f3c1a9e2` (hors menu, sans inscription publique)
- [x] Rôle admin sur le compte
- [x] Tableau de bord protégé (barre latérale, en-tête, contenu principal)
- [x] Gestion des produits (créer, modifier, publier, dépublier, supprimer)
- [x] Gestion des catégories (créer, modifier, publier, dépublier, supprimer)
- [x] Gestion des demandes de devis (liste, détail, statut, prévisualisation interactive slide-over)
- [x] Gestion des messages de contact (liste, détail, marquer comme lu, prévisualisation interactive slide-over)

### 6. Référencement et mise en confiance

- [ ] Passe SEO : sitemap, `robots.txt`, Open Graph, données structurées Organisation + Produit, fil d’Ariane
- [ ] Mentions légales et politique de confidentialité
- [ ] Revue mobile du parcours catalogue → panier → devis

## En cours

## Terminé

## Plus tard (hors MVP)

- Paiement, comptes clients, suivi de commande
- Multi-langue
- Filtres avancés (marque, spécialité, disponibilité) une fois le catalogue réel connu
