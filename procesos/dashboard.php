<?php
include("../config/db.php");
include("../config/conexion.php");
@session_start();

if($_POST["accion"]=="user"){
	$loguin=0;
	if($a=mysqli_query($con,"SELECT case when count(*) > 1 then 0 else 1 end cantidad  FROM `log_session` WHERE  accion in ('LOGIN','LOGOUT') group by id_session")){


		while($row=mysqli_fetch_array($a)){ 
			$loguin+= $row['cantidad'];  
		}
	}

	echo json_encode($loguin);
}


if($_POST["accion"]=="session"){
	$cantidad=0;
	//error_log("select  count(*) cant from log_session ls inner join estado_session es on(es.id_session=ls.id_session) where ls.id_usuario ='".$_POST["idUsuario"]."' and ls.ip='".$_SESSION['ip']."' and es.estado=0");
	$result=mysqli_query($con,"select  count(*) cant from log_session ls,estado_session es where ls.id_usuario ='".$_POST["idUsuario"]."' and ls.ip='".$_SESSION['ip']."' and es.estado=1");


		while($row=mysqli_fetch_array($result)){ 
			$cantidad= $row['cant'];  
		}

		
	
	
	echo json_encode($cantidad);

}