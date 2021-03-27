<?php

include "config/db.php";
include "config/conexion.php";
          $db = new BaseDatos();
          
          if( $result=$db -> insertar("log_session","'".$_SESSION['id_session']."','".$_SESSION['id']."',now(), 'LOGOUT'")){
          	session_destroy();
          	echo "<script> window.location='inicio'; </script>";
          }



