<?php

/*
|--------------------------------------------------------------------------
| Authentication Language Lines
|--------------------------------------------------------------------------
| 
| The following language lines are used throughout the authentication
| section of the Tessify Core.
|
*/

return [
      
    //
    // Middleware
    //
    
    'middleware_login_required' => 'Je moet ingelogd zijn om die pagina te mogen bekijken.',
    'middleware_guest_required' => 'Die pagina kun je alleen zien als je niet bent ingelogd.',
    'middleware_banned_permanently' => 'Je bent permanent gebanned van het platform.',
    'middleware_banned_temporarily' => 'Je bent nog :days :day gebanned van het platform.',
    'middleware_ban_lifted' => 'Je ban is opgeheven, probeer een ban te voorkomen in de toekomst aub.',
    'middleware_banned_temporarily_day' => 'dag',
    'middleware_banned_temporarily_days' => 'dagen',
    
    //
    // Login page
    // 

    'login_title' => 'Aanmelden',
    'login_email' => 'E-mailadres',
    'login_password' => 'Wachtwoord',
    'login_remember_me' => 'Onthoud mijn gegevens',
    'login_submit' => 'Inloggen',
    'login_forgot_password' => 'Wachtwoord vergeten?',
    'login_register_text' => 'Nog geen account? Registreer nu een account',
    'login_about_title' => 'Wat is NNW?',
    'login_about_text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus ipsum enim, tempor nec lobortis non, vulputate sit amet libero. Nunc eget interdum sem. Fusce eu luctus turpis, sed scelerisque turpis. Aliquam tortor nulla, hendrerit eu maximus eget, egestas nec lectus. Pellentesque convallis imperdiet faucibus.',
    'login_more_title' => 'Meer weten?',
    'login_more_text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus ipsum enim, tempor nec lobortis non, vulputate sit amet libero. Nunc eget interdum sem. Fusce eu luctus turpis, sed scelerisque turpis. Aliquam tortor nulla, hendrerit eu maximus eget, egestas nec lectus. Pellentesque convallis imperdiet faucibus.',
    'login_welcome_back' => 'Welkom terug :name',
    'login_password_incorrect' => 'Het wachtwoord was incorrect, probeer het opnieuw.',

    //
    // Register page
    //

    'register_title' => 'Registreren',
    'register_annotation' => 'Aanhef',
    'register_first_name' => 'Voornaam',
    'register_last_name' => 'Achternaam',
    'register_email' => 'E-mailadres',
    'register_password' => 'Wachtwoord',
    'register_confirm_password' => 'Bevestig wachtwoord',
    'register_submit' => 'Registreer je account!',
    'register_go_to_login' => 'Heb je al een account? Ga naar inloggen',
    'register_success' => 'Bedankt voor je registratie! Je bent automatisch ingelogd.',

    //
    // Forgot password page
    //

    'forgot_password_title' => 'Wachtwoord vergeten',
    'forgot_password_intro' => 'Vul hieronder je e-mailadres in en we zullen je een link sturen waarmee je je wachtwoord kan herstellen.',
    'forgot_password_email' => 'E-mailadres',
    'forgot_password_submit' => 'Herstel mijn wachtwoord',
    'forgot_password_back' => 'Ga terug',

    'forgot_password_email_sent_title' => 'E-mail is onderweg!',
    'forgot_password_email_sent_text' => 'Er is zojuist een e-mail verstuurd naar :email met instructies over hoe je je wachtwoord opnieuw kunt instellen.',

    //
    // Reset password page
    //

    'reset_password_title' => 'Wachtwoord resetten',
    'reset_password_form_email' => 'E-mailadres',
    'reset_password_form_code' => 'Herstelcode',
    'reset_password_form_password' => 'Nieuwe wachtwoord',
    'reset_password_form_password_confirmation' => 'Bevestig nieuwe wachtwoord',
    'reset_password_form_back' => 'Annuleren',
    'reset_password_form_submit' => 'Reset mijn wachtwoord',
    'reset_password_error_invalid_email' => 'We konden je wachtwoord niet herstellen want het opgegeven e-mailadres was ongeldig',
    'reset_password_error_invalid_code' => 'We konden je wachtwoord niet herstellen want de opgegeven herstelcode was ongeldig',
    'reset_password_success' => 'Je wachtwoord is opnieuw ingesteld en je kunt nu inloggen!',

    //
    // Recover account email
    //

    'recover_account_email_subject' => 'Herstel jouw Tessify account!',
    'recover_account_email_title' => 'Tessify account herstellen',
    'recover_account_email_text' => 'Hey :name! We hebben een verzoek ontvangen om je account te herstellen.\n\nKlik op de knop hieronder om je wachtwoord te resetten.',
    'recover_account_email_button' => 'Reset mijn wachtwoord',

    //
    // Logout
    //

    'logout_cya_later' => 'Tot de volgende keer!',
    
];