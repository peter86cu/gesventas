<?php


require_once  ("conexion.php");

class ModeloProveedor{
	
	

	static public function insertarProveedor( $razon_social, $ruc ,$direccion,$telefono,$celular,$email,$web ){  
		
    	
   			$obj = new BaseDatos();      
			$result=$obj -> insertar("proveedores", "'".$razon_social."', '".$ruc."', '".$direccion."', '".$telefono."','".$celular."','".$email."','".$web."', now(),null ");  
			return $result;
						
	}		
					
	

	static public function mostrarProveedores($parametro, $datos){

		if($parametro != null){

			$obj = new BaseDatos();  
			$stmt= $obj->buscarAjax("proveedores","id_proveedor ='".$datos."'");
			
			return $stmt;

		}else{

			$obj = new BaseDatos();      
        	$result=$obj -> buscarSQL($datos);  
						
			return $result;
						
		}

		
						

	}



	static public function updateProveedor($idProveedor,$razon_social, $ruc ,$direccion,$telefono,$celular,$email,$web,$habilitado ){
			$hab="";
			if ($habilitado) {
				$hab=",fecha_baja=null";
			}else{
				$hab=",fecha_baja=now()";
			}
			$obj = new BaseDatos();  
			$stmt= $obj->actualizar("proveedores", "razon_social = '".$razon_social."' , ruc='".$ruc."' , direccion='".$direccion."', telefono='".$telefono."' , celular='".$celular."' , email='".$email."' , web='".$web."' ".$hab." ", 
			"id_proveedor = ".$idProveedor."");
			
			return $stmt;

						
		}



	static public function eliminarProveedor($idProveedor){

			$obj = new BaseDatos();  
			$stmt= $obj->actualizar("proveedores", "fecha_baja=now()", "id_proveedor = ".$idProveedor."");
			
			return $stmt;

						
		}
	

		
						

	



}