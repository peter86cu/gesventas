<?php
require_once  "../controladores/CtrlProductos.php";
require_once  "../modelo/MdlProductos.php";
class productosAjax{

  public $idProducto;
  public $codigo;
  public $nombre;
  public $minimo;
  public $precioV;
  public $iva;
  public $categoria;
  public $marca;
  public $tipo_producto;
  public $unidad_medida;
  public $inventario;
  public $disponible;
  public $moneda;
  public $foto;
  public $url_tem;
  public $src;
  public $accion;



  public function modificarProductoAjax(){

  
    if($this->accion=="update" || $this->accion=="buscar"){

    $parametro = "idProducto";  
    $idProducto = $this->idProducto;
    $respuesta = ModeloProductos::mostrarProductos($parametro,$idProducto); 
    
    } elseif($this->accion=="buscarP"){
     
      $codigo = $this->codigo;
    $respuesta = ModeloProductos::buscarProductos($codigo);
    }    
    echo json_encode($respuesta);


  }


  public function eliminarProductoAjax(){

    $idProducto = $this->idProducto;
    $respuesta = ModeloProductos::eliminarProductos($idProducto);      
    echo json_encode($respuesta);


  }


  public function buscarSimboloMonedaAjax(){

    $moneda = $this->moneda;
    $respuesta = ModeloProductos::buscarSimboloMoneda($moneda);      
    echo json_encode($respuesta);


  }


  public function tratarProductoAjax(){

   $idProducto = $this->idProducto;
   $codigo =$this->codigo;
   $nombre = $this->nombre;
   $minimo = $this->minimo;
   $precioV = $this->precioV;
   $iva =$this->iva;
   $categoria= $this->categoria;
   $marca = $this->marca;
   $tipo_producto = $this->tipo_producto;
   $unidad_medida = $this->unidad_medida;
   $inventario = $this->inventario;
   $disponible = $this->disponible;
   $moneda =$this->moneda;       
   $foto =$this->foto;

   if($this->accion=="update"){
    $respuesta = ModeloProductos::updateProductos($idProducto,$codigo,$nombre, $minimo ,$precioV, $iva,$categoria,$marca,$tipo_producto,$unidad_medida,$inventario,$disponible,$moneda, $foto);      

  }else{
    error_log("ajax insert",0);
    $respuesta = ModeloProductos::insertarProductoNew($codigo,$nombre, $minimo ,$precioV, $iva,$categoria,$marca,$tipo_producto,$unidad_medida,$inventario,$disponible,$moneda, $foto);      

  }   
  if ($this->foto!='' && $respuesta) {
    error_log("Entro a guardar imagen ".$this->src,0);
    move_uploaded_file($this->url_tem, $this->src);       

  }       
  echo json_encode($respuesta);


}

}

if($_POST["accion"]=="buscar"){ 

  $obj_Modificar = new productosAjax();
  $obj_Modificar -> idProducto = $_POST["idProducto"];
  $obj_Modificar -> accion = $_POST["accion"];
  $obj_Modificar ->modificarProductoAjax();

}else if($_POST["accion"]=="update" || $_POST["accion"]=="insert"){
  $obj_Modificar = new productosAjax();
  $foto= $_FILES['foto'];
  $nombre_foto = $foto['name'];
  $url_tem = $foto['tmp_name'];
  $imgProducto= 'img_producto.png';

  if($nombre_foto!=''){
   $destino = '../vistas/recursos/dist/img/productos/';
   $img_nombre = 'img_'.md5(date('d-m-Y H:m:s'));
   $imgProducto = $img_nombre.'.jpg';
   $src= $destino.$imgProducto;
 }

 if($_POST["accion"]=="update"){
  $obj_Modificar -> idProducto = $_POST["idProducto"];
}


$obj_Modificar -> codigo = $_POST["codigo"];
$obj_Modificar -> nombre = $_POST["nombre"];
$obj_Modificar -> minimo = $_POST["minimo"];
$obj_Modificar -> precioV = $_POST["precioV"];
$obj_Modificar -> iva = $_POST["iva"];
$obj_Modificar -> categoria = $_POST["categoria"];
$obj_Modificar -> marca = $_POST["marca"];
$obj_Modificar -> tipo_producto = $_POST["tipo_producto"];
$obj_Modificar -> unidad_medida = $_POST["unidad_medida"];
$obj_Modificar -> inventario = $_POST["inventario"];
$obj_Modificar -> disponible = $_POST["disponible"];
$obj_Modificar -> moneda = $_POST["moneda"];
$obj_Modificar -> foto = $imgProducto;
$obj_Modificar -> url_tem = $url_tem;
$obj_Modificar -> src = $src;
$obj_Modificar -> accion = $_POST["accion"];    
$obj_Modificar ->tratarProductoAjax();

}else if($_POST["accion"]=="delete"){

  $obj_Modificar = new productosAjax();
  $obj_Modificar -> idProducto = $_POST["idProducto"];
  $obj_Modificar ->eliminarProductoAjax();
}
 if($_POST["accion"]=="buscarP"){
  $obj_Modificar = new productosAjax();
  $obj_Modificar -> codigo = $_POST["codigo"];
  $obj_Modificar -> accion = $_POST["accion"]; 
  $obj_Modificar ->modificarProductoAjax();
}

if($_POST["accion"]=="buscarMoneda"){ 

  $obj_Modificar = new productosAjax();
  $obj_Modificar -> moneda = $_POST["idMoneda"];
  $obj_Modificar ->buscarSimboloMonedaAjax();

}