<?php

    namespace Controller;

    use \View as View;

    class Route extends \Controller {

        public function __construct() {
            $this->redisModel = $this->redis('BaseRedis');
        }

        public function index($request, $params) {
            $route = $this->redisModel->getRoute($params['id']);

            $data = [
               "id" => $params['id'],
               "url" => $route['url']
            ];

            View::render('index', $data);
        }

        public function getAdd() {
            $data = [
                "url" => "",
                "error" => ""
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
            header('Location: ' . URLROOT . '/routes/view/' . $routeID);
        }
    }


    