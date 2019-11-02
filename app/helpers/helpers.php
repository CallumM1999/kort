<?php

    function encodeURL($routeID) {
        $encoded = base_convert($routeID, 10, 16);
        $len = strlen($encoded);
        // If less than 6 characters, prepend 0's untilllength is 6
        if ($len < 6) $encoded = str_repeat('0', 6 - $len) . $encoded;
        return $encoded;
    }

    function decodeUrl($encodedUrl) {
        return base_convert($encodedUrl, 16, 10);
    }