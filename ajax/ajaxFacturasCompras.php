<?php
require_once  "../controladores/CtrlFacturaCompras.php";
require_once  "../modelo/MdlFacturasCompras.php";
class facturasComprasAjax{

  public $idEntrada;
  public $idProducto;
  public $idOrden;
  public $idCompra;
  public $idProveedor;
  public $fecha;
  public $plazo;
  public $formaPago;
  public $estado;
  public $cantidad;
  public $importe;
  public $accion;
  public $factura;
  public $receptor;
  public $deposito;
  public $moneda; 


  public function modificarFacturasComprasAjax(){

    error_log("orden accion ".$this->accion,0);
    if($this->accion=="buscar"){

      $parametro = "idCompra";  
      $idCompra = $this->idCompra;      
      $respuesta = ModeloFacturasCompras::mostrarFacturas($parametro,$idCompra); 

    }elseif($this->accion=="buscarProveedor"){

      $idProveedor = $this->idProveedor;
      error_log("llegue a modificar ajax con id ".$idProveedor,0);
      $respuesta = ModeloFacturasCompras::mostrarDatosProveedor($idProveedor); 

    }elseif($this->accion=="validar"){

     $idOrden = $this->idOrden;      
     $respuesta = ModeloFacturasCompras::buscarOrdenCompra($idOrden); 

   }

   echo json_encode($respuesta);


 }


 public function eliminarCompraAjax(){

  $idCompra = $this->idCompra;
  $respuesta = ModeloFacturasCompras::eliminarCompra($idCompra);      
  echo json_encode($respuesta);


}


public function tratarFacturasComprasAjax(){

  if($this->accion=="inicial"){

    $respuesta = ModeloFacturasCompras::insertarFacturaInicial();      

  }else if($this->accion=="update"){
   $idOrden = $this->idOrden;
   $idCompra = $this->idCompra;   
   $plazo = $this->plazo;
   $fecha = $this->fecha;
   $formaPago = $this->formaPago;
   $estado = $this->estado;
   $factura = $this->factura;
   $receptor = $this->receptor;
   $moneda = $this->moneda;
   $deposito = $this->deposito;
   $respuesta = ModeloFacturasCompras::updateCompras($idCompra,$idOrden,$plazo, $fecha ,$formaPago, $estado,$factura,$receptor,$moneda,$deposito);        


 }else if($this->accion=="insert"){
  $idProducto = $this->idProducto;
  $cantidad =$this->cantidad;
  $importe = $this->importe;
  $idCompra = $this->idCompra;
  $respuesta = ModeloFacturasCompras::insertarDetalleCompra($idCompra,$idProducto,$cantidad,$importe);  
}  
if($this->accion=="uProveedor"){

  $idProveedor =$this->idProveedor;
  $idCompra = $this->idCompra;
  $respuesta = ModeloFacturasCompras::updateProveedorCompras($idCompra,$idProveedor);     

} 

echo json_encode($respuesta);


}

}

if($_POST["accion"]=="buscar" || $_POST["accion"]=="buscarProveedor" || $_POST["accion"]=="validar"){ 

  $obj_Modificar = new facturasComprasAjax();

  if($_POST["accion"]=="buscar"){

    $obj_Modificar -> idCompra = $_POST["idCompra"];

  }elseif($_POST["accion"]=="buscarProveedor"){

    $obj_Modificar -> idProveedor = $_POST["idProveedor"];

  }elseif($_POST["accion"]=="validar"){

    $obj_Modificar -> idOrden = $_POST["idOrden"];
  }

  $obj_Modificar -> accion = $_POST["accion"];
  $obj_Modificar ->modificarFacturasComprasAjax();

}else if($_POST["accion"]=="update" || $_POST["accion"]=="insert" || $_POST["accion"]=="inicial" || $_POST["accion"]=="uProveedor"){

  $obj_Modificar = new facturasComprasAjax();
  

  if($_POST["accion"]=="update"){
    $obj_Modificar -> idOrden = $_POST["idOrden"];
    $obj_Modificar -> idCompra = $_POST["idCompra"];   
    $obj_Modificar -> fecha = $_POST["fecha"];
    $obj_Modificar -> plazo = $_POST["plazo"];
    $obj_Modificar -> formaPago = $_POST["forma_pago"];
    $obj_Modificar -> factura = $_POST["factura"];
    $obj_Modificar -> receptor = $_POST["receptor"];
    $obj_Modificar -> estado = $_POST["estado"];
    $obj_Modificar -> deposito = $_POST["deposito"];
    $obj_Modificar -> moneda = $_POST["moneda"];

  }

  if($_POST["accion"]=="insert"){
    $obj_Modificar -> idProducto = $_POST["idProducto"];
    $obj_Modificar -> idCompra = $_POST["idCompra"];
    $obj_Modificar -> cantidad = $_POST["cantidad"];
    $obj_Modificar -> importe = $_POST["importe"];
  }

  if($_POST["accion"]=="uProveedor"){
   $obj_Modificar -> idCompra = $_POST["idCompra"];
   $obj_Modificar -> idProveedor = $_POST["idProveedor"]; 
 }
 

 $obj_Modificar -> accion = $_POST["accion"];    
 $obj_Modificar ->tratarFacturasComprasAjax();

}if($_POST["accion"]=="delete"){

 $obj_Modificar = new facturasComprasAjax();
 $obj_Modificar -> idCompra = $_POST["idCompra"]; 
 $obj_Modificar -> accion = $_POST["accion"];    
 $obj_Modificar ->eliminarCompraAjax();
}