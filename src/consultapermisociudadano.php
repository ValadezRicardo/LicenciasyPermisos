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
    <link rel="icon" type="image/png" href="/favicon.png">

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
                  <a class="nav-link" href="./">< REGRESAR</a>
                </li>
              </ul>
            </div>
          </nav>
    </header>
    <div class="login">
    <section class="top-element">               
      <h1>PERMISOS</h1>
      <h2>TU INFORMACI??N</h2>
      <p class="mt-2 mb-5"></p>
    </section>
    <hr class="my-5">
    <section>
    <?php
            require "phpqrcode/qrlib.php";   
            include_once 'utilities.php';
            $folio='';
            $nombre='';
            $apellidoPaterno='';
            $apellidoMaterno='';

            if(ISSET($_GET['folio'])&&ISSET($_GET['prefix'])){
                $folio=$_GET['folio'];
                $prefix=$_GET['prefix'];
                $query="SELECT * FROM permiso p join permisoprefijo pp on pp.id=p.id_prefijo WHERE p.folio='$folio' and pp.descripcion='$prefix'";
            }
            
            if(ISSET($_GET['razonSocial'])&&ISSET($_GET['serie'])){
                $razonSocial=$_GET['razonSocial'];
                $serie=$_GET['serie'];
                $query="SELECT * FROM permiso WHERE razonSocial='$razonSocial' or serie='$serie'";
            }

            
            // $query="SELECT * FROM permiso WHERE razonSocial='$razonSocial' or serie='$serie'";
            if( $query==""){
              echo '';
            }else{
              $q=execQueryP($query,true);
            }

            
            //Declaramos una carpeta temporal para guardar la imagenes generadas
            $dir = 'temp/';

            //Si no existe la carpeta la creamos
            if (!file_exists($dir))
                mkdir($dir);

                //Declaramos la ruta y nombre del archivo a generar
            $filename = $dir.'test.png';

                //Parametros de Condiguraci??n

            $tama??o = 8; //Tama??o de Pixel
            $level = 'L'; //Precisi??n Baja
            $framSize = 3; //Tama??o en blanco
            $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

            $contenido = $actual_link; //Texto

                //Enviamos los parametros a la Funci??n para generar c??digo QR 
            // QRcode::png($contenido, $filename, $level, $tama??o, $framSize); 
           
                //Mostramos la imagen generada
             $count=0;
            while ($row = mysqli_fetch_array($q)) {
                $count++;
                 echo '<div id="qrcodeTable" style="padding-left: 25%;"></div><hr/>'; 
                  echo '
                    <p class="my-2"><strong>Raz??n Social/Nombre:</strong> '.$row["razonSocial"].'</p>
                    <p class="my-2"><strong>Marca:</strong>'.$row["marca"].'</p>
                    <p class="my-2"><strong>Line:</strong> '.$row["linea"].'</p>
                    <p class="my-2"><strong>Serie:</strong> '.$row["serie"].'</p>
                    <p class="my-2"><strong>Vencimiento:</strong> '.$row["vencimiento"].'</p>
                    <p class="my-2"><strong>DV:</strong> '.$row["dv"].'</p>
                    ';
                }
                if($count<1){
                    echo '<p class="my-2"><strong>No se encontro informaci??n con los filtros proporcionados,</strong></p>
                          <p class="my-2"><strong>favor de intentar nuevamente</strong></p>
                        ';
                }
      ?>
    </section>
    </div>
    <script src="qrencode.js"></script>
    <script src="jqueryqrencode.js"></script>
    
    <script>
      jQuery('#qrcodeTable').qrcode({
		render	: "table",
		text	: "<?php echo "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";?>"
	});	
      </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script async src="./js/validate.js"></script>

  </body>

</html>



