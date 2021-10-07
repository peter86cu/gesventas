<?php

require_once  "../modelo/MdlProveedores.php";

class proveedoresAjax{

    public $idProveedor;
    public $razon_social;
    public $ruc;
    public $direccion;
    public $telefono;
    public $celular;
    public $email;
    public $web;
    public $accion;
    public $habilitado;

    public function modificarProveedorAjax(){
    
      $parametro = "idProveedor";  
      $idProveedor = $this->idProveedor;
      $respuesta = ModeloProveedor::mostrarProveedores($parametro,$idProveedor);      
      echo json_encode($respuesta);
     

    }


    public function eliminarProveedorAjax(){
    
      $idProveedor = $this->idProveedor;
      $respuesta = ModeloProveedor::eliminarProveedor($idProveedor);      
      echo json_encode($respuesta);
     

    }

     public function tratarProveedorAjax(){
    
           $razon_social = $this->razon_social;
           $ruc = $this->ruc;
           $direccion = $this->direccion;
           $telefono = $this->telefono;
           $celular = $this->celular;
           $email = $this->email;
           $web = $this->web;
           $habilitado = $this->habilitado;
           
           if($this->accion=="update"){
            $idProveedor = $this->idProveedor;
          $respuesta = ModeloProveedor::updateProveedor($idProveedor,$razon_social, $ruc ,$direccion,$telefono,$celular,$email,$web, $habilitado);      
          
        }else{
           
      
          $respuesta = ModeloProveedor::insertarProveedor($razon_social, $ruc ,$direccion,$telefono,$celular,$email,$web);      

        }  
           
        echo json_encode($respuesta);
          
          
   }
}

if($_POST["accion"]=="buscar"){ 

    $obj_Modificar = new proveedoresAjax();
    $obj_Modificar -> idProveedor = $_POST["idProveedor"];
    $obj_Modificar ->modificarProveedorAjax();
}else if($_POST["accion"]=="update" || $_POST["accion"]=="insert"){
  
  $obj_Modificar = new proveedoresAjax();
  if($_POST["accion"]=="update"){
     $obj_Modificar -> idProveedor = $_POST["idProveedor"];
  }
   
    $obj_Modificar -> razon_social = $_POST["razon_social"];
    $obj_Modificar -> ruc = $_POST["ruc"];
    $obj_Modificar -> direccion = $_POST["direccion"];
    $obj_Modificar -> telefono = $_POST["telefono"]; 
    $obj_Modificar -> celular = $_POST["celular"]; 
    $obj_Modificar -> email = $_POST["email"]; 
    $obj_Modificar -> web = $_POST["web"];
    $obj_Modificar -> habilitado = $_POST["habilitado"];
    $obj_Modificar -> accion = $_POST["accion"];    
    $obj_Modificar ->tratarProveedorAjax();
    
}else if($_POST["accion"]=="delete"){

  $obj_Modificar = new proveedoresAjax();
  $obj_Modificar -> idProveedor = $_POST["idProveedor"];
  $obj_Modificar ->eliminarProveedorAjax();
}