# Brief produit

Nom de travail : **Référence Médico SARL** (déduit du dépôt `referencemedicosarl`, à confirmer).

## Activité / problème résolu

Site vitrine B2B qui présente des appareils médicaux destinés aux hôpitaux et aux cliniques. Le visiteur découvre le catalogue, constitue un panier, puis demande un devis. Il n’y a pas de paiement en ligne : le panier sert à préparer une demande, pas à encaisser une commande.

Le site doit aussi recevoir des messages via le formulaire de contact, et permettre à un administrateur de gérer les produits, les demandes de devis et les messages.

## Visiteur cible

- Responsables d’achats, biomédicaux ou techniques d’hôpitaux et de cliniques
- Directeurs d’établissements de santé et décideurs qui comparent des équipements avant de demander un devis
- Équipe interne (admin) qui tient le catalogue à jour et traite les demandes

Le grand public n’est pas la cible. Le ton reste professionnel, clair, et orienté décision d’achat institutionnel.

## Zone géographique (si activité locale)

À confirmer avec le porteur du projet (ville, pays, zone de livraison ou d’intervention). En attendant, le contenu ne doit pas inventer une zone.

## Positionnement

- Vitrine moderne, lisible sur mobile et bureau
- Mieux référencé : une intention de recherche par page, titres et meta uniques, HTML sémantique, URLs stables, images avec texte alternatif
- Conversion = demande de devis qualifiée (établissement, contact, produits concernés), pas un achat immédiat

## Pages du site (périmètre MVP)

Public :

- Accueil
- Catalogue (liste, filtre par catégorie, fiche produit)
- À propos
- Contact
- Demander un devis
- Panier (ajout, retrait, quantités, passage en demande de devis)

Admin (accès authentifié) :

- Tableau de bord
- Produits (création, modification, publication, retrait)
- Demandes de devis
- Messages de contact

Pages de confiance, hors menu principal mais obligatoires avant mise en ligne :

- Mentions légales
- Politique de confidentialité

## Hors périmètre MVP

- Paiement, compte client, suivi de commande
- Multi-langue
- Avis clients, comparateur, configurateur
- Espace client après envoi du devis

Ces sujets ne se construisent pas tant qu’ils ne sont pas ajoutés ici.

## Parcours principal

1. Le visiteur arrive sur l’accueil ou une fiche produit (recherche ou lien direct).
2. Il parcourt le catalogue et ajoute un ou plusieurs appareils au panier.
3. Il envoie une demande de devis depuis le panier, ou un formulaire de devis / de contact.
4. L’admin retrouve la demande, met à jour son statut, et répond en dehors du site (e-mail ou téléphone).

## Succès =

- Un établissement peut trouver un appareil, l’ajouter au panier et envoyer une demande de devis complète sans appeler d’abord.
- L’admin gère produits, devis et contacts sans toucher au code.
- Chaque page publique a un titre, une meta description et un seul `h1`, avec des URLs propres et partageables.

## Contenus encore à fournir

Le porteur enverra les rendus de pages au fil de l’eau. En attendant, ne pas inventer :

- le nom commercial définitif, le logo, l’adresse et les coordonnées
- les textes À propos, les catégories et les fiches produits réelles
- les certifications, marques ou allégations réglementaires
- la zone géographique

## Ordre de démarrage retenu

Le catalogue, le panier et l’admin reposent sur les mêmes données. On fige d’abord le socle (navigation, charte, modèles Produit / Devis / Contact), puis le catalogue et le panier. L’accueil se construit quand son rendu arrive. L’admin vient une fois que les demandes publiques existent vraiment.
