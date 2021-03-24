<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
include "PHPMailer.php";
include "SMTP.php";
include "Exception.php";

//Load Composer's autoloader
require '../vendor/autoload.php';
@session_start();



if($_POST["accion"]=="enviar"){


$mail = new PHPMailer(true); // create a new object

 $mail->SMTPDebug = 4; 
 $mail->SMTPAuth = true; // authentication enabled

 $mail->Username = $_SESSION['email'];
 $mail->Password = $_SESSION['password'];

 $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
 $mail->Host = "gesventas.ml";
 $mail->Port = 465; 
 $mail->Mailer = "smtp";
 $mail->isHTML(true);
 
 $mail->From=$_SESSION['email'];
 $mail->FromName= $_SESSION['nombres'];
 
 $mail->Subject = $_POST["asunto"];
 $mail->Body = $_POST["body"];
 $mail->addAddress($_POST["para"]);

if(!empty($archivos_adjuntos_ruta)){
foreach($archivos_adjuntos_ruta as $archivo){
$mail->AddAttachment($archivo); // attachment
}
}

if(!empty($archivos_adjuntos_temp)){
foreach($archivos_adjuntos_temp as $nombrearchivo=>$contenidoArchivo){
$mail->AddStringAttachment($contenidoArchivo,$nombrearch ivo,'base64');
}
}
$mail->Timeout = 20;


 $mail_salved= "From: ".$_SESSION['email']."\r\n"
               ."Personal: ".$_SESSION['nombres']."\r\n"
                   . "To: ".$_POST["para"]."\r\n"
                   . "Subject: ".$_POST["asunto"]."\r\n"
                   . "\r\n"
                   . $_POST["body"]."\r\n";
error_log($mail_salved);
$buzon = 'Sent';
saved_mail($mail_salved, $mail->Username, $mail->Password,$buzon);
 if(!$mail->Send()) {
  //echo json_encode ("Error de envio: " . $mail->ErrorInfo);
  echo json_encode(false);
 } else {
 	
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
error_log("Msg Count despues: ". $check->Nmsgs . "\n");
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
