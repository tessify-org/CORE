<?php

/*
 | Tessify Core Configuration
 |
 | @version 1.0.0
 | @author Nick Verheijen <verheijen.webdevelopment@gmail.com>
*/

return [

    /**
     * Available locales
     * This array will be used to populate the LocaleSwitcher component in the app layout.
     * 
     * @array
     */
    "locales" => ["nl", "en"],

    /**
     * Reputation points
     * Configure how many points are awarded throughout the application
     */
    "reputation" => [

        // Smallest possible amount of reputation points one can receive
        "base_points" => 10,

    ],

];
