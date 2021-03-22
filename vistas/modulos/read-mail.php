
 <?php
             
              $identificador=""; 
              $sin_leer=0;
              $idMail="";

              if (isset($_SESSION['id_mail'])){
                if($_SESSION['accion_mail']=='entrada'){
                   $identificador = $_SESSION['id_mail'];
                $sin_leer = $_SESSION['sin_leer'];
                /*unset($_SESSION['id_mail']);
                unset($_SESSION['sin_leer']);*/
                 setlocale(LC_TIME, 'spanish'); 
                 $parametro= null;
                    $datos= "SELECT * FROM `mail` WHERE id=".$identificador."";
                    $mail = ControlMail::buscarMail($parametro,$datos);
                    $asunto="";
                    $from="";
                    $date="";
                    $body="";
                     foreach ($mail as $key => $value) { 
                        $asunto = encriptaDatos::desencriptar($value['subject']);
                         $nombre = encriptaDatos::desencriptar($value['nombre']);
                        $from =encriptaDatos::desencriptar($value['email_origen']);
                        $date = encriptaDatos::desencriptar($value['datemail']);
                        $body = encriptaDatos::desencriptar($value['body']);
                         $nueva_fecha = date("d-m-Y h:i:s", encriptaDatos::desencriptar ($value["datemail"]));       
                  $prettydate = strftime("%A, %d de %B de %Y %H : %M :%S", strtotime($nueva_fecha));
                  $dateutf = ucfirst(iconv("ISO-8859-1","UTF-8",$prettydate));
                  $idMail=$value['id'];
                      } 

                }if($_SESSION['accion_mail']=='salida'){
                     $identificador = $_SESSION['id_mail'];
                $sin_leer = $_SESSION['sin_leer'];
                /*unset($_SESSION['id_mail']);
                unset($_SESSION['sin_leer']);*/
                 setlocale(LC_TIME, 'spanish'); 
                 $parametro= null;
                    $datos= "SELECT * FROM `mail_sent` WHERE id=".$identificador."";
                    $mail = ControlMail::buscarMail($parametro,$datos);
                    $asunto="";
                    $from="";
                    $date="";
                    $body="";
                     foreach ($mail as $key => $value) { 
                        $asunto = encriptaDatos::desencriptar($value['subject']);
                        $nombre = $_SESSION['nombres'];
                        $from = encriptaDatos::desencriptar($value['email_destinos']);
                        $date = encriptaDatos::desencriptar($value['datemail']);
                        $body = encriptaDatos::desencriptar($value['body']);
                         $nueva_fecha = date("d-m-Y h:i:s", encriptaDatos::desencriptar ($value["datemail"]));       
                  $prettydate = strftime("%A, %d de %B de %Y %H : %M :%S", strtotime($nueva_fecha));
                  $dateutf = ucfirst(iconv("ISO-8859-1","UTF-8",$prettydate));
                    $idMail=$value['id'];
                      } 
                }
                           
                
              }
             
              ?> 

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
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3">
            <a href="mailbox" class="btn btn-primary btn-block mb-3">Regresar a la bandeja</a>

            <div class="card">
              <div class="card-header">
                <h3 class="card-title"><strong>Buzon</strong> [<?php echo $_SESSION['email'] ?>]</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
              </div>
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
              <h3 class="card-title"><p><h5><strong>De: </strong><?php echo $nombre ?></h5>
                    <?php if($_SESSION['accion_mail']=='salida') { ?> <p><h5><strong>Para: </strong><?php echo $from ?></h5> <?php } ?></h3>

            </div>
            <!-- /.card-header -->
             
            <div class="card-body p-0">
              <div class="mailbox-read-info">               
                  <h3> <strong>Asunto: </strong><?php echo $asunto ?></h3>
                <h6>
                  <span class="mailbox-read-time float-right"><?php echo $dateutf ?></span></h6>
              </div>
              <!-- /.mailbox-read-info -->
              <div class="mailbox-controls with-border text-center">
                <div class="btn-group">
                 
                </div>
                <!-- /.btn-group -->
               
              </div>
              <!-- /.mailbox-controls -->
              <div class="mailbox-read-message">
                <?php echo $body ?>
              </div>
              <!-- /.mailbox-read-message -->
            </div>
            <!-- /.card-body -->
            <div class="card-footer bg-white">
              <ul class="mailbox-attachments d-flex align-items-stretch clearfix">
                <li>
                  <span class="mailbox-attachment-icon"><i class="far fa-file-pdf"></i></span>

                  <div class="mailbox-attachment-info">
                    <a href="#" class="mailbox-attachment-name"><i class="fas fa-paperclip"></i> Sep2014-report.pdf</a>
                        <span class="mailbox-attachment-size clearfix mt-1">
                          <span>1,245 KB</span>
                          <a href="#" class="btn btn-default btn-sm float-right"><i class="fas fa-cloud-download-alt"></i></a>
                        </span>
                  </div>
                </li>          
                
              </ul>
            </div>
            <!-- /.card-footer -->
            <div class="card-footer">
              <div class="float-right">
                <button type="button" class="btn btn-default" onclick="leerMail(<?php echo $idMail ?>,<?php echo $sin_leer ?>,'responder')" ><i class="fas fa-reply"></i> Responder</button>
                <button type="button" class="btn btn-default"><i class="fas fa-share"></i> Reenviar</button>
              </div>
              <button type="button" class="btn btn-default" onclick="moverDeleteLectura(<?php echo $idMail ?>,'<?php echo $_SESSION['accion_mail']?>')"><i class="far fa-trash-alt" ></i> Eliminar</button>
              <button type="button" class="btn btn-default"><i class="fas fa-print"></i> Print</button>
            </div>
            <!-- /.card-footer -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <div class="modal" id="ModalLoaderRecibidos"  data-backdrop="static" data-keyboard="false" tabindex="-1">
  <div class="modal-dialog modal-sm">
   
      <div class="modal-body">
  <div class="loader"></div> 
    <span class="sr-only">Enviando...</span>
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