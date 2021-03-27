<?php

 $ventas = ControlVentas::validarNoExistenVentas();        
          
 if($ventas){ 
  echo "<script> alert('Hay ventas por despachar.') </script>"; 
    echo "<script> window.location='ventas'; </script>";
}else{
unset($_SESSION['loginCaja']);
$_SESSION['loginCaja']='no_login';
error_log("esta el estado ".$_SESSION['loginCaja']);
echo "<script> window.opener.location.reload(); window.close(); </script>";
//echo "<script> window.close()  </script>";


}



 
      		


