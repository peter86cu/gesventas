 <!-- Main Sidebar Container -->
 <aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="#" class="brand-link">
    <img src="vistas/recursos/dist/img/GesventasLogo.png" alt="GesVentas Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">GesVentas</span>
  </a>

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


    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
           with font-awesome or any other icon font library -->
           <?php if($_SESSION['rol']==1) { ?>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="fas fa-cogs" style="color:#218838" ></i>
                <p>
                  PARAMETROS
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="proveedores" class="nav-link">
                    <i class="fas fa-user-tie" style="color:#0069d9"></i>
                    <p>Proveedores</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="#" class="nav-link">
                   <i class="fas fa-user-tie" style="color:#0069d9"></i>
                   <p>Clientes</p>
                 </a>
               </li>
               <li class="nav-item">
                <a href="productos" class="nav-link">
                 <i class="fas fa-cart-arrow-down" style="color:#0069d9"></i>
                 <p>Productos</p>
               </a>
             </li>
             <li class="nav-item">
              <a href="rol" class="nav-link">
                <i class="fas fa-user-lock" style="color:#0069d9"></i>
                <p>Roles</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="usuarios" class="nav-link">
                <i class="fas fa-users-cog" style="color:#0069d9" ></i>
                <p>Usuarios</p>
              </a>
            </li>
          </ul>
        </li>

        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="fab fa-shopify" style="color:#218838"></i>
            <p>
              COMPRAS
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="facturas-compra" class="nav-link">
                <i class="fas fa-file-invoice-dollar" style="color:#0069d9"></i>
                <p>Facturas de compras</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="ordenes-compra" class="nav-link">
                <i class="fas fa-shipping-fast" style="color:#0069d9"></i>
                <p>Ordenes de compras</p>
              </a>
            </li>
          </ul>
        </li>
      <?php } ?>
      <?php if( $_SESSION['rol']==2 || $_SESSION['rol']==3 || $_SESSION['rol']==1) { ?>
       <li class="nav-item">
        <a href="#" class="nav-link">
          <i class="fab fa-shopify" style="color:#218838"></i>
          <p>
            POS
            <i class="fas fa-angle-left right"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a  href="caja"  class="nav-link">
              <i class="fas fa-hand-holding-usd" style="color:#0069d9"></i></i>
              <p>Caja</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="javascript:abirirVentas()" class="nav-link" >
              <i class="fas fa-shipping-fast" style="color:#0069d9"></i>
              <p>POS Ventas</p>
            </a>
          </li>

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
          <a href="javascript:filtro_reporte()" class="nav-link">
            <i class="fas fa-file-invoice-dollar" style="color:#0069d9"></i>
            <p>Stock</p>
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

  </ul>
</nav>
<!-- /.sidebar-menu -->
</div>
<!-- /.sidebar -->
</aside>
