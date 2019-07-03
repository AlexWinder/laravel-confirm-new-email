<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Email Verify Settings
    |--------------------------------------------------------------------------
    |
    | The email-verify setting is used to determine if the users
    | email_verified_at value should also be updated when the user confirms
    | the update of their new email address. When setting this value to true
    | be sure to check that the user.fields.verified_datetime value is correct
    | for your user model. You also may need to add the value set in 
    | user.fields.verified-datetime to your $fillable array in your user model
    | to allow for mass-assignment. Please see README for further details.
    | 
    */
    'email-verify' => false,

    /*
    |--------------------------------------------------------------------------
    | Redirect Settings
    |--------------------------------------------------------------------------
    |
    | These values are used to specify where you wish specific actions to
    | redirect the user. These values should be set to named routes, so
    | ensure that your redirection is correctly named. If you do not use a
    | valid named route then this will not correctly redirect the user.
    |
    */
    'redirect' => [
        /**
         * Where you would like to redirect the user after successful verification
         * of their new email address. By default this is set to the edit page.
         * If you edit the name of edit route then be sure to also update this.
         */
        'update-confirm' => 'confirm-new-email.edit',
    ],

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
         * The update-request route is that which is used to request an update to the
         * users email address.
         */
        'update-request' => [
            'uri' => '/settings/email/edit',
            'name' => 'confirm-new-email.update-request',
        ],
        /**
         * The update-confirm route is that which is used to confirm the update to the
         * users email address. The URI value set here should not match the URI value
         * of any other route.
         */
        'update-confirm' => [
            'uri' => '/settings/email/update',
            'name' => 'confirm-new-email.update-confirm',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Update Expiry Settings
    |--------------------------------------------------------------------------
    |
    | These values relate to if the update has an expiry. If so then the user
    | must confirm their updated email within this time limit to complete
    | the update. The update-expiry.enabled value must be set to true
    | for the update-expiry.limit value to specify the number of minutes
    | for the update to expire.
    |
    */
    'update-expiry' => [
        /**
         * If set to true then the update-expiry.limit value will be used to set an
         * expiry on the update to the email address.
         */
        'enabled' => true,
        /**
         * The limit is the number of minutes that the update expires in, if the
         * update-expiry.enabled value is set to true. If this is set to 0
         * then the update-expiry will be disabled.
         */
        'limit' => 60,
    ],

    /*
    |--------------------------------------------------------------------------
    | User Settings
    |--------------------------------------------------------------------------
    |
    | These values relate to settings of the user which is having their e-mail
    | address updated. In addition to these please also ensure that the 
    | auth.providers.users config values are set. Please see README for
    | further details.
    |
    */
    'user' => [
        /**
         * Specific fields of the database which are to be used to be updated.
         */
        'fields' => [
            /**
             * The field of the user table which stores the email address.
             */
            'email' => 'email',
            /**
             * The field of the user table which stores the datetime that the 
             * user was verified.
             */
            'verified-datetime' => 'email_verified_at',
        ],
    ],
];