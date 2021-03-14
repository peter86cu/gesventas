<?php
include("../config/db.php");
include("../config/conexion.php");
$_ajax=true;
$forma_pago = explode('|', $_POST['forma_pago']);
$cantidad = explode('|',$_POST['cantidad']);
$str='';

if($_POST){
$formas_array=array();
$qf = mysqli_query($con,"select * from formas_cobros");
while($r = mysqli_fetch_array($qf)){
	$formas_array[$r['simbolo']]=$r['id_forma_cobro'];

}

//pg_query("begin");
for($i =0; $i<count($forma_pago);$i++){
	if($forma_pago[$i]!=''){
		//si es dolar
		$cotizacion='';$val_cotizacion='';$input_credito='';$val_input_credito='';
		if($formas_array[$forma_pago[$i]]=='7'){//dolar
			$cotizacion=',cotizacion';
			$val_cotizacion=",'".$_claves["dolar"]."'";
		}
		if($formas_array[$forma_pago[$i]]=='11'){//si es credito.
			$input_credito=",meses,tasa_interes";	
			$val_input_credito=",'".$_POST['meses']."','".$_POST["interes_venta"]."'";
		}
		mysqli_query($con,"insert into ventas_cobros (id_venta,id_forma_cobro,valor ".$cotizacion.$input_credito.")values('".$_POST["id_venta"]."','".$formas_array[$forma_pago[$i]]."','".$cantidad[$i]."' ".$val_cotizacion." ".$val_input_credito.")");
	}
}

error_log("que es esto ".$_POST["id_venta"]);
if(isset($_POST["cliente"]) && $_POST["cliente"]!=''){
	$cliente=	$_POST["cliente"];
}else{
	$cliente=0;	
}

$respuesta = array();

	if(@mysqli_query($con,"update ventas set monto_total='".$_POST['total']."',
	 estado=2,id_cliente='".$cliente."',
	 fecha_hora_cerrado=NOW(),iva5='".$_POST['iva5']."',iva10='".$_POST['iva10']."'  where id_venta = '".$_POST['id_venta']."'")){
		 $respuesta['exito']='si';
	}else{
		$respuesta['exito']='no';
		//$respuesta["error"]=pg_last_error();
	}
	
	echo json_encode($respuesta);
}
	 
?>