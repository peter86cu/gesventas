<?php


require_once  ("conexion.php");


class ModeloGeneral{
	
	

	static public function insertarNotificacion( $tipoN,$descripcion ){  
		
    	
   			$obj = new BaseDatos();      
			$result=$obj -> insertar("notif", " Aplicacion, '".$tipoN."', '".$descripcion."', 1,now(), '".$_SESSION['id']."' ");  
			return $result;
						
	}		
					
	static public function mostrarNotif($parametro, $datos){

		if($parametro != null){

			$obj = new BaseDatos();  
			$stmt= $obj->buscarAjax("notif","id ='".$datos."'");
			
			return $stmt;

		}else{

			$obj = new BaseDatos();      
        	$result=$obj -> buscarSQL($datos);  
						
			return $result;
						
		}
	}

	
	static public function updateNotificacion($id){

			$obj = new BaseDatos();  
			$stmt= $obj->actualizar("notif", "estado = 2", 	"tipo_notificacion = ".$id." and username='".$_SESSION['id']."' ");
			
			return $stmt;

						
		}
		
						

	



}