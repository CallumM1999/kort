<?php

    namespace Model;

    class Log extends \BaseRedisModel {
        public function logRequest($routeID, $time, $ipaddress) {

            $list = 'log:' . $routeID;
            $key = $time . ':' . $ipaddress;

            $this->redis->zincrby($list, 1, $key);
        }

        public function getLogData($routeID) {
            $key = 'log:' . $routeID;

            return $this->redis->zrange($key, 0, -1, 'WITHSCORES');
        }
    }