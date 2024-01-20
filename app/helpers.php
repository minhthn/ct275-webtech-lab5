<?php

declare(strict_types=1);

if (! function_exists('http_accept_json')) {
    function http_accept_json() {
        return isset($_SERVER['HTTP_ACCEPT']) &&
                (strpos(strtolower($_SERVER['HTTP_ACCEPT']), 'application/json') !== false);
    }
}

if (! function_exists('redirect')) {
    // redirect to another page
    function redirect($location, array $data = []) {
        foreach ($data as $key => $value) {
            $_SESSION[$key] = $value;
        }
        header('Location: ' . $location, replace: true, response_code: 302);
        exit;
    }
}

if (! function_exists('session_get_once')) {
    // read and delete a variable in $_SESSION
    function session_get_once($name, $default = null) {
        $value = $default;
        if (isset($_SESSION[$name])) {
            $value = $_SESSION[$name];
            unset($_SESSION[$name]);
        }
        return $value;
    }
}
