<?php

    class User extends Model{

        public $id;
        public $firstname;
        public $lastname;
        public $email;
        public $password;
        public $created;

        public $orderBy = array("firstname", "lastname", "email", "created");

        public function select(){

            $pagination = new Pagination($this->orderBy);
            return $pagination->Get($this->db, 'users', 'id,firstname,lastname,email');
        }

        public function save(){

            return $this->db->save('users', $this);
        }
    }
?>