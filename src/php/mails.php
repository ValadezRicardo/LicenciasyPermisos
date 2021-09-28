<?php
$nombre = $_POST['nombre'];
$email = $_POST['email'];
$ciudad = $_POST['ciudad'];
$mensaje = $_POST['mensaje'];

require "PHPMailer/Exception.php";
require "PHPMailer/PHPMailer.php";
require "PHPMailer/SMTP.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$oMail= new PHPMailer();
$oMail->isSMTP();
$oMail->Host="mail.dooshub.net";
$oMail->Port=587;
$oMail->SMTPSecure="tls";
$oMail->SMTPAuth=true;
$oMail->Username="mail@dooshub.net";
$oMail->Password="MLhost157$";
$oMail->setFrom("mail@dooshub.net", "Yorch DoosHub");
$oMail->addAddress("yorch@doos.com.mx", "Yorch Doos");
$oMail->Subject="Mail del Formulario 1";
$oMail->MsgHTML("Nombre: " . $nombre . "<br> " . "Email: " . $email . "<br> " . "Ciudad: " . $ciudad . "<br> " . "Mensaje: " . $mensaje . "<br><br> " . "Este mail fue enviado desde MI FORMULARIO PHP + JQ 1");

  if (!empty($_POST['nombre']) && !empty($_POST['email']) && !empty($_POST['ciudad']))
   {
     !$oMail->send();
     header("Location: https://www.doos.com.mx");

  }
  else {
    //header("Location: http://192.168.64.2/pruebas/formulario1/formulario2.php");
    echo "Chanfle, no se envió";
  }
?>
