<?php


require_once("conexion.php");
 include "../vistas/recursos/mcript.php";
@session_start();

class ModeloVentas{
	
	

	static public function insertarVenta($idApertura ){  
		
		$obj = new BaseDatos(); 
		$conse = new ModeloVentas();
		$consecutivo= $conse->getConsecutivoCajero(); 
		$result=$obj -> insertarCamposEspecificos("ventas","id_venta,estado,id_usuario,id_sucursal,nro_consecutivo,id_apertura_cajero,id_cliente","1,'".$_SESSION['id']."','".$_SESSION['sucursal']."',".$consecutivo.",'".$idApertura."',1");  
		
		return $result;

	}	


	static public function insertarVentaDetalle($idVenta,$cantidad,$idProducto){
	
	$obj = new BaseDatos();  
	$result=$obj -> insertarCamposEspecificos("ventas_detalle","id_venta_detalle,id_venta,cantidad,id_producto"," '".$idVenta."','".$cantidad."',".$idProducto."");  
		
		/*if($result){
				$stmt= $obj->actualizar("productos", "disponible=0 ,  fecha_actualizado =now() ", "id_producto = ".$idProducto."");
		}*/
		return $result;


	}	

	static public function getConsecutivoCajero(){
		$obj = new BaseDatos();  
		$q = $obj->buscarSQL("select case when estado=1 then v.nro_consecutivo else max(v.nro_consecutivo)+1 end consecutivo from ventas v where v.id_usuario='".$_SESSION['id']."' ");
		$consecutivo=0;
		foreach($q as $row) { 
			$consecutivo= $row['consecutivo'];
		}

		if($consecutivo==0){
			$q1 = $obj->buscarSQL("select nro_consecutivo+1 consecutivo from aperturas_cajeros ac  where ac.id_usuario='".$_SESSION['id']."' and ac.fecha_hora_cierre is null  ");
			foreach($q1 as $row) { 
			$consecutivo= $row['consecutivo'];
		}
		}

		return $consecutivo;


	}	


	static public function buscarStockDisponible($idProducto){
	
	$obj = new BaseDatos();  
	$q = $obj->buscarSQL("select cantidad from stock where id_producto='".$idProducto."' and id_sucursal='".$_SESSION["sucursal"]."'");
		$cantidad=0;
		foreach($q as $row) { 
			$cantidad= $row['cantidad'];
		}

		return $cantidad;


	}	

	static public function buscasAperturaCajeroVentas($parametro,$datos){

		if($parametro != null){

			$obj = new BaseDatos();  
			$stmt= $obj->buscarAjaxSQL("select ac.id_apertura_cajero, case when estado=1 then v.nro_consecutivo else v.nro_consecutivo+1 end consecutivo, v.id_venta from ventas v, aperturas_cajeros ac where ac.id_apertura_cajero=v.id_apertura_cajero 
				and v.id_usuario='".$_SESSION['id']."' and v.fecha_hora_cerrado is null ");
			
			return $stmt;

		}else{

			$obj = new BaseDatos();      
			$result=$obj -> buscarSQL($datos);  

			return $result;

		}
	}


		static public function validarLoginCaja($usuario,$pass){           
					$descr = new encriptaDatos();
				    $obj = new BaseDatos();  
					$stmt= $obj->buscarSQL("select * from usuarios_caja where usuario ='".$usuario."'");
					
					$login=false;
	 				if ($stmt) {

	 						 foreach($stmt as $row) {
						      $password= $row['password'];						      					      
							 $pass_descriptado = $descr->desencriptar($password);												 
					         if($pass_descriptado==$pass){					         				         	
					         	if($_SESSION['loginCaja']='no_login'){			         						         		
					         		$_SESSION['loginCaja']='conectado';
					         		$_SESSION['usu_caja']=$row['usuario'];	
					         		$_SESSION['id_usuario_caja']=$row['id_usu_caja'];
					         		$login=true;					         	
					         }
					     }
					 }
					 }                                 
					
					return $login;
					
	}


	static public function buscasAperturaCajero(){

			$obj = new BaseDatos();  
			$stmt= $obj->buscarAjaxSQL("select ac.id_apertura_cajero from  aperturas_cajeros ac where  ac.id_usuario='".$_SESSION['id']."' and ac.fecha_hora_cierre is null ");
			
			return $stmt;

		
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
		
		return $monto_total;
		

	}

static public function buscarVentasInterzas($query){
		$obj = new BaseDatos();  
		$q = $obj->buscarSQL($query);

		return $q;


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


	static public function validarVentasSalir(){
		$obj = new BaseDatos();  
		$ventas = $obj->buscarSQL("select v.id_venta from ventas_detalle vd,ventas v, aperturas_cajeros ac where vd.id_venta=v.id_venta and v.id_apertura_cajero=ac.id_apertura_cajero and ac.fecha_hora_cierre is null and v.estado=1 and  v.id_usuario=".$_SESSION['id']." ");
	
			foreach($ventas as $row) { 
			$id= $row['id_venta'];			
		}
			if($id>0)
				return true;
			else
				return false;


	}

	static public function buscarVentasTiempoReal($idVenta){
				
			$obj = new BaseDatos();  
			$stmt= $obj->buscarSQL("select p.id_impuesto,p.id_producto, p.codigo, sum(d.cantidad) as cantidad,precio_venta(p.id_producto) precio, p.nombre, (select m.simbolo from monedas m where m.id_moneda=p.id_moneda ) moneda,d.id_venta_detalle
			  from ventas_detalle d, ventas v, productos p where v.id_venta='".$idVenta."' and v.id_venta=d.id_venta and d.id_producto =p.id_producto and cantidad <>0 group by p.id_producto ");
			/*select p.id_impuesto,p.id_producto, p.codigo, sum(d.cantidad) as cantidad,precio_venta(p.id_producto) precio, p.nombre
			  from ventas_detalle d, ventas v, productos p where v.id_venta='".$id."' and v.id_venta=d.id_venta and d.id_producto =p.id_producto and cantidad <>0 group by p.id_producto */
			return $stmt;

		}


		static public function eliminarVentasTiempoReal($idVenta,$idVentaDetalle,$idProducto){
				
			$obj = new BaseDatos();  
			$ventas= $obj->buscarSQL("select max(vd.id_venta_detalle) as id from ventas v, ventas_detalle vd where v.id_venta=vd.id_venta and estado= 1 and v.id_usuario='".$_SESSION['id']."' and vd.id_venta= '".$idVenta."' and vd.id_venta_detalle= '".$idVentaDetalle."' and vd.id_producto= '".$idProducto."' ");

			$id=0;
			foreach($ventas as $row) { 
			$id= $row['id'];						
			}
			$delete=false;
			if($id>0){
				$delete= $obj->borrar("ventas_detalle","id_venta_detalle= ".$id."");
			}
			
			return $delete;

		}


		static public function cancelarVenta($idVenta){
				
			$obj = new BaseDatos();  
			$ventas= $obj->actualizar("ventas","estado=3,fecha_hora_cerrado=now(),fecha_baja=now()", "id_venta=".$idVenta."");

			return $ventas;

		}


		static public function eliminarVentaSalir($idVenta){
				
			$obj = new BaseDatos(); 
			$ventas= $obj->buscarSQL("select v.id_venta from ventas_detalle vd,ventas v, aperturas_cajeros ac where vd.id_venta=v.id_venta and v.id_apertura_cajero=ac.id_apertura_cajero and ac.fecha_hora_cierre is null and v.estado=1 and v.id_usuario=".$_SESSION['id']." and v.id_venta=".$idVenta." ");

			$id=0;
			foreach($ventas as $row) { 
			$id= $row['id_venta'];						
			}
			$delete=false;
			if($id>0 && $id!=null){
				$delete= $obj->borrar("ventas","id_venta= ".$id."");
			}
			
			return $delete;

		}
	


}