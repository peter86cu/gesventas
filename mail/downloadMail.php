<?php
/* Connect To Database*/
    include("../config/db.php");
    include("../config/conexionMail.php");
    include("../modelo/mcript.php");

    ob_start();
    

     $encri = new encriptaDatos();
     

if($_POST['accion']=='descargar'){
$hostname = '{gesventas.ml/notls}'.$_POST['carpeta'];
$username = $_SESSION['email'];
$password = $_SESSION['password'];


$inbox = array();

if($connection   = imap_open($hostname,$username,$password)){
  $num_msg = imap_num_msg($connection);
  if($num_msg>0){

    $bandera=false;
    $cantidad_total=0;
    $cantidad_descargados=$num_msg;

  for($i = 0; $i <= $num_msg; $i++) {
   
      $inbox[] = array(
        'index'     => $i,
        'header'    => imap_headerinfo($connection, $i),
        'body'      => imap_body($connection, $i),
        'structure' => imap_fetchstructure($connection, $i)
      );
      imap_delete($connection, $i);
      imap_expunge($connection);
    }

     for ($j=1; $j <count($inbox) ; $j++) {
      $id=uniqid() ;
      $header =$inbox[$j]['header'];
      $subj =  $encri->encriptar($header->subject); 
      $from = $header->from; 
      $email = $from[0]->mailbox."@".$from[0]->host; 
      $name = $from[0]->personal;
    
       if($name==null){
         $name= $email;
      }
     
     if(existe_adjunto($inbox[$j]['structure'])){
      adjunto($inbox[$j]['structure'],$connection,$j,$con,$id);
       $body = ((imap_fetchbody($connection,$j,1.1)));       
    }else{
       $body = imap_fetchbody($connection,$j,1);
       
    }
    // $body = (nl2br(htmlspecialchars(imap_fetchbody($connection,$j,1))));
    //$filtro= str_replace("=20",'',$body); str_replace("<br />",'',$filtro)

    if(mysqli_query($con,"INSERT INTO mail(datemail,id_usuario,email_origen,nombre, subject, body, estado,accion,id_mail) VALUES ('".$encri->encriptar($header->udate)."','".$encri->encriptar($_SESSION['id'])."','".$encri->encriptar($email)."','".$encri->encriptar($name)."','".$subj."','". $encri->encriptar($body)."',0,1,'".$id."')")){
       $bandera=true;
       $cantidad_descargados=$j;
     
    }else{
       $bandera=false;
    }
    
    }
    

        if($bandera && $num_msg>0){
           imap_close($connection );
          echo json_encode("Se descargaron ".$cantidad_descargados. " de ".$num_msg);
          }else {  
              
           echo json_encode("Ha fallado la conexión. Intentelo mas tarde o ponganse en contacto con el administrador1.");
          }

      }else{
        imap_close($connection );
        echo json_encode("No hay correos nuevos");
      }

    } else {
     
    echo json_encode('Ha fallado la conexión. Intentelo mas tarde o ponganse en contacto con el administrador2.');

    }


}

if($_POST['accion']=='descargar_enviados'){

$username = $_SESSION['email'];
$password = $_SESSION['password'];
$buzon= $_POST['carpeta'];
$inbox = array();
$srv = '{gesventas.ml/notls}';

if($lista   = imap_open($srv, $username, $password)){
 
 if(!$boxes = imap_listmailbox($lista, $srv, '*')) {
      
      echo json_encode("Error accediendo al buzon");
    
 }else{

  $bandera=false;
$cantidad_total=0;
$cantidad_enviadas=0;

$ruta="";

    foreach ($boxes as $val) { 
      if (strpos($val, $buzon)!== false) {
       $ruta= $val ;
      }        
    }

            if($connection  = imap_open($ruta, $username, $password)){             
               $num_msg = imap_num_msg($connection);
               if($num_msg==0){
                imap_close($connection );
                echo json_encode ('Buzon actualizado');
              }else{ 
      for($i = 0; $i <= $num_msg; $i++) {

           $inbox[] = array(
            'index'     => $i,
            'header'    => imap_headerinfo($connection, $i),
            'body'      => imap_body($connection, $i),
            'structure' => imap_fetchstructure($connection, $i)
          );
          
         for ($j=1; $j <count($inbox) ; $j++) { 

          $header =$inbox[$j]['header'];
          $subj = $header->subject;        
          $email = $header->toaddress;     
         
           $body =  nl2br(htmlspecialchars(imap_fetchbody($connection,$i,1)));
          if(mysqli_query($con,"INSERT INTO mail_sent(datemail,id_usuario,email_destinos, subject, body, estado,accion) VALUES ('".$encri->encriptar($header->udate)."','".$encri->encriptar($_SESSION['id'])."','".encriptaDatos::encriptar($email)."','".$encri->encriptar($subj)."','".$encri->encriptar($body)."',1,1)")){
            $bandera=true;
            $cantidad_enviadas=$j;
        /* imap_delete($connection, $i);
          imap_expunge($connection);*/
          }else{
            $bandera=false;
          }
         }
         $cantidad_total=$i;
        }
        
          if($bandera && $cantidad_total>0){
           imap_close($connection );
          echo json_encode('OK');
          }else {
            imap_close($connection );
           echo json_encode("Se descargaron ".$cantidad_enviadas. " de ".$cantidad_total);
          }
       }
      }
      else{
     
        echo json_encode('Ha fallado la conexión. Intentelo mas tarde o ponganse en contacto con el administrador.' /*. imap_last_error()*/);     
      }
 }

}else{

echo json_encode('Ha fallado la conexión. Intentelo mas tarde o ponganse en contacto con el administrador.' /*. imap_last_error()*/);
 

  } 

}




