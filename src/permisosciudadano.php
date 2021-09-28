<?php
if(session_status() != PHP_SESSION_ACTIVE ){
    session_start();
  }
?>

<html>
  <head>
    <title>Permisos</title>
    <meta charset="UTF-8">
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;900&display=swap" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link href="css/licencias-styles-front.css" rel="stylesheet">

    <!-- JQUERY only -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
  
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
                        <a class="nav-link" href="https://www.transito-ixcateopan.gob.mx/">< REGRESAR</a>
                        </li>
        
                    </ul>
                    </div>
                </nav>
            </header>
            <div class="login">
            <section class="top-element">               
            <h2>PERMISOS DE CIRCULACIÓN</h2>
            <h3>VERIFICACIÓN PERMISO</h3>
            <!--<p class="mt-2 mb-5">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>-->
            </section>
            <hr class="my-5">
            <section>
            <p class="my-2"><strong>Ingresa tu información:</strong> </p>
            <form  name="form" action="consultapermisociudadano.php"  method="GET">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="" class="form-label">Razón Social/Nombre :</label>
                        <input type="text" class="form-control" id="" aria-describedby="" name="razonSocial" placeholder="Ingresa razón social/nombre">
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="" class="form-label">SERIE:</label>
                        <input type="text" class="form-control" id="" aria-describedby="" name="serie" placeholder="Ingresa tu nombre completo">
                    </div>
                    <div class="col-md-6 mt-4">
                        <button type="submit" class="btn btn-success" name="submit" id="submit">BUSCAR</button>
                    </div>
                </div>
                </form>
            </section>
            </div>
       

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script async src="./js/validate.js"></script>

  </body>

</html>
