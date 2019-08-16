<?php

    abstract class Controller {

        private $route = [];
        private $args = 0;

        function __construct(){

            $this->route = ROUTE;
            array_pop($this->route);
            $this->args = count($this->route);
            $this->router();
        }
        
        private function router(){

            if(class_exists(ROUTE[0])) $this->uriCaller($this->route);
        }

        private function uriCaller(){

            $controllerAction = $this->args<2? 'Index':$this->route[1];
            if(!method_exists($this, $controllerAction) || empty($controllerAction))
                Response::NotFound();

            die(call_user_func_array(array($this, $controllerAction), array()));

        }

        abstract function Index ();

        function view ($filePath){

            $filePath = ROOT . '/public/'.$filePath.'.html';
            if(file_exists($filePath)) require_once($filePath);
        }
    }
?>