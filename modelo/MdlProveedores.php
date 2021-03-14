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



	static public function updateRoles($id,$nombre,$descripcion,$estado){

			$obj = new BaseDatos();  
			$stmt= $obj->actualizar("rol", "rol = '".$nombre."' , descripcion='".$descripcion."' ,estado=".$estado." ", 
			"id_rol = ".$id."");
			
			return $stmt;

						
		}



	static public function eliminarRol($idRol){

			$obj = new BaseDatos();  
			$stmt= $obj->actualizar("rol", "estado=0 ", "id_rol = ".$idRol."");
			
			return $stmt;

						
		}
	

		
						

	



}