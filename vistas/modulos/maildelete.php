<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Buzón de Correo</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Inicio</a></li>
              <li class="breadcrumb-item active">Mail</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
     <section class="content">
      <div class="row">
        <div class="col-md-3">
          <a href="redactar-mail" class="btn btn-primary btn-block mb-3">Nuevo correo</a>

          <div class="card">
            <div class="card-header">
              <h3 class="card-title"><strong>Buzón</strong> [<?php echo $_SESSION['email'] ?>]</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <?php
                      $parametro= null;
                    $cant= "SELECT count(*) sin_leer FROM `mail` WHERE id_usuario='".encriptaDatos::encriptar($_SESSION['id'])."' and estado=0 and accion=1";
                    $cantidad = ControlMail::buscarMail($parametro,$cant);
                    $sin_leer=0;
                    foreach ($cantidad as $key => $value) {
                      $sin_leer=$value['sin_leer'];

                    }
             ?>
            <div class="card-body p-0">
              <ul class="nav nav-pills flex-column">
                <li class="nav-item active">
                  <a href="mailbox" class="nav-link">
                    <i class="fas fa-inbox"></i> Bandeja de entrada
                    <span class="badge bg-primary float-right"><?php echo $sin_leer ?></span>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="javascript:;" onclick="descargarMailEnviados('Sent')" class="nav-link">
                    <i class="far fa-envelope"></i> Elementos enviados
                  </a>
                </li>              
                <li class="nav-item">
                  <a href="#" class="nav-link">
                    <i class="far fa-trash-alt"></i> Elementos eliminados
                  </a>
                </li>
              </ul>
            </div>
            <!-- /.card-body -->
          </div>
         
        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="card card-primary card-outline">
            <div class="card-header">
              

              <div class="card-tools">
                <div class="input-group input-group-sm">
                 
                  
                </div>
              </div>
              <!-- /.card-tools -->
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
              <div class="mailbox-controls">
                <!-- Check all button -->
                <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="far fa-square"></i>
                </button>
                <div class="btn-group">
                  <button type="button" class="btn btn-default btn-sm" onclick="moverDelete('permanente')">
                    <i class="far fa-trash-alt"></i>
                  </button>
                  <button type="button" class="btn btn-default btn-sm">
                    <i class="fas fa-reply"></i>
                  </button>
                  <button type="button" class="btn btn-default btn-sm">
                    <i class="fas fa-share"></i>
                  </button>
                </div>
                <!-- /.btn-group -->
                <button type="button" class="btn btn-default btn-sm">
                  <i class="fas fa-sync-alt"></i>
                </button>
              
                <!-- /.float-right -->
              </div>
              <div class="table-responsive mailbox-messages">
                <table class="table table-hover table-striped">
                  <tbody>
                      <?php 

                      function timeago($date) {
                       $timestamp = strtotime($date);       
                       
                       $strTime = array("segundo", "minuto", "hora", "dia", "mes", "año");
                       $length = array("60","60","24","30","12","10");

                       $currentTime = time();                      
                       if($currentTime >= $date) {
                                    $diff     = time()- $date;
                                    for($i = 0; $diff >= $length[$i] && $i < count($length)-1; $i++) {
                                    $diff = $diff / $length[$i];
                                    }

                                    $diff = round($diff);
                                    return "Hace " . $diff . " " . $strTime[$i] . "(s)";
                       }
                    }

                    $parametro= null;
                    $datos= "SELECT id,datemail,id_usuario,email_origen,subject,body,fecha_delete,accion FROM `mail` WHERE id_usuario='".encriptaDatos::encriptar($_SESSION['id'])."'  and fecha_delete is not null and accion=2  union
(SELECT id,datemail,id_usuario,email_destinos,subject,body,fecha_delete,accion FROM `mail_sent` WHERE id_usuario='".encriptaDatos::encriptar($_SESSION['id'])."'  and fecha_delete is not null and accion=2 ) order by id desc";
                    error_log($datos);
                    $mail = ControlMail::buscarMail($parametro,$datos);
                     foreach ($mail as $key => $value) {                     
                      $strTimeAgo = timeago(encriptaDatos::desencriptar($value["datemail"]));               
                  ?>
                  <tr>
                    <td>
                      <div class="icheck-primary">
                        <input type="checkbox" value="<?php echo $value['id'] ?>" id="check1_<?php echo $value['id'] ?>" onclick="selectMail(<?php echo $value['id'] ?>)">
                        <label for="check1"></label>
                      </div>
                    </td>
                    
                    <td class="mailbox-name" style="color: #000000"><a href="javascript:void(0);" style="color: #000000" onClick="marcarLeido(<?php echo $value['id'] ?>,'salida');" > <?php echo encriptaDatos::desencriptar($value['email_origen']) ?></a> </td>  

                   
                    <td class="mailbox-subject"><a href="javascript:void(0);" style="color: #000000" onClick="marcarLeido(<?php echo $value['id'] ?>,'salida');" <?php echo $value['id'] ?> >   <?php echo encriptaDatos::desencriptar($value['subject']) ?> 
                    </td>
                    <td class="mailbox-attachment"></td>
                    <td class="mailbox-date"><?php echo $strTimeAgo ?></td>
                  </tr>
                  <?php } ?>
                  </tbody>
                </table>
                <!-- /.table -->
              </div>
              <!-- /.mail-box-messages -->
            </div>
            <!-- /.card-body -->
            <div class="card-footer p-0">
              <div class="mailbox-controls">
                <!-- Check all button -->
               
                <div class="float-right">
                  1-50/200
                  <div class="btn-group">
                    <button type="button" class="btn btn-default btn-sm">
                      <i class="fas fa-chevron-left"></i>
                    </button>
                    <button type="button" class="btn btn-default btn-sm">
                      <i class="fas fa-chevron-right"></i>
                    </button>
                  </div>
                  <!-- /.btn-group -->
                </div>
                <!-- /.float-right -->
              </div>
            </div>
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <div class="modal" id="ModalLoaderRecibidos"  data-backdrop="static" data-keyboard="false" tabindex="-1">
  <div class="modal-dialog modal-sm">
   
      <div class="modal-body">
  <div class="loader"> 
  </div> 
    
</div>
</div></div>

<style type="text/css">
  .loader {
  border: 16px solid #f3f3f3; /* Light grey */
  border-top: 16px solid #3498db; /* Blue */
  border-radius: 50%;
  width: 120px;
  height: 120px;
  animation: spin 2s linear infinite;
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

.modal-dialog {
  height: 80% !important;
  padding-top:10%;
}

.modal-content {
  height: 100% !important;
  overflow:visible;
}

.modal-body {
  height: 80%;
  overflow: auto;
}
</style>