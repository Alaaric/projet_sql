# Projet PHP avec Docker et MySQL

Ce projet est une application PHP utilisant MySQL comme base de données Sql et mongoDB comme base de données NoSql, Docker pour la conteneurisation, et Composer pour la gestion des dépendances et l'autolaoding qui est sympa quand même on va pas se mentir.

## Technologies utilisées

- **PHP** : Langage principal pour l’application.
- **MySQL** : Base de données relationnelle.
- **MongoDB** : Base de données non relationnelle.
- **Docker** : Conteneurisation de l'application et des services.
- **Apache** : Serveur web pour servir l’application.
- **Composer** : Gestionnaire de dépendances PHP.

## Prérequis

Assurez-vous d’avoir les outils suivants installés sur votre machine :

- [Docker](https://www.docker.com/)
- [Docker Compose](https://docs.docker.com/compose/)
- [Git](https://git-scm.com/)

## Installation et mise en place

1. **Cloner le projet :**

   ```bash
   git clone git@github.com:Alaaric/projet_sql.git
   cd projet_sql
   ```

2. **Configurer le fichier `.env` :**

   Créez un fichier `.env` sur la base du `.env.sample` à la racine du projet et remplissez-le avec les informations suivantes :

   ```env
   DB_HOST=mysql_db
   DB_NAME=db_name
   DB_USER=db_user
   DB_PASSWORD=db_password
   MYSQL_ROOT_PASSWORD=root_password

   MONGO_HOST=mongo-db
   MONGO_INITDB_ROOT_USERNAME=db_user
   MONGO_INITDB_ROOT_PASSWORD=db_password
   MONGO_INITDB_PORT=27017
   MONGO_INITDB_DATABASE=db_name
   ```

3. **Démarrer les conteneurs Docker :**

   ```bash
   docker-compose up --build
   ```

4. **Accéder à l’application :**
   Ouvrez votre navigateur et rendez-vous à :

   ```
   http://localhost:8080
   ```

5. **Se connecter :**

- Pour un compte admin': email: `place@holder.com` mdp: `test`.
- Pour un compte client: email: `lorem@ipsum.com` mdp: `test`.

## Structure du projet

- **`src/`** : Contient le code source PHP.
- **`public/`** : Contient les fichiers accessibles publiquement, y compris `index.php`.
- **`docker-compose.yml`** : Configuration Docker Compose.
- **`.env`** : Fichier d’environnement pour les variables sensibles.
- **`setup-database.sql`** : Script SQL pour réinisialiser la base de données MySQL si besoin.
- **`setup-mongo.js`** : Script JS pour réinisialiser la base de données MongoDB si besoin.

## Autres Infos

- Pas le temps d'intégrer les commandes correctement donc j'ai préféré ne pas le faire.
- Je n'ai pas investis beaucoup de temps sur tout ce qui concerne l'interface donc c'est minimaliste, mal centré, mal placé, mal organisé. J'ai juste fais en sorte que ce soit un peux mieux que pas de CSS du tout.
- Gestion des erreurs incomplète.
