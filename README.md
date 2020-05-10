# Project setup
1. [Install docker](https://www.docker.com/products/docker-desktop)
2. in laradock folder: cp .env-example .env
3. enable xdebug
4. change mysql username and pw to the same as project .env
5. cp .env.example .env
6. docker-compose up -d workspace mysql nginx
7. docker-compose exec workspace bash
8. php artisan key:generate
9. composer install, composer update
10. npm install, npm update
11. php artisan migrate:fresh
