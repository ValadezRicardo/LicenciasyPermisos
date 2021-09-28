<?php
if(session_status() != PHP_SESSION_ACTIVE ){
    session_start();
  }
include_once 'utilities.php';
$_SESSION["redirectPage"]="licencias.php";
if(ISSET($_SESSION["token"])){
    if(validateToken($_SESSION["token"]))
    {
        include_once 'licenciausuario.php';
    }
    else{
        include_once 'licenciaciudadano.php';
    }
    
}
else{
include_once 'licenciaciudadano.php';

}

?>
