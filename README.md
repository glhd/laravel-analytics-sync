# Laravel Analytics Sync

> Package to help automatically sync Google Analytics client IDs with your User models for use with the Google Analytics Measurement Protocol.

## Installation

You should use [Composer](http://getcomposer.org) to install *Laravel Analytics Sync* package:

```
composer require galahad/laravel-analytics-sync
```

### Configuring the Service Provider

In `config/app.php`:

```php
'providers' => [
    // ...
    Galahad\LaravelAnalyticsSync\GoogleAnalyticsServiceProvider::class,
],
```

### Saving the Configuration File *(optional)*

Run the following command:

```
php artisan vendor:publish
```

This will save a `analytics.php` file under `/config`, with the following content:

```php
return [
    /*
    |--------------------------------------------------------------------------
    | User table
    |--------------------------------------------------------------------------
    |
    | This is the table name where you store User models.
    |
    */
    'table' => 'users',
    /*
    |--------------------------------------------------------------------------
    | Google Analytics Client ID column name
    |--------------------------------------------------------------------------
    |
    | This is the column name on the User model, where the Google Analytics
    | Client ID is stored.
    |
    */
    'column' => 'analytics_client_id',
];
```

You can change each configuration value if you want. Those configurations will be used to generate the required migration file under `/database/migrations`.

### Migration File

Now you have to generate the migration file to add a `analytics_client_id` column on the `users` table (or the values you've set in the configuration file):

```
php artisan analytics:migration
```

And now run the migration:

```
php artisan migrate
```

### Configuring the Google Analytics Middleware

Now you have to add `GoogleAnalyticsMiddleware` to your `app/Http/Kernel.php`:

```php
protected $middleware = [
    // ...
    \Galahad\LaravelAnalyticsSync\GoogleAnalyticsMiddleware::class,
];
```

### Google Analytics Cookie

Now you should tell Laravel to not encrypt the Google Analytics cookie (`_ga`). Add the cookie key to your `/app/Http/Middleware/EncryptCookies.php`:

```php
protected $except = [
    // ...
    \Galahad\LaravelAnalyticsSync\GoogleAnalyticsMiddleware::COOKIE_KEY,
];
```

## Licence

[MIT License](http://mit-license.org/) © Galahad Inc.