<?php
/* Connect To Database*/
    include("config/db.php");
    include("config/conexionMail.php");

ob_start();


$username = 'pedrocum';
$password = 'Ayala860809';
//Array ( [0] => {gesventas.ml/notls}INBOX.Spam [1] => {gesventas.ml/notls}Drafts [2] => {gesventas.ml/notls}Trash [3] => {gesventas.ml/notls}Sent [4] => {gesventas.ml/notls}Spam [5] => {gesventas.ml/notls}INBOX ) 
$inbox = array();


$srv = '{mail.exfrxedl.lucusvirtual.es/notls}';

$lista   = imap_open($srv, $username, $password) or die('Ha fallado la conexión: ' . imap_last_error());

$boxes = imap_listmailbox($lista, $srv, '*');

$bandera;

$ruta="";
$cantidad_total=0;
$cantidad_enviadas=0;
if ($boxes == false) {   
    foreach ($boxes as $val) {
      if (strpos($val, 'INBOX')!== false) {
        $ruta= $val ;
      }        
    }
}else{
  echo json_encode("Error accediendo al buzon");
}

if($connection  = imap_open($ruta, $username, $password)){
 echo 'Ha fallado la conexión: ' . imap_last_error();
}
else{

$num_msg = imap_num_msg($connection);
for($i = 1; $i <= $num_msg; $i++) {
     $inbox[] = array(
      'index'     => $i,
      'header'    => imap_headerinfo($connection, $i),
      'body'      => imap_body($connection, $i),
      'structure' => imap_fetchstructure($connection, $i)
    );
    
   for ($j=0; $j <count($inbox) ; $j++) { 

    $header =$inbox[$j]['header'];
    $subj = $header->subject;        
    $email = $header->toaddress;     
   
 $body =  nl2br(htmlspecialchars(imap_fetchbody($connection,$i,1)));
if(mysqli_query($con,"INSERT INTO mail_sent(datemail,id_usuario,email_destinos, subject, body, estado) VALUES ('".$header->udate."',".$_SESSION['id'].",'".$email."','".$subj."','".$body."',0)")){
  $bandera=true;
  $cantidad_enviadas=$j;
imap_delete($connection, $j);
imap_expunge($connection);
}else{
  $bandera=false;
}


}

}


}


/*if($bandera){
  imap_close($connection);
echo json_encode('OK');
}else{
  echo json_encode("Se descargaron ".$cantidad_enviadas. "mensajes enviados de ".$num_msg);
}*/






?>

