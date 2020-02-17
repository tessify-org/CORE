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

    'middleware_login_required' => 'You must be logged in to view that page.',
    'middleware_guest_required' => 'You can only view that page if you\'re not logged in.',

    //
    // Login page
    //

    'login_title' => 'Login',
    'login_email_text' => 'E-mail',
    'login_password_text' => 'Password',
    'login_remember_me_text' => 'Remember me',
    'login_submit_text' => 'Login',
    'login_forgot_password_text' => 'Forgot your password?',
    'login_register_text' => 'Don\'t have an account yet? Register now.',
    'login_about_title' => 'What is NNW?',
    'login_about_text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus ipsum enim, tempor nec lobortis non, vulputate sit amet libero. Nunc eget interdum sem. Fusce eu luctus turpis, sed scelerisque turpis. Aliquam tortor nulla, hendrerit eu maximus eget, egestas nec lectus. Pellentesque convallis imperdiet faucibus.',
    'login_more_title' => 'Want to know more?',
    'login_more_text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus ipsum enim, tempor nec lobortis non, vulputate sit amet libero. Nunc eget interdum sem. Fusce eu luctus turpis, sed scelerisque turpis. Aliquam tortor nulla, hendrerit eu maximus eget, egestas nec lectus. Pellentesque convallis imperdiet faucibus.',
    'login_welcome_back' => 'Welcome back :name',
    'login_password_incorrect' => 'The entered password was incorrect, please try again',

    //
    // Register page
    //

    'register_title' => 'Register',
    'register_annotation' => 'Annotation',
    'register_first_name' => 'First name',
    'register_last_name' => 'Last name',
    'register_email' => 'E-mail',
    'register_password' => 'Password',
    'register_confirm_password' => 'Confirm password',
    'register_submit' => 'Create your account!',
    'register_go_to_login' => 'Already have an account? Go to login.',
    'register_success' => 'Thanks for your registration! You\'ve been automatically logged in.',

    //
    // Forgot password page
    //

    'forgot_password_title' => 'Forgot password',
    'forgot_password_intro' => 'Fill in your e-mail in the form below and we\'ll send you an email containing a recovery link.',
    'forgot_password_email' => 'E-mail',
    'forgot_password_submit' => 'Recover my password',
    'forgot_password_back' => 'Go back',

    'forgot_password_email_sent_title' => 'Email has been sent!',
    'forgot_password_email_sent_text' => 'An email has been dispatchedd to :email containing instructions on how to reset your password.',

    //
    // Reset password page
    // 

    'reset_password_title' => 'Reset password',
    'reset_password_form_email' => 'Email',
    'reset_password_form_code' => 'Recovery code',
    'reset_password_form_password' => 'New password',
    'reset_password_form_password_confirmation' => 'Confirm new password',
    'reset_password_form_back' => 'Cancel',
    'reset_password_form_submit' => 'Reset my password',
    'reset_password_error_invalid_email' => 'Could not reset password bacause of invalid e-mail address',
    'reset_password_error_invalid_code' => 'Could not reset password because of an invalid recovery code',
    'reset_password_success' => 'Succesfully reset your password! You can now login using your new password',

    //
    // Recover account email
    //

    'recover_account_email_subject' => 'Recover your Tessify account!',
    'recover_account_email_title' => 'Recover your Tessify account',
    'recover_account_email_text' => 'Hi :name! We have received a request to recover your account.\nClick on the button below to reset your password.\n\n',
    'recover_account_email_button' => 'Reset my password',

    //
    // Logout
    //

    'logout_cya_later' => 'See you later alligator!',

];