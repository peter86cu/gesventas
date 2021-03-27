<?php
require_once  "../controladores/CtrlOrdenesCompras.php";
require_once  "../modelo/MdlOrdenesCompras.php";
class ordenesAjax{

  public $idOrden;
  public $idProducto;
  public $idProveedor;
  public $fecha;
  public $plazo;
  public $formaPago;
  public $estado;
  public $cantidad;
  public $importe;
  public $accion;



  public function modificarOrdenAjax(){

  
    if($this->accion=="buscar"){
      $parametro = "idOrden";  
      $idOrden = $this->idOrden;      
      $respuesta = ModeloOrdenes::mostrarOrdenes($parametro,$idOrden); 
    }else{
      $idProveedor = $this->idProveedor;
   
      $respuesta = ModeloOrdenes::mostrarDatosProveedor($idProveedor); 
    }

    echo json_encode($respuesta);


  }


  public function eliminarOrdenAjax(){

    $idOrden = $this->idOrden;
    $respuesta = ModeloOrdenes::eliminarOrden($idOrden);      
    echo json_encode($respuesta);


  }


  public function tratarOrdenesAjax(){

    if($this->accion=="inicial"){

      $respuesta = ModeloOrdenes::insertarOrdenInicial();      

    }else if($this->accion=="update"){
     $idOrden = $this->idOrden;
     $idProveedor =$this->idProveedor;
     $plazo = $this->plazo;
     $fecha = $this->fecha;
     $formaPago = $this->formaPago;
     $estado = $this->estado;
     $respuesta = ModeloOrdenes::updateOrdenes($idOrden,$idProveedor,$plazo, $fecha ,$formaPago, $estado);        
     

   }else if($this->accion=="insert"){
    $idProducto = $this->idProducto;
    $cantidad =$this->cantidad;
    $importe = $this->importe;
    $idOrden = $this->idOrden;
    $respuesta = ModeloOrdenes::insertarDetalleOrden($idOrden,$idProducto,$cantidad,$importe);  
  }  
  if($this->accion=="uProveedor"){

    $idProveedor =$this->idProveedor;
    $idOrden = $this->idOrden;
    $respuesta = ModeloOrdenes::updateProveedorOrdenes($idOrden,$idProveedor);     

  } 

  echo json_encode($respuesta);


}

}

if($_POST["accion"]=="buscar" || $_POST["accion"]=="buscarProveedor"){ 

  $obj_Modificar = new ordenesAjax();

  if($_POST["accion"]=="buscar"){

    $obj_Modificar -> idOrden = $_POST["idOrden"];
  }elseif($_POST["accion"]=="buscarProveedor"){
    $obj_Modificar -> idProveedor = $_POST["idProveedor"];
  }
  $obj_Modificar -> accion = $_POST["accion"];
  $obj_Modificar ->modificarOrdenAjax();

}else if($_POST["accion"]=="update" || $_POST["accion"]=="insert" || $_POST["accion"]=="inicial" || $_POST["accion"]=="uProveedor"){

  $obj_Modificar = new ordenesAjax();
  

  if($_POST["accion"]=="update"){
    $obj_Modificar -> idOrden = $_POST["idOrden"];
    $obj_Modificar -> idProveedor = $_POST["idProveedor"];
    $obj_Modificar -> fecha = $_POST["fecha"];
    $obj_Modificar -> plazo = $_POST["plazo"];
    $obj_Modificar -> formaPago = $_POST["forma_pago"];
    $obj_Modificar -> estado = $_POST["estado"];


  }

  if($_POST["accion"]=="insert"){
    $obj_Modificar -> idProducto = $_POST["idProducto"];
    $obj_Modificar -> idOrden = $_POST["idOrden"];
    $obj_Modificar -> cantidad = $_POST["cantidad"];
    $obj_Modificar -> importe = $_POST["importe"];
  }

  if($_POST["accion"]=="uProveedor"){
   $obj_Modificar -> idOrden = $_POST["idOrden"];
   $obj_Modificar -> idProveedor = $_POST["idProveedor"]; 
 }
 

 $obj_Modificar -> accion = $_POST["accion"];    
 $obj_Modificar ->tratarOrdenesAjax();

}if($_POST["accion"]=="delete"){

 $obj_Modificar = new ordenesAjax();
 $obj_Modificar -> idOrden = $_POST["idOrden"]; 
 $obj_Modificar -> accion = $_POST["accion"];    
 $obj_Modificar ->eliminarOrdenAjax();
}