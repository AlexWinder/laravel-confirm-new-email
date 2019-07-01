@component('mail::message')
# E-Mail Address Updated

You are receiving this email as you have updated the email address on your account from {{ $old_email }} to {{ $new_email }}. 

If you did not request this action then please contact a system administrator immediately.

[{{ config('app.name') }}]({{ url(config('app.url')) }})
@endcomponent
