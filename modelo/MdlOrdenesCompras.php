<?php


require_once  ("conexion.php");

@session_start();
class ModeloOrdenes{
	
	

	static public function insertarOrdenInicial(){  
		
		
		$obj = new BaseDatos();      
		$result=$obj -> insertarCamposEspecificos("ordenes_de_compras","id_orden_compra,estado,id_usuario,fecha_hora,id_sucursal,id_forma_pago,id_plazo", " 1,".$_SESSION['id'].", now(), ".$_SESSION["sucursal"].", 1, 1 ");  
		

		$idOrden = $obj ->buscarSQL("select max(id_orden_compra) as maximo from ordenes_de_compras  where id_usuario =".$_SESSION['id']." ");
		
		foreach($idOrden as $row) { 
				$id= $row['maximo'];
		}

		return $id;

	}		


static public function insertarDetalleOrden($idOrden, $idProducto,$cantidad, $importe ){  
		
    	
   			$obj = new BaseDatos();      
			$result=$obj -> insertar("ordenes_de_compras_detalle", "".$idProducto.", ".$cantidad.", ".$idOrden.",".$importe.",get_moneda()");  
			return $result;
						
	}	
	

	static public function mostrarOrdenes($parametro, $datos){


		if($parametro != null){
			
			$obj = new BaseDatos();  
			$stmt= $obj->buscarAjax("ordenes_de_compras","id_orden_compra ='".$datos."'");
			
			return $stmt;

		}else{

			$obj = new BaseDatos();      
			$result=$obj -> buscarSQL($datos);  

			return $result;

		}


	}
	

	static public function mostrarDatosProveedor( $datos){


		
			$obj = new BaseDatos();  
			$stmt= $obj->buscarAjax("proveedores","id_proveedor ='".$datos."'");
			
			return $stmt;


	}


	static public function cantidadRegistros( $datos){

		     $obj = new BaseDatos();      
			$result=$obj -> buscarSQL($datos);  

			return $result;
		

	}



	static public function updateOrdenes($idOrden,$idProveedor,$plazo, $fecha ,$formaPago, $estado){

		$obj = new BaseDatos();  
		$stmt= $obj->actualizar("ordenes_de_compras", 
			
			"estado='".$estado."',fecha_hora='".$fecha."',id_proveedor='".$idProveedor."',id_sucursal='".$_SESSION["sucursal"]."',id_forma_pago='".$formaPago."',id_plazo='".$plazo."'", 
			"id_orden_compra='".$idOrden."'");


		if($stmt){
				if($estado==3){
					$stmt2= $obj->insertar("ordenes_compras_modificaciones",			
			"'".$idOrden."','".$_SESSION["id"]."',null,now(),null ");
				}
			
		}

		if($stmt)
		return $stmt;

		}


	

	static public function updateProveedorOrdenes($idOrden,$idProveedor){

		$obj = new BaseDatos();  
		$stmt= $obj->actualizar("ordenes_de_compras", "id_proveedor='".$idProveedor."'", "id_orden_compra='".$idOrden."'");

		return $stmt;


	}



	static public function eliminarOrden($idOrden){
		
		$obj = new BaseDatos();  
		$stmt= $obj->actualizar("ordenes_de_compras", " fecha_baja =now() ", "id_orden_compra = ".$idOrden."");

		return $stmt;


	}
	




	



}