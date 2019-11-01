<?php

    namespace Controller;

    use \View as View;

    class Base extends \Controller {

        public function __construct() {
            $this->redisModel = $this->redis('BaseRedis');
        }

        public function index() {
            if (isset($_SESSION['id'])) header('Location: /kort/dashboard');
            View::render('index');
        }

        public function notfound() {
            http_response_code(404);
            View::render('notfound', ["title" => "404"]);
        }

        public function dashboard() {
            $routes = $this->redisModel->viewAllRoutes();

            $data = [
                "routes" => $routes
            ];

            View::render('dashboard', $data);
        }

        public function redirectPage($request, $params) {
            echo "id: " . $params['id'];
        }
    }