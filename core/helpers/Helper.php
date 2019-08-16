<?php

    class Helper {

		public static function AllowMethods($array){
			return in_array(REQUEST_METHOD, $array)? true:Response::BadRequest();
		}
        
        public function GetIp(){
            $client  = @$_SERVER['HTTP_CLIENT_IP'];
			$forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
			$remote  = $_SERVER['REMOTE_ADDR'];
			if(filter_var($client, FILTER_VALIDATE_IP)){
				$ip = $client;
			}elseif(filter_var($forward, FILTER_VALIDATE_IP)){
				$ip = $forward;
			}else{
				$ip = $remote;
			}
			return $ip;
        }

        public function GetUserAgent(){
			if(!isset($_SERVER['HTTP_USER_AGENT'])){ exit; }
			$useragent = strtolower($_SERVER['HTTP_USER_AGENT']);
			if(strpos("$useragent","chrome") 		!== false){ return "Google Chrome"; }
			if(strpos("$useragent","msie") 			!== false){ return "Internet Explorer"; }
			if(strpos("$useragent","netscape") 		!== false){ return "Netscape"; }
			if(strpos("$useragent","firefox") 		!== false){ return "Fire Fox"; }
			if(strpos("$useragent","opera") 		!== false){ return "Opera"; }
            if(strpos("$useragent","safari") 		!== false){ return "Safari"; }
            return false;
        }
        
        public function getUrlContent($url, $post=false, $headers=false, $request=false){
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; Fedora; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.81 Safari/537.36');
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($ch, CURLOPT_HTTP_VERSION, 3);
			if($post!==false){
				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
			}
			if($headers!==false) curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			if($request!==false) curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $request);
			curl_setopt($ch, CURLOPT_TIMEOUT, 5);
			$data		= curl_exec($ch);
			$httpcode	= curl_getinfo($ch, CURLINFO_HTTP_CODE);
			curl_close($ch);
			return $data;
			return ($httpcode>=200 && $httpcode<=401) ? $data:false;
		}
    }
?>