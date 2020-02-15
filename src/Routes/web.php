<?php 

/*
 |
 | Product package routes
 |
 */

Route::group(["prefix" => "core"], function() {

    Route::get("test", function() {
        return "hurai";
    });

});