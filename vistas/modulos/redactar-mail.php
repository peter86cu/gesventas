 <?php
 $parametro= null;
 $cant= "SELECT count(*) sin_leer FROM `mail` WHERE id_usuario='".encriptaDatos::encriptar($_SESSION['id'])."' and estado=0 and accion=1";
 $cantidad = ControlMail::buscarMail($parametro,$cant);
 $sin_leer=0;
 foreach ($cantidad as $key => $value) {
  $sin_leer=$value['sin_leer'];
}

$identificador=""; 
$sin_leer=0;

$accion="";
$mail_responder="";
$asunto="";
$from="";
$date="";
$body="";
$adjuntos = array();
$id_mail="";

if(isset($_SESSION['id_mail']) && $_SESSION['accion_mail']=='responder' ){ 
error_log($_SESSION['id_mail']);                     
 $identificador = $_SESSION['id_mail'];
 $sin_leer = $_SESSION['sin_leer'];
 $accion=$_SESSION['accion_mail'];
 setlocale(LC_TIME, 'spanish'); 
 $parametro= null;
 $datos= "SELECT * FROM `mail` WHERE id=".$identificador."";
 $mail = ControlMail::buscarMail($parametro,$datos);
error_log($datos);
 foreach ($mail as $key => $value) { 
  $asunto = encriptaDatos::desencriptar($value['subject']);
  $nombre = encriptaDatos::desencriptar($value['nombre']);
  $from =encriptaDatos::desencriptar($value['email_origen']);
  $date = encriptaDatos::desencriptar($value['datemail']);
  $body = encriptaDatos::desencriptar($value['body']);
  $nueva_fecha = date("d-m-Y h:i:s", encriptaDatos::desencriptar ($value["datemail"]));       
  $prettydate = strftime("%A, %d de %B de %Y %H : %M :%S", strtotime($nueva_fecha));
  $dateutf = ucfirst(iconv("ISO-8859-1","UTF-8",$prettydate)); 
  $id_mail=$_SESSION['id_new_mail'];

} 

$mail_responder= "De: ".$nombre ." <".$from.">\r\n"
."Enviado el : ". $dateutf."\r\n"
."Para: ".$_SESSION['email']."\r\n"
."Asunto: ".$asunto."\r\n"
."\r\n"
.$body."\r\n";
$para_resp=$from;
$asunto_resp="RE: ".$asunto;


}

if($_SESSION['accion_mail']=="nuevo"){

  $id_mail=$_SESSION['id_new_mail'];
}

if($_SESSION['accion_mail']=='borrador'){

  $identificador = $_SESSION['id_mail'];
  $sin_leer = $_SESSION['sin_leer'];
  $accion=$_SESSION['accion_mail'];
  setlocale(LC_TIME, 'spanish'); 
  $parametro= null;
  $datos= "SELECT * FROM `mail_sent` WHERE id=".$identificador."";  
  $mail = ControlMail::buscarMail($parametro,$datos);


  foreach ($mail as $key => $value) { 
    $asunto = encriptaDatos::desencriptar($value['subject']);
    $nombre = encriptaDatos::desencriptar($value['nombre']);
    $from =encriptaDatos::desencriptar($value['email_destinos']);
    $date = encriptaDatos::desencriptar($value['datemail']);
    $body = encriptaDatos::desencriptar($value['body']);
    $nueva_fecha = date("d-m-Y h:i:s", encriptaDatos::desencriptar ($value["datemail"]));       
    $prettydate = strftime("%A, %d de %B de %Y %H : %M :%S", strtotime($nueva_fecha));
    $dateutf = ucfirst(iconv("ISO-8859-1","UTF-8",$prettydate));   
    $id_mail=$value['id_mail'];   
  } 


}

error_log("accion ".$_SESSION['accion_mail']);

