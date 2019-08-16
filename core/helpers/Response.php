<?php

    class Response{

        public static function json($status, $array=array()){

            http_response_code($status);
            return json_encode($array);
        }

        public static function xml($status, $array){
            http_response_code($status);
            $xml = new SimpleXMLElement('<response/>');

            foreach($array as $key=>$value){
                $record = $xml->addChild('record');

                foreach($value as $k=>$v){
                    $record->addChild($k, $v);
                }
            }

            header('Content-Type: text/xml');
            return $xml->asXML();
        }

        public static function NotFound(){
            die(self::json(404, array("msg" => "Not Found")));
        }

        public static function BadRequest(){
            die(self::json(401, array("msg" => "Bad Request")));
        }

        public static function Unauthorized(){
            die(self::json(400, array("msg" => "Unauthorized")));
        }
    }
?>