 <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="vistas/recursos/index3.html" class="brand-link">
      <img src="vistas/recursos/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-4 pb-6 mb-3 d-flex">
        <div class="image">
          <img src="vistas/recursos/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <h4><strong>Bienvenido</strong></h4>
          <?php echo $_SESSION['user'] ?>
           <div> <a href="logout" class="d-block"> Cerrar</div>
        </div>
      
          
      </div>
     
        <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
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
                  <i class="far fa-circle nav-icon"></i>
                  <p>Proveedores</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                 <i class="fas fa-user-tie" style="color:#218838"></i>
                  <p>Clientes</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="productos" class="nav-link">
                 <i class="fas fa-cart-arrow-down" style="color:#218838"></i>
                  <p>Productos</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="rol" class="nav-link">
                  <i class="fas fa-user-lock" style="color:#218838"></i>
                  <p>Roles</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="usuarios" class="nav-link">
                  <i class="fas fa-users-cog" style="color:#218838" ></i>
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
                  <i class="fas fa-file-invoice-dollar" style="color:#218838"></i>
                  <p>Facturas de compras</p>
                </a>
              </li>             
              <li class="nav-item">
                <a href="ordenes-compra" class="nav-link">
                  <i class="fas fa-shipping-fast" style="color:#218838"></i>
                  <p>Ordenes de compras</p>
                </a>
              </li> 
               <li class="nav-item">
                <a href="nueva-orden" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Nueva orden de compra</p>
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
                  <i class="fas fa-hand-holding-usd" style="color:#218838"></i></i>
                  <p>Caja</p>
                </a>
              </li>             
              <li class="nav-item">
                <a href="javascript:abirirVentas()" class="nav-link" >
                  <i class="fas fa-shipping-fast" style="color:#218838"></i>
                  <p>POS Ventas</p>
                </a>
              </li> 
                        
            </ul>
          </li>
           <?php } ?>
        
       
         
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>