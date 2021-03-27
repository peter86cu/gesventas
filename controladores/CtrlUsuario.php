    <?php

    session_start();
    class ControlUsuario{
   


		//obtiene el usuario para el login
     static public function validarLogin(){
        global $stmt;
        global $IdUsuario_;
        global $Usuario_;
        if (isset($_POST["txt_usuario"])) {

          $usuario= $_POST["txt_usuario"];
          $passw= $_POST["txt_contra"];


          $result=ModeloUsuario::mdBuscarUsuarioPasword($usuario);

          $descr = new encriptaDatos();

          if ($result) {
           foreach($result as $row) {
            $password= $row['password'];
            $pass_descriptado = $descr->desencriptar($password);                           
            if($pass_descriptado==$passw){                
                $id=uniqid();                   
                $_SESSION['id_session']= $id;
                ModeloUsuario::insertarSession($id,$row['id_usuario'],'LOGIN');
                
                $_SESSION['id']=$row['id_usuario'] ;
                $_SESSION['sucursal']=$row['sucursal'] ;
                $_SESSION['login'] = 'activa';
                $_SESSION['user'] = $row['nombres'] ;
                $_SESSION['rol'] = $row['nivel'] ;
                $_SESSION['email'] = $row['email'];
                $_SESSION['nombres'] = $row['nombres'];
                $_SESSION['password'] = $pass_descriptado;
                $_SESSION['loginCaja']='no_login';
                $_SESSION['adjunto_mail']='no_adjunto';
                $ips= new ControlUsuario();
                $_SESSION['ip'] = $ips->get_client_ip();

                echo "<script> window.location='inicio'; </script>";


            }else{
             echo '<div class="alert alert-danger">Login incorrecto</div>';
         }



     }




 }else{

   echo '<div class="alert alert-danger padre">Login incocercto</div>';
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
