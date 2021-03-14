
<div class="padre">
<div class="login-box">
  <div class="login-logo">
    <a href="../../index2.html"><b>Sistema </b>PRUEBA</a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Inicio de Sesión<p>

      <form  method="post">
        <div class="input-group mb-3">
         <input type="text" name="txt_usuario" class="form-control" placeholder="Usuario">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Contraseña" name="txt_contra">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="remember">
              <label for="remember">
                Recordarme
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="#" class="btn btn-primary btn-block">Entrar</button>
          </div>
          <!-- /.col -->

        </div>
     
     

      </form>

          
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
</div>
<!-- jQuery -->
<script src="vistas/recursos/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="vistas/recursos/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="vistas/recursos/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="vistas/recursos/dist/js/demo.js"></script>
<!--  aperura -->
<script src="vistas/recursos/dist/js/apertura.js"></script>
  <?php 

       $obj_login = new ControlUsuario();
       $obj_login -> validarLogin();

        ?>

<style>
  
  .padre {  
  display: flex;
  justify-content: center;
  align-items: center;
}
</style>
