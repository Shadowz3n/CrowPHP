<?php

    class Auth extends Helper {

        protected static $key = "YzJSbVozTmtabWR6WkdablpITm1aM05rWm1oelozVnBjRE0xYVRNMGRETTBjMlJtWjNOa1ptZHpaR1puWkhObVozTmtabWh6WjNWcGNETTE";

        public static function GetJWTEncode($payload){

            $header = json_encode(['typ' => 'JWT', 'alg' => 'HS256', 'timeout' => (time() + (3 * 60 * 60))]); // 3 Hours
            $base64UrlHeader = base64_encode($header);
            $base64UrlPayload = base64_encode(json_encode($payload));
            $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, self::$key, true);
            $base64UrlSignature = base64_encode($signature);
            return array("tokenType" => "Bearer", "accessToken" => ($base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature));
        }

        private static function GetJWT(){

            $bearer = null;
            if(isset($_SERVER['Authorization'])){
                $bearer = trim($_SERVER["Authorization"]);
            }else if(isset($_SERVER['HTTP_AUTHORIZATION'])){
                $bearer = trim($_SERVER["HTTP_AUTHORIZATION"]);
            }elseif(function_exists('apache_request_headers')){
                $requestHeaders = apache_request_headers();
                $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
                if (isset($requestHeaders['Authorization'])){
                    $bearer = trim($requestHeaders['Authorization']);
                }
            }

            if(!isset($bearer)) return false;

            if(preg_match('/Bearer\s(\S+)/', $bearer, $matches)) return $matches[1];

            return false;
        }

        public static function GetJWTDecode(){

            $token = self::GetJWT();
            if(!$token || !is_string($token)) return false;

            try{
                $part = explode(".", $token);
                $header = $part[0];
                $payload = $part[1];
                $signature = $part[2];
                $valid = hash_hmac('sha256',"$header.$payload", self::$key, true);
                $valid = base64_encode($valid);
                if($signature == $valid){
                    $decodedPayload = base64_decode($payload);
                    $jwtHeader = json_decode(base64_decode($header), false);
                    return isset($jwtHeader->timeout) && $jwtHeader->timeout>time()? $decodedPayload:false;
                 }else{
                    return false;
                 }
            }catch(Exception $e){
                return false;
            }
        }
    }
?>