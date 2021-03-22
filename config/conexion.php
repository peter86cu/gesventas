<?php
	
	# conectare la base de datos
    $con=@mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if(!$con){
        die("imposible conectarse: ".mysqli_error($con));
    }
    if (@mysqli_connect_errno()) {
        die("Conexión falló: ".mysqli_connect_errno()." : ". mysqli_connect_error());
    }



    $res_config = mysqli_query($con,"SELECT * FROM configuraciones");
while($row_config = mysqli_fetch_array($res_config)){
	
	$_claves[$row_config['clave']] =$row_config['valor'];
	
	//$_claves_imagen[$row_config['clave']]=$row_config['imagen'];
}

