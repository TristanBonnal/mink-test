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
bin/console doctrine:database:create
bin/console doctrine:migrations:migrate
```