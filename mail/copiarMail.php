<?php
/* Connect To Database*/
    include("config/db.php");
    include("config/conexionMail.php");

ob_start();
    @session_start();

$username = 'vendedor@gesventas.ml';
$password = 'Vendedor123*';
$hostname = '{gesventas.ml/notls}';


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
      if (strpos($val, 'Sent')!== false) {
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
          print_r($inbox[2]['header']);
         for ($j=1; $j <count($inbox) ; $j++) { 

          $header =$inbox[$j]['header'];
          $subj = $header->subject;        
          $email = $header->toaddress;     
         
           $body =  nl2br(htmlspecialchars(imap_fetchbody($connection,$i,1)));
          if(mysqli_query($con,"INSERT INTO mail_sent(datemail,id_usuario,email_destinos, subject, body, estado,accion) VALUES ('".($header->udate)."','".($_SESSION['id'])."','".($email)."','".($subj)."','".($body)."',0,1)")){
            $bandera=true;
            $cantidad_enviadas=$j;
         /*imap_delete($connection, $i);
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
     
        echo json_encode('Ha fallado la conexión. Intentelo mas tarde o ponganse en contacto con el administrador1.' /*. imap_last_error()*/);     
      }
 }

}else{

echo json_encode('Ha fallado la conexión. Intentelo mas tarde o ponganse en contacto con el administrador2.' /*. imap_last_error()*/);
 

  } 