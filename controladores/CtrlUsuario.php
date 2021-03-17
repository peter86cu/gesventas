    <?php


	 class ControlUsuario{



		//obtiene el usuario para el login
	 	static public function validarLogin(){
	 		global $stmt;
	 		global $IdUsuario_;
	 		global $Usuario_;
	 		if (isset($_POST["txt_usuario"])) {

	 			if(preg_match('/^[a-zA-Z0-9]+$/', $_POST["txt_usuario"]) && preg_match('/^[a-zA-Z0-9]+$/', $_POST["txt_contra"]) ){

	 				$usuario= $_POST["txt_usuario"];
	 				$passw= $_POST["txt_contra"];


	 				$result=ModeloUsuario::mdBuscarUsuarioPasword($usuario);

	 				 $descr = new encriptaDatos();

	 				if ($result) {
	 						 foreach($result as $row) {
						      $password= $row['password'];
							 $pass_descriptado = $descr->desencriptar($password);
					         if($pass_descriptado==$passw){
					         	 $_SESSION['id']=$row['id_usuario'] ;
					         	 $_SESSION['sucursal']=$row['sucursal'] ;
                                 $_SESSION['login'] = 'activa';
                                 $_SESSION['user'] = $row['nombres'] ;
                                 $_SESSION['rol'] = $row['nivel'] ;
                                 $_SESSION['loginCaja']='no_login';
                                  $ips= new ControlUsuario();
                                 $_SESSION['ip'] = $ips->get_client_ip();
                              
                                 echo "<script> window.location='inicio'; </script>";


					         }else{
					         	echo '<div class="alert alert-danger">Login incorrecto</div>';
					         }
					     //Configuraciones del sistema
					   /* $res_config=ModeloUsuario::buscarConfiguraciones();
					    foreach($res_config as $row_config) {
						$_claves[$row_config['clave']] =$row_config['valor'];
							}*/

	 					/*  CORREO
 							$headers =  'MIME-Version: 1.0' . "\r\n";
							$headers .= 'From: Your name <info@address.com>' . "\r\n";
							$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";



                    	      if(mail("payalaortiz@gmail.com","prueba","Es una prueba",$headers )){

							        error_log("Correo enviado") ;

							    }else{

							        error_log("Error de envio");

							    }
	 					*/


                    }




                }else{

                	echo '<div class="alert alert-danger padre">Login incocercto</div>';
                }
            }else{
                	echo '<div class="alert alert-danger padre">Usuario o contraseña con caracteres no permitidos</div>';
                }

        }

    }



    static  public function mostrarUsuario($parametro, $datos){


          $resultado=ModeloUsuario::mostrarUsuario($parametro, $datos);

           return $resultado;

          }



       //Obtiene la IP del cliente
    static  public function get_client_ip() {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if(getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if(getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if(getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if(getenv('HTTP_FORWARDED'))
           $ipaddress = getenv('HTTP_FORWARDED');
        else if(getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }



	}
