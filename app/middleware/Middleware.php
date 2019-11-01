<?php

    abstract class Middleware {
        public static function auth($request) {
            // is authenticated
            if (isset($_SESSION['id'])) return $request;
            
            // not authenticated
            header('Location: ' . URLROOT);
        }
    }