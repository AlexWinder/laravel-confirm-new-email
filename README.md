# Verify Updated User Email Address in Laravel 5

## Instructions

Register the [EmailUpdateServiceProvider](src/EmailUpdateServiceProvider.php) in the providers of your Laravel application under `config/app.php` in the `providers` array.

```php
'providers' => [
    ...
    AlexWinder\ConfirmNewEmail\ConfirmNewEmailServiceProvider::class,
    ...
],
```

## License
This project is licensed under the [MIT License](LICENSE.md).