<?php


require_once  ("conexion.php");
@session_start();

class ModeloApertura{
	
	

	static public function insertarAperturaInicial( ){  
		
		$obj = new BaseDatos();      
		$result=$obj -> insertarInicial("aperturas_cajeros","id_apertura_cajero,fecha_inicio,id_usuario,id_sucursal,hora_inicio,nro_consecutivo,id_usuario_alta,id_tipo_arqueo" ,
			"select null, now(), '".$_SESSION['id']."', '".$_SESSION['sucursal']."',  curTime() , case when max(nro_consecutivo) is null then 1000 else max(nro_consecutivo)+1000 end as consecutivo , '".$_SESSION['id']."',1 from aperturas_cajeros");  
		return $result;

	}		

	static public function buscasApertura($parametro,$datos){

		if($parametro != null){

			$obj = new BaseDatos();  
			$stmt= $obj->buscarAjax("aperturas_cajeros","id_usuario='".$_SESSION['id']."' and id_sucursal='".$_SESSION['sucursal']."' and fecha_hora_cierre is null");

			
			return $stmt;

		}else{

			$obj = new BaseDatos();      
			$result=$obj -> buscarSQL($datos);  

			return $result;

		}
	}

	
	static public function updateApertura($idApertura,$idCaja,$idTurno){

		$obj = new BaseDatos();  
		$stmt= $obj->actualizar("aperturas_cajeros", "id_caja = ".$idCaja." , id_turno=".$idTurno." ", 	"id_apertura_cajero = ".$idApertura." and id_usuario='".$_SESSION['id']."' ");

		if($stmt){
			$result= $obj->buscarAjax("aperturas_cajeros","id_usuario='".$_SESSION['id']."' and id_apertura_cajero = ".$idApertura." and fecha_hora_cierre is null");
		}

		return $result;


	}

	static public function insertarArqueo($idApertura,$tipoArqueo, $data, $idCuadre ){  
		
		$apertura = new ModeloApertura();
		$obj = new BaseDatos();      
		$result=$obj -> insertar("arqueos", "".$idApertura.", now(), ".$_SESSION['id'].",".$_SESSION['sucursal'].",null,".$tipoArqueo.", ".$idCuadre." ");  
		
		if($result){
			$id_apertura= $apertura -> getArqueo($idApertura);
			foreach ($data as $values) { 
			error_log("el id de bille es ".$values['id']." y el valor es ".$values['value']) ; 				
   				$resultado=$obj -> insertar("arqueos_detalle", "".$values['id'].", ".$id_apertura.",".$values['value']."");     				
				}

			if($tipoArqueo==3){

					$obj->actualizar("aperturas_cajeros", "fecha_hora_cierre='now()', id_tipo_arqueo=3 ", 	"id_apertura_cajero = ".$idApertura." and id_usuario='".$_SESSION['id']."' ");
			}
		}
		if($result && $resultado)
		return true;
			else
		return false;

	}



	static public function buscarVentas($idApertura){  
		
		$montoInicial = new ModeloApertura();

		$obj = new BaseDatos();  
		
		$ventas = $montoInicial -> validarVentas($idApertura);
				
		$monto_total=0;
		$monto_ventas=0;
		$monto_inicial=0;
		if($ventas){
			$monto_inicial= $montoInicial-> obtenerMontoAperturaInicial($idApertura);
			$q = $obj->buscarSQL("select sum(v.monto_total) monto_total from ventas v, ventas_cobros vc where v.id_venta= vc.id_venta and v.estado=2 and vc.id_forma_cobro= 1 and v.id_apertura_cajero='".$idApertura."'");
			foreach($q as $row) { 
			$monto_ventas= $row['monto_total'];	
		      }

		$monto_total=$monto_inicial+$monto_ventas;

		}
		error_log($monto_total);
		return $monto_total;
		

	}


static public function getArqueo($idApertura){
		$obj = new BaseDatos();  
		$q = $obj->buscarSQL("select id_arqueo from arqueos where id_apertura_cajero=".$idApertura." and id_usuario=".$_SESSION['id']." ");

		foreach($q as $row) { 
			$id_arqueo= $row['id_arqueo'];			
		}

		return $id_arqueo;


	}



	static public function obtenerMontoAperturaInicial($idApertura){
		$obj = new BaseDatos();  
		$q = $obj->buscarSQL("select sum(ad.valor*b.monto) saldo_apertura_inicial from arqueos ar , arqueos_detalle ad , billetes b, aperturas_cajeros ac where ac.id_apertura_cajero=ar.id_apertura_cajero and ar.id_arqueo=ad.id_arqueo and ad.id_billete=b.id_billete
	and ar.id_estado_arqueo=1 and ac.id_usuario='".$_SESSION['id']."' and ac.id_apertura_cajero=".$idApertura." and ac.fecha_hora_cierre is null");

		foreach($q as $row) { 
			$monto_inicial= $row['saldo_apertura_inicial'];
			
		}

		return $monto_inicial;


	}
	
static public function validarVentas($idApertura){
		$obj = new BaseDatos();  
		$ventas = $obj->buscarSQL("select v.id_venta from ventas v, aperturas_cajeros ac where v.id_apertura_cajero=ac.id_apertura_cajero and  ac.fecha_hora_cierre is null and v.estado=2 and v.id_apertura_cajero='".$idApertura."' ");

				
				$id=0;
			foreach($ventas as $row) { 
			$id= $row['id_venta'];			
		}
			if($id>0)
				return true;
			else
				return false;


	}


}