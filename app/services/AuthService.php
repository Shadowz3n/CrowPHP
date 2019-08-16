<?php
    class AuthService extends Model{
        
        // Auth JWT
        public static function GetAuth(){

            $auth = new Auth();
            if($auth::GetJWTDecode() === false){
                return Response::Unauthorized();
            }else{
                return $auth::GetJWTDecode();
            }
        }
    }
?>