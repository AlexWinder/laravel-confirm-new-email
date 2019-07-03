# Verify Updated User Email Address in Laravel 5

## Installation

### Require Into Composer

Require this package into your `composer.json`.

```shell
composer require alexwinder/laravel-confirm-new-email
```

### Register Service Provider

Register the [ConfirmNewEmailServiceProvider](src/ConfirmNewEmailServiceProvider.php) in the providers of your Laravel application under `config/app.php` in the `providers` array.

```php
'providers' => [
    ...
    AlexWinder\ConfirmNewEmail\ConfirmNewEmailServiceProvider::class,
    ...
],
```

### Confirm User Model

In your `config/auth.php` ensure that you have correctly specified your User model in the `providers` array.

```php
'providers' => [
    'users' => [
        'driver' => 'eloquent',
        'model' => Namespace\Of\Your\User\Model\User::class,
    ],
],
```

### Publish Vendor Files

If you wish, you can publish the configuration file with the `config` tag. This will allow you to customise this package to work with your Laravel project. If you do not publish this file then the default values set within [src/config/config.php](src/config/config.php) will be used however this may cause some unintended issues with your project.

```shell
php artisan vendor:publish --provider="AlexWinder\ConfirmNewEmail\ConfirmNewEmailServiceProvider" --tag="config"
```

This package comes with a number of views for the form and the email markdowns used. If you wish to customise these views for your Laravel project you can do so by publishing with the `views` tag. These files will be published to the `views/vendor/confirm-new-email` directory within your project.

```shell
php artisan vendor:publish --provider="AlexWinder\ConfirmNewEmail\ConfirmNewEmailServiceProvider" --tag="views"
```

## TODO

- Tests.

## License

This project is licensed under the [MIT License](LICENSE.md).
