# Forum
- Léo STEVENOT
- Nathan PONCET
## Installation
```shell
composer install
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate # ou :  php bin/console doc:sch:up -f   
php bin/console doctrine:fixtures:load          # Peut prendre un peu de temps avec le hashage des mots de passe
yarn install
yarn build
```

## Commandes
```shell
php bin/console user:create # Créer un User
php bin/console workshop:assign-rooms # Assigner une salle aux ateliers
php bin/console hash:students # Hasher tous les étudiant non hashés
```

## Api
> route : /api/atelier

## Utilisateurs
- Admin
  - email : admin@mail.fr
  - mot de passe : password
- Lycee 1
  - email : lycee1@mail.fr
  - mot de passe : password
- Étudiant 1
  - email : etudiant1@mail.fr
  - mot de passe : password
- Intervenant 1
  - email : intervenant1@mail.fr
  - mot de passe : password