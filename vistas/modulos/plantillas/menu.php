 <!-- Main Sidebar Container -->
 <aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="#" class="brand-link">
    <img src="vistas/recursos/dist/img/GesventasLogo.png" alt="GesVentas Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">GesVentas</span>
  </a>

<script type="text/javascript">
  
  //setInterval("comprobar_session()", 10);

  

</script>
  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user (optional) -->
    <div class="user-panel mt-4 pb-6 mb-3 d-flex">
      <div class="image">

      </div>
      <?php
      $db = new BaseDatos();
      $rol="";
      if($resultado=$db->buscar("rol","id_rol=".$_SESSION['rol']."")){
        foreach($resultado as $row) {
          $rol=$row['rol'];
        }
      }

      ?>
      <div class="info">
        <h4 style="color:#FFFFFF;"><strong>Bienvenido</strong></h4>
        <span style="color:#FFFFFF;"><?php echo $_SESSION['user'] ?></span >
        <p><span style="color:#FFFFFF;"><?php echo  $rol ?></span ></p>
        <div> <a href="logout" class="d-block"> <strong>Cerrar Sessión</strong>  </a></div>
      </div>

    <input type="hidden"  id="id_usuario_session" name="id_usuario_session"  value="<?php echo $_SESSION['id'] ?>" > 
     <input type="hidden"  id="ips_session" name="ips_session"  value="<?php echo $_SESSION['ip'] ?>" > 
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
           with font-awesome or any other icon font library -->
                

               <?php
      $db = new BaseDatos();
      $rol="";
      $modulos = array();
      $resultado=$db->buscarSQL("select DISTINCT r.id_rol,r.id_modulo,m.nombre FROM  roles_modulos_niveles r inner join roles_modulos rm on (rm.id_modulo=r.id_modulo) inner join modulos m on (r.id_modulo=m.id_modulo) where estado =1 and r.id_rol=".$_SESSION['rol']."");
        foreach($resultado as $row) { 
        $modulos[] = $row['id_modulo']; 
      }
      
       if(in_array(2, $modulos) || in_array(3, $modulos) || in_array(4, $modulos)) { ?>
            <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="fab fa-shopify" style="color:#218838"></i>
            <p>
              CONFIGURACIONES
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>   
          
          <ul class="nav nav-treeview">
           <?php if(in_array(2, $modulos)) { ?>
            <li class="nav-item">
              <a href="rol" class="nav-link">
                <i class="fas fa-user-lock" style="color:#0069d9"></i>
                <p>Roles</p>
              </a>
            </li> <?php } if(in_array(3, $modulos)) {?>
            <li class="nav-item">
              <a href="categorias" class="nav-link">
                <i class="fas fa-user-lock" style="color:#0069d9"></i>
                <p>Categorias de productos</p>
              </a>
            </li> <?php } if(in_array(4, $modulos)) {?>
             <li class="nav-item">
              <a href="usuarios" class="nav-link">
                <i class="fas fa-users-cog" style="color:#0069d9" ></i>
                <p>Usuarios</p>
              </a>
            </li> <?php } ?>
          </ul>          
        </li>
<?php  }

if(in_array(5, $modulos) || in_array(6, $modulos) || in_array(7, $modulos) || in_array(8, $modulos)){ ?>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="fas fa-cogs" style="color:#218838" ></i>
                <p>
                  PARAMETROS
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                 <?php if(in_array(5, $modulos)) { ?>
                <li class="nav-item">
                  <a href="proveedores" class="nav-link">
                    <i class="fas fa-user-tie" style="color:#0069d9"></i>
                    <p>Proveedores</p>
                  </a>
                </li>  <?php } if(in_array(6, $modulos)) {?>
                <li class="nav-item">
                  <a href="clientes" class="nav-link">
                   <i class="fas fa-user-tie" style="color:#0069d9"></i>
                   <p>Clientes</p>
                 </a>
               </li>  <?php } if(in_array(7, $modulos)) {?>
               <li class="nav-item">
                <a href="productos" class="nav-link">
                 <i class="fas fa-cart-arrow-down" style="color:#0069d9"></i>
                 <p>Productos</p>
               </a>
             </li>  <?php } if(in_array(8, $modulos)) {?>           
             <li class="nav-item">
              <a href="billetes-monedas" class="nav-link">
                <i class="fas fa-user-lock" style="color:#0069d9"></i>
                <p>Billetes por monedas</p>
              </a>
            </li>  <?php } ?>          
          </ul>
        </li>
<?php } 

