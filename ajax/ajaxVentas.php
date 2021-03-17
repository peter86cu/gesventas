<?php
require_once  "../controladores/CtrlVentas.php";
require_once  "../modelo/MdlVentas.php";
class ventasAjax{

  public $consecutivo;
  public $idApertura;
  public $accion;
  public $idVenta;
  public $idVentaDetalle;
  public $idProducto;
  public $cantidad;
  public $user;
  public $pass;


  public function buscarArqueoParaVentasAjax(){

      $respuesta = ModeloVentas::buscasAperturaCajero();
      echo json_encode($respuesta);
    }

     public function buscarArqueoParaVentasCajaAjax(){
       $parametro = "buscar";
      $respuesta = ModeloVentas::buscasAperturaCajeroVentas($parametro,null);
      echo json_encode($respuesta);
    }


     public function loginCajaAjax(){
       $user = $this->user;
       $pass = $this->pass;
      $respuesta = ModeloVentas::validarLoginCaja($user,$pass);      
      echo json_encode($respuesta);
    }

  public function buscarVentasTiempoAjax(){
      $parametro = "buscar";
      $idVenta = $this->idVenta;

      $respuesta = ModeloVentas::buscarVentasTiempoReal($idVenta);
      foreach ($respuesta as $key => $value) {      
      }
      echo json_encode($respuesta);
    }

  public function eliminarProductoVentasAjax(){
      $idVenta = $this->idVenta;
      $idVentaDetalle = $this->idVentaDetalle;
      $idProducto = $this->idProducto;
      $respuesta = ModeloVentas::eliminarVentasTiempoReal($idVenta,$idVentaDetalle,$idProducto);
      echo json_encode($respuesta);
    }

     public function cancelarVentasAjax(){
      $idVenta = $this->idVenta;      
      $respuesta = ModeloVentas::cancelarVenta($idVenta);
      echo json_encode($respuesta);
    }

    public function eliminarVentasSalirAjax(){
      $idVenta = $this->idVenta;      
      $respuesta = ModeloVentas::eliminarVentaSalir($idVenta);
      echo json_encode($respuesta);
    }

  public function insertarVentaAjax(){
      $idApertura = $this->idApertura;
      $respuesta = ModeloVentas::insertarVenta($idApertura);
      echo json_encode($respuesta);
    }

  public function buscarStockAjax(){
      $idProducto = $this->idProducto;
      $respuesta = ModeloVentas::buscarStockDisponible($idProducto);
      echo json_encode($respuesta);
    }

  public function insertarDetalle(){
      $idProducto = $this->idProducto;
      $idVenta = $this->idVenta;
      $cantidad = $this->cantidad;
      $respuesta = ModeloVentas::insertarVentaDetalle($idVenta,$cantidad,$idProducto);
      echo json_encode($respuesta);
    }






}

if($_POST["accion"]=="buscarArqueo" ){

  $obj_Modificar = new ventasAjax();
  $obj_Modificar -> accion = $_POST["accion"];
  $obj_Modificar ->buscarArqueoParaVentasAjax();

}if($_POST["accion"]=="buscarVentas" ){

  $obj_Modificar = new ventasAjax();

  $obj_Modificar -> idVenta = $_POST["idVenta"];
  $obj_Modificar -> accion = $_POST["accion"];
  $obj_Modificar ->buscarVentasTiempoAjax();

}if($_POST["accion"]=="eliminar" ){

  $obj_Modificar = new ventasAjax();
  $obj_Modificar -> accion = $_POST["accion"];
  $obj_Modificar -> idVenta = $_POST["idVenta"];
  $obj_Modificar -> idVentaDetalle = $_POST["idVentaDetalle"];
  $obj_Modificar -> idProducto = $_POST["idProducto"];

  $obj_Modificar ->eliminarProductoVentasAjax();

}if($_POST["accion"]=="insert" ){

  $obj_Modificar = new ventasAjax();
  $obj_Modificar -> idApertura = $_POST["idApertura"];
  $obj_Modificar -> accion = $_POST["accion"];
  $obj_Modificar ->insertarVentaAjax();

}if($_POST["accion"]=="buscarStock" ){

  $obj_Modificar = new ventasAjax();
  $obj_Modificar -> idProducto = $_POST["codigo"];
  $obj_Modificar -> accion = $_POST["accion"];
  $obj_Modificar ->buscarStockAjax();

}if($_POST["accion"]=="insertVentaDetalle" ){

  $obj_Modificar = new ventasAjax();
  $obj_Modificar -> idProducto = $_POST["idProducto"];
  $obj_Modificar -> idVenta = $_POST["idVenta"];
  $obj_Modificar -> cantidad = $_POST["cantidad"];
  $obj_Modificar ->insertarDetalle();

}if($_POST["accion"]=="buscarArqueoCaja" ){

  $obj_Modificar = new ventasAjax();
  $obj_Modificar -> accion = $_POST["accion"];
  $obj_Modificar ->buscarArqueoParaVentasCajaAjax();

}if($_POST["accion"]=="loginCaja" ){

  $obj_Modificar = new ventasAjax();
  $obj_Modificar -> pass = $_POST["pass"];
  $obj_Modificar -> user = $_POST["user"];

  $obj_Modificar ->loginCajaAjax();

}if($_POST["accion"]=="cancelar" ){

  $obj_Modificar = new ventasAjax();
  $obj_Modificar -> idVenta = $_POST["idVenta"];  
  $obj_Modificar ->cancelarVentasAjax();

}if($_POST["accion"]=="eliminarSalir" ){

  $obj_Modificar = new ventasAjax();
  $obj_Modificar -> idVenta = $_POST["idVenta"];  
  $obj_Modificar ->eliminarVentasSalirAjax();

}
