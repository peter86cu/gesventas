<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Blank Page</title>

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


</head>
<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->


    <?php 
    @session_start();

    #session_destroy();
if (isset($_SESSION['login']) && $_SESSION['login']=='activa') {
     
      if($_GET["enlace"]=="ventas"){
        include "vistas/modulos/ventas.php";
      }else{
    
    echo '<div class="wrapper">';
      //Cabecera
      include "vistas/modulos/plantillas/cabecera.php";

      //Menu

     include "vistas/modulos/plantillas/menu.php";

     //pagias
      if(isset($_GET["enlace"])){
      if( $_GET["enlace"]=="inicio" || $_GET["enlace"]=="productos" || $_GET["enlace"]=="facturas-compra" || $_GET["enlace"]=="ordenes-compra" || $_GET["enlace"]=="nueva-orden" || $_GET["enlace"]=="rol" || $_GET["enlace"]=="ventas" || $_GET["enlace"]=="usuarios" || $_GET["enlace"]=="caja" || $_GET["enlace"]=="proveedores" || $_GET["enlace"]=="logout" ){

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



<!-- jQuery -->
<script src="vistas/recursos/plugins/jquery/jquery.min.js"></script>
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
 <!--  apertura -->
<script src="vistas/recursos/dist/js/apertura.js"></script>
<!--  ventas -->
<script src="vistas/recursos/dist/js/ventas.js"></script>
<!--  proveedor -->
<script src="vistas/recursos/dist/js/proveedores.js"></script>
<!--  varios -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/js/select2.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/css/select2.min.css" rel="stylesheet" />
<script src="vistas/recursos/plugins/jquery-ui/jquery-ui.js"></script>


</body>
</html>
