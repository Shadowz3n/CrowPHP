<?php
    define("REQUEST_METHOD", $_SERVER['REQUEST_METHOD']);

    define("GET", "GET");
    define("POST", "POST");
    define("PUT", "PUT");
    define("PATH", "PATH");
    define("DELETE", "DELETE");
    define("ALL_METHODS", array(GET, POST, PUT, PATH, DELETE));

    defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
    defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
    defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
    defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);
?>