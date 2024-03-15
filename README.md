# ThinkIT Assignment - Articles App

## Prerequisites

- PHP 8.1
- Composer
- Node 14.15
- Npm 6.14

## Stack used:
- Laravel 10.10
- Sqlite

## Installation
After cloning the repository install backend dependencies from project root with Composer:

`$ composer install`

Copy environment example file

`$ mv .env.example .env`

From the project root create database by running:

`$ touch database/database.sqlite`

Run migration and seeder:

`$ php artisan migrate --seed`

From the project root start server by running:

`php artisan serve --PORT=8001`

App should be serving at http://localhost:8001.
Make sure your system has port `8001` available.

## Tests

Run all tests:

`$ ./vendor/bin/pest`






