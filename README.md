# Verify Updated User E-Mail Address in Laravel 5

This is a package for [Laravel](https://laravel.com/) which provides functionality that when a user wants to update their e-mail address they must first verify their new e-mail address for it to be successfully updated. This is particularly useful if you want to ensure that a user has control of an e-mail address when they want to make this change to their account.

This is done by sending an e-mail notification to the new users e-mail address, when they click on the link inside that e-mail then their e-mail address will be updated on the system. Upon a successful update of a users e-mail address a second e-mail notification is then sent to the new and the old e-mail address notifying the user of the change to their account.

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

If you wish, you can publish the configuration file with the `config` tag. This will create a `confirm-new-email` config file in your configuration path and allow you to customise this package to work with your Laravel project. If you do not publish this file then the default values set within [src/config/config.php](src/config/config.php) will be used however this may cause some unintended issues when trying to use this package with your project.

```shell
php artisan vendor:publish --provider="AlexWinder\ConfirmNewEmail\ConfirmNewEmailServiceProvider" --tag="config"
```

This package comes with a number of views for the form and the email markdowns used. If you wish to customise these views for your Laravel project you can do so by publishing with the `views` tag. These files will be published to the `views/vendor/confirm-new-email` directory within the resource path of your project.

```shell
php artisan vendor:publish --provider="AlexWinder\ConfirmNewEmail\ConfirmNewEmailServiceProvider" --tag="views"
```

## TODO

- Tests.

## License

This project is licensed under the [MIT License](LICENSE.md).