if(isset($_SESSION['archivo']) && $_SESSION['archivo']=='mostrar' && ($_SESSION['accion_mail']=="nuevo" || $_SESSION['accion_mail']=="borrador" || $_SESSION['accion_mail']=='enviar_adjunto')){
  $parametro= null;
  $datos= "select fa.*,(select cf.class from class_tipo_fichero cf where cf.tipo=fa.tipo) class from mail_sent ms inner join fichero_adjuntos fa on(fa.id_mail=ms.id_mail) where ms.id_usuario= '".($_SESSION["id"])."' and ms.accion=6 and fa.estado=5 and fa.id_mail='".$_SESSION['id_new_mail']."' ";
  $mail = ControlMail::buscarMail($parametro,$datos);
  error_log($datos);
  foreach ($mail as $key => $values) { 

    $adjuntos[] =  array (
      'name' => $values['nombre'],
      'ext' =>  $values['tipo'],
      'class' =>  $values['class'],
      'size' =>  $values['size'],
      'id_fichero' =>  $values['id'],
      'path' =>  $values['direccion']
    );

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
          <a href="mailbox" class="btn btn-primary btn-block mb-3">Bandeja de entrada</a>

          <div class="card">
            <div class="card-header">
              <h3 class="card-title"><strong>Buzón</strong> [<?php echo $_SESSION['email'] ?>]</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="card-body p-0">
              <ul class="nav nav-pills flex-column">
                <li class="nav-item active">
                  <a href="mailbox" onclick="actualizar_Borrador('<?php echo $id_mail; ?>')" class="nav-link">
                    <i class="fas fa-inbox"></i> Bandeja de entrada
                    <span class="badge bg-primary float-right"><?php echo $sin_leer ?></span>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="mailsend" onclick="actualizar_Borrador('<?php echo $id_mail; ?>')" class="nav-link">
                    <i class="far fa-envelope"></i> Elementos enviados
                  </a>
                </li>                 
                <li class="nav-item">
                  <a href="maildelete" onclick="actualizar_Borrador('<?php echo $id_mail; ?>')" class="nav-link">
                    <i class="far fa-trash-alt"></i> Elementos eliminados
                  </a>
                </li>
                <li class="nav-item">
                  <a href="mailborrador" onclick="actualizar_Borrador('<?php echo $id_mail; ?>')" class="nav-link">
                    <i class="far fa-file-alt"></i> Borradores
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
              <h3 class="card-title"> <?php if($accion=='responder') {?> Responder correo <?php }else{ ?>Redactar correo nuevo <?php } ?></h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <div class="form-group">
                <input class="form-control" id="txt_para" placeholder="Para:" value="<?php if($accion=='responder') echo $para_resp; if($accion=='borrador') echo $from; ?>">
              </div>
              <div class="form-group">
                <input class="form-control" id="txt_asunto" placeholder="Asunto:" value="<?php if($accion=='responder') echo $asunto_resp; if($accion=='borrador') echo $asunto; ?>">
              </div>
              <div class="form-group">
                <textarea id="compose-textarea"  class="form-control" style="height: 300px"><?php if($accion=='responder'){echo $mail_responder;}if($accion=='borrador'){echo $body; } if($accion!='responder' || $accion!='borrador'){ ?> <?php }?></textarea>
              </div>
              <div id='here' class="form-group">

                <ul class="mailbox-attachments d-flex align-items-stretch clearfix">

                 <?php for ($j=0; $j <count($adjuntos) ; $j++) { ?>
                  <li>
                   <a href="<?php echo $adjuntos[$j]['path'].$adjuntos[$j]['name'] ?>" target="_blank"> <span class="mailbox-attachment-icon"><i <?php echo $adjuntos[$j]['class'] ?> ></i></span>                   
                    <div class="mailbox-attachment-info">
                      <a href="<?php echo $adjuntos[$j]['path'].$adjuntos[$j]['name'] ?>" target="_blank" class="mailbox-attachment-name"><i class="fas fa-paperclip"></i> <?php echo $adjuntos[$j]['name'] ?></a>
                      <button type="button" class="close" onclick="eliminarAdjunto('<?php echo $adjuntos[$j]['path'].$adjuntos[$j]['name'] ?>','<?php echo $adjuntos[$j]['id_fichero'] ?>')">&times;</button> 
                    </li>
                  <?php }  ?>

                </ul>
              </div>
              <form method="post" enctype="multipart/form-data">
                <div class="btn btn-default btn-file">
                  <i class="fas fa-paperclip"></i> Adjuntar           
                  <input type="file" name="attachment" id="idAdjunto" multiple onchange="validarFicheroAdjunto()">

                </div></form>
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                <div class="float-right">
                  <button type="button" class="btn btn-default"><i class="fas fa-pencil-alt"></i> Borrador</button>
                  <button type="submit" class="btn btn-success" onclick="enviarMail('<?php echo $id_mail ?>')"><i class="far fa-envelope"></i> Enviar</button>
                </div>
                <button type="reset" class="btn btn-default"><i class="fas fa-times"></i> Descartar</button>
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