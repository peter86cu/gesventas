<?php


require_once  ("conexion.php");

class ModeloRol{
	
	

	static public function insertarRol( $nombre,$descripcion, $estado,$data ){  
		

   			$obj = new BaseDatos();  
			$result=$obj -> insertar("rol", "'".$nombre."', '".$descripcion."', '".$estado."' "); 

			$id=$obj -> buscarSQL("select MAX(id_rol) AS id FROM rol");  
			
			$id_rol;
			foreach($id as $row) { 
			$id_rol= $row['id'];			
				}						
			foreach ($data as $values) {
						$modulos=$obj -> insertar("roles_modulos", "'".$id_rol."', '".$values['modulo']."' ");
					foreach($values['nivel'] as $nivel){						
						$niveles=$obj -> insertar("roles_modulos_niveles", "'".$id_rol."', '".$values['modulo']."','".$nivel."' "); 
					}
			  
			
			} 
		
		


			return $result;
						
	}		
					
	static public function coloresPagina( $datos ){  
		
    	
   			$obj = new BaseDatos();      
			$result=$obj -> buscarSQL($datos);   
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


static public function buscarModulosNiveles($idRol){

		    $obj = new BaseDatos();      
        	$result=$obj -> buscarSQL("select DISTINCT r.id_rol,r.id_modulo,r.id_nivel,m.nombre,na.descripcion FROM  roles_modulos_niveles r inner join roles_modulos rm on (rm.id_modulo=r.id_modulo) inner join modulos m on (r.id_modulo=m.id_modulo) inner join nivel_acceso na on (r.id_nivel=na.id ) where m.estado =1 and r.id_rol=".$idRol." order by id_modulo,id_nivel");						
			return $result;
						
						

	}




		static public function mostrarModulos($parametro, $datos){

		if($parametro != null){

			$obj = new BaseDatos();  
			$stmt= $obj->buscarAjax("modulos","id_modulo ='".$datos."'");
			
			return $stmt;

		}else{

			$obj = new BaseDatos();      
        	$result=$obj -> buscarSQL($datos);  
						
			return $result;
						
		}

		
						

	}



	static public function updateRoles($id,$nombre,$descripcion,$estado,$data){

			$obj = new BaseDatos();  
			$stmt= $obj->actualizar("rol", "rol = '".$nombre."' , descripcion='".$descripcion."' ,estado=".$estado." ", 
			"id_rol = ".$id."");

			
			//error_log( print_r($data, TRUE) );
			if($obj -> borrar("roles_modulos" ,"id_rol=".$id."")){			
			foreach ($data as $values) {
				//error_log("roles_modulos", "'".$id."', '".$values['modulo']."' ");
						$modulos=$obj -> insertar("roles_modulos", "'".$id."', '".$values['modulo']."' ");
					foreach($values['nivel'] as $nivel){						
						$niveles=$obj -> insertar("roles_modulos_niveles", "'".$id."', '".$values['modulo']."','".$nivel."' "); 
					}
			  
			
			} 
			}
			return $stmt;

						
		}



	static public function eliminarRol($idRol){

			$obj = new BaseDatos();  
			$stmt= $obj->actualizar("rol", "estado=0 ", "id_rol = ".$idRol."");
			
			return $stmt;

						
		}
	

		
						

	



}