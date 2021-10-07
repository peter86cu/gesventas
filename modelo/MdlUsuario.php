<?php

require_once  ("conexion.php"); 


class ModeloUsuario{
	
   
	static public function mdBuscarUsuarioPasword($usuario){
            
						
				    $obj = new BaseDatos();  
					$stmt= $obj->buscarSQL("select * from usuarios inner join rol on (usuarios.nivel=rol.id_rol) where usuario ='".$usuario."' and rol.estado=1");
					
					return $stmt;
					
	}

	static public function validaSession($usuario){
            
						
				    $obj = new BaseDatos();  
					$log= $obj->buscarSQL("select  MAX(id) id, id_session from log_session inner join usuarios on (usuarios.id_usuario=log_session.id_usuario) where usuarios.usuario ='".$usuario."'");

					$idsession="";
					$session="";
					if($log){

						foreach($log as $row) { 
						$idsession= $row['id_session'];			
							}	

					$acceso= $obj->buscarSQL("select count(*) count from log_session where id_session='".$idsession."'");
						
						foreach($acceso as $row) { 
						$session= $row['count'];			
							}	

					}
					
					if($session==1)
						return $idsession;
					else
						return false;


	}
					
	

	static public function buscarConfiguraciones(){
            
	
				    $obj = new BaseDatos();  
					$stmt= $obj->buscar("configuraciones","1");
					
					return $stmt;
					
	}


	static public function insertarUsuario( $nombre, $usuario ,$pass,$correo,$idRol,$idSucursal ){  
		
    	
   			$obj = new BaseDatos();      
			$result=$obj -> insertar("usuarios", "'".$usuario."', '".$pass."','".$idRol."',null,'".$correo."','".$idSucursal."',
			null,null,null,'".$nombre."', null,now(),1");  
			return $result;
						
	}		
	

	static public function insertarSession( $idSession, $usuario,$accion,$ip){  
		
    	
   			$obj = new BaseDatos();      
			$result=$obj -> insertar("log_session","'".$idSession."','".$usuario."',now(), '".$accion."', '".$ip."'");  
			return $result;
						
	}				
	

	static public function mostrarUsuario($parametro, $datos){

		if($parametro != null){

			$obj = new BaseDatos();  
			$stmt= $obj->buscarAjax("usuarios","id_usuario ='".$datos."'");
			
			return $stmt;

		}else{

			$obj = new BaseDatos();      
        	$result=$obj -> buscarSQL($datos);  
						
			return $result;
						
		}

		
						

	}



	static public function updateUsuario($idUsuario,$nombre, $usuario ,$pass,$correo,$idRol,$idSucursal){

			$obj = new BaseDatos();  
			$stmt= $obj->actualizar("usuarios", "nombres = '".$nombre."' , usuario='".$usuario."' ,password='".$pass."',email='".$correo."' ,nivel='".$idRol."', sucursal = '".$idSucursal."' ", "id_usuario = ".$idUsuario."");
			
			return $stmt;

						
		}



	static public function eliminarUsuario($idUsuario){

			$obj = new BaseDatos();  
			$stmt= $obj->actualizar("usuarios", "estado=0 ", "id_usuario = ".$idUsuario."");
			
			return $stmt;

						
		}

}