<?php

/*
    Framework Core Class
    Formats URL and passes to router

*/

    class App {
        public function __construct() {
            // Load app config
            require_once '../app/config/config.php';

            // Autoload Core Libraries
            spl_autoload_register(function($className) {
                $path = APPROOT . '/libraries/' . $className . '.php';
                if(file_exists($path)) require_once $path;
            });

            // Load middleware
            require_once APPROOT . '/middleware/Middleware.php';

            require_once VENDORROOT . '/autoload.php';

            require_once APPROOT . '/helpers/helpers.php';

            session_start();

            require_once APPROOT . '/routes.php';

            // If no route found
            http_response_code(404);
            exit();

        }
    }
