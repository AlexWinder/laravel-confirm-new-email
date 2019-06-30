<?php

namespace AlexWinder\ConfirmNewEmail;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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
     * Request new email method - WIP.
     */
    public function requestNewEmail(Request $request)
    {
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
    }

    /**
     * Update method - WIP.
     */
    public function update()
    {
        
    }
}
