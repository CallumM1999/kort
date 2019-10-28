<?php

    namespace Model;

    class PageRedis extends \BaseRedisModel {
        public function getUrl($id) {
            return $this->redis->hget('route:'.$id, 'url');
        }   
    }