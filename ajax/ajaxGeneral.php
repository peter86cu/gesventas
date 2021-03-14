<?php

require_once  "../modelo/MdlGeneral.php";

class notificacionesAjax{

  public $tipoNotif; 
  public $idNotif;   
  public $descripcion;
  public $estado;
  public $accion;

  public function modificarRolAjax(){

    $parametro = "idRol";  
    $idRol = $this->idRol;
    $respuesta = ModeloRol::mostrarRoles($parametro,$idRol);      
    echo json_encode($respuesta);


  }


  public function eliminarRolAjax(){

    $idRol = $this->idRol;
    $respuesta = ModeloRol::eliminarRol($idRol);      
    echo json_encode($respuesta);


  }

  public function tratarNotificacionesAjax(){




   if($this->accion=="update"){
    $idNotif= $this->idNotif;
    $respuesta = ModeloGeneral::updateNotificacion($idNotif);      

  }elseif($this->accion=="noti"){
    $tipoNotif = $this->tipoNotif; 
    $descripcion  = $this->descripcion;    
    $respuesta = ModeloGeneral::insertarNotificacion($tipoNotif, $descripcion );      

  }  

  echo json_encode($respuesta);


}
}

if($_POST["accion"]=="update" || $_POST["accion"]=="noti"){

  $obj_Modificar = new notificacionesAjax();
  if($_POST["accion"]=="update"){
   $obj_Modificar -> idNotif = $_POST["id"];
 }if($_POST["accion"]=="noti"){
  $obj_Modificar -> tipoNotif = $_POST["tipoNotif"];
  $obj_Modificar -> descripcion = $_POST["descripcion"]; 

}
$obj_Modificar -> accion = $_POST["accion"];    
$obj_Modificar ->tratarNotificacionesAjax();

}else if($_POST["accion"]=="delete"){

  $obj_Modificar = new notificacionesAjax();
  $obj_Modificar -> idRol = $_POST["idRol"];
  $obj_Modificar ->eliminarRolAjax();
}