<?php
/* Connect To Database*/
    include("../config/db.php");
    include("../config/conexionMail.php");
    include("../modelo/mcript.php");

    ob_start();
    @session_start();

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
    
     for ($j=1; $j <count($inbox) ; $j++) {
   
      $header =$inbox[$j]['header'];
      $subj =  $encri->encriptar($header->subject); 
      $from = $header->from; 
      $email = $from[0]->mailbox."@".$from[0]->host; 
      $name = $encri->encriptar($from[0]->personal); 
     
      $body = (nl2br(htmlspecialchars(imap_fetchbody($connection,$i,1))));


    if(mysqli_query($con,"INSERT INTO mail(datemail,id_usuario,email_origen,nombre, subject, body, estado,accion) VALUES ('".$encri->encriptar($header->udate)."','".$encri->encriptar($_SESSION['id'])."','".$encri->encriptar($email)."','".$name."','".$subj."','". $encri->encriptar(str_replace("=20",'',$body))."',0,1)")){

      imap_delete($connection, $i);
      imap_expunge($connection);
       $bandera=true;
       $cantidad_descargados=$j;
    }else{
       $bandera=false;
    }
    
    }
    
    }

        if($bandera && $num_msg>0){
           imap_close($connection );
          echo json_encode("Se descargaron ".$cantidad_descargados. " de ".$num_msg);
          }else {  
              imap_close($connection );     
           echo json_encode("Ha fallado la conexión. Intentelo mas tarde o ponganse en contacto con el administrador1.");
          }

      }else{
        imap_close($connection );
        echo json_encode("No hay correos nuevos");
      }

    } else {
      imap_close($connection );
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
          if(mysqli_query($con,"INSERT INTO mail_sent(datemail,id_usuario,email_destinos, subject, body, estado,accion) VALUES ('".$encri->encriptar($header->udate)."','".$encri->encriptar($_SESSION['id'])."','".encriptaDatos::encriptar($email)."','".$encri->encriptar($subj)."','".$encri->encriptar($body)."',0,1)")){
            $bandera=true;
            $cantidad_enviadas=$j;
         imap_delete($connection, $i);
          imap_expunge($connection);
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






