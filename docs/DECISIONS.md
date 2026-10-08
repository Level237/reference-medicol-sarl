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

## Décisions à prendre plus tard (en attente)
- Devise unique du catalogue (pas de colonne devise sur le produit)
- Les montants sont-ils hors taxe ou toutes taxes comprises ?
- Faut-il passer à MySQL avant la mise en ligne ?
