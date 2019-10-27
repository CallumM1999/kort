<?php

    namespace Model;

    class BaseRedis extends \BaseRedisModel {
        public function getVisits() {
            return $this->redis->incr('visits');
        }   

        public function addRoute($url) {
            $routeID = $this->redis->incr('routeid');


            $this->redis->rpush('user:1', $routeID);

            $this->redis->hmset('route:'.$routeID, [
                "url" => $url,
                "owner" => "1"
            ]);

            return $routeID;
        }

        public function getRoute($id) {
            return $this->redis->hgetall('route:' . $id);
        }

        public function viewAllRoutes() {
            $ids = $this->redis->lrange('user:1', 0, -1);
            $routes = [];

            foreach($ids as $id) {
                $route = $this->redis->hgetall('route:'.$id);
                
                $routes[] = [
                    "url" => $route['url'],
                    "id" => $id
                ];
            }

            return $routes;
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