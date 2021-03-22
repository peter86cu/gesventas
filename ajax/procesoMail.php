<?php
 
 require_once  "../modelo/MdlMail.php";
 require_once  "../modelo/mcript.php";

if($_POST["accion"]=="parametros"){
@session_start();
unset($_SESSION['accion_mail']);
unset($_SESSION['id_mail']);
unset($_SESSION['sin_leer']);
unset($_SESSION['accion_mail']);
  $_SESSION['id_mail']  = $_POST["id_mail"];
  $_SESSION['sin_leer'] = $_POST["sin_leer"];
  $_SESSION['accion_mail'] = $_POST["accion_mail"];

echo json_encode(true);

}


if($_POST["accion"]=="marcarLectura"){

	 $encri = new encriptaDatos();

	$resultado = ModeloMail::marcarComoLeido($_POST["id_mail"],$encri->encriptar($_SESSION['id']));

echo json_encode($resultado);

}


if($_POST["accion"]=="delete"){

	 $data = json_decode($_POST['array'], true);
	$resultado = ModeloMail::moverEliminadosSeleccion($data,$_POST["accion_mail"]);

echo json_encode($resultado);

}


if($_POST["accion"]=="delete_lectura"){

	
	$resultado = ModeloMail::moverEliminadosLectura($_POST["id_mail"],$_POST["accion_mail"]);

echo json_encode($resultado);

}

