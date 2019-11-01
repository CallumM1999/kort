<?php

    namespace Controller;

    use \View as View;

    class Base extends \Controller {
        public function index() {
            if (isset($_SESSION['id'])) header('Location: ' . URLROOT . '/routes');
            View::render('index');
        }

        public function notfound() {
            http_response_code(404);
            View::render('notfound', ["title" => "404"]);
        }

        public function redirectPage($request, $params) {
            echo "id: " . $params['id'];
        }
    }