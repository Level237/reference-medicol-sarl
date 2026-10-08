# Architecture

⚠️ À personnaliser en séance 1, avant de demander la première page à Marco.

## Stack
Laravel [version] · Blade · SQLite (ou MySQL) · Tailwind (ou CSS simple)

## Où vit quoi
- Pages / routes : `routes/web.php`
- Vues : `resources/views/`
- Logique simple (ex : envoi du formulaire de contact) : `app/Http/Controllers/`
- Styles : [Tailwind via CDN, ou fichier CSS dans `public/`]

## Entités de données

Catalogue, en place :

- Category — nom, slug, description, image de profil (nullable), texte alternatif, meta_title, meta_description, meta_image, ordre, publié
- Product — catégorie, nom, slug, référence, résumé, description, caractéristiques (JSON), prix et prix promo (vides autorisés, indicatifs), meta_title, meta_description, meta_image, mis en avant, ordre, publié. Pas de colonne image. Le montant affiché est le prix promo seulement s’il est strictement inférieur au prix ; sinon le prix. Les deux vides : pas de montant public
- ProductImage — produit, chemin du fichier, texte alternatif, ordre. La première selon l’ordre est la photo de carte. Supprimer le produit supprime ses photos. Une catégorie qui contient des produits ne se supprime pas

Les fichiers image restent sur le disque. La base ne stocke que le chemin.

Connexion admin : chemin dans `config/access.php` (`/k8f3c1a9e2`), `SessionController`, vue `resources/views/access/login.blade.php`. Image `public/assets/images/login.jpeg`. Le compte est créé par `AdminSeeder` (`ADMIN_NAME`, `ADMIN_EMAIL`, `ADMIN_PASSWORD`). Seul un utilisateur `is_admin` reste connecté. Le middleware `admin` (`EnsureAdmin`) protège `routes/admin.php`. Les tentatives sont limitées par le limiteur `access` (5 par minute, e-mail + adresse IP).

À venir : demande de devis et ses lignes, message de contact.

## Conventions
- Une page = une route = une vue Blade dédiée.
- Pas de logique métier dans les vues : ce qui calcule ou décide vit dans
  un contrôleur.
- Nommage des routes en anglais, cohérent (`/contact`, `/about`, `/services`).