function adjunto($structure,$inbox,$email_number,$con,$id){

      $attachments = array(); 
     if(isset($structure->parts) && count($structure->parts)) { 
     for($i = 0; $i < count($structure->parts); $i++) { 
      $attachments[$i] = array(
       'is_attachment' => false, 
       'filename' => '', 
       'name' => '', 
       'attachment' => ''); 

      if($structure->parts[$i]->ifdparameters) { 
      foreach($structure->parts[$i]->dparameters as $object) { 
       if(strtolower($object->attribute) == 'filename') { 
       $attachments[$i]['is_attachment'] = true; 
       $attachments[$i]['filename'] = $object->value; 
       } 
      } 
      } 

      if($structure->parts[$i]->ifparameters) { 
      foreach($structure->parts[$i]->parameters as $object) { 
       if(strtolower($object->attribute) == 'name') { 
       $attachments[$i]['is_attachment'] = true; 
       $attachments[$i]['name'] = $object->value; 
       } 
      } 
      } 

      if($attachments[$i]['is_attachment']) { 
      $attachments[$i]['attachment'] = imap_fetchbody($inbox, $email_number, $i+1); 
      if($structure->parts[$i]->encoding == 3) { // 3 = BASE64 
       $attachments[$i]['attachment'] = base64_decode($attachments[$i]['attachment']); 
      } 
      elseif($structure->parts[$i]->encoding == 4) { // 4 = QUOTED-PRINTABLE 
       $attachments[$i]['attachment'] = quoted_printable_decode($attachments[$i]['attachment']); 
      } 
      }    
     } // for($i = 0; $i < count($structure->parts); $i++) 
     } // if(isset($structure->parts) && count($structure->parts)) 


    if(count($attachments)!=0){ 

    $direccion="C:/xampp/htdocs/gesventas/vistas/recursos/dist/archivosRecibidos/";
     foreach($attachments as $at){ 

      if($at["is_attachment"]==1){ 
       file_put_contents($direccion.$at["filename"], $at["attachment"]);      
        $esten = new SplFileInfo($at["filename"]);
       
      mysqli_query($con,"INSERT INTO fichero_adjuntos( `id_usuario`, `nombre`, `tipo`, `size`, `direccion`, `estado`,id_mail) VALUES ('".$_SESSION['id']."','".$at["filename"]."','".$esten->getExtension()."',0,'vistas/recursos/dist/archivosRecibidos/',4,'".$id."')");

       } 
      } 

     } 
    } 


 function existe_adjunto($structure){

      $tiene_adjunto=false;
      $attachments = array(); 
     if(isset($structure->parts) && count($structure->parts)) { 
     for($i = 0; $i < count($structure->parts); $i++) { 
      $attachments[$i] = array(
       'is_attachment' => false, 
       'filename' => '', 
       'name' => '', 
       'attachment' => ''); 

      if($structure->parts[$i]->ifdparameters) { 
      foreach($structure->parts[$i]->dparameters as $object) { 
       if(strtolower($object->attribute) == 'filename') { 
       $attachments[$i]['is_attachment'] = true; 
       $attachments[$i]['filename'] = $object->value; 
       $tiene_adjunto=true; 
       break;      
       } 
      } 
      } 
    }
  }
return $tiene_adjunto;
}
