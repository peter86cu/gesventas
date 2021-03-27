<?php

require_once  "../modelo/MdlMail.php";
require_once  "../modelo/mcript.php";

if($_POST["idReporte"]==1){
  
 $sql="select s.id_sucursal,p.id_producto,p.codigo,p.nombre,s.costo_contable,s.cantidad from stock s, productos p where p.id_producto=s.id_producto and p.inventariable=true" ;
  $resultado = ModeloMail::ModeloReportes("Reporte",$sql);  
 

 echo json_encode($resultado);
}


if($_POST["accion"]=="marcarLectura"){

  $encri = new encriptaDatos();

  $resultado = ModeloMail::marcarComoLeido($_POST["id_mail"],$encri->encriptar($_SESSION['id']),$_POST["accion_mail"]);

  

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

if($_POST["accion"]=="actualizar_borrador"){

  
  $resultado = ModeloMail::actualizarBorrador($_POST["id_mail"],$_POST["para"],$_POST["asunto"],$_POST["body"]);

  echo json_encode($resultado);

}



if($_POST["accion"]=="validar_fichero"){


  $nombre_archivo = $_FILES['adjunto']['name'];


  if($nombre_archivo!=''){
   $tipo_archivo = $_FILES['adjunto']['type'];
   $tamano_archivo = $_FILES['adjunto']['size'];
   $esten= explode("/", $tipo_archivo);
   $destino = '../vistas/recursos/dist/adjuntoMail/';
  //$nombre = 'mail_'.md5(date('d-m-Y H:m:s'));  
   $url_tem = $_FILES['adjunto']['tmp_name']; 
   $src= $destino;
   move_uploaded_file($url_tem, $src.$nombre_archivo); 
   $esten = new SplFileInfo($nombre_archivo);
   
   $resultado = ModeloMail::adjuntoTemp($nombre_archivo,$esten->getExtension(),$tamano_archivo,$src);



 }
 echo json_encode($resultado);


}

if($_POST["accion"]=="borrador" ){
  unset($_SESSION['accion_mail']);
  unset($_SESSION['archivo']);
  $_SESSION['accion_mail']="nuevo";
  $_SESSION['archivo']="no_mostrar";
  $resultado = ModeloMail::crearBorrador();
  echo json_encode($resultado);
}

if($_POST["accion"]=="eliminar_adjunto"){
  unset($_SESSION['accion_mail']);
  unset($_SESSION['archivo']);
  
  $resultado = ModeloMail::eliminarFicheroAdjunto($_POST["id_fichero"]);
  $_SESSION['accion_mail']="nuevo";
  $_SESSION['archivo']="mostrar";
  if($resultado){    
    unlink($_POST["fichero_adjunto"]);
  }
  echo json_encode($resultado);
}








