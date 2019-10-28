<?php

    namespace Controller;

    use \View as View;

    class Page extends \Controller {

        public function __construct() {
            $this->redisModel = $this->redis('PageRedis');
        }

        public function index($request, $params) {
            $id = $params['id'];

            $url = $this->redisModel->getUrl($id);

            header('Location: ' . $url);
        }
    }