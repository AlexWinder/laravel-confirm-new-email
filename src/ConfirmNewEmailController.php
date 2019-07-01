<?php

namespace AlexWinder\ConfirmNewEmail;

use AlexWinder\ConfirmNewEmail\ConfirmNewEmailNotification;
use AlexWinder\ConfirmNewEmail\EmailUpdatedNotification;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\URL;

class ConfirmNewEmailController extends Controller
{
    /**
     * Display the form to allow the user to update their email address.
     *
     * @return View
     */
    public function edit()
    {
        return view('confirm-new-email::email-edit');
    }

    /**
     * User has requested an update to their email address, send notification to new email.
     * 
     * @return Redirect
     */
    public function requestNewEmail(Request $request)
    {
        $user_table = config('auth.providers.users.table');
        $email_field = config('confirm-new-email.user.fields.email');

        // Validate the new email
        $request->validate([
            'new_email' => [
                'required',
                'string',
                'unique:' . $user_table . ',' . $email_field,
                'max:255',
            ],
        ]);
        
        // The parameters to be sent into the signed URL
        $parameters = [
            'user' => auth()->id(),
            'old_email' => auth()->user()->email,
            'new_email' => $request->new_email,
        ];

        // Create a signed URL which is used to confirm the update of the users email
        if(config('confirm-new-email.update-expiry.enabled') && config('confirm-new-email.update-expiry.limit') > 0) 
        {
            $url = URL::temporarySignedRoute(
                config('confirm-new-email.route.update-confirm.name'), 
                now()->addMinutes(config('confirm-new-email.update-expiry.limit')),
                $parameters
            );
        } else {
            $url = URL::signedRoute(
                config('confirm-new-email.route.update-confirm.name'), 
                $parameters
            );
        };

        // Send an email notification to the new email address
        Notification::route('mail', $request->new_email)
                        ->notify(new ConfirmNewEmailNotification($url, $parameters));

        // Set session flash message
        session()->flash('status', 'An e-mail notification has been sent to your new e-mail address to confirm this request.');

        // Redirect back
        return back();
    }

    /**
     * Process the update of the users email address.
     * 
     * @return Redirect
     */
    public function update(Request $request)
    {
        // Check for a valid URL signature
        if(!$request->hasValidSignature()) 
        {
            abort(403);
        }

        // Verify that the logged in user matches the old email
        if(auth()->user()->email != $request->old_email)
        {
            abort(403, 'Your e-mail address already appears to have been updated. If you wish to attempt to update your e-mail address again please request a new update link.');
        }

        // Check that the new email doesn't exist in the database
        $user = config('auth.providers.users.model');
        if($user::where(config('confirm-new-email.user.fields.email'), '=', $request->new_email)->exists())
        {
            abort(403, 'Your new e-mail address appears to be in use. If you wish to attempt to update your e-mail address again please request a new update link.');
        }

        // Check that the old email address could be found
        if(!$user::where(config('confirm-new-email.user.fields.email'), '=', $request->old_email)->exists())
        {
            abort(403, 'Your e-mail address already appears to have been updated. If you wish to attempt to update your e-mail address again please request a new update link.');
        }

        // Proceed with updating the users email address
        $user::where(config('confirm-new-email.user.fields.email'), $request->old_email)
                ->first()
                ->update([
                    config('confirm-new-email.user.fields.email') => $request->new_email,
                ]);

        // Send an email notification to the new email address
        Notification::route('mail', [
                            $request->new_email,
                            $request->old_email,
                        ])
                        ->notify(new EmailUpdatedNotification($request));
        
        // Set session flash message
        session()->flash('status', 'Your e-mail address has been updated.');
        
        // Redirect the user
        return redirect()->route(config('confirm-new-email.route.edit.name'));
    }
}
