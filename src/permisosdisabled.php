<?php
if(session_status() != PHP_SESSION_ACTIVE ){
  session_start();
}
include_once 'utilities.php';
?>

<html>
  <head>
    <title>Permisos</title>
    <meta charset="UTF-8">
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;900&display=swap" rel="stylesheet">
    <link href="css/reset-boot.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="/favicon.png">

    <!-- JQUERY only -->
    
 </head>

<body>

    <div class="container">
    <?php
    include_once 'headerpermisos.php';

  function read($user){
      $_SESSION["id"]=$user['id'];
      $disabled='disabled';
      $id=$_SESSION["id"];
      $q=execQueryP("SELECT p.* ,pp.descripcion as prefijo FROM permiso p join permisoprefijo pp on p.id_prefijo=pp.id WHERE p.id=$id");
      while ($row = mysqli_fetch_array($q)) {
        $_SESSION["permiso"]=$row;
      }
  }  
  
  if(ISSET($_GET["a"])){
      switch ($_GET["a"]) {
          case 'c':
              create($_POST);
              unset($_POST);
              break;
          case 'd':
              delete($_POST);
              unset($_POST);
              break;
          case 'r':
              read($_POST);
              unset($_POST);
              break;
          default:
              # code...
              break;
      }


  }
    ?>

    <section class="top-element">               
      <h1>REGISTRO DE FOLIOS</h1> 
      <h2>PLATAFORMA PERMISOS</h2>
      <h3>USUARIO QUE PUEDE VER ESTA SECCIÓN: SUPERADMIN, ADMIN, USUARIO</h3>
      <p class="my-5">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
    </section>
    
     <p><a type="button" class="btn btn-success" href="listadopermisos.php">Regresar al Listado</a></p>

    <section class="mb-5">

        <form action="registropermisos.php?a=c" class="formulario"  method="POST" enctype="multipart/form-data">    <!-- novalidate -->
          <div class="row">
            <div class="col-md-4 mb-3 was-validated">
              <label for="" class="form-label">Número de folio:</label>
              <input type="text" class="form-control" id="" aria-describedby="nombreHelp" placeholder="Número de folio" <?php if(ISSET($_SESSION["permiso"]))echo 'value="'.$_SESSION["permiso"]["prefijo"].$_SESSION["permiso"]["folio"].'" disabled';?>  name="" required disabled>
              <div class="valid-feedback">Folio a asignar</div>
            </div>
          </div>
          <input style="display:none;" type="text"name="folio" <?php if(ISSET($_SESSION["permiso"]))echo 'value="'.$_SESSION["permiso"]["prefijo"].$_SESSION["permiso"]["folio"].'" disabled';?> >

          <hr class="mt-2 mb-4">
          <div class="row">
            <div class="col-md-12 mb-12 was-validated">
                <label for="nombre" class="form-label">Razón Social:</label>
                <input type="text" class="form-control" id="nombre" 
                aria-describedby="nombreHelp" placeholder="Nombre" name="nombre" <?php if(ISSET($_SESSION["permiso"]))echo 'value="'.$_SESSION["permiso"]["razonSocial"].'" disabled';?> required>
                <div class="invalid-feedback">Ingresa tu nombre.</div>
                <div class="valid-feedback">¡Muy bien!</div>
            </div>
  
          </div>
          <hr class="mt-2 mb-4">
          <div class="row">
            <p><strong>DOMICILIO:</strong></p>
            <div class="col-md-6 mb-3 was-validated">
              <label for="" class="form-label">Calle o Avenida:</label>
              <input type="text" class="form-control" id="" aria-describedby="nombreHelp"
              <?php if(ISSET($_SESSION["permiso"]))echo 'value="'.$_SESSION["permiso"]["calle"].'" disabled';?> 
              placeholder="Calle o Avenida" name="calle" required>
              <div class="invalid-feedback">Ingresa el dato.</div>
              <div class="valid-feedback">¡Muy bien!</div>
            </div>
            <div class="col-md-2 mb-3 was-validated">
              <label for="" class="form-label">Número:</label>
              <input type="text" class="form-control" id="" aria-describedby="nombreHelp"
              <?php if(ISSET($_SESSION["permiso"]))echo 'value="'.$_SESSION["permiso"]["numero"].'" disabled';?> 
              placeholder="Número" name="numero" required>
              <div class="invalid-feedback">Ingresa el dato.</div>
              <div class="valid-feedback">¡Muy bien!</div>
            </div>
            <div class="col-md-4 mb-3 was-validated">
              <label for="" class="form-label">Colonia:</label>
              <input type="text" class="form-control" id="" aria-describedby="nombreHelp"
              <?php if(ISSET($_SESSION["permiso"]))echo 'value="'.$_SESSION["permiso"]["colonia"].'" disabled';?> 
              placeholder="Colonia" name="colonia" required>
              <div class="invalid-feedback">Ingresa el dato.</div>
              <div class="valid-feedback">¡Muy bien!</div>
            </div>
            <div class="col-md-6 mb-3 was-validated">
              <label for="" class="form-label">Municipio:</label>
              <input type="text" class="form-control" id="" aria-describedby="nombreHelp"
              <?php if(ISSET($_SESSION["permiso"]))echo 'value="'.$_SESSION["permiso"]["municipio"].'" disabled';?> 
              placeholder="Municipio" name="municipio" required>
              <div class="invalid-feedback">Ingresa el dato.</div>
              <div class="valid-feedback">¡Muy bien!</div>
            </div>
            <div class="col-md-6 mb-3">
              <label for="" class="form-label">Estado:</label>
              <input type="text" class="form-control" id="" aria-describedby="nombreHelp"
              <?php if(ISSET($_SESSION["permiso"]))echo 'value="'.$_SESSION["permiso"]["estado"].'" disabled';?> 
              placeholder="" name="estado" required>


            </div>
            <div class="col-md-6 mb-3">
              <label for="" class="form-label">País:</label>
              <input type="text" class="form-control" id="" aria-describedby="nombreHelp" placeholder="México" name="pais" value="México" disabled>
              <input type="text" class="form-control" id="" aria-describedby="nombreHelp" placeholder="México" name="pais" value="México" style="display:none;">

            </div>
            <div class="col-md-6 mb-3 was-validated">
              <label for="" class="form-label">Código Postal:</label>
              <input type="text" class="form-control" id="" aria-describedby="nombreHelp"
              <?php if(ISSET($_SESSION["permiso"]))echo 'value="'.$_SESSION["permiso"]["cp"].'" disabled';?> 
              placeholder="Código Postal" name="cp" required>
              <div class="invalid-feedback">Ingresa el dato.</div>
              <div class="valid-feedback">¡Muy bien!</div>
            </div>
          </div>
          <hr class="mt-2 mb-4">
          <div class="row">
            <div class="col-md-4 mb-3 was-validated">
              <label for="" class="form-label">RFC:</label>
              <input type="text" class="form-control" id="" aria-describedby="nombreHelp"
              <?php if(ISSET($_SESSION["permiso"]))echo 'value="'.$_SESSION["permiso"]["RFC"].'" disabled';?> 
              placeholder="CURP" name="CURP" required>
              <div class="invalid-feedback">Ingresa tu CURP.</div>
              <div class="valid-feedback">¡Muy bien!</div>
            </div>
            <div class="col-md-4 mb-3">
              <label for="" class="form-label">Marca:</label>
              <input type="text" class="form-control" id="" aria-describedby="nombreHelp"
              <?php if(ISSET($_SESSION["permiso"]))echo 'value="'.$_SESSION["permiso"]["marca"].'" disabled';?> 
              placeholder="CURP" name="CURP" required>

            </div>
            <div class="col-md-4 mb-3">
              <label for="" class="form-label">Linea:</label>
              <input type="text" class="form-control" id="" aria-describedby="nombreHelp"
              <?php if(ISSET($_SESSION["permiso"]))echo 'value="'.$_SESSION["permiso"]["linea"].'" disabled';?> 
              placeholder="CURP" name="CURP" required>

            </div>
          </div>
          <div class="row">
          <div class="col-md-4 mb-3">
              <label for="" class="form-label">Color:</label>
              <input type="text" class="form-control" id="a" aria-describedby="nombreHelp"
              <?php if(ISSET($_SESSION["permiso"]))echo 'value="'.$_SESSION["permiso"]["color"].'" disabled';?> 
              placeholder="Antigüedad" name="antiguedad" required>
            </div>
            <div class="col-md-4 mb-3">
              <label for="" class="form-label">Serie:</label>
              <input type="text" class="form-control" id="a" aria-describedby="nombreHelp"
              <?php if(ISSET($_SESSION["permiso"]))echo 'value="'.$_SESSION["permiso"]["serie"].'" disabled';?> 
              placeholder="Antigüedad" name="antiguedad" required>
            </div>
            <div class="col-md-4 mb-3">
              <label for="" class="form-label">Motor:</label>
              <input type="text" class="form-control" id="" aria-describedby="nombreHelp" 
              <?php if(ISSET($_SESSION["permiso"]))echo 'value="'.$_SESSION["permiso"]["motor"].'" disabled';?> 
              placeholder="Alergia a..." name="alergiasMedicamento" required>
            </div>
            <div class="col-md-4 mb-3">
              <label for="" class="form-label">Año o Modelo:</label>
              <input type="text" class="form-control" id="a" aria-describedby="nombreHelp"
              <?php if(ISSET($_SESSION["permiso"]))echo 'value="'.$_SESSION["permiso"]["anio"].'" disabled';?> 
              placeholder="Antigüedad" name="antiguedad" required>
              <div class="invalid-feedback">Ingresa la fecha.</div>
              <div class="valid-feedback">¡Muy bien!</div>
              </select>
            </div>
            <div class="col-md-4 mb-3 was-validated">
              <label for="" class="form-label">Expedición:</label>
              <input type="date" class="form-control" id="" aria-describedby="nombreHelp"
              <?php if(ISSET($_SESSION["permiso"]))echo 'value="'.$_SESSION["permiso"]["expedicion"].'" disabled';?> 
              placeholder="Expedición" name="expedicion" required>
              <div class="invalid-feedback">Ingresa la fecha.</div>
              <div class="valid-feedback">¡Muy bien!</div>
            </div>
            <div class="col-md-4 mb-3 was-validated">
              <label for="" class="form-label">Vencimiento:</label>
              <input type="date" class="form-control" id="a" aria-describedby="nombreHelp"
              <?php if(ISSET($_SESSION["permiso"]))echo 'value="'.$_SESSION["permiso"]["vencimiento"].'" disabled';?> 
              placeholder="Vencimiento" name="vencimiento" required>
              <div class="invalid-feedback">Ingresa la fecha.</div>
              <div class="valid-feedback">¡Muy bien!</div>
            </div>
          
     
          </div>

          <div class="row">
          <div class="col-md-4 mb-3 was-validated">
              <label for="" class="form-label">Número Factura:</label>
              <input type="text" class="form-control" id="a" aria-describedby="nombreHelp"
              <?php if(ISSET($_SESSION["permiso"]))echo 'value="'.$_SESSION["permiso"]["numeroFactura"].'" disabled';?> 
              placeholder="Vencimiento" name="vencimiento" required>
              <div class="invalid-feedback">Ingresa la referencia.</div>
              <div class="valid-feedback">¡Muy bien!</div>
            </div>
            <div class="col-md-4 mb-3">
              <?php 
              if($_SESSION["permiso"]["fotoIdentificacion"]!="")
              echo '<img style="width:100%;cursor:pointer;" onclick="zoom(this)"  src="data:image/png;base64,'.base64_encode($_SESSION["permiso"]["fotoIdentificacion"]) .'">';
              ?>
            
              <!-- <label class="mb-2" for="exampleFormControlFile1">Identificación o CURP: (jpg, gif, bmp, png)</label>
              <input type="file" class="form-control-file" id="exampleFormControlFile1" name="fotoIdentificacion"> -->
            </div>
            <div class="col-md-4 mb-3">
            <?php 
              if($_SESSION["permiso"]["fotoFactura"]!="")
              echo '<img style="width:100%;cursor:pointer;" onclick="zoom(this)" src="data:image/png;base64,'.base64_encode($_SESSION["permiso"]["fotoFactura"]) .'">';
              ?>
              <!-- <label class="mb-2" for="exampleFormControlFile1">Firma: (jpg, gif, bmp, png)</label>
              <input type="file" class="form-control-file" id="exampleFormControlFile1" name="fotoFirma"> -->
            </div>

          </div>
        </form>
   
    </section>
    
    <p><a type="button" class="btn btn-success" href="listadopermisos.php">Regresar al Listado</a></p>
    
    <div class="modal fade" id="zoomModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Zoom</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style=" text-align: center; ">
        <img id="imgZoom" src="" style="width:100%">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

    <script>
      var x;
      function zoom(elem){
        x=elem;
        $('#imgZoom').attr("src",$(elem).attr("src"));
        $('#zoomModal').modal();
      }
      
    </script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  <script async src="./js/validate.js"></script>

  </body>


</html>
