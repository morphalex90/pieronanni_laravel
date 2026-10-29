<div align="center">
<h1><a href="https://www.pieronanni.me">Piero Nanni v3 - Laravel + React</a></h1>
<img src="public/img/background.webp" >

[![Laravel Forge Site Deployment Status](https://img.shields.io/endpoint?url=https%3A%2F%2Fforge.laravel.com%2Fsite-badges%2F65b8f08b-bfed-4207-a450-95255d6f41d6%3Flabel%3D1&style=flat)](https://forge.laravel.com/mor/personal-qwc/2856930)
[![tests](https://github.com/morphalex90/pieronanni_laravel/actions/workflows/tests.yml/badge.svg)](https://github.com/morphalex90/pieronanni_laravel/actions/workflows/tests.yml)
![Static Badge](https://img.shields.io/badge/Laravel-v13.x-red?style=flat&logo=laravel&label=Laravel)
![Static Badge](https://img.shields.io/badge/PHP-8.4-4F5B93?style=flat&logo=php&php=8.4)
</div>

## Locally install & run

copy .env.example to .env and edit the necessary data

    composer install
    npm install
    php artisan storage:link
    php artisan google-fonts:fetch
    composer run dev

then open http://localhost:8000

### Pint

    ./vendor/bin/pint --parallel

### Larastan

    ./vendor/bin/phpstan analyse

### Rector

    ./vendor/bin/rector

### Create model with migration, controller, resource and factory

    php artisan make:model Post -mcrf
