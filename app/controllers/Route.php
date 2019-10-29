<?php

    namespace Controller;

    use \View as View;

    class Route extends \Controller {

        public function __construct() {
            $this->redisModel = $this->redis('BaseRedis');
        }

        public function index($request, $params) {
            $id = $params['id'];
            $route = $this->redisModel->getRoute($id);

            if (empty($route)) {
                $data = [ "id" => $id ];
                View::render('notfound', $data);
            }

            $data = [
               "id" => $params['id'],
               "url" => $route['url']
            ];

            View::render('index', $data);
        }

        public function getAdd() {
            $data = [
                "url" => ""
            ];

            View::render('add', $data);
        }

        public function postAdd() {
        
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

            $routeID = $this->redisModel->addRoute($url);

            // Route added
            header('Location: ' . URLROOT);
        }

        public function getEdit($request, $params) {
            $id = $params['id'];

            $route = $this->redisModel->getRoute($id);

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
            $error = "";

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

            $res = $this->redisModel->deleteRoute($id);

            if (!$res) {
                $data = [ "id" => $id ];
                View::render('notfound', $data);
            }

            header('Location: ' . URLROOT);
        }
    }
