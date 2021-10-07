<?php

require_once  "../modelo/MdlRoles.php";

class rolesAjax{

    public $idRol;
    public $nombre;
    public $descripcion;
    public $estado;
    public $accion;
    public $data;

    public function modificarRolAjax(){
    
      $parametro = "idRol";  
      $idRol = $this->idRol;
      $respuesta = ModeloRol::mostrarRoles($parametro,$idRol);      
      echo json_encode($respuesta);
     

    }


     public function buscarModulosXNivelesAjax(){
    
     
      $idRol = $this->idRol;
      $respuesta = ModeloRol::buscarModulosNiveles($idRol);      
      echo json_encode($respuesta);
     

    }



    public function buscarModulos(){
    
      $consulta = "select * from modulos where estado =1";  
      $parametro=null;
      $respuesta = ModeloRol::mostrarModulos($parametro,$consulta);      
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
       $data =$this->data; 

           if($this->accion=="update"){
           
          $respuesta = ModeloRol::updateRoles($idRol,$nombre, $descripcion ,$estado,$data);      
          
        }else{
          
          $respuesta = ModeloRol::insertarRol($nombre, $descripcion ,$estado,$data );      

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
    $obj_Modificar -> data = json_decode($_POST['array'], true);    
    $obj_Modificar ->tratarRolesAjax();
    
}else if($_POST["accion"]=="delete"){

  $obj_Modificar = new rolesAjax();
  $obj_Modificar -> idRol = $_POST["idRol"];
  $obj_Modificar ->eliminarRolAjax();
}else if($_POST["accion"]=="modulos_niveles"){

  $obj_Modificar = new rolesAjax();
  $obj_Modificar -> idRol = $_POST["idRol"];
  $obj_Modificar ->buscarModulosXNivelesAjax();
}else if($_POST["accion"]=="lista_modulos"){

  $obj_Modificar = new rolesAjax();  
  $obj_Modificar ->buscarModulos();
}
