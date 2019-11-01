<?php

    namespace Model;

    class BaseRedis extends \BaseRedisModel {
        public function addRoute($url, $userID) {
            $id = $this->redis->incr('routeid');

            $this->redis->rpush('user:'.$userID, $id);

            $this->redis->hmset('route:'.$id, [
                "url" => $url,
                "owner" => $userID
            ]);

            return $id;
        }

        public function editRoute($url, $id) {
            $this->redis->hmset('route:'.$id, [
                "url" => $url
            ]);
        }

        public function getRoute($id, $userID) {
            $route = $this->redis->hgetall('route:' . $id);

            if (empty($route)) return false;

            // Don't show route, user doesnt own it
            if ($route['owner'] != $userID) return false;

            return $route;
        }

        public function viewAllRoutes($userID) {
            $idList = $this->redis->lrange('user:'.$userID, 0, -1);
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

        public function deleteRoute($id, $userID) {
            // If we dont own the route, will return false;
            $validRoute = $this->getRoute($id, $userID);
            if (!$validRoute) return false;

            $deleted = $this->redis->del('route:'.$id);

            if ($deleted == 0) return false;

            $removedFromList = $this->redis->lrem('user:'.$userID, 1, $id);

            return $removedFromList == 1;
        }
    }