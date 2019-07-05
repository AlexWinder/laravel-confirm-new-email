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

##  Usage

### Routes

In the [src/routes.php](src/routes.php) file, a number of routes have been defined which are used to display the update form, and to process the e-mail address update.

If you choose to use the default views contained within this package you can link to the update form in your views by making use of the following:

- `route(config('confirm-new-email.route.edit.name'))` is a GET request which will display the form used by the user to request an update to their e-mail address.
- `route(config('confirm-new-email.route.update-request.name'))` is a POST request which accepts a `new_email` value for the new users e-mail address. This value is then used to send an e-mail notification to the new e-mail address to confirm the update to the users account.
- `route(config('confirm-new-email.route.update-confirm.name'))` is a GET request which processes the update of the users e-mail address once the confirmation link has been clicked.

If you wish you can opt not to use `route(config('confirm-new-email.route.edit.name'))` if you so wish and you can create your own form. However, in your form to make use of this package you must submit with a POST request to `route(config('confirm-new-email.route.update-request.name'))` and you must send a `new_email` value to this route. For example:

```html
<form method="POST" action="{{ route(config('confirm-new-email.route.update-request.name')) }}">
    @csrf

    <div class="form-group row">
        <label for="new_email" class="col-md-4 col-form-label text-md-right">New E-Mail Address</label>

        <div class="col-md-6">
            <input id="new_email" type="email" class="form-control" name="new_email" value="{{ old('new_email') }}" required autocomplete="email" autofocus>
        </div>
    </div>

    <div class="form-group row mb-0">
        <div class="col-md-8 offset-md-4">
            <button type="submit" class="btn btn-primary">
                Submit
            </button>
        </div>
    </div>
</form>
```

### Configuration Settings

Whilst every effort has been made to provide detailed information within the configuration file, further information about the configuration values can be found below.

#### Email Verification

`email-verify` is a boolean value which when set to `true` will also update the users verified at datetime.

Please note that this value will be updated to the current datetime stamp as is the same method used within Laravel. Therefore if you have changed the default way Laravel verifies users then you should leave this value set to `false`.

If you set this value to true you must do the following:

- You must ensure that the field in your project which stores the datetime for the user verified field is correctly set in the config. This is configured in the `config('confirm-new-email.user.fields.verified-datetime')` value.
- You must ensure that your User model has the user verified field added to its `$fillable` array if you are protecting against mass-assignment. If you are working in a fresh Laravel project, this is often the case. If you do not add this value to the `$fillable` array you will receive a mass-assignment exception. For example:
    ```php
    class User extends Authenticatable
    {
        /**
        * The attributes that are mass assignable.
        *
        * @var array
        */
        protected $fillable = [
            'name', 'email', 'password', 'email_verified_at',
        ];
    }
    ```

## TODO

- Tests.

## License

This project is licensed under the [MIT License](LICENSE.md).
