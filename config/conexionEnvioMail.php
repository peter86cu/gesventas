<?php
	
	# conectare la base de datos
    $conexion=@mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME_MAIL);
    if(!$conexion){
        die("imposible conectarse: ".mysqli_error($conexion));
    }
    if (@mysqli_connect_errno()) {
        die("Conexión falló: ".mysqli_connect_errno()." : ". mysqli_connect_error());
    }

