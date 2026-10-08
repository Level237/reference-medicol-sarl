# Design du projet

Document de référence imposé à toute l'équipe (Marco, Louis, Julio, Emilie, Emile, Paul).

## Police
- Police principale : Instrument Sans (titres et texte courant)
- Polices alternatives de secours : ui-sans-serif, system-ui, sans-serif

## Couleurs
- Couleur primaire : #029e55 (vert médical principal — boutons d'action, accents forts, focus)
- Couleur secondaire / accent : #edbb45 (doré / ocre — filets d'accent, badges, promotions)
- Fond clair : #FFFFFF
- Fond sombre (si utilisé) : #0F172A
- Texte principal : #1D2939 (titres et texte fort)
- Texte secondaire : #667085 (labels, sous-titres, placeholders)
- Texte tertiaire / discret : #98A2B3 (séparateurs, aides)
- Bordures : #E4E7EC
- Succès : #029e55
- Erreur : #D92D20
- Avertissement : #edbb45

## Stack CSS
- Framework : Tailwind CSS v4 exclusivement (compilé via Vite).
- Pas de fichiers CSS pur / vanilla dédiés par vue. Toutes les interfaces sont composées à l'aide des classes utilitaires Tailwind et du fichier `resources/css/app.css`.

## Règle imposée à tous les agents
L'IA (Marco, Louis) ne doit jamais introduire une nouvelle couleur ou une
nouvelle police en dehors de cette liste sans validation explicite du
porteur du projet.
