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
    | route names inside your application. It is important that all values
    | set in these routes should all contain unique 'name' values.
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
        /**
         * The update-request route is that which is used to request an update to the users email address.
         */
        'update-request' => [
            'uri' => '/settings/email/edit',
            'name' => 'confirm-new-email.update-request',
        ],
        /**
         * The update-confirm route is that which is used to confirm the update to the users email address.
         * The URI value set here should not match the URI value of any other route.
         */
        'update-confirm' => [
            'uri' => '/settings/email/update',
            'name' => 'confirm-new-email.update-confirm',
        ],
    ],
];