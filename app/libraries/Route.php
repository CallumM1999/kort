<?php

    class Route {
         public static function __callStatic($routeMethod, $args) {
            // Check request method
            // ====================

            $requestMethod = strtolower($_SERVER['REQUEST_METHOD']);
            $path;

            // Match Route method passes array for first parameter, than path
            if ($routeMethod === 'match') {
                // example ['get', 'post']
                $matchMethodsArray = array_shift($args);
                $path = array_shift($args);
            } else {
                $path = array_shift($args);    
            }

            // Check method matches URL
            if (!self::checkRequestPath($path)) return;

            // Check if method is in array below
            $methods = ['get', 'post', 'put', 'patch', 'delete', 'options'];
            // If Request method is one of the above, and is actual method
            if (in_array($routeMethod, $methods, true) && $routeMethod === $requestMethod) {               
                self::handlePageRequest($path, $args);
                exit();
            }

            // Check if method matches item in array
            if ($routeMethod === 'match') {
                // If request method matches one of the passed methods
                if (in_array($requestMethod, $matchMethodsArray, true)) {
                    self::handlePageRequest($path, $args);
                    exit();
                }
            }

            // Accepts any metod
            if ($routeMethod === 'any') {
                // Doesn't matter what the actual method is
                self::handlePageRequest($path, $args);
                exit();
            }

            if ($routeMethod === 'permamentRedirect' || $routeMethod === 'redirect') {
                self::redirect($routeMethod, $args[0]);
                exit();
            }

            if ($routeMethod === 'view') {
                self::handleViewRoute($args);
                exit();
            }
        }

        private static function handleViewRoute($args) {
            $view = $args[0];
            $data = (isset($args[1])) ? $args[1] : [];

            View::render($view, $data);
        }

        
        private static function checkMethod($method) {
            return (strtoupper($method) === strtoupper($_SERVER['REQUEST_METHOD']));
        }

        private static function redirect($routeMethod, $dest) {
            $statusCode = ($routeMethod === 'permamentRedirect') ? '302' : '301';
            $newPath = URLROOT . $dest;

            Header('Location: ' . $newPath, true, $statusCode);
            exit();
        }

        private static function handlePageRequest($path, $args) {
            // Handles a normal request route
            // An arg will consist of middleware, then an inline function or controller to load
            $request = [];
            $urlParams = self::decodePath($path);

            $lastElement = sizeof($args) -1;

            foreach($args as $index => $arg) {

                if ($index === $lastElement) {
                    // Either inline function or controller
                    if (is_callable($arg)) {
                        call_user_func_array($arg, [$request, $urlParams]);
                    } else {
                        self::loadController($arg, $request, $urlParams);
                    }
                } else {
                    // Is middleware

                    if (is_callable($arg)) {
                        $request = $arg($request);
                    } else {
                        $request = Middleware::$arg($request);
                    }

                    // Check middleware returned $request Array
                    if ($request === null || !is_array($request)) {
                        $message = "Middleware didn't return valid \$request Array. Recieved " . gettype($request) . ".";
                        die($message);
                    }

                }
            }
        }

        private static function checkRequestPath($path) {
            $decodedPath = self::decodePath($path);
            return $decodedPath !== false;
        }

        private static function decodePath($path) {            
            $url = self::getUrl();

            // Split URL and path into array
            $urlArr = explode('/', $url);
            $urlArr[0] = 'index';

            $pathArr = explode('/', $path);
            $pathArr[0] = 'index';

            // Return empty array (No parameters)
            if ($path === '*') return [];
            
            // URL and params don't match, since array size should be same
            if(sizeof($urlArr) !== sizeof($pathArr)) return false;
            
            // Parameters extracted from URL
            $parameters = [];

            $length = sizeof($urlArr);

            for ($i=0; $i<$length;$i++) {
                $urlBlock = $urlArr[$i];
                $pathBlock = $pathArr[$i];

                // Check if param block is param /users/{id}
                $extractParameter = self::extractUrlParams($pathBlock);

                if ($extractParameter !== false) {
                    // Parameter found
                    $parameter = $extractParameter;
                    // Sanitize parameter
                    $urlBlock = filter_var($urlBlock, FILTER_SANITIZE_SPECIAL_CHARS);
                    // Add parameter to parameters array
                    $parameters[$parameter] = $urlBlock;

                } else if ($urlBlock !== $pathBlock) {
                    // URL doesnt match path, no point checking any other blocks
                    return false;
                }
            }
                
            // If we've got this far, the URL must match
            return $parameters;
        }

        private static function extractUrlParams($block) {
            $regex = '/{\K[^}]*(?=})/m';
            preg_match_all($regex, $block, $results);

            // If results are not empty, a parameter was found
            return (sizeof($results[0]) > 0) ? $results[0][0] : false;
        }

        private static function loadController($controller, $request, $parameters = []) {
            $params = explode('@', $controller);
            $cname = $params[0];
            $page = (isset($params[1])) ? $params[1] : 'index';

            require_once APPROOT . '/controllers/' . $cname . '.php';

            // Initiate class
            $class = 'Controller\\' . $cname;
            $baseName = new $class();

            // Call class method
            $baseName->$page($request, $parameters);

            exit();
        }

        private static function getUrl() {
            $url = (isset($_GET['url'])) ? '/' . $_GET['url'] : '/';
            $url = filter_var($url, FILTER_SANITIZE_URL);
            return $url;
        }
    }

