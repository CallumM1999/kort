<?php

    abstract class Middleware {
        public static function auth($request) {
            $request['auth'] = true;
            
            return $request;
        }
    }