<?php

namespace AlexWinder\ConfirmNewEmail;

use AlexWinder\ConfirmNewEmail\ConfirmNewEmailNotification;
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
     * Update method - WIP.
     */
    public function update()
    {
        
    }
}
