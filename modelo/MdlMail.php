<?php


require_once("conexionMail.php");

@session_start();

class ModeloMail{
	
	
	

	static public function buscasMailAll($parametro,$datos){

		if($parametro != null){

			$obj = new BaseDatosMail();  
			$stmt= $obj->buscarAjaxSQL("");
			
			return $stmt;

		}else{

			$obj = new BaseDatosMail();      
			$result=$obj -> buscarSQL($datos);  

			return $result;

		}
	}



		static public function marcarComoLeido($idMail,$idUser){           
					
		$obj = new BaseDatosMail();  
		$stmt= $obj->actualizar("mail", "estado = 1", 	"id = ".$idMail."");
		$cant=0;
		$result=$obj -> buscarSQL("SELECT count(*) sin_leer FROM `mail` WHERE id_usuario='".$idUser."' and estado=0");

				foreach ($result as $key => $value) {
					$cant = $value['sin_leer'];
				}
			

		return $cant;
					
	}



static public function moverEliminadosSeleccion($listaIdMail,$accion){           
					
		$obj = new BaseDatosMail(); 
		$stmt=""; 
		$stmt2=""; 
		if($accion=="entrada"){
			foreach ($listaIdMail as $value) {
			
			$stmt= $obj->actualizar("mail", "accion = 2,fecha_delete=now()", 	"id = ".$value['id']."");

			}

		}if($accion=="salida"){
			foreach ($listaIdMail as $value) {
				
			$stmt= $obj->actualizar("mail_sent", "accion = 2,fecha_delete=now()", 	"id = ".$value['id']."");
		   }
		}if($accion=="permanente"){
			foreach ($listaIdMail as $value) {
				
			$stmt= $obj->actualizar("mail_sent", "accion = 3,fecha_delete=now()", 	"id = ".$value['id']."");

			$stmt2= $obj->actualizar("mail", "accion = 3,fecha_delete=now()", 	"id = ".$value['id']."");
			
		   }
		}
		
		if($stmt && $stmt2)

		return $stmt;
					
	}

	static public function moverEliminadosLectura($idMail,$accion){           
					error_log($accion);
		$obj = new BaseDatosMail(); 
		$stmt=""; 
		if($accion=="entrada"){			
				
			$stmt= $obj->actualizar("mail", "accion = 2,fecha_delete=now()", 	"id = ".$idMail."");


		}if($accion=="salida"){			
				
			$stmt= $obj->actualizar("mail_sent", "accion = 2,fecha_delete=now()", 	"id = ".$idMail."");
		   
		}

		return $stmt;
					
	}


	static public function adjuntoTemp($nombre,$tipo,$size,$direccion){           
					
		$obj = new BaseDatosMail(); 		      
		$result=$obj -> insertar("fichero_adjuntos", "'".$_SESSION['id']."', '".$nombre."', '".$tipo."', '".$size."', '".$direccion."', 5 ,'".$_SESSION['id_new_mail']."'");		
		
		if($result){

		$_SESSION['archivo']='mostrar';
  		$_SESSION['accion_mail']='nuevo';
  		
		}

		return $result;

					
	}



	static public function crearBorrador(){
		$id_mail=uniqid() ;		        
		 
		$obj = new BaseDatosMail(); 		      
		$result=$obj -> insertarCamposEspecificos("mail_sent","id,id_usuario,estado,accion,id_mail", " '".$_SESSION['id']."','0', '6', '".$id_mail."'");		
		
		if($result){

		unset($_SESSION['id_new_mail']);
		$_SESSION['id_new_mail']=  $id_mail; 
  		
		}

		return $result;

					
	}




	static public function eliminarFicheroAdjunto($id){           
					
		$obj = new BaseDatosMail(); 
		
			$stmt= $obj->borrar("fichero_adjuntos", "id_mail = '".$_SESSION['id_new_mail']."' and id=".$id."");
			
		return $stmt;
					
	}




	




}