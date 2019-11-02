<?php

    namespace Controller;

    use \View as View;

    class Page extends \Controller {

        public function __construct() {
            $this->pageModel = $this->redis('Page');
            $this->logModel = $this->redis('Log');
        }

        public function index($request, $params) {
            $routeID = $params['id'];
            $url = $this->pageModel->getUrl($routeID);

            if ($url === null) {
                $data = [ "id" => $routeID ];
                View::render('notfound', $data);
            }

            // Round to last minute
            $time = time() - time() % 60;
            $ipaddress = self::getClientIp();

            $this->logModel->logRequest($routeID, $time, $ipaddress);
            
            header('Location: ' . $url);    
        }

        private static function getClientIp() {
            $ipaddress = '';
            
            if (isset($_SERVER['HTTP_CLIENT_IP'])) {
                $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
            } else if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
            } else if (isset($_SERVER['HTTP_X_FORWARDED'])) {
                $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
            } else if (isset($_SERVER['HTTP_FORWARDED_FOR'])) {
                $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
            } else if (isset($_SERVER['HTTP_FORWARDED'])) {
                $ipaddress = $_SERVER['HTTP_FORWARDED'];
            } else if (isset($_SERVER['REMOTE_ADDR'])) {
                $ipaddress = $_SERVER['REMOTE_ADDR'];
            } else {
                $ipaddress = 'UNKNOWN';
            }

            return $ipaddress;
        }
    }