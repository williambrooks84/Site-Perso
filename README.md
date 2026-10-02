# Portfolio William Brooks

Ce projet est mon portfolio personnel. Il présente mon parcours, mes compétences ainsi que les différents projets que j'ai réalisés.

## Technologies utilisées  

### Frontend  
- **Nuxt** ([nuxt.com](https://nuxt.com)) : Framework basé sur Vue.js qui facilite la création d’applications web modernes, rapides et optimisées.
- **Vue.js** ([vuejs.org](https://vuejs.org/)) : utilisé avec Nuxt pour construire l'interface utilisateur.
- **TailwindCSS** ([tailwindcss.com](https://tailwindcss.com/)) : Framework CSS utility-first permettant de concevoir rapidement des interfaces responsives et personnalisées.

### Backend  
- **Symfony** ([symfony.com](https://symfony.com/)) : Framework PHP permettant de développer des applications web robustes, structurées et évolutives.
- **API Platform** : utilisé avec Symfony pour exposer les données du backend via une API.

### Base de données
- **MySQL** ([mysql.com](https://www.mysql.com/)) : système de gestion de base de données utilisé pour stocker les données de l'application.

### Infrastructure
- **Docker** ([docker.com](https://www.docker.com/)) : utilisé pour conteneuriser le backend et la base de données.

### Outils
- **Git / GitHub** ([github.com](https://github.com/)) : gestion du code source et versionnement.

## Installation et Exécution  

### Prérequis

- Node.js ([nodejs.org](https://nodejs.org/fr))
- npm ([npmjs.com](https://www.npmjs.com/))
- Docker Desktop ([docs.docker.com](https://docs.docker.com/desktop/))
- Git ([git-scm.com](https://git-scm.com/))


### 1. Cloner le projet
```bash
git clone https://github.com/williambrooks84/Site-Perso.git
```

### 2. Installation des dépendances  
```bash
cd client
npm install
```

### 3. Lancement du projet en local (2 terminaux)  

#### Terminal 1
```bash
cd client
npm run dev
```

Le frontend est accessible sur http://localhost:3000.

#### Terminal 2
```bash
cd api
cp .env.example .env
docker compose up -d --build 
docker compose exec api php bin/console doctrine:migrations:migrate --no-interaction
```

Le backend est accessible sur http://localhost:8000. 

### Développement local

Pour le développement local, vous pouvez créer un fichier `docker-compose.override.yml` dans le dossier api.

```yaml
services:
  api:
    volumes:
      - ./var/uploads:/var/www/html/api/public/uploads
```
Ce fichier est volontairement ignoré par Git.


```bash
Remove-Item -Recurse -Force node_modules\.vite -ErrorAction SilentlyContinue
Remove-Item -Recurse -Force .nuxt
npm run dev
```
S'il y a des erreurs du style "**Pre-transform error: Failed to resolve import "#app-manifest" from "node_modules/nuxt/dist/app/composables/manifest.js?v=b70d02fc". Does the file exist?**", vous pouvez utiliser ces commandes pour vider le cache de Nuxt et Vite.

## 🌍 Démo en ligne
Le projet est accessible ici 👉 [willbrooks.fr](https://willbrooks.fr)

## Fonctionnalités  
- Présentation de mon profil et de mes compétences
- Présentation des projets
- Filtrage des projets par catégorie
- Carousel de projets
- Interface responsive
- Thème clair / sombre
- API permettant de récupérer les projets