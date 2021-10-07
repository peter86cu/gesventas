<?php

require_once  "../controladores/CtrlReportes.php";
require_once  "../modelo/MdlReportes.php";
require_once  "../controladores/CtrlVentas.php";
require_once  "../modelo/MdlVentas.php";

if($_POST["accion"]=="parametro_reporte"){
  
   $_SESSION['id_reporte']  = $_POST["idReporte"];
  
  $resultado=ModeloReportes::buscasNombreeReporte($_POST["idReporte"]);
   $_SESSION['nombre_reporte'] = $resultado;
  
 echo json_encode(true);
}


if($_POST["accion"]=="reporte"){
 
   if($_POST["tipo"]==1){ 

          $date1 = new DateTime($_POST["fechaInicio"]);
          $date2 = new DateTime($_POST["fechaFin"]);
        

   $respuesta = ControlVentas::ctrRangoFechasVentas($date1->format('Y-m-d')." 00:00:00", $date2->format('Y-m-d')." 23:59:59");
 
   } if($_POST["tipo"]==4){ 
         

   $respuesta = ControlVentas::comparativoAnualdeVentas();
 
   }
  

  
 echo json_encode($respuesta);
}



if($_POST["accion"]=="reporte2"){

   $respuesta = ControlVentas::crecimientoMesActualAnterior();
   echo json_encode($respuesta);

}





