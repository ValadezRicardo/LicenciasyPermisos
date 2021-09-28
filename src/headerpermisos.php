<?php
// if(session_status() != PHP_SESSION_ACTIVE ){
//   session_start();
// }

include_once 'utilities.php';
$rol_id=3;

$page='';
if(ISSET($_SESSION["tokenp"])){
    if(validateTokenP($_SESSION["tokenp"]))
    {
        $page= '';
    }
    else{
        $page= 'permisosciudadano.php';
    }
    
}
else{
    $page= 'permisosciudadano.php';

}

if($page!=''){
    echo '<script>window.location="'.$page.'"</script>';
}

$q=execQueryP('select descripcion from permisoprefijo where deleted=0');
$prefijo="";

while ($row = mysqli_fetch_array($q)){
  $prefijo=$row["descripcion"];
}

$_SESSION["prefijop"]=$prefijo;

?>
    <header>
        <nav class="navbar fixed-top navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="https://www.transito-ixcateopan.gob.mx/" target="_self"><img src="/imgs/LOGO-GUERRERO.png" width="120" alt="Ixcateopan"></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
              <ul class="navbar-nav">
                <li class="nav-item active">
                  <a class="nav-link" href="./">Inicio</a>
                </li>
                <?php
                // $rol_id=3;
                // $id=0;
                if(ISSET($_SESSION["tokenp"])){
                    $token=$_SESSION["tokenp"];
                    $info=DecryptedVal($token);
                    $data=explode(",", $info);
                    // echo $info;
                    $id=$data[0];
                    $rol_id=$data[2];
                  
                }
                if($rol_id==1)
                echo '
                
                <li class="nav-item">
                  <a class="nav-link" href="usuariosp.php">Usuarios</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="permisoprefijo.php">Prefijo</a>
                </li>';

                ?>
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Folios
                  </a>
                  <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                  <?php
                    if($rol_id==1||$rol_id==2)
                    echo '<a class="dropdown-item" href="asignacionfoliopermisos.php">Asignación</a>';
                    ?>
                    <a class="dropdown-item" href="registropermisos.php">Registro</a>
                    <a class="dropdown-item" href="listadopermisos.php">Listado</a>
                  </div>
                </li>
                <?php
                    if($rol_id==1||$rol_id==2)
                    echo '
                <li class="nav-item">
                  <a class="nav-link" href="reportepermisos.php">Reporte</a>
                </li>';
                ?>
                <li class="nav-item">
                  <a class="nav-link" href="login.php?a=l&m=p">Cerrar Sesión</a>
                </li>
              </ul>
              
            </div>
          </nav>
    </header>