<?php

require_once  "../controladores/CtrlReportes.php";
require_once  "../modelo/MdlReportes.php";

if($_POST["accion"]=="parametro_reporte"){
  
   $_SESSION['id_reporte']  = $_POST["idReporte"];
  
  $resultado=ModeloReportes::buscasNombreeReporte($_POST["idReporte"]);
   $_SESSION['nombre_reporte'] = $resultado;
   error_log("nombre ".$resultado);
 echo json_encode(true);
}




