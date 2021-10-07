<?php


require_once  ("conexion.php");

class ModeloProductos{
	
	

	static public function insertarProductoNew( $codigo,$nombre, $minimo ,$precioV, $iva,$categoria,$marca,$tipo_producto,$unidad_medida,$inventario,$disponible,$moneda, $foto){  
		
		$obj = new BaseDatos();      
		$result=$obj -> insertar("productos", "'".$codigo."', '".$nombre."', '".$precioV."', '".$iva."', '".$categoria."', 
			'".$marca."', '".$tipo_producto."', '".$unidad_medida."', '".$foto."', '".$inventario."', '".$disponible."',now(),'".$moneda."', '".$minimo."',now() ");  
		
		return $result;

	}		

	

	static public function mostrarProductos($parametro, $datos){

		if($parametro != null){

			$obj = new BaseDatos();  
			$stmt= $obj->buscarAjax("productos","id_producto ='".$datos."'");
			
			return $stmt;

		}else{

			$obj = new BaseDatos();      
			$result=$obj -> buscarSQL($datos);  

			return $result;

		}


	}

	static public function buscarProductos( $datos){
				
			$obj = new BaseDatos();  
			$stmt= $obj->buscarAjax("productos","codigo ='".$datos."' and disponible=1");
			
			return $stmt;

	}

	static public function buscarSimboloMoneda( $idMoneda){
				
			$obj = new BaseDatos();  
			$stmt= $obj->buscarSQL("select m.simbolo from monedas m,  productos p where m.id_moneda=p.id_moneda and m.id_moneda='".$idMoneda."'");
			
			foreach ($stmt as $key => $value) {
				$simbolo=$value['simbolo'];
			}

			return $simbolo;

	}

	static public function cantidadRegistros( $datos){

		     $obj = new BaseDatos();      
			$result=$obj -> buscarSQL($datos);  

			return $result;
		

	}



	static public function updateProductos($idProducto,$codigo,$nombre, $minimo ,$precioV, $iva,$categoria,$marca,$tipo_producto,$unidad_medida,$inventario,$disponible,$moneda, $foto){

		$obj = new BaseDatos();  
		$stmt= $obj->actualizar("productos", 
			
			"codigo = '".$codigo."' , nombre='".$nombre."' ,precio_venta=".$precioV." , id_impuesto=".$iva." , id_categoria=".$categoria.",
			id_marca=".$marca." , id_tipo_producto=".$tipo_producto." , id_unidad_medida=".$unidad_medida." , foto='".$foto."' , inventariable=".$inventario.",
			disponible=".$disponible." , id_moneda =".$moneda." , minimo=".$minimo." , fecha_actualizado =now() ", 
			"id_producto = ".$idProducto."");

		return $stmt;


	}



	static public function eliminarProductos($idProducto){

		$obj = new BaseDatos();  
		$stmt= $obj->actualizar("productos", "disponible=0 ,  fecha_actualizado =now() ", "id_producto = ".$idProducto."");

		return $stmt;


	}
	




	



}