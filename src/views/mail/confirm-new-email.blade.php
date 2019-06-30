@component('mail::message')
# Confirm New E-Mail

You are receiving this e-mail as you have submitted a request to update the e-mail address on your account from {{ $old_email }} to {{ $new_email }}.

Please click on the button below to update your e-mail address to {{ $new_email }}.

@if(config('confirm-new-email.update-expiry.enabled') && config('confirm-new-email.update-expiry.limit') > 0)
Please note that this button will expire in {{ config('confirm-new-email.update-expiry.limit') }} minutes.
@endif

@component('mail::button', ['url' => $url])
Confirm New E-Mail
@endcomponent

If you did not request this action then please contact a system administrator immediately.

[{{ config('app.name') }}]({{ url(config('app.url')) }})
@endcomponent
