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
               "url" => $route['url']
            ];

            View::render('view', $data);
        }

        public function getAdd() {
            $data = [
                "url" => ""
            ];

            View::render('add', $data);
        }

        public function postAdd() {
            $userID = $_SESSION['id'];
            $error = "";

            $url = $_POST['url'];

            if ($url === '') {
                $error = "please add a valid url";

                $data = [
                    "url" => $url,
                    "error" => $error
                ];

                View::render('add', $data);
            }

            $routeID = $this->redisModel->addRoute($url, $userID);

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
