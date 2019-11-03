<?php

    abstract class BaseRedisModel {
        private $host = REDIS_HOST;
        private $port = REDIS_PORT;
        private $pass = REDIS_PASS;
        private $user = REDIS_USER;
        private $scheme = REDIS_SCHEME;

        public function __construct() {
            try {
                \Predis\Autoloader::register();

                $config = [
                    "scheme" => $this->scheme,
                    "host" => $this->host,
                    "port" => $this->port
                ];

                if (ENV !== 'LOCAL') {
                    $config['password'] = $this->pass;
                    $config['user'] = $this->user;
                }

                $this->redis = new \Predis\Client($config);

            } catch (Exception $e) {
                echo "err";
                die($e->getMessage());
            }
        }
    }
