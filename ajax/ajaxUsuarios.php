<?php

require_once  "../modelo/MdlUsuario.php";
require_once  "../modelo/mcript.php";

class usuariosAjax{

    public $idUsuario;
    public $idRol;
    public $nombre;
    public $usuario;
    public $idSucursal;
    public $correo;
    public $pass;
    public $estado;
    public $accion;

    public function modificarUsuarioAjax(){
    
      $parametro = "idUsuario";  
      $idUsuario = $this->idUsuario;
      $respuesta = ModeloUsuario::mostrarUsuario($parametro,$idUsuario);      
      echo json_encode($respuesta);
     

    }


    public function eliminarUsuarioAjax(){
    
      $idUsuario = $this->idUsuario;
      $respuesta = ModeloUsuario::eliminarUsuario($idUsuario);      
      echo json_encode($respuesta);
     

    }

     public function tratarUsuarioAjax(){
    
       $idUsuario = $this->idUsuario;  
       $idRol = $this->idRol;       
       $nombre = $this->nombre;
       $usuario = $this->usuario;
       $idSucursal = $this->idSucursal;
       $correo = $this->correo;
       $pass = $this->pass;
       

           if($this->accion=="update"){
            
          $respuesta = ModeloUsuario::updateUsuario($idUsuario,$nombre, $usuario ,$pass,$correo,$idRol,$idSucursal);      
          
        }else{

          $respuesta = ModeloUsuario::insertarUsuario($nombre, $usuario ,$pass,$correo,$idRol,$idSucursal);      

        }  
           
        echo json_encode($respuesta);
          
          
   }
}

if($_POST["accion"]=="buscar"){ 
    
    $obj_Modificar = new usuariosAjax();
    $obj_Modificar -> idUsuario = $_POST["idUsuario"];
    $obj_Modificar ->modificarUsuarioAjax();
}else if($_POST["accion"]=="update" || $_POST["accion"]=="insert"){
 
  $obj_Modificar = new usuariosAjax();
   
   if($_POST["accion"]=="update"){
     $obj_Modificar -> idUsuario = $_POST["idUsuario"];
   }
  
    $encri = new encriptaDatos();
    $pass_encriptado = $encri->encriptar($_POST["pass"]);   

    
    $obj_Modificar -> nombre = $_POST["nombre"];
    $obj_Modificar -> usuario = $_POST["usuario"];
    $obj_Modificar -> pass = $pass_encriptado;   
    $obj_Modificar -> correo = $_POST["mail"];
    $obj_Modificar -> idSucursal = $_POST["sucursal"];
    $obj_Modificar -> idRol = $_POST["rol"]; 
    $obj_Modificar -> accion = $_POST["accion"];    
    $obj_Modificar ->tratarUsuarioAjax();
    
}else if($_POST["accion"]=="delete"){

  $obj_Modificar = new usuariosAjax();
  $obj_Modificar -> idUsuario = $_POST["idUsuario"];
  $obj_Modificar ->eliminarUsuarioAjax();
}