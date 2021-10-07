<?php
	
	# conectare la base de datos
    $con=@mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME_MAIL);
   if (mysqli_connect_errno()) {
    printf("Fall贸 la conexi贸n: %s\n", mysqli_connect_error());
    exit();
}



    $res_config = mysqli_query($con,"SELECT * FROM configuraciones");
while($row_config = mysqli_fetch_array($res_config)){
    
    $_claves[$row_config['clave']] =$row_config['valor'];
    
}

