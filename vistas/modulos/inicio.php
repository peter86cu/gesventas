<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Dashboard</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Inicio</a></li>
            <li class="breadcrumb-item active">Dashboard</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->
  <input type="hidden" id="variable_sesion" value="<?php echo $_SESSION['loginCaja']; ?>"> 
  <!-- Main content -->
<script type="text/javascript">
  
  setInterval("comprobar_refresco()", 10);

  function comprobar_refresco() {
    var datos = new FormData(); 
    var accion ="user";    
    datos.append("accion",accion);

  
 /* $.ajax({
    type: 'POST',
     data: datos,
    url: 'procesos/dashboard.php'
  }).success(function(resultado) {
    if (resultado.indexOf('REFRESCAR') > -1) {
      location.reload();
    }
  });*/

     $.ajax({
     url: "procesos/dashboard.php",
     method : "POST",
     data: datos,
     chache: false,
     contentType: false,
     processData:false,
     dataType: "json",
     success: function(respuesta){
      console.log(respuesta)
      if(respuesta){
       document.querySelector('#login').innerText = respuesta;
       // $( "#idLogin" ).load(window.location.href + " #idLogin" );
     }



   }
 });
}

</script>


  <section class="content">
    <div class="container-fluid">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-3 col-6">
          <!-- small box -->        
          <div class="small-box bg-info">
            <div class="inner" id="idLogin">
              <h3><label id="login">0</label></h3>
              <p>Usuarios conectados</p>
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>            
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-success">
            <div class="inner">
              <h3>53<sup style="font-size: 20px">%</sup></h3>

              <p>Bounce Rate</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-warning">
            <div class="inner">
              <h3 ></h3>

              <p>User Registrations</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-danger">
            <div class="inner">
              <h3>65</h3>

              <p>Unique Visitors</p>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>
      <!-- /.row -->
      <!-- Main row -->
      <div class="row">

      </div>

    </div>
    <!-- /.card -->
  </section>
  <!-- right col -->
</div>



<div class="modal" id="ModalLoginCaja" data-backdrop="static" data-keyboard="false" tabindex="-1">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">

      <form role="form" method="POST" enctype="multipart/form-data">


        <!-- Modal body -->
        <div class="modal-body">
          <div class="box-body">

            <div class="card">
              <div class="card-body login-card-body">
                <p class="login-box-msg">Entrar a POS DE VENTAS<p>

                  <form  method="post">
                    <div class="input-group mb-2">
                     <input type="text" name="txt_usuario" id ="txt_usuario" class="form-control" placeholder="Usuario">
                     <div class="input-group-append">
                      <div class="input-group-text">
                        <span class="fas fa-user"></span>
                      </div>
                    </div>
                  </div>
                  <div class="input-group mb-2">
                    <input type="password" class="form-control" placeholder="Contraseña" name="txt_contra" id="txt_contra">
                    <div class="input-group-append">
                      <div class="input-group-text">
                        <span class="fas fa-lock"></span>
                      </div>
                    </div>
                  </div>
                  <div class="row">          

                    <button type="submit" class="btn btn-primary btn-block" href="javascript:;"  onclick="entrarCaja(); return false">Entrar</button>


                  </div>



                </form>


              </div>
              <!-- /.login-card-body -->
            </div>  

            
          </div>
        </div>


        <!---OK-->
      </form>

    </div>

  </div>

</div>