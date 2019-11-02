<?php

    namespace Controller;

    use \View as View;

    class Route extends \Controller {

        public function __construct() {
            $this->redisModel = $this->redis('BaseRedis');
        }

        public function index() {
            $userID = $_SESSION['id'];

            $routes = $this->redisModel->viewAllRoutes($userID);

            $data = [
                "routes" => $routes
            ];

            View::render('index', $data);
        }

         public function view($request, $params) {
            $id = $params['id'];
            $userID = $_SESSION['id'];

            $route = $this->redisModel->getRoute($id, $userID);

            if (empty($route) || !$route) {
                $data = [ "id" => $id ];
                View::render('notfound', $data);
            }

            $data = [
               "id" => $params['id'],
               "name" => $route['name'],
               "url" => $route['url'],
               "enabled" => $route['enabled']
            ];

            View::render('view', $data);
        }

        public function getAdd() {
            $data = [
                "name" => "",
                "url" => "",
                "enabled" => true,
                "errors" => []
            ];

            View::render('add', $data);
        }

        public function postAdd() {
            $userID = $_SESSION['id'];
            
            $data = [
                "name" => filter_var($_POST['name'], FILTER_SANITIZE_STRING),
                "url" => filter_var($_POST['url'], FILTER_SANITIZE_URL),
                "enabled" => isset($_POST['enabled']),
                "errors" => []
            ];

            if (strlen($data['name']) < 1 || strlen($data['name']) > 255) {
                $data['errors'][] = 'Name field must be between 1-255 characters.';
            } else if (!preg_match('/^[a-zA-Z0-9 ]*$/m', $data['name'])) {
                $data['errors'][] = 'Name field can only contain letters and numbers.';
            }

            if (!filter_var($data['url'], FILTER_VALIDATE_URL)) {
                $data['errors'][] = 'Invalid URL';
            }

            // There cannot be errors
            if (count($data['errors']) > 0) View::render('add', $data);

            // Valid, add route
            $routeID = $this->redisModel->addRoute($userID, $data['name'], $data['url'], $data['enabled']);

            // Route added
            header('Location: ' . URLROOT . '/routes');
        }

        public function getEdit($request, $params) {
            $id = $params['id'];
            $userID = $_SESSION['id'];

            $route = $this->redisModel->getRoute($id, $userID);

            if (empty($route)) {
                $data = [ "id" => $id ];
                View::render('notfound', $data);
            }

            $data = [
                "url" => $route['url'],
                "id" => $id
            ];

            View::render('edit', $data);
        }

        public function postEdit($request, $params) {
            $id = $params['id'];
            $userID = $_SESSION['id'];

            $route = $this->redisModel->getRoute($id, $userID);

            if (empty($route)) {
                $data = [ "id" => $id ];
                View::render('notfound', $data);
            }

            $url = $_POST['url'];

            if ($url === '') {
                $error = "please add a valid url";

                $data = [
                    "url" => $url,
                    "error" => $error,
                    "id" => $id
                ];

                View::render('edit', $data);
            }

            $this->redisModel->editRoute($url, $id);

            // Route added
            header('Location: ' . URLROOT . '/routes/view/' . $id);
        }

        public function getDelete($request, $params) {
            $id = $params['id'];
            $userID = $_SESSION['id'];

            $res = $this->redisModel->deleteRoute($id, $userID);

            if (!$res) {
                $data = [ "id" => $id ];
                View::render('notfound', $data);
            }

            header('Location: ' . URLROOT . '/routes');
        }
    }
