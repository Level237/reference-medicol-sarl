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

## Décisions à prendre plus tard (en attente)
- [ex : faut-il passer à MySQL avant la mise en ligne ?]
