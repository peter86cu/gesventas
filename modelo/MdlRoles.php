<?php


require_once  ("conexion.php");

class ModeloRol{
	
	

	static public function insertarRol( $nombre,$descripcion, $estado ){  
		
    	
   			$obj = new BaseDatos();      
			$result=$obj -> insertar("rol", "'".$nombre."', '".$descripcion."', '".$estado."' ");  
			return $result;
						
	}		
					
	

	static public function mostrarRoles($parametro, $datos){

		if($parametro != null){

			$obj = new BaseDatos();  
			$stmt= $obj->buscarAjax("rol","id_rol ='".$datos."'");
			
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