<?php
/* Connect To Database*/
    include("config/db.php");
    include("config/conexionMail.php");

ob_start();
    @session_start();

 $encri = new encriptaDatos();
$hostname = '{gesventas.ml/notls}INBOX';
$username = 'vendedor@gesventas.ml';
$password = 'Vendedor123*';


$inbox = array();

 

if($connection   = imap_open($hostname,$username,$password)){
  $num_msg = imap_num_msg($connection);
  if($num_msg>0){

    $bandera=false;
    $cantidad_total=0;
    $cantidad_descargados=$num_msg;
//print_r("cantd ms".$num_msg);
  for($i = 0; $i <= $num_msg; $i++) {
      $inbox[] = array(
        'index'     => $i,
        'header'    => imap_headerinfo($connection, $i),
        'body'      => imap_body($connection, $i),
        'structure' => imap_fetchstructure($connection, $i)
      );

    $body = imap_fetchstructure($connection, 5);
     // var_dump( $body);
     for ($j=0; $j <count($inbox) ; $j++) {
    
      adjunto($inbox[$j]['structure'],$connection,$i);
      $header =$inbox[$j]['header'];
      $subj =  $encri->encriptar($header->subject); 
      $from = $header->from; 
      $email = $from[0]->mailbox."@".$from[0]->host; 
      $name = $encri->encriptar($from[0]->personal); 
    
      $body = (nl2br(htmlspecialchars(imap_fetchbody($connection,4,1))));
 var_dump( $body);
      $filtro= str_replace("=20",'',$body);
     /* imap_delete($connection, $i);
      imap_expunge($connection);

   /* if(mysqli_query($con,"INSERT INTO mail(datemail,id_usuario,email_origen,nombre, subject, body, estado,accion) VALUES ('".$encri->encriptar($header->udate)."','".$encri->encriptar($_SESSION['id'])."','".$encri->encriptar($email)."','".$name."','".$subj."','". $encri->encriptar(str_replace("<br />",'',$filtro))."',0,1)")){

      imap_delete($connection, $i);
      imap_expunge($connection);
       $bandera=true;
       $cantidad_descargados=$j;
    }else{
       $bandera=false;
    }*/
    
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




function adjunto($structure,$inbox,$email_number){
 
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
var_dump($attachments[$i]['attachment']);
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


//INSERT INTO fichero_adjuntos( `id_usuario`, `nombre`, `tipo`, `size`, `direccion`, `estado`) VALUES ([value-2],[value-3],[value-4],[value-5],[value-6],[value-7])

    if(count($attachments)!=0){ 

    $direccion="vistas/recursos/dist/archivosRecibidos/";
     foreach($attachments as $at){ 

      if($at[is_attachment]==1){ 
       file_put_contents("vistas/recursos/dist/archivosRecibidos/".$at[filename], $at[attachment]); 
        $esten= explode(".", $at[filename]);
        
     

       } 
      } 

     } 
    } 










                                  
               