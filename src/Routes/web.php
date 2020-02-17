<?php 

/*
 |
 | Core Web Routes
 |
 */

Route::group(["middleware" => "guest"], function() {
    
    // Registration
    Route::get("register", "Auth\RegisterController@getRegister")->name("auth.register");
    Route::post("register", "Auth\RegisterController@postRegister")->name("auth.register.post");

    // Login
    Route::get("login", "Auth\LoginController@getLogin")->name("auth.login");
    Route::post("login", "Auth\LoginController@postLogin")->name("auth.login.post");

    // Forgot password
    Route::get("wachtwoord-vergeten", "Auth\ForgotPasswordController@getForgotPassword")->name("auth.forgot-password");
    Route::post("wachtwoord-vergeten", "Auth\ForgotPasswordController@postForgotPassword")->name("auth.forgot-password.post");

    // Reset password
    Route::get("wachtwoord-herstellen/{email}/{code}", "Auth\ResetPasswordController@getResetPassword")->name("auth.reset-password");
    Route::post("wachtwoord-herstellen/{email}/{code}", "Auth\ResetPasswordController@postResetPassword")->name("auth.reset-password.post");

});

// Auth endpoints, when user is logged in
Route::group(["middleware" => "auth"], function() {

    // Logout
    Route::get("uitloggen", "Auth\LogoutController@getLogout")->name("auth.logout");
    
});