<?php

namespace AlexWinder\ConfirmNewEmail;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
     * Update method - WIP.
     */
    public function update()
    {
        
    }
}
