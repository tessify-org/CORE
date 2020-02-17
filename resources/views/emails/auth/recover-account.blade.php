@component('mail::message')
# @lang('auth.recover_account_email_title')

{!! $text !!}

@component('mail::button', ['url' => route('auth.reset-password', ['email' => $user->email, 'code' => $user->recovery_code])])
    @lang('auth.recover_account_email_button')
@endcomponent

{!! $closing_text !!} 
@endcomponent
