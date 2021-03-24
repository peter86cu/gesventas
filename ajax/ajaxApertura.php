<?php
require_once  "../controladores/CtrlApertura.php";
require_once  "../modelo/MdlApertura.php";
class aperturaAjax{

  public $idApertura;
  public $idTurno;
  public $idCaja;
  public $tipoArqueo;
  public $consecutivo;
  public $idCuadre;
  public $accion;
  public $data;



  public function buscarAperturaAjax(){

    
    if($this->accion=="inicio"){

     $parametro = "idApertura";  
     $respuesta = ModeloApertura::buscasApertura($parametro,null); 


  }if($this->accion=="respuesta"){

     $result = ModeloApertura::insertarAperturaInicial(); 

     if($result){
      $parametro = "idApertura";  
     $respuesta = ModeloApertura::buscasApertura($parametro,null);
     }
  } if($this->accion=="buscar"){

     $parametro = "idApertura";  
     $respuesta = ModeloApertura::buscasApertura($parametro,null); 


  }


  echo json_encode($respuesta);


}


  public function buscarVentasAjax(){
  
     $idApertura = $this->idApertura;  
     $respuesta = ModeloApertura::buscarVentas($idApertura); 

  echo json_encode($respuesta);


}



 public function validarVentasAjax(){
    
     $idApertura = $this->idApertura;  
     $respuesta = ModeloApertura::validarVentas($idApertura); 

  echo json_encode($respuesta);


}


public function tratarAperturaAjax(){

 if($this->accion=="update"){
   $idApertura = $this->idApertura;
   $idCaja =$this->idCaja;
   $idTurno = $this->idTurno;
  
   $respuesta = ModeloApertura::updateApertura($idApertura,$idCaja,$idTurno);  

 } if($this->accion=="insert"){
   $idApertura = $this->idApertura;
   $tipoArqueo = $this->tipoArqueo;
   $idCuadre = $this->idCuadre;
   $data =$this->data;   
  
   $respuesta = ModeloApertura::insertarArqueo($idApertura,$tipoArqueo,$data, $idCuadre);  

 }

echo json_encode($respuesta);


}

}

if($_POST["accion"]=="inicio" || $_POST["accion"]=="respuesta" || $_POST["accion"]=="buscar"){ 

  $obj_Modificar = new aperturaAjax();
  
  if($_POST["accion"]=="buscar"){
    //$obj_Modificar -> idApertura = $_POST["idApertura"];
  }

  $obj_Modificar -> accion = $_POST["accion"];
  $obj_Modificar ->buscarAperturaAjax();

}else if($_POST["accion"]=="update" ){

  $obj_Modificar = new aperturaAjax();
  

  if($_POST["accion"]=="update"){
    $obj_Modificar -> idTurno  = $_POST["turno"];
    $obj_Modificar -> idCaja = $_POST["caja"];
    $obj_Modificar -> idApertura = $_POST["idApertura"];
  }

  $obj_Modificar -> accion = $_POST["accion"];    
  $obj_Modificar ->tratarAperturaAjax();

}else if($_POST["accion"]=="insert" ){

    $obj_Modificar = new aperturaAjax();
    $obj_Modificar -> idApertura  = $_POST["idApertura"]; 
    $obj_Modificar -> tipoArqueo  = $_POST["tipoArqueo"];  
    $obj_Modificar -> idCuadre  = $_POST["idCuadre"];
    $obj_Modificar -> data = json_decode($_POST['array'], true);
    $obj_Modificar -> accion = $_POST["accion"]; 
    $obj_Modificar ->tratarAperturaAjax();
}else if($_POST["accion"]=="ventas" ){

    $obj_Modificar = new aperturaAjax();
    $obj_Modificar -> idApertura  = $_POST["idApertura"];   
    $obj_Modificar -> accion = $_POST["accion"];
    
    $obj_Modificar ->buscarVentasAjax();
}else if($_POST["accion"]=="validar" ){

    $obj_Modificar = new aperturaAjax();      
    $obj_Modificar ->buscarVentasAjax();
}else if($_POST["accion"]=="elimina_inicio" ){
    
    $obj_Modificar = new aperturaAjax();      
    $obj_Modificar ->buscarVentasAjax();
}