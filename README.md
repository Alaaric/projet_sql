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

## Installation et mise en place

1. **Cloner le projet :**

   ```bash
   git clone <URL_DU_DEPOT>
   ```

2. **Configurer le fichier `.env` :**

   Créez un fichier `.env` à la racine du projet et remplissez-le avec les informations suivantes :

   ```env
   DB_NAME=nom_de_la_base_de_donnees
   DB_USER=utilisateur
   DB_PASSWORD=mot_de_passe
   MYSQL_ROOT_PASSWORD=mot_de_passe_root
   ```

3. **Installer les dépendances PHP :**

   ```bash
   composer install
   ```

4. **Démarrer les conteneurs Docker :**

   ```bash
   docker-compose up --build
   ```

5. **Accéder à l’application :**
   Ouvrez votre navigateur et rendez-vous à :
   ```
   http://localhost:8080
   ```

## Structure du projet

- **`src/`** : Contient le code source PHP.
- **`public/`** : Contient les fichiers accessibles publiquement, y compris `index.php`.
- **`docker-compose.yml`** : Configuration Docker Compose.
- **`.env`** : Fichier d’environnement pour les variables sensibles.
- **`setup-database.sql`** : Script SQL pour réinisialiser la base de données si besoin.

se connecter avec les identifier place@holder mdp: test pour un compte admin
