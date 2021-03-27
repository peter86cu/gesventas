<?php
include("../config/db.php");
include("../config/conexion.php");

if($_POST["accion"]=="user"){
	$loguin=0;
	if($a=mysqli_query($con,"SELECT case when count(*) > 1 then 0 else 1 end cantidad  FROM `log_session` WHERE  accion in ('LOGIN','LOGOUT') group by id_session")){


		while($row=mysqli_fetch_array($a)){ 
			$loguin+= $row['cantidad'];  
		}
	}

	echo json_encode($loguin);
}