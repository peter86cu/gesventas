<?php
include("../config/db.php");
require_once  ("../modelo/conexion.php");

 $con=@mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
$search = strip_tags(trim($_GET['q'])); 
// Do Prepared Query
$query = mysqli_query($con, "SELECT * FROM productos WHERE codigo LIKE '%$search%' or nombre LIKE '%$search%'  LIMIT 40");
// Do a quick fetchall on the results
$list = array();
$data = array();

$sql = new BaseDatos();


while ($list=mysqli_fetch_array($query)){
	$result = $sql-> buscarSQL("select  get_precio('".$list['id_producto']."') as precio");
	foreach ($result as $key => $value) {
			if($value['precio']==null){
				$precio=0;
			}else{
				$precio=$value['precio'];
			}

		$data[] = array('id' => $list['id_producto'], 'text' => $list['codigo'],'nombre' => $list['nombre'],'precio' => $precio);
}
	
}
// return the result in json
echo json_encode($data);
?>