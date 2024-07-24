- Installation packages

```bash
# Versions utilisées
# PHP 8.1
# Node 22
composer install
npm install
```
- Init db  
Configurer DATABASE_URL dans le .env ou le .env.local
```bash
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
php bin/console doctrine:fixtures:load
```
- Générer les assets
```bash
npm run dev
```

- Générer les clés pour l'auth JWT
```bash
php bin/console lexik:jwt:generate-keypair
```
- Identifiants utilisateurs test
>'admin@admin.fr' => 'admin'  
>'user@user.fr => 'user'


TODO : 
- Corriger edit animal
- Permissions route /admin
- Tri + filtre
- Persistance en cascade des relations
- Upload images
- Gestion statut