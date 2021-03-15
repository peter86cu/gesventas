<?php


require_once  ("conexion.php");
@session_start();

class ModeloFacturasCompras{



	static public function insertarFacturaInicial(){


			$facturas = new ModeloFacturasCompras();

		$obj = new BaseDatos();
		$result=$obj -> insertarCamposEspecificos("entradas_compras","id_entrada_compra,estado,id_usuario,fecha_hora,id_sucursal,id_usuario_recibio,id_moneda,id_cotizacion_moneda", " 1,".$_SESSION['id'].", now(), ".$_SESSION["sucursal"].",'".$_SESSION['id']."', 1, ".$facturas->getCotizacion()."");


		$idOrden = $obj ->buscarSQL("select max(id_entrada_compra) as maximo from entradas_compras  where id_usuario =".$_SESSION['id']." ");

		foreach($idOrden as $row) {
			$id= $row['maximo'];
		}

		return $id;

	}



static public function buscarOrdenCompra($idOrden){


		$obj = new BaseDatos();
		$idOrden = $obj ->buscarSQL("select id_orden_compra as orden from ordenes_de_compras  where  estado = 3 and id_orden_compra =".$idOrden." ");
		$id=null;
		foreach($idOrden as $row) {
				$id= $row['orden'];
		}

		return $id;

	}




	static public function insertarDetalleCompra($idCompra, $idProducto,$cantidad, $importe ){


		$obj = new BaseDatos();
		$result=$obj -> insertar("entradas_compras_detalle", "".$idProducto.", ".$cantidad.", ".$idCompra.",".$importe.",get_moneda()");
		return $result;

	}


	static public function mostrarFacturas($parametro, $datos){


		if($parametro != null){
			error_log("llegue al modelo ".$datos,0);
			$obj = new BaseDatos();
			$stmt= $obj->buscarAjax("entradas_compras","id_entrada_compra ='".$datos."'");

			return $stmt;

		}else{

			$obj = new BaseDatos();
			$result=$obj -> buscarSQL($datos);

			return $result;

		}


	}


	static public function mostrarDatosProveedor( $datos){



		$obj = new BaseDatos();
		$stmt= $obj->buscarAjax("proveedores","id_proveedor ='".$datos."'");

		return $stmt;


	}


	static public function cantidadRegistros( $datos){

		$obj = new BaseDatos();
		$result=$obj -> buscarSQL($datos);

		return $result;


	}

	static public function getCotizacion(){
		$obj = new BaseDatos();
		$q = $obj->buscarSQL("select * from cotizaciones_monedas order by serie desc limit 1");

		foreach($q as $row) {
			$serie= $row['serie'];
		}

		return $serie;


	}


	static public function updateCompras($idCompra,$idOrden,$plazo, $fecha ,$formaPago, $estado,$factura,$receptor,$moneda,$deposito){

		$obj = new BaseDatos();
		$stmt= $obj->actualizar("entradas_compras",

			"estado='".$estado."',fecha_hora='".$fecha."',id_sucursal='".$_SESSION["sucursal"]."',id_deposito='".$deposito."',id_usuario_recibio='".$receptor."',id_forma_pago='".$formaPago."',id_plazo='".$plazo."',id_orden_compra='".$idOrden."', nro_factura='".$factura."',id_moneda='".$moneda."'",
			"id_entrada_compra ='".$idCompra."' and id_usuario='".$_SESSION["id"]."'");

		//Pendiente
		if($stmt){
			if($estado==3){
				$stmt2= $obj->actualizar("ordenes_de_compras",	"estado=4" ,"id_orden_compra='".$idOrden."'");
			}

			return $stmt;
		}




	}




	static public function updateProveedorCompras($idCompra,$idProveedor){

		$obj = new BaseDatos();
		$stmt= $obj->actualizar("entradas_compras", "id_proveedor='".$idProveedor."'", "id_entrada_compra='".$idCompra."'");

		return $stmt;


	}



	static public function eliminarCompra($idCompra){

		$obj = new BaseDatos();
		$stmt= $obj->actualizar("entradas_compras", " fecha_baja =now() ", "id_entrada_compra = ".$idCompra."");

		return $stmt;


	}









}
