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
- Product — catégorie, nom, slug, résumé, description, caractéristiques (JSON), meta_title, meta_description, meta_image, publié. Pas de colonne image
- ProductImage — produit, chemin du fichier, texte alternatif, ordre. La première selon l’ordre est la photo de carte. Supprimer le produit supprime ses photos. Une catégorie qui contient des produits ne se supprime pas

Les fichiers image restent sur le disque. La base ne stocke que le chemin.

À venir : demande de devis et ses lignes, message de contact, compte admin.

## Conventions
- Une page = une route = une vue Blade dédiée.
- Pas de logique métier dans les vues : ce qui calcule ou décide vit dans
  un contrôleur.
- Nommage des routes en anglais, cohérent (`/contact`, `/about`, `/services`).
