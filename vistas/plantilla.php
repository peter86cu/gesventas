<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>GesVentas 1.0</title>
  <link rel="shortcut icon" href="favicon.png">
  


  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="vistas/recursos/plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="vistas/recursos/dist/css/adminlte.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="vistas/recursos/dist/css/style.css">
<!-- sweetalert2 -->
  <script src="vistas/recursos/plugins/sweetalert2/sweetalert2.all.js"></script>  
<link rel="stylesheet" href="vistas/recursos/plugins/sweetalert2/sweetalert2.min.css">

  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>

 <!-- Daterange picker -->
  <link rel="stylesheet" href="vistas/recursos/plugins/bootstrap-daterangepicker/daterangepicker.css">



  <!-- Daterange picker -->
  <link rel="stylesheet" href="vistas/bower_components/bootstrap-daterangepicker/daterangepicker.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="vistas/bower_components/font-awesome/css/font-awesome.min.css">


   <!-- SweetAlert 2 -->
  <script src="vistas/plugins/sweetalert2/sweetalert2.all.js"></script>
   <!-- By default SweetAlert2 doesn't support IE. To enable IE 11 support, include Promise polyfill:-->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script>

  <!-- iCheck 1.0.1 -->
  <script src="vistas/plugins/iCheck/icheck.min.js"></script>

  <!-- InputMask -->
  <script src="vistas/plugins/input-mask/jquery.inputmask.js"></script>
  <script src="vistas/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
  <script src="vistas/plugins/input-mask/jquery.inputmask.extensions.js"></script>

  <!-- jQuery Number -->
  <script src="vistas/plugins/jqueryNumber/jquerynumber.min.js"></script>

  <!-- daterangepicker http://www.daterangepicker.com/-->
  <script src="vistas/bower_components/moment/min/moment.min.js"></script>
  <script src="vistas/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>

  <!-- Morris.js charts http://morrisjs.github.io/morris.js/-->
  <script src="vistas/bower_components/raphael/raphael.min.js"></script>
  <script src="vistas/bower_components/morris.js/morris.min.js"></script>

  <!-- ChartJS http://www.chartjs.org/-->
  <script src="vistas/bower_components/Chart.js/Chart.js"></script>

 <!--  apertura -->
<script src="vistas/recursos/dist/js/apertura.js"></script>

</head>
<body class="hold-transition <?php if(isset($_SESSION["login"])): ?> skin-blue sidebar-mini<?php else:?>login-page<?php endif;?>">
<!-- Site wrapper -->


    <?php 
    
    #session_destroy();
  
if (isset($_SESSION['login']) && $_SESSION['login']=='activa') {
     
      if($_SESSION['login']=='activa' && $_GET["enlace"]=="ventas"){
        include "vistas/modulos/ventas.php";        
      }else{
    
    echo '<div class="wrapper">';
      //Cabecera
      include "vistas/modulos/plantillas/cabecera.php";

      //Menu

     include "vistas/modulos/plantillas/menu.php";

     //pagias
      if(isset($_GET["enlace"])){
      if( $_GET["enlace"]=="inicio" || $_GET["enlace"]=="productos" || $_GET["enlace"]=="facturas-compra" || $_GET["enlace"]=="ordenes-compra" || $_GET["enlace"]=="nueva-orden" || $_GET["enlace"]=="rol" || $_GET["enlace"]=="ventas" || $_GET["enlace"]=="usuarios" || $_GET["enlace"]=="caja" || $_GET["enlace"]=="mailbox" || $_GET["enlace"]=="read-mail" || $_GET["enlace"]=="logoutcaja" || $_GET["enlace"]=="proveedores" || $_GET["enlace"]=="mailsend" || $_GET["enlace"]=="maildelete"  || $_GET["enlace"]=="mailborrador" || $_GET["enlace"]=="redactar-mail" || $_GET["enlace"]=="reporte-stock" || $_GET["enlace"]=="logout" || $_GET["enlace"]=="clientes" || $_GET["enlace"]=="control-asistencia" || $_GET["enlace"]=="categorias" || $_GET["enlace"]=="billetes-monedas" || $_GET["enlace"]=="reporte-ventas" || $_GET["enlace"]=="perfil-empresa" || $_GET["enlace"]=="admin-ventas" || $_GET["enlace"]=="reportes"){

        include "vistas/modulos/".$_GET["enlace"].".php";
      }else{
        include "vistas/modulos/plantillas/404.php";

      }

     }else{
      
      include "vistas/modulos/inicio.php";

     }
      
      //pie
     include "vistas/modulos/plantillas/pie.php";

      echo '</div>'; }
      }else{
        include "vistas/modulos/login.php";

      }
     ?>
 

  

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->



<!--  varios -->


<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/js/select2.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/css/select2.min.css" rel="stylesheet" />
<script src="vistas/recursos/plugins/jquery-ui/jquery-ui.js"></script>

  

<!-- Bootstrap 4 -->
<script src="vistas/recursos/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="vistas/recursos/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="vistas/recursos/dist/js/demo.js"></script>

<!-- Funciones -->
<script src="vistas/recursos/dist/js/Funciones.js"></script>
<!--  Producto -->
<script src="vistas/recursos/dist/js/productos.js"></script>
<!--  roles -->
<script src="vistas/recursos/dist/js/roles.js"></script>
<!--  usuarios -->
<script src="vistas/recursos/dist/js/usuarios.js"></script>
<!--  ordenes de compras -->
<script src="vistas/recursos/dist/js/ordenes.js"></script>
<!--  facturas -->
<script src="vistas/recursos/dist/js/facturas.js"></script>
<!--  ventas -->
<script src="vistas/recursos/dist/js/ventas.js"></script>
<!--  proveedor -->
<script src="vistas/recursos/dist/js/proveedores.js"></script>
<!--  mail -->
<script src="vistas/recursos/dist/js/mail.js"></script>
<!--  reportes -->
<script src="vistas/recursos/dist/js/reportes.js"></script>
<!--  clientes -->
<script src="vistas/recursos/dist/js/clientes.js"></script>
<!--  categorias de productos -->
<script src="vistas/recursos/dist/js/categorias.js"></script>
<!--  billetes por monedas -->
<script src="vistas/recursos/dist/js/billetes.js"></script>


<!-- OPTIONAL SCRIPTS -->
<script src="vistas/recursos/plugins/chart.js/Chart.min.js"></script>
<!-- AdminLTE for demo purposes -->

<script src="vistas/recursos/dist/js/dashventas.js"></script>


</body>
</html>