if(in_array(9, $modulos) || in_array(10, $modulos)){ ?>
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="fab fa-shopify" style="color:#218838"></i>
            <p>
              COMPRAS
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <?php if(in_array(9, $modulos)) { ?>
            <li class="nav-item">
              <a href="facturas-compra" class="nav-link">
                <i class="fas fa-file-invoice-dollar" style="color:#0069d9"></i>
                <p>Facturas de compras</p>
              </a>
            </li> <?php } if(in_array(10, $modulos)) {?>
            <li class="nav-item">
              <a href="ordenes-compra" class="nav-link">
                <i class="fas fa-shipping-fast" style="color:#0069d9"></i>
                <p>Ordenes de compras</p>
              </a>
            </li> <?php } ?>
          </ul>
        </li>  
      <?php } 
      if(in_array(11, $modulos) || in_array(12, $modulos) || in_array(13, $modulos)){ ?>
       <li class="nav-item">
        <a href="#" class="nav-link">
          <i class="fab fa-shopify" style="color:#218838"></i>
          <p>
            POS
            <i class="fas fa-angle-left right"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
           <?php if(in_array(11, $modulos)) { ?>
          <li class="nav-item">
            <a  href="caja"  class="nav-link">
              <i class="fas fa-hand-holding-usd" style="color:#0069d9"></i></i>
              <p>Caja</p>
            </a>
          </li><?php } if(in_array(12, $modulos)) {?>
          <li class="nav-item">
            <a href="javascript:abirirVentas()" class="nav-link" >
              <i class="fas fa-shipping-fast" style="color:#0069d9"></i>
              <p>POS Ventas</p>
            </a>
          </li>   <?php } if(in_array(13, $modulos)) {?>
          <li class="nav-item">
            <a href="admin-ventas" class="nav-link" >
              <i class="fas fa-shipping-fast" style="color:#0069d9"></i>
              <p>Gestionar ventas</p>
            </a>
          </li> <?php } ?>


        </ul>
      </li>
      <?php } ?> 
    

    <li class="nav-item">
      <a href="#" class="nav-link">
        <i class="fab fa-shopify" style="color:#218838"></i>
        <p>
          REPORTES
          <i class="fas fa-angle-left right"></i>
        </p>
      </a>
      <ul class="nav nav-treeview">
        <li class="nav-item">
          <a href="reportes" class="nav-link">
            <i class="fas fa-file-invoice-dollar" style="color:#0069d9"></i>
            <p>Reportes</p>
          </a>
        </li>

      </ul>
       <ul class="nav nav-treeview">
        <li class="nav-item">
          <a href="reporte-ventas" class="nav-link">
            <i class="fas fa-file-invoice-dollar" style="color:#0069d9"></i>
            <p>Reporte de Ventas</p>
          </a>
        </li>

      </ul>
    </li>

    <li class="nav-item">
      <a href="#" class="nav-link">
        <i class="fab fa-shopify" style="color:#218838"></i>
        <p>
          MAILBOX
          <i class="fas fa-angle-left right"></i>
        </p>
      </a>
      <ul class="nav nav-treeview">
        <li class="nav-item">
          <a href="mailbox" class="nav-link">
            <i class="fas fa-file-invoice-dollar" style="color:#0069d9"></i>
            <p>Correo</p>
          </a>
        </li>

      </ul>
    </li>

<?php if($_SESSION['rol']==1 || $_SESSION['rol']==6) { ?>
     <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="fas fa-users" style="color:#218838"></i>
            <p>
              GESTION HUMANA
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>

          <?php if($_SESSION['rol']==6 || $_SESSION['rol']==1 ) { ?>

            <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="fas fa-cogs" style="color:#490318"></i>
                <p>PARAMETROS</p>
              </a>
               <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="fas fa-user-cog" style="color:#0069d9"></i>
                <p>Empleados</p>
              </a> 

            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="fas fa-briefcase" style="color:#0069d9"></i>
                <p>Departamentos</p>
              </a>
            </li>
          </ul>
            </li>            
          </ul>

          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="fas fa-fingerprint" style="color:#490318"></i>
                <p>ASISTENCIA</p>
              </a>
               <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="control-asistencia" class="nav-link">
                <i class="fas fa-barcode" style="color:#0069d9"></i>
                <p>Control de asistencia</p>
              </a> 

            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="fas fa-book-open" style="color:#0069d9"></i>
                <p>Reportes</p>
              </a>
            </li>
          </ul>
            </li>            
          </ul>
          <?php } ?>        

        </li>


 <?php } ?>
  </ul>
</nav>
<!-- /.sidebar-menu -->
</div>
<!-- /.sidebar -->
</aside>
