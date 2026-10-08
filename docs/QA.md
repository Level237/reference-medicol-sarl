# QA — vérifier sans savoir lire le code

## Règle d'or
On ne vérifie PAS en lisant le code. On vérifie en utilisant le site
comme un visiteur, puis en regardant la console du navigateur (F12) et
les éventuels messages d'erreur affichés.

## Checklist par page (à refaire à chaque page cochée dans BACKLOG.md)

- [ ] Cas nominal : la page s'ouvre sans erreur et son contenu est correct
- [ ] Tous les liens du menu et du pied de page fonctionnent
- [ ] Design : couleurs, polices, espacements conformes à DESIGN.md
- [ ] Fenêtre réduite (largeur 375 px) → tout reste lisible et utilisable
- [ ] Console (F12) : aucune erreur rouge
- [ ] Commit fait après validation

## Checklist spécifique au formulaire de contact

- [ ] Cas nominal : envoi avec des informations valides → confirmation visible
- [ ] Champ obligatoire vide → message clair, aucun envoi
- [ ] Adresse e-mail invalide → message clair, aucun envoi
- [ ] Caractères spéciaux et émojis dans le message → affichés/traités correctement
- [ ] Test malveillant : message contenant `<img src=x onerror=alert(1)>` → rien
      ne s'exécute
- [ ] Double-clic rapide sur "Envoyer" → pas d'envoi en double

## Checklist de fin de projet ("mise en ligne")

- [ ] Toutes les pages du BACKLOG.md cochées ET passées à la checklist ci-dessus
- [ ] docs/DECISIONS.md à jour (aucune décision prise oralement sans trace)
- [ ] Revue de Paul faite (docs/SECURITY-JOURNAL.md sans faille critique ouverte)
- [ ] Revue d'Emilie faite (titres, meta descriptions en place)
- [ ] QA visuel final par comparaison de captures (maquette vs rendu)
- [ ] Commit final

## Bugs connus non corrigés (assumés)

| Date | Description | Gravité | Statut |
|------|-------------|---------|--------|
| | | | |

## Ce que QA n'est pas
QA n'est pas "cliquer une fois et dire que ça marche". QA, c'est chercher
activement à casser ce qu'on vient de construire — avant qu'un visiteur
réel ne le fasse à notre place.
