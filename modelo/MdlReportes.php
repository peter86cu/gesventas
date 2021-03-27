<?php


require_once("conexion.php");


class ModeloReportes{
	
	
	

	static public function buscasReporte($parametro,$datos){

		if($parametro != null){

			$obj = new BaseDatos();  
			$stmt= $obj->buscarAjaxSQL("");
			
			return $stmt;

		}else{

			$obj = new BaseDatos();      
			$result=$obj -> buscarSQL($datos);  

			return $result;

		}
	}


static public function buscasNombreeReporte($id){

		$nombre="";
			$obj = new BaseDatos();      
			$result=$obj -> buscar("reportes","id=".$id.""); 

			foreach ($result as $key => $value) {
			 	$nombre= $value['reporte'];
			 } 

			return $nombre;

		
	}





	




}