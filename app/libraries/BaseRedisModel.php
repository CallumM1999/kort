<?php

    abstract class BaseRedisModel {
        
        public function __construct() {
            try {
                \Predis\Autoloader::register();

                $this->redis = new \Predis\Client(array(
                    "scheme" => "tcp",
                    "host" => "localhost",
                    "port" => 6379
                ));
            } catch (Exception $e) {
                die($e->getMessage());
            }
        }
    }
