# API Clinique Vétérinaire

Ce projet est une API développée avec Symfony et API Platform pour la gestion d'une clinique vétérinaire. L'API gère les utilisateurs, les animaux, les rendez-vous et les traitements.

## Membres du groupe

- BOUDJEMELINE Haider Rayan

## Installation

### 1. Cloner le projet

```bash
git clone https://github.com/BrayanOfficiel/symfony_api_rendu.git
cd symfony_api_rendu
```

### 2. Installer les dépendances

```bash
composer install
```

### 3. Configurer l'environnement

Modifier la ligne de connexion à la base de données :

```env
DATABASE_URL="mysql://root:root@127.0.0.1:3306/iim_api_veterinaire"
```

### 4. Créer la base de données et importer les utilisateurs

```bash
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
mysql -u root -p iim_api_veterinaire < users.sql
```

ou importer manuellement le fichier `users.sql`.

Le fichier `users.sql` contient les utilisateurs préconfigurés.

### 5. Lancer le serveur

```bash
symfony server:start
```

L'API est maintenant accessible sur `http://127.0.0.1:8000`.

## Documentation de l'API

L'API expose une documentation OpenAPI automatiquement générée.

Accès via Swagger :  
[http://127.0.0.1:8000/api/docs](http://127.0.0.1:8000/api/docs)

## Utilisation avec Postman

Une collection Postman est fournie pour faciliter les tests.

### 1. Importer la collection Postman

1. Ouvrir **Postman**.
2. Aller dans **File > Import**.
3. Importer le fichier `Clinique Vétérinaire.postman_collection.json` fourni.

### 2. Authentification

Avant de tester les requêtes, obtenir un token JWT.

1. Exécuter la requête `POST Creates a user token.`
2. Envoyer les informations d'identification :
   ```json
   {
     "email": "admin@vet.fr",
     "password": "admin"
   }
   ```
3. Copier le token retourné et le coller dans l'onglet **Authorization** de Postman sous forme de `Bearer Token`.

### 3. Tester les requêtes

Les requêtes de l'API sont préconfigurées dans Postman.

⚠️ **Ne pas modifier directement le JSON des requêtes**. Postman génère automatiquement les champs nécessaires dans l'interface. Utiliser les formulaires et tableaux fournis par Postman pour remplir les paramètres.

### Structure de la collection Postman

- **Collection principale** : Collection de base.
    - **API** : Dossier contenant les requêtes de l'API.
      - **Entités** : Chaque entité a son propre dossier.
          - **Requêtes principales** : Contient `POST` et `GET Collection`.
          - **Dossier ID** : Contient les requêtes nécessitant un ID (`GET`, `PUT`, `PATCH`, `DELETE`).
      - **Auth** : Requête d'authentification.

⚠️ **Ne pas modifier les fichiers e.g. de la collection**. Pour exécuter une requête :
1. Générer un token JWT via la requête d'authentification.
2. L'ajouter dans **Authorization** sous forme de `Bearer Token`.
3. Modifier uniquement les champs nécessaires dans l'onglet **Body** selon les besoins.

## Rôles et Accès

L'API gère plusieurs rôles avec des permissions différentes :

- **Directeur** (`ROLE_DIRECTOR`) : Gérer le personnel.
- **Vétérinaire** (`ROLE_VETERINARIAN`) : Gérer les traitements et rendez-vous.
- **Assistant** (`ROLE_ASSISTANT`) : Gérer les rendez-vous et fiches animaux.
- **Client** (non authentifié) : Aucun accès spécifique.
