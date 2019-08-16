<?php

    class App {

        public $db;
        public $showErrors = false;
        public $useDatabase = false;

        function __construct(){

            $this->require('/core/config/Constants.php');
            if(!in_array(REQUEST_METHOD, ALL_METHODS)) return Response::BadRequest();
        }

        function autoload(){
            spl_autoload_register(function ($class) {
                $class = $class;

                $classes    = '/core/classes/' . $class . '.php';
                $helpers    = '/core/helpers/' . $class . '.php';
                $config     = '/core/config/' . $class . '.php';
                $models     = '/app/models/' . $class . '.php';
                $services   = '/app/services/' . $class . '.php';

                if(file_exists(ROOT . $classes))   $this->require($classes);
                if(file_exists(ROOT . $helpers))   $this->require($helpers);
                if(file_exists(ROOT . $config))   $this->require($config);
                if(file_exists(ROOT . $models))    $this->require($models);
                if(file_exists(ROOT . $services))  $this->require($services);
            });
        }

        function config(){

            if($this->useDatabase === true) $this->db  = new PDOConnector();

            if($this->showErrors === true){
                ini_set('display_errors', 1);
                ini_set('display_startup_errors', 1);
                error_reporting(E_ALL);
            }
        }

        function require($path){

            require_once(ROOT . $path);
        }

        function start(){

            $controllerClass = ucfirst(ROUTE[0]);

            if(file_exists(ROOT . '/app/controllers/'.$controllerClass.'Controller.php')){
                $this->require('/app/controllers/'.$controllerClass.'Controller.php');
                $controller = new $controllerClass();
            }else{
                return Response::NotFound();
            }
        }
    }
?>