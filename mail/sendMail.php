<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
include "PHPMailer.php";
include "SMTP.php";
include "Exception.php";
include("../config/db.php");
include("../config/conexionMail.php");
include("../modelo/mcript.php");

//Load Composer's autoloader
require '../vendor/autoload.php';

ob_start();
$encri = new encriptaDatos();

if($_POST["accion"]=="enviar"){


$mail = new PHPMailer(true); // create a new object

 //$mail->SMTPDebug = 4; 
 $mail->SMTPAuth = true; // authentication enabled

 $mail->Username = $_SESSION['email'];
 $mail->Password = $_SESSION['password'];

 $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
 $mail->Host = "mail.exfrxedl.lucusvirtual.es";
 $mail->Port = 465; 
 $mail->Mailer = "smtp";
 $mail->isHTML(true);
 
 $mail->From=$_SESSION['email'];
 $mail->FromName= $_SESSION['nombres'];
 
 $mail->Subject = $_POST["asunto"];
 $mail->Body = $_POST["body"];
 $mail->addAddress($_POST["para"]);


 if(!$con){
        error_log("imposible conectarse: ".mysqli_error($con));
    }else{
       error_log("conectado");
    }

$direccion="C:/xampp/htdocs/gesventas/vistas/recursos/dist/adjuntoMail/";
 if($a=mysqli_query($con,"select fa.*,(select cf.class from class_tipo_fichero cf where cf.tipo=fa.tipo) class from mail_sent ms inner join fichero_adjuntos fa on(fa.id_mail=ms.id_mail) where ms.id_usuario= '".$encri->encriptar($_SESSION['id'])."' and ms.accion=6 and fa.estado=5 and fa.id_mail='". $_POST["id_mail"]."' ")){
  
  if($a){
    while($row=mysqli_fetch_array($a)){ 
      $mail->AddAttachment( $direccion.$row['nombre'] ,$row['nombre']);  
     }
    
  }
  
 }
 



 
      
     /* $mail->AddAttachment( $direccion.$row['nombre'] ,$row['nombre']);
      error_log($direccion.$row['nombre']); */
 

$mail->Timeout = 20;
/* //salvar correo buzon Sent del servido
$buzon = 'Sent';
saved_mail($mail_salved, $mail->Username, $mail->Password,$buzon);
 $mail_salved= "From: ".$_SESSION['email']."\r\n"
               ."Personal: ".$_SESSION['nombres']."\r\n"
                   . "To: ".$_POST["para"]."\r\n"
                   . "Subject: ".$_POST["asunto"]."\r\n"
                   . "\r\n"
                   . $_POST["body"]."\r\n";

*/
 if(!$mail->Send()) {
  echo json_encode ("Error de envio: " . $mail->ErrorInfo);
  echo json_encode(false);
 } else {
  
   if(mysqli_query($con,"UPDATE `mail_sent` SET `datemail`='".$encri->encriptar(time())."', `id_usuario`='".$encri->encriptar($_SESSION['id'])."', `email_destinos`='".$encri->encriptar($_POST["para"])."',`subject`='".$encri->encriptar($_POST["asunto"])."',`body`='".$encri->encriptar($_POST["body"])."',`estado`=0,`accion`=7 WHERE id_mail='". $_POST["id_mail"]."'")){
   
   }


   //echo json_encode ("Correo enviado");
   echo json_encode(true);
 }

}


function saved_mail($mail, $user, $pass, $buzon)
{
 $srv = '{gesventas.ml/notls}';  
$connection   = conectar_server($user, $pass,$buzon);

$boxes = imap_listmailbox($connection, $srv, '*');
//$imapStream = @imap_open($boxes[4], $user, $pass);

$ruta="";
if ($boxes == false) {
    echo "Call failed<br />\n";
} else {
    foreach ($boxes as $val) {
      if (strpos($val, $buzon)!== false) {
        $ruta= $val ;
      }        
    }
}

 $result = imap_append($connection , $ruta, $mail);

$connection2   = conectar_server($user, $pass,$ruta);

$check = imap_check($connection2);

imap_close($connection);

    return $result;
}


function conectar_server($user, $pass,$buzon)
{

$srv = '{gesventas.ml/notls}';
$connection   = imap_open($srv, $user, $pass) or die('Ha fallado la conexión: ' . imap_last_error());
$boxes = imap_listmailbox($connection, $srv, '*');

$ruta="";
if ($boxes == false) {
    echo "Call failed<br />\n";
} else {
    foreach ($boxes as $val) {
      if (strpos($val, $buzon)!== false) {
        $ruta= $val ;
      }        
    }
}

$imapStream = @imap_open($ruta, $user, $pass);

error_log($ruta);
$check = imap_check($imapStream);
error_log( "Msg Count antes: ". $check->Nmsgs . "\n");

    return $imapStream;
}
