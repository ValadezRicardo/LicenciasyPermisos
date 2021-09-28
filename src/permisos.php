<?php
if(session_status() != PHP_SESSION_ACTIVE ){
    session_start();
  }
include_once 'utilities.php';
// echo $_SESSION["tokenp"];
// echo validateTokenP($_SESSION["tokenp"]);
$_SESSION["redirectPage"]="permisos.php";
if(ISSET($_SESSION["tokenp"])){
    if(validateTokenP($_SESSION["tokenp"]))
    {
      // echo 'valid';
        include_once 'permisosusuario.php';
    }
    else{
      // echo 'invalid';
        include_once 'permisosciudadano.php';
    }
    
}
else{
include_once 'permisosciudadano.php';

}

?>
