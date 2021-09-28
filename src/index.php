<?php
//  session_destroy();
if(session_status() != PHP_SESSION_ACTIVE ){
  session_start();
}
// UNSET($_SESSION["token"]);
$_SESSION["redirectPage"]="index.php";
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Licencias</title>
    <meta charset="UTF-8">
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;900&display=swap" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link href="css/styles.css" rel="stylesheet">
    <link href="css/reset-boot.css" rel="stylesheet">

    <!-- JQUERY only -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.js"></script>


    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.flash.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script>

    
    <script type="text/javascript">
        $(document).ready( function () {

            $('#FoliosLicencias').DataTable( {
                    language: {
                        url: 'https://cdn.datatables.net/plug-ins/1.10.22/i18n/Spanish.json'
                    },
                    order: [[ 3, 'asc' ], [ 0, 'asc' ]],
                    dom: 'Bfrtlip',
                    buttons: [
                        'csv', 'excel', 'pdf', 'print', 'copy',
                    ]
            });
        } );
     </script>
    
 </head>

<body>

    <div class="container">
    <header>
        <nav class="navbar fixed-top navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="https://www.transito-ixcateopan.gob.mx/" target="_self"><img src="/imgs/LOGO-GUERRERO.png" width="120" alt="Ixcateopan"></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
              <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="https://www.transito-ixcateopan.gob.mx/" target="_self"><strong>SITIO WEB</strong></a>
                </li>
                <?php
                // if(ISSET($_SESSION["token"])){
                //   echo '  <li class="nav-item">
                //   <a class="nav-link" href="login.php?a=l">Cerrar Sesión</a>
                // </li>';
                // }
                //  else {
                //   echo '  <li class="nav-item">
                //   <a class="nav-link" href="login.php">Ingresar</a>
                // </li>';
                // }
                ?>
              
                <!-- <li class="nav-item">
                  <a class="nav-link" href="#">Cerrar Sesión</a>
                </li> -->
              </ul>
            </div>
          </nav>
    </header>

    <section class="top-element text-center">  
        <?php
        //  echo 'token'.$_SESSION["token"];
        ?>             
      <h1>BIENVENIDOS</h1>
      <h2>DIRECCIÓN DE TRÁNSITO Y MOVILIDAD</h2>
      <h3>PLATAFORMA OFICIAL DE REGISTRO UNICO DE TRAMITES Y SERVICIOS VEHICULARES Y ACCESO A LA INFORMACION PUBLICA DE IXCATEOPAN DE CUAUHTEMOC</h3>
      <p class="mt-2 mb-5">Selecciona la opción que requieres para ingresar:</p>
      <div class="text-center">
          <a type="button" class="btn btn-warning btn-lg" href="login.php?redirectPage=licencias.php"   target="_self">LICENCIAS DE MANEJO</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          <a type="button" class="btn btn-warning btn-lg" href="login.php?redirectPage=permisos.php" target="_self">PERMISOS DE CIRCULACIÓN</a>
      </div>
     

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script async src="./js/validate.js"></script>

  </body>

</html>
