<?php

    namespace Model;

    class BaseRedis extends \BaseRedisModel {
        public function getVisits() {
            return $this->redis->incr('visits');
        }   

        public function addRoute($url) {
            $id = $this->redis->incr('routeid');

            $this->redis->rpush('user:1', $id);

            $this->redis->hmset('route:'.$id, [
                "url" => $url,
                "owner" => "1"
            ]);

            return $id;
        }

        public function editRoute($url, $id) {
            $this->redis->hmset('route:'.$id, [
                "url" => $url
            ]);
        }

        public function getRoute($id) {
            return $this->redis->hgetall('route:' . $id);
        }

        public function viewAllRoutes() {
            $idList = $this->redis->lrange('user:1', 0, -1);
            $routes = [];

            foreach($idList as $id) {
                $route = $this->redis->hgetall('route:'.$id);
                
                $routes[] = [
                    "url" => $route['url'],
                    "id" => $id
                ];
            }

            return $routes;
        }

        public function deleteRoute($id) {
            $this->redis->lrem('user:1', 1, $id);
            $this->redis->del('route:'.$id);
        }
    }

    /*
        List routes
            lrange user:1 0 -1

        Add route
            incr routeid

            rpush user:1 routeid
            hmset route:id url google.com user userid

        Update route
            hmget route:id user
            // check user is current user

            hmset route:id values

        delete route
            del route:id




    */