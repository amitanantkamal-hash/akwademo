@component('mail::message')
# Welcome, {{ $user->name }}

Your account has been successfully created.

We are excited to have you with us!

Thanks,<br>
{{ config('app.name') }}
@endcomponent