<?php

if (!function_exists('httpStatusCodeError')) {
    function httpStatusCodeError(int $statusCode = 0)
    {
        $statusCodeErrors = [400, 401, 403, 404, 405, 406, 407, 408, 409, 500, 501, 502, 503, 504];

        if (! in_array($statusCode, $statusCodeErrors)) $statusCode = 500;

        return $statusCode;
    }
}

if (!function_exists('slug')) {
    function slug(string $title = '')
    {
        return Illuminate\Support\Str::slug($title);
    }
}
