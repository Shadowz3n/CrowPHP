<?php

    class UserService extends Model{
        
        // Get All Users
        public static function getUsers(){

            $user = new User();
            die(Response::json(200, $user->select()));
        }

        // Add User
        public static function addUser(){

            $user = new User();
            $user->id = 4;
            $user->firstname = "Teste 3";
            return $user->save();
        }
    }
?>