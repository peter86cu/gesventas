<?php

require_once  "../modelo/MdlRoles.php";

class rolesAjax{

    public $idRol;
    public $nombre;
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

     public function tratarRolesAjax(){
    
       $idRol = $this->idRol;       
       $nombre = $this->nombre;
       $descripcion = $this->descripcion;
       $estado = $this->estado;
       

           if($this->accion=="update"){
          $respuesta = ModeloRol::updateRoles($idRol,$nombre, $descripcion ,$estado);      
          
        }else{
          error_log("ajax insert",0);
          $respuesta = ModeloRol::insertarRol($nombre, $descripcion ,$estado);      

        }  
           
        echo json_encode($respuesta);
          
          
   }
}

if($_POST["accion"]=="buscar"){ 

    $obj_Modificar = new rolesAjax();
    $obj_Modificar -> idRol = $_POST["idRol"];
    $obj_Modificar ->modificarRolAjax();
}else if($_POST["accion"]=="update" || $_POST["accion"]=="insert"){
  
  $obj_Modificar = new rolesAjax();
  if($_POST["accion"]=="update"){
     $obj_Modificar -> idRol = $_POST["idRol"];
  }
   
    $obj_Modificar -> nombre = $_POST["rol"];
    $obj_Modificar -> descripcion = $_POST["descripcion"];
    $obj_Modificar -> estado = $_POST["estado"];   
    $obj_Modificar -> accion = $_POST["accion"];    
    $obj_Modificar ->tratarRolesAjax();
    
}else if($_POST["accion"]=="delete"){

  $obj_Modificar = new rolesAjax();
  $obj_Modificar -> idRol = $_POST["idRol"];
  $obj_Modificar ->eliminarRolAjax();
}