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

In your `config/auth.php` ensure that you have correctly specified your User model and table in the `providers` array.

```php
'providers' => [
    'users' => [
        'driver' => 'eloquent',
        'model' => Namespace\Of\Your\User\Model\User::class,
		'table' => 'users'
    ],
],
```

### Publish Vendor Files

If you wish, you can publish the configuration file with the `config` tag. This will create a `confirm-new-email` config file in your configuration path and allow you to customise this package to work with your Laravel project. If you do not publish this file then the default values set within [src/config/config.php](src/config/config.php) will be used however this may cause some unintended issues when trying to use this package with your project.

```shell
php artisan vendor:publish --provider="AlexWinder\ConfirmNewEmail\ConfirmNewEmailServiceProvider" --tag="config"
```

This package comes with a number of views for the form and the e-mail markdowns used. If you wish to customise these views for your Laravel project you can do so by publishing with the `views` tag. These files will be published to the `views/vendor/confirm-new-email` directory within the resource path of your project.

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

## Usage

### Routes

In the [src/routes.php](src/routes.php) file, a number of routes have been defined which are used to display the update form, and to process the e-mail address update.

If you choose to use the default views contained within this package you can link to the update form in your views by making use of the following:

- `route(config('confirm-new-email.route.edit.name'))` is a GET request which will display the form used by the user to request an update to their e-mail address.
- `route(config('confirm-new-email.route.update-request.name'))` is a POST request which accepts a `new_email` value for the new users e-mail address. This value is then used to send an e-mail notification to the new e-mail address to confirm the update to the users account.
- `route(config('confirm-new-email.route.update-confirm.name'))` is a GET request which processes the update of the users e-mail address once the confirmation link has been clicked.

If you wish you can opt not to use `route(config('confirm-new-email.route.edit.name'))` and you can create your own form. However, in your form to make use of this package you must submit with a POST request to `route(config('confirm-new-email.route.update-request.name'))` or `route(config('confirm-new-email.route.update-request.uri'))` and you must send a `new_email` value to this route. For example:

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

#### E-Mail Verification

`email-verify` is a boolean value which when set to `true` will also update the users verified at datetime.

Please note that this value will be updated to the current datetime stamp as is the same method used within Laravel. Therefore if you have changed the default way Laravel verifies users then you should leave this value set to `false`.

If you set this value to true you must do the following:

- You must ensure that the field in your project which stores the datetime for the user verified field is correctly set in the config. This is configured in the `config('confirm-new-email.user.fields.verified-datetime')` value.
- You must ensure that your User model has the user verified field added to its `$fillable` array if you are protecting against mass-assignment in your Laravel project, by default all Eloquent models protect against mass-assignment. If you do not add this value to the `$fillable` array you will receive a mass-assignment exception. For example:

    ```php
    <?php

    namespace App;

    use Illuminate\Database\Eloquent\Model;

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

#### Redirect

`redirect` is an array of values used to specify named routes used to redirect the user at points in the process.

**Please note that these are named routes and so the named route must exist within your Laravel project.**

- `config('confirm-new-email.redirect.update-confirm)` is the named route of the location that the user will be redirected to upon successful verification of a users new e-mail address. By default this is set to redirect back to [src/view/email-edit.blade.php](src/views/email-edit.blade.php). For more information please see the [Route/URI Names Section](#route-urinames)

#### Route URI/Names

`route` is an array of values used to define the route names and URI's inside the [src/routes.php](src/routes.php) file. If you wish to customise the route name/URI from this package for your Laravel project then you should edit these configuration values.

If you are working from a default Laravel project then you likely do not need to change these values, unless of course you do not like the naming convention. If you have conflicting route names/URI's already in your Laravel project then these default values should be changed.

All of the `name` values for the routes should be unique to each other.

It should be noted that if you change from the default values for the `config('confirm-new-email.route.edit.name')` then you may also need to update `config('confirm-new-email.redirect.update-confirm')` to match your new route name as listed in [the Redirect section](#redirect).

#### Update Expiry

`update-expiry` is an array of values which is used to set an expiry limit on the e-mail address confirmation. When these values are correctly set the user will have a set number of minutes to confirm their new e-mail address.

- `config('confirm-new-email.update-expiry.enabled')` is a boolean and should be set to a `true` value if you wish to enable this.
- `config('confirm-new-email.update-expiry.limit')` is an integer which is the number of minutes a user has to confirm their new e-mail address. If this value is set to 0 this will have the same effect as setting a `false` value to `config('confirm-new-email.update-expiry.enabled')`.

#### User Settings

`user` is an array of values which relates to the User model in your Laravel project.

- `config('confirm-new-email.user.email')` is the field for the e-mail address for your User model.
- `config('confirm-new-email.user.verified-datetime')` is the **datetime** field for when the users e-mail address was verified. Note that this field is required to be part of the `$fillable` array in your User model and you must correctly set the `config('confirm-new-email.email-verify')` value. See [the E-Mail Verification section](#e-mail-verification) for further details.

## E-Mail Notifications

When a POST request with a `new_email` value is sent to `config('confirm-new-email.route.update-request.name')` the following happens:

- The new e-mail address is validated to ensure that it has been sent, and hasn't already been persisted in the database.
- An e-mail notification is then sent to the new e-mail address of the user with a URL which must be vistied to confirm the change to their user account.

This URL will be a signed URL to `config('confirm-new-email.route.update-confirm.name')`. This is a GET request which does the following:

- Several checks are done to ensure that the signed URL is valid, that the users e-mail address hasn't changed or that their new e-mail address has become used between the time of them requesting the update and updating their e-mail address.
- The users e-mail address is updated.
- An e-mail notification is sent to the new and old e-mail addresses of the user account, notifying that the e-mail address has been updated on the account.

For both routes the Laravel `auth` middleware is in place - as the user must be fully authenticated to complete the update to their e-mail address.

The e-mail notifications sent make use of [markdown](https://laravel.com/docs/5.8/mail#markdown-mailables). If you wish to edit the content of these e-mails you should [publish the views](#publish-vendor-files) - this will be published to `views/vendor/confirm-new-email` directory within the resource path of your project where you can then edit them to fit your specific needs.

## TODO

- Tests.

## Changelog

A changelog of this project can be found in [CHANGELOG.md](CHANGELOG.md).

## License

This project is licensed under the [MIT License](LICENSE.md).
