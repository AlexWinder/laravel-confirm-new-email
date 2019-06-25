<?php

// Route which provides user a form to update their email address
Route::get(config('confirm-new-email.route.edit.uri'), '\AlexWinder\ConfirmNewEmail\ConfirmNewEmailController@edit')
    ->name(config('confirm-new-email.route.edit.name'));