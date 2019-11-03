<?php

    // App base root
    define('APPROOT', dirname(dirname(__FILE__)));

    // Vendor root
    define('VENDORROOT', dirname(APPROOT). '/vendor');

    // sitename
    define('SITENAME', 'kort');

    // Set environment instance
    define('ENV', (empty(getenv('JAWSDB_URL'))) ? 'LOCAL' : 'PRODUCTION');

    if (ENV === 'LOCAL') {
        // local

        // URL Root
        define('URLROOT', '/kort');

        // database
        define('DB_HOST', '127.0.0.1');
        define('DB_DATABASE', 'kort');
        define('DB_USER', 'root');
        define('DB_PASSWORD', '123');

        // redis
        define('REDIS_HOST', 'localhost');
        define('REDIS_PORT', '6379');
        define('REDIS_PASS', '');
        define('REDIS_USER', '');
        define('REDIS_SCHEME', 'tcp');
    
    } else {
        // production

        // URL Root
        define('URLROOT', 'https://guarded-brushlands-44549.herokuapp.com');

        // database
        $dburl = getenv('JAWSDB_URL');
        $dbparts = parse_url($dburl);

        $db_host = $dbparts['host'];
        $db_db = substr($dbparts['path'], 1);
        $db_user = $dbparts['user'];
        $db_password = $dbparts['pass'];

        define('DB_HOST', $db_host);
        define('DB_DATABASE', $db_db);
        define('DB_USER', $db_user);
        define('DB_PASSWORD', $db_password);

        // redis
        $redisurl = getenv('REDISCLOUD_URL');

        $redisparts = parse_url($redisurl);
        
        define('REDIS_HOST', $redisparts['host']);
        define('REDIS_PORT', $redisparts['port']);
        define('REDIS_PASS', $redisparts['pass']);
        define('REDIS_USER', $redisparts['user']);
        define('REDIS_SCHEME', $redisparts['scheme']);   
    }