<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Route Settings
    |--------------------------------------------------------------------------
    |
    | These values can be customised to avoid conflicting URI's or route names
    | from inside your application, or if you wish to change the name for
    | cosmetic purposes. For convenience a route name has also been defined
    | and should also be updated if this is likely to conflict with other
    | route names inside your application.
    |
    */
    'route' => [
        /**
         * The edit route is that which is used to display the form to allow the user
         * to edit their email address.
         */
        'edit' => [
            'uri' => '/settings/email/edit',
            'name' => 'confirm-new-email.edit',
        ],
    ],
];