# Verify Updated User Email Address in Laravel 5

## Installation

Require this package into your `composer.json`.

```shell
composer require alexwinder/laravel-confirm-new-email
```

Register the [ConfirmNewEmailServiceProvider](src/ConfirmNewEmailServiceProvider.php) in the providers of your Laravel application under `config/app.php` in the `providers` array.

```php
'providers' => [
    ...
    AlexWinder\ConfirmNewEmail\ConfirmNewEmailServiceProvider::class,
    ...
],
```

In your `config/auth.php` ensure that you have correctly specified your User model in the `providers` array.

```php
'providers' => [
    'users' => [
        'driver' => 'eloquent',
        'model' => Namespace\Of\Your\User\Model\User::class,
    ],
],
```

## TODO

- Tests.

## License

This project is licensed under the [MIT License](LICENSE.md).
