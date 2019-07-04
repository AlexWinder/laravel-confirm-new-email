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

## Prepare Your Laravel Project

If you choose to use this package there are a number of things of note you should be aware of which may require you making changes to your Laravel project.

1. The views located in [src/views](src/views/) make use of some default Laravel configuration settings. If you opt to use these views without publishing them to your project or configuring them for your use case then you should check that the following are set in your project:

    - `config('app.name')`
    - `config('app.url')`

2. Your project should be correctly configured with e-mail server settings to allow e-mail verification notifications to be sent via e-mail to the user. To configure your particular use case for your project please consult the [Laravel documentation](https://laravel.com/docs/5.8/mail).

3. Your Eloquent User model should contain an `email` attribute which relates to that users e-mail address. If you are using the default User model/migration provided by Laravel out of the box then it is unlikely that you will need to change this. However, if you have changed the value from its default then the simplest way to resolve this is to define an accessor in your User model for the `email` attribute:

    ```php
    <?php

    namespace App;

    use Illuminate\Database\Eloquent\Model;

    class User extends Model
    {
        /**
        * Get the user's e-mail address.
        *
        * @return string
        */
        public function getEmailAttribute()
        {
            return $this->your_current_email_address_attribute;
        }
    }
    ```

## TODO

- Tests.

## License

This project is licensed under the [MIT License](LICENSE.md).
