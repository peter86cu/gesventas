<?php
include("../config/db.php");		
 $con=@mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
$search = strip_tags(trim($_GET['q'])); 
// Do Prepared Query
$query = mysqli_query($con, "SELECT * FROM proveedores WHERE razon_social LIKE '%$search%' and fecha_baja is null LIMIT 40");
// Do a quick fetchall on the results
$list = array();
$data = array();
while ($list=mysqli_fetch_array($query)){
	$data[] = array('id' => $list['id_proveedor'], 'text' => $list['razon_social'],'email' => $list['email'],'telefono' => $list['telefono'],'direccion' => $list['direccion']);
}
// return the result in json
echo json_encode($data);
?>