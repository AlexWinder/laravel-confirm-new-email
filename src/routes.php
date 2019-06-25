<?php

// Route which provides user a form to update their email address
Route::get(config('confirm-new-email.route.edit.uri'), '\AlexWinder\ConfirmNewEmail\ConfirmNewEmailController@edit')
    ->name(config('confirm-new-email.route.edit.name'));

// Route which is used to update a users email address
Route::post(config('confirm-new-email.route.update.uri'), '\AlexWinder\ConfirmNewEmail\ConfirmNewEmailController@update')
    ->name(config('confirm-new-email.route.update.name'));