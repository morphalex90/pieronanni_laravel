<div align="center">
<h1><a href="https://www.pieronanni.me">Piero Nanni v3 - Laravel + React</a></h1>
<img src="public/img/background.webp" >
</div>

[![Laravel Forge Site Deployment Status](https://img.shields.io/endpoint?url=https%3A%2F%2Fforge.laravel.com%2Fsite-badges%2Fdc181360-959d-46e9-b57e-80dec4611d0e%3Flabel%3D1&style=flat)](https://forge.laravel.com/servers/795161/sites/2438683)
[![Laravel](https://github.com/morphalex90/pieronanni_laravel/actions/workflows/laravel.yml/badge.svg)](https://github.com/morphalex90/pieronanni_laravel/actions/workflows/laravel.yml)
![Static Badge](https://img.shields.io/badge/Laravel-v12.x-red?style=flat&logo=laravel&label=Laravel)
![Static Badge](https://img.shields.io/badge/PHP-8.3-4F5B93?style=flat&logo=php&php=8.3)

## Locally install & run
copy .env.example to .env and edit the necessary data

    composer install
    npm install
    php artisan storage:link
    composer run dev
    
then open http://localhost:8000
### Pint
    ./vendor/bin/pint

### Larastan
    ./vendor/bin/phpstan analyse

### Create model with migration, controller, resource and factory
    php artisan make:model Post -mcrf