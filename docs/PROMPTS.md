# PROMPTS — playbook du projet

## Comment s'en servir
1. Avant chaque prompt à Marco : il relit rules.md, docs/DESIGN.md et
   docs/DECISIONS.md automatiquement — pas besoin de les recopier.
2. Un prompt = UNE page ou UNE fonctionnalité du BACKLOG. On teste avec
   docs/QA.md avant le prompt suivant.
3. Un prompt qui a marché = copié dans le journal en bas, avec la date.
4. Un prompt qui a échoué = noté aussi, avec ce qu'on a changé pour le
   faire marcher.

## Démarrage du projet

**Prompt (structure)**
> @marco Construis la page d'accueil du BACKLOG. Respecte strictement
> docs/DESIGN.md pour les couleurs et la police. Structure : en-tête avec
> menu, section d'accueil claire (qui je suis / ce que je propose /
> bouton de contact), pied de page avec informations de contact.

## Pages courantes

**Nouvelle page**
> @marco Construis la page [nom] du BACKLOG, en respectant docs/DESIGN.md
> et la structure des autres pages déjà en place.

**Formulaire de contact**
> @marco Ajoute un formulaire de contact (nom, email, message) sur la
> page Contact. Validation côté serveur obligatoire (champs requis,
> format email). Envoie le message par e-mail au propriétaire du site.
> Message de confirmation après envoi réussi, message d'erreur clair
> sinon.

## Revue et correction (boucle standard)

> @julio Relis l'architecture de la page [nom].
> @louis Vérifie la conformité design de la page [nom].
> [lire les rapports, arbitrer en une phrase]
> @marco Applique les points [1, 2...] de la revue de [Julio/Louis].
> @emile Teste la page [nom] selon docs/QA.md.

## Signaler un bug (template à copier)

> Comportement observé : …
> Comportement attendu : …
> Pour reproduire : 1) … 2) … 3) …
> Message d'erreur console (F12), si visible : …
> @marco Corrige sans toucher aux autres pages, et explique en une phrase
> ce que tu as changé et pourquoi.

## Journal des prompts qui ont marché

| Date | But | Prompt (copié tel quel) | Résultat |
|------|-----|--------------------------|----------|
| | | | |

## Journal des prompts qui ont échoué (et pourquoi)

| Date | Prompt | Ce qui a raté | Ce qu'on a changé |
|------|--------|----------------|---------------------|
| | | | |
