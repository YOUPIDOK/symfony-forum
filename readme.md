# Forum
- Léo STEVENOT
- Nathan PONCET
## Installation
```shell
composer install
php bin/console doctrine:database:create
php bin/console doctrine:schema:update --force
php bin/console doctrine:fixtures:load          # Peut prendre un peux de temps avec le hashage des mots de passe
yarn install
yarn build
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