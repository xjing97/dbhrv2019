@component('mail::message')
# User Password Reset

This is your new generated password for your email, {{ $email }}.

@component('mail::panel')
{{ $pass }}
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
