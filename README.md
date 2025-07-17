<div align="center">
<h1><a href="https://www.pieronanni.me">Piero Nanni v3 - Laravel + React</a></h1>
<img src="public/img/background.webp" >

[![Laravel Forge Site Deployment Status](https://img.shields.io/endpoint?url=https%3A%2F%2Fforge.laravel.com%2Fsite-badges%2F98049798-aa73-42c9-9c32-f3c79c1fd59b&style=flat)](https://forge.laravel.com/servers/921076/sites/2724402)
[![Laravel](https://github.com/morphalex90/pieronanni_laravel/actions/workflows/laravel.yml/badge.svg)](https://github.com/morphalex90/pieronanni_laravel/actions/workflows/laravel.yml)
![Static Badge](https://img.shields.io/badge/Laravel-v12.x-red?style=flat&logo=laravel&label=Laravel)
![Static Badge](https://img.shields.io/badge/PHP-8.3-4F5B93?style=flat&logo=php&php=8.3)
</div>

## Locally install & run
copy .env.example to .env and edit the necessary data

    composer install
    npm install
    php artisan storage:link
    composer run dev
    
then open http://localhost:8000

### Pint
    ./vendor/bin/pint --parallel

### Larastan
    ./vendor/bin/phpstan analyse

### Create model with migration, controller, resource and factory
    php artisan make:model Post -mcrf
