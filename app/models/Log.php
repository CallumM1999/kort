<?php

    namespace Model;

    class Log extends \BaseRedisModel {
        public function logRequest($routeID, $time, $ipaddress) {

            $key = 'log:' . $routeID;
            $value = $time . ':' . $ipaddress;

            $this->redis->rpush($key, $value);
        }
    }