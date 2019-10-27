<?php

    namespace Model;

    class BaseRedis extends \BaseRedisModel {
        public function getVisits() {
            return $this->redis->incr('visits');
        }   
    }