<?php
    class Home extends Controller {

        //$this->view('viewname');

        function Index(){
            Helper::AllowMethods(array(GET, POST, PUT));

            if(REQUEST_METHOD==GET) return UserService::getUsers();
            if(REQUEST_METHOD==POST) return UserService::addUser();
            if(REQUEST_METHOD==PUT) return UserService::addUser();
        }

        function GetAuth(){
            Helper::AllowMethods(array(GET));

            if(REQUEST_METHOD==GET) return AuthService::GetAuth();
        }
    }
?>