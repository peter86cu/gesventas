<?php
$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
$action2 = (isset($_REQUEST['action2'])&& $_REQUEST['action2'] !=NULL)?$_REQUEST['action2']:'';
if($action == 'ajax'){
	/* Connect To Database*/
	require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
	
	if (isset($_REQUEST['id'])){

		$id=intval($_REQUEST['id']);		
		$delete=mysqli_query($con,"delete from entradas_compras_detalle where id_entrada_compra_detalle='$id'");
	}
	error_log("accion 2".$action2,0 );
	$dis="enabled";	
 if($action2=="editar"){
 	$dis="disabled";	
}
 	
 


    if (isset($_REQUEST['idCompra'])){                          
    $idCompra = $_REQUEST['idCompra']; 
    }else{
    	 $idCompra = $_REQUEST['id'];
    }   
	$query=mysqli_query($con,"select o.id_entrada_compra_detalle as id_detalle, o.cantidad, o.importe, p.codigo,p.nombre
                             from entradas_compras_detalle o inner join productos p 
                             on (o.id_producto=p.id_producto) and o.id_entrada_compra=".$idCompra."  group by p.codigo");
	$items=1;
	$suma=0;
	while($row=mysqli_fetch_array($query)){
			$total=$row['cantidad']*$row['importe'];
			$total=number_format($total,2,'.','');
			
		?>
		
				
	<tr>
		<td class='text-center'><?php echo $items;?></td>
		<td class='text-center'><?php echo $row['cantidad'];?></td>
		<td class='text-center'><?php echo $row['codigo'];?></td>
		<td><?php echo $row['nombre'];?></td>
		<td class='text-right'><?php echo $row['importe'];?></td>
		<td class='text-right'><?php echo $total;?></td>
		<td class='text-right'><a href="#" onclick="eliminar_item('<?php echo $row['id_detalle']; ?>')" ><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAMAAAAoLQ9TAAAAeFBMVEUAAADnTDznTDznTDznTDznTDznTDznTDznTDznTDznTDznTDznTDznTDznTDznTDznTDznTDznTDznTDznTDznTDznTDznTDznTDznTDznTDznTDznTDznTDznTDznTDznTDznTDznTDznTDznTDznTDznTDznTDx+VWpeAAAAJ3RSTlMAAQIFCAkPERQYGi40TVRVVlhZaHR8g4WPl5qdtb7Hys7R19rr7e97kMnEAAAAaklEQVQYV7XOSQKCMBQE0UpQwfkrSJwCKmDf/4YuVOIF7F29VQOA897xs50k1aknmnmfPRfvWptdBjOz29Vs46B6aFx/cEBIEAEIamhWc3EcIRKXhQj/hX47nGvt7x8o07ETANP2210OvABwcxH233o1TgAAAABJRU5ErkJggg=="></a></td>
	</tr>	
		<?php
		$items++;
		$suma+=$total;
	}
	?>
	<tr>
		<td colspan='7'>
		
			<button id="itemsBtt" type="button" class="btn btn-info btn-sm" data-toggle="modal" style ="float: left;" data-target="#myModalCompra" <?php echo $dis ?> ><span class="glyphicon glyphicon-plus"></span> Agregar Ítem</button>
		</td>
	</tr>
	<tr>
		<td colspan='5' class='text-right'>
			<h4>TOTAL </h4>
		</td>
		<th class='text-right'>
			<h4><?php echo number_format($suma,2);?></h4>
		</th>
		<td></td>
	</tr>
<?php

}