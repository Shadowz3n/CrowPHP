<?php

    class PDOConnector extends PDO{

        private $hostname    = 'localhost';
        private $username    = 'root';
        private $password    = '';
        private $dbname      = 'api';

        public function __construct(){

            try {
                $connector = new PDO('mysql:host=' . $this->hostname . ';dbname=' . $this->dbname, $this->username, $this->password);
                $connector->query('SET NAMES utf8');
                $connector->query('SET CHARACTER_SET utf8_unicode_ci');
                $connector->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->db = $connector;
        
            } catch (PDOException $e) {
                die('Database error: ' . $e->getMessage());
            }
        }

        public function select($query, $bind=false, $param_type=false){

            $rows	= array();
            $select = $this->db->prepare($query);
            if(is_array($bind) && is_array($param_type)){
                foreach($bind as $key=>$value){
                    $select->bindValue($key, $value, (($param_type[$key]=='int')? PDO::PARAM_INT:PDO::PARAM_STR));
                }
                $select->execute();
            }else{
                ($bind)? $select->execute($bind):$select->execute();
            }
            if($select->rowCount()>0){
                while($row = $select->fetch(PDO::FETCH_ASSOC)){
                    $rows[] = $row;
                }
            }
            return $rows;
        }

        public function save($table, $model){

            $model = json_decode(json_encode($model), true);
            $keys						= array();
            $values 					= array();
            $protection_key				= "";
            $protection_val				= "";
            $protection_on_update		= "";
            foreach((array) $model as $key=>$value){
                $protection_key 		.= $key.",";
                $protection_val			.= "?,";
                $protection_on_update	.= $key." = ?,";
                array_push($keys, $key);
                array_push($values, $value);
            }

            $insert	= $this->db->prepare("INSERT INTO ".$table." (".rtrim($protection_key, ',').") VALUES (".rtrim($protection_val, ',').") ON DUPLICATE KEY UPDATE ".rtrim($protection_on_update, ',').";");
            $insert->execute(array_merge($values, $values));
            return array_merge($values, $values);
        }

        public function delete($table, array $column_id){

            $delete = $this->db->prepare("DELETE FROM ".$table." WHERE ".key($column_id)." = :id;");
            $delete->bindParam(":id", array_values($column_id)[0]);
            $delete->execute();
        }

        public function execute($query, $bind=false, $last_id=false){

            $select = $this->db->prepare($query);
            if($last_id){
                ($bind)? $select->execute($bind):$select->execute();
                return $this->db->lastInsertId();
            }else{
                return ($bind)? $select->execute($bind):$select->execute();
            }
        }
    }
?>