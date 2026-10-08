# Template — Équipe d'agents pour site vitrine Laravel

## Où mettre ces fichiers

Copie tout ce dossier à la racine de ton projet Laravel. La structure
finale doit ressembler à ça :

```
mon-projet-laravel/
├── .github/
│   └── agents/
│       ├── marco.agent.md
│       ├── julio.agent.md
│       ├── louis.agent.md
│       ├── emilie.agent.md
│       ├── emile.agent.md
│       └── paul.agent.md
├── docs/
│   ├── PRODUCT.md
│   ├── ARCHITECTURE.md
│   ├── DESIGN.md
│   ├── DECISIONS.md
│   ├── BACKLOG.md
│   ├── PROMPTS.md
│   ├── QA.md
│   ├── ROADMAP.md
│   ├── SECURITY-JOURNAL.md
│   └── BUG-JOURNAL.md
├── rules.md
├── app/            ← déjà généré par Laravel
├── routes/         ← déjà généré par Laravel
└── ...
```

Le dossier `.github/agents/` est l'emplacement reconnu par VS Code /
GitHub Copilot pour les agents personnalisés — chaque fichier
`xxx.agent.md` apparaît automatiquement dans le sélecteur d'agent du
chat, ou s'invoque avec `@xxx` (ex : `@marco`, `@julio`).

## Avant de commencer (obligatoire)

Remplace tous les `[...]` avant la première demande faite à Marco :

1. `docs/PRODUCT.md` — ton activité, ta cible, tes pages.
2. `docs/ARCHITECTURE.md` — la version de Laravel/PHP utilisée.
3. `docs/DESIGN.md` — ta police (fonts.google.com) et ta palette
   (coolors.co).
4. `rules.md` — le nom du projet et sa description.
5. `docs/BACKLOG.md` — ajuste la liste des pages si besoin.

Les fichiers `docs/DECISIONS.md`, `docs/PROMPTS.md` et `docs/QA.md` sont
déjà prêts à l'emploi — tu les remplis au fil du projet, pas avant.

## Comment utiliser l'équipe au quotidien

1. Demande à **Marco** de construire une page du backlog :
   `@marco construis la page d'accueil du backlog.`
2. Une fois la page construite, appelle un ou plusieurs relecteurs :
   `@louis vérifie cette page.`
   `@julio vérifie l'architecture de cette page.`
3. Lis le rapport (un tableau court), puis dis à Marco quoi appliquer :
   `@marco applique les points 1 et 2 de la revue de Louis.`
4. En fin de fonctionnalité, appelle **Emile** :
   `@emile teste la page d'accueil.`
5. Avant de mettre le site en ligne, appelle **Paul** et **Emilie** :
   `@paul audite le projet.`
   `@emilie propose la stratégie SEO du site.`

## Ce qui n'est PAS inclus dans ce template

- **Lamine** (performance) : pas nécessaire pour un site vitrine simple.
  Si le site grossit ou devient lent, demande le template "e-commerce"
  qui l'inclut.
- Un système de compte utilisateur ou de paiement : si ton projet en a
  besoin, ce n'est plus un site vitrine — utilise le template
  "vente en ligne", qui inclut un Paul en version complète (pas la
  version allégée de ce template).

## Règle d'or à ne jamais casser

Seul **Marco** modifie le code de l'application. Tous les autres agents
sont soit en lecture seule (Julio, Louis, Emilie), soit limités à un
seul fichier journal (Paul → SECURITY-JOURNAL.md, Emile →
BUG-JOURNAL.md). Ne donne jamais l'outil `edit` sur le code lui-même à
un agent d'audit — c'est ce qui garantit qu'une seule "main" touche
l'application, et que tu sais toujours qui a changé quoi.
