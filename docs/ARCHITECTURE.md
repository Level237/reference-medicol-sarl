# Architecture

⚠️ À personnaliser en séance 1, avant de demander la première page à Marco.

## Stack
Laravel [version] · Blade · SQLite (ou MySQL) · Tailwind (ou CSS simple)

## Où vit quoi
- Pages / routes : `routes/web.php`
- Vues : `resources/views/`
- Layout public : `resources/views/layouts/public.blade.php`. Il inclut `partials/topbar` (barre de contact) et `partials/header` (logo, navigation, recherche, devis). Ces deux composants sont réutilisés par ce layout. L’accueil est `resources/views/home.blade.php`.
- Logique simple (ex : envoi du formulaire de contact) : `app/Http/Controllers/`
- Styles : [Tailwind via CDN, ou fichier CSS dans `public/`]

## Entités de données

Catalogue, en place :

- Category — nom, slug, description, image de profil (nullable), texte alternatif, meta_title, meta_description, meta_image, ordre, publié
- Product — catégorie, nom, slug, référence, résumé, description, caractéristiques (JSON), prix et prix promo (vides autorisés, indicatifs), quantité en stock (nullable, optionnelle), meta_title, meta_description, meta_image, mis en avant, ordre, publié. Pas de colonne image. Le montant affiché est le prix promo seulement s’il est strictement inférieur au prix ; sinon le prix. Les deux vides : pas de montant public
- ProductImage — produit, chemin du fichier, texte alternatif, ordre. La première selon l’ordre est la photo de carte. Supprimer le produit supprime ses photos. Une catégorie qui contient des produits ne se supprime pas

Les fichiers image restent sur le disque. La base ne stocke que le chemin.

Connexion admin : chemin dans `config/access.php` (`/k8f3c1a9e2`), `SessionController`, vue `resources/views/access/login.blade.php`. Image `public/assets/images/login.jpeg`. Le compte est créé par `AdminSeeder` (`ADMIN_NAME`, `ADMIN_EMAIL`, `ADMIN_PASSWORD`). Seul un utilisateur `is_admin` reste connecté. Le middleware `admin` (`EnsureAdmin`) protège `routes/admin.php`. Les tentatives sont limitées par le limiteur `access` (5 par minute, e-mail + adresse IP).

Tableau de bord : `/k8f3c1a9e2/board` (`DashboardController`, vue `resources/views/admin/dashboard.blade.php`). Le cadre est `resources/views/admin/layout.blade.php` : barre latérale, en-tête, contenu principal. La déconnexion est `POST /k8f3c1a9e2/logout`.

Produits admin : sous le même préfixe secret (`ProductController`, `admin.products.*`). Liste, création, modification, publication et suppression. Les caractéristiques sont une liste nom → valeur. Le slug est généré depuis le nom s’il est vide, et n’est pas recalculé tant qu’on ne le change pas. Les photos et l’image de référencement vont sur le disque `public`, dans `products/`. Supprimer le produit efface aussi ces fichiers.

Catégories admin : sous le même préfixe (`CategoryController`, `admin.categories.*`). Liste, création, modification, publication et suppression. Le slug suit la même règle que le produit. L’image de profil et l’image de référencement vont sur le disque `public`, dans `categories/`. Une catégorie qui contient encore des produits ne se supprime pas.

Demandes de devis admin : sous le même préfixe (`QuoteRequestController`, `admin.quotes.*`). Liste paginée avec filtres par statut (pending, processing, processed, rejected) et recherche textuelle. Panneau latéral (slide-over modal) interactif Alpine.js pour la prévisualisation instantanée en temps réel sans rechargement de page, accessible depuis la liste et depuis le tableau de bord. Mise à jour directe du statut et notes internes. Les lignes `quote_request_items` conservent le libellé et le prix de l'équipement au moment de la demande même si le produit est supprimé du catalogue.

Messages de contact admin : sous le même préfixe (`ContactMessageController`, `admin.messages.*`). Table `contact_messages`. Liste paginée avec filtres par état de lecture (non lus, lus) et recherche textuelle. Panneau latéral (slide-over modal) interactif Alpine.js pour l'aperçu instantané en temps réel, bascule lu/non lu en AJAX, réponse e-mail directe (`mailto:`) et notes internes. Visible également sur le tableau de bord et dans la barre latérale avec badge du nombre de messages non lus.

## Conventions
- Une page = une route = une vue Blade dédiée.
- Pas de logique métier dans les vues : ce qui calcule ou décide vit dans
  un contrôleur.
- Nommage des routes en anglais, cohérent (`/contact`, `/about`, `/services`).
