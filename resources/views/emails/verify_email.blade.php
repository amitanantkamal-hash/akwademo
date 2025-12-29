@component('mail::message')
# Verify Your Email Address

Hi **{{ $pending->name }}**,  
Thank you for registering with **{{ config('app.name') }}**.

To complete your registration, please verify your email address by clicking the button below:

@component('mail::button', ['url' => $verify_url])
Verify Email
@endcomponent

This verification link will expire in **24 hours**.  
If you did not create an account, you can safely ignore this email.

---

Thanks,  
**The {{ config('app.name') }} Team**

@endcomponent
