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

        public function login() {
            $_SESSION['id'] = '1';
            header('Location: /kort/');
        }

        public function logout() {
            // delete session cookie
            if (isset($_COOKIE[session_name()])) {
                setcookie(session_name(), '', time()-3600, '/' );
            }
            // delete all session variables
            $_SESSION = [];
            // kill session
            session_destroy();
            header('Location: /kort/');
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