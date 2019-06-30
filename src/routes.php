<?php

// Route which provides user a form to update their email address
Route::get(config('confirm-new-email.route.edit.uri'), '\AlexWinder\ConfirmNewEmail\ConfirmNewEmailController@edit')
    ->name(config('confirm-new-email.route.edit.name'))
    ->middleware(['web', 'auth']);

// Route which is used to send a request to update a users email address
Route::post(config('confirm-new-email.route.update-request.uri'), '\AlexWinder\ConfirmNewEmail\ConfirmNewEmailController@requestNewEmail')
    ->name(config('confirm-new-email.route.update-request.name'))
    ->middleware(['web', 'auth']);

// Route which is used to confirm the update to a users email address
Route::get(config('confirm-new-email.route.update-confirm.uri'), '\AlexWinder\ConfirmNewEmail\ConfirmNewEmailController@update')
    ->name(config('confirm-new-email.route.update-confirm.name'))
    ->middleware(['web', 'auth']);