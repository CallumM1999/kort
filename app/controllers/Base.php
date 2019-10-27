<?php

    namespace Controller;

    use \View as View;

    class Base extends \Controller {

        public function index() {
            $data = [
                "title" => "Eleganta",
                "copy" => "A simple PHP MVC framework."
            ];

            View::render('index', $data);
        }

        public function notfound() {
            http_response_code(404);
            View::render('notfound', ["title" => "404"]);
        }
    }