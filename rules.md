# Règles du projet

⚠️ À personnaliser avant de démarrer.

## Le projet
- Nom du projet : [______]
- Activité / à propos : [______]
- Stack : Laravel [version], PHP [version], SQLite (ou MySQL)

## Conventions
- Les vues restent simples (Blade), pas de logique métier dans les vues.
- Nommage des routes et des fichiers en anglais, cohérent sur tout le
  projet.
- Le design suit strictement docs/DESIGN.md — voir ce fichier pour le
  détail.

## Les fichiers du projet, et qui les lit
- docs/PRODUCT.md — le brief du site (activité, cible, pages). Lu par
  Emilie et Louis.
- docs/ARCHITECTURE.md — la stack et les conventions techniques. Lu par
  Julio et Marco.
- docs/DESIGN.md — police, couleurs, composants. Lu par Marco et Louis.
- docs/DECISIONS.md — journal des choix déjà tranchés. Lu par Marco et
  Julio avant toute proposition technique.
- docs/BACKLOG.md — les pages/fonctionnalités à construire, dans l'ordre.
  Lu par Marco.
- docs/PROMPTS.md — le playbook de prompts prêts à l'emploi, et le
  journal de ce qui a marché ou échoué.
- docs/QA.md — la checklist de vérification. Lu par Emile.
- docs/ROADMAP.md — le plan séance par séance de ce projet.
- docs/SECURITY-JOURNAL.md — écrit uniquement par Paul.
- docs/BUG-JOURNAL.md — écrit uniquement par Emile.

## Équipe d'agents de ce projet
- Marco : seul agent autorisé à modifier le code (hors journaux).
- Julio : relit l'architecture backend. Lecture seule.
- Louis : relit la conformité visuelle. Lecture seule.
- Emilie : propose la stratégie SEO. Lecture seule.
- Emile : teste le site, écrit uniquement dans docs/BUG-JOURNAL.md.
- Paul : audite la sécurité de base, écrit uniquement dans
  docs/SECURITY-JOURNAL.md.

## Boucle de correction (ordre permanent)
- Un agent d'audit (Julio, Louis, Emilie) rapporte dans le chat.
- Le chef de projet arbitre en une phrase : "applique 1 et 3", "passe 2".
- Marco applique uniquement ce qui a été validé.
- Pour les journaux (Paul, Emile) : Marco lit les entrées ouvertes en
  début de séance et propose un ordre de traitement ; le chef de projet
  valide l'ordre.
- Personne ne recopie un rapport à la main : les agents se lisent entre
  eux directement dans le chat ou dans les journaux.
