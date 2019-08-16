<?php

    $rootPath = end(explode('api/', $_SERVER['REQUEST_URI']));
    if(empty($rootPath)) $rootPath = 'Home';

    define("ROOT", dirname(__FILE__));
    define("ROUTE", explode('/', $rootPath));

    require __DIR__ . '/core/app.php';
    $app = new App();

    // Use Database
    $app->useDatabase = true;

    // Show Erros
    $app->showErrors = true;

    $app->autoload();
    $app->config();
    $app->start();
?>