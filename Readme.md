# Solorecipes

Solorecipes is a simple module written in laravel to help manage meal plans for the week.

## Current Status
Basic recipe creation has been added.

## Installation

```php
'providers' => [
    ...
    Solocode\Solorecipes\SolorecipesServiceProvider::class,
],
```

```
php artisan vendor:publish
php artisan migrate
```