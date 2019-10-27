<?php

    namespace Controller;

    use \View as View;

    class Base extends \Controller {

        public function __construct() {
            $this->redisModel = $this->redis('BaseRedis');
        }

        public function index() {
            $visits = $this->redisModel->getVisits();

            $data = [
                "title" => "Eleganta",
                "copy" => "A simple PHP MVC framework.",
                "visits" => $visits
            ];

            View::render('index', $data);
        }

        public function notfound() {
            http_response_code(404);
            View::render('notfound', ["title" => "404"]);
        }
    }