<?php

if (!function_exists('httpStatusCodeError')) {
    function httpStatusCodeError($statusCode)
    {
        $statusCodeErrors = [400, 401, 403, 404, 405, 406, 407, 408, 409, 500, 501, 502, 503, 504];

        if (! in_array($statusCode, $statusCodeErrors)) $statusCode = 500;

        return $statusCode;
    }
}
