<?php
class encriptaDatos{


//private $clave  = 'Una cadena, muy, muy larga para mejorar la encriptacion';

//Metodo de encriptación
//private $method = 'aes-256-cbc';

// Puedes generar una diferente usando la funcion $getIV()
 

 /*
 Encripta el contenido de la variable, enviada como parametro.
  */
 /*$encriptar = function ($valor) use ($method, $clave, $iv) {
     return openssl_encrypt ($valor, $method, $clave, false, $iv);
 };*/


 static  function encriptar($valor){
 	 $method = 'aes-256-cbc';
 	 $clave  = 'Una cadena, muy, muy larga para mejorar la encriptacion';
 	 $iv =$iv = base64_decode("C9fBxl1EWtYTL1/M8jfstw==");
     return openssl_encrypt ($valor,$method, $clave, false, $iv); 
 }

 /*
 Desencripta el texto recibido
 */
 static function desencriptar ($valor){
 		
 	 $encrypted_data = base64_decode($valor);
 	  $method = 'aes-256-cbc';
 	 $clave  = 'Una cadena, muy, muy larga para mejorar la encriptacion';
 	 $iv = base64_decode("C9fBxl1EWtYTL1/M8jfstw==");
     return openssl_decrypt($valor,  $method,  $clave, false, $iv);
 } 
    


 /*
 Genera un valor para IV
 */
  function getIV() {
     return base64_encode(openssl_random_pseudo_bytes(openssl_cipher_iv_length($this->method)));
 }

 }