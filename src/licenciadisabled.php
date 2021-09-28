<?php
if(session_status() != PHP_SESSION_ACTIVE ){
  session_start();
}
include_once 'utilities.php';
?>

<html>
  <head>
    <title>Licencias</title>
    <meta charset="UTF-8">
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;900&display=swap" rel="stylesheet">
    <link href="css/reset-boot.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet">

    <!-- JQUERY only -->
    
 </head>

<body>

    <div class="container">
    <?php
    include_once 'headerlicencias.php';

  function read($user){
      $_SESSION["id"]=$user['id'];
      $disabled='disabled';
      $id=$_SESSION["id"];
      $q=execQuery("SELECT l.*,lp.descripcion as prefijo FROM licencia l left join licenciaprefijo lp on l.id_prefijo=lp.id WHERE l.id=$id");
      while ($row = mysqli_fetch_array($q)) {
        $_SESSION["licencia"]=$row;
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
<!--      <h2>PLATAFORMA LICENCIAS</h2>
      <h3>USUARIO QUE PUEDE VER ESTA SECCIÓN: SUPERADMIN, ADMIN, USUARIO</h3>
      <p class="my-5">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
      </p>-->
      
    <p><a type="button" class="btn btn-success" href="listadolicencias.php">Regresar al Listado</a> 
    </p>
      
       
    </section>
    
    

    <section class="mb-5">

        <form action="registrolicencias.php?a=c" class="formulario"  method="POST" enctype="multipart/form-data">    <!-- novalidate -->
          <div class="row">
            <div class="col-md-4 mb-3 was-validated">
              <label for="" class="form-label">Número de folio:</label>
              <input type="text" class="form-control" id="" aria-describedby="nombreHelp" placeholder="Número de folio" <?php if(ISSET($_SESSION["licencia"]))echo 'value="'.$_SESSION["licencia"]["prefijo"].$_SESSION["licencia"]["folio"].'" disabled';?>  name="" required disabled>
              <div class="valid-feedback">Folio a asignar</div>
            </div>
          </div>
          <input style="display:none;" type="text"name="folio" <?php if(ISSET($_SESSION["licencia"]))echo 'value="'.$_SESSION["licencia"]["prefijo"].$_SESSION["licencia"]["folio"].'" disabled';?> >

          <hr class="mt-2 mb-4">
          <div class="row">
            <div class="col-md-4 mb-3 was-validated">
                <label for="nombre" class="form-label">Nombre:</label>
                <input type="text" class="form-control" id="nombre" 
                aria-describedby="nombreHelp" placeholder="Nombre" name="nombre" <?php if(ISSET($_SESSION["licencia"]))echo 'value="'.$_SESSION["licencia"]["nombre"].'" disabled';?> required>
                <div class="invalid-feedback">Ingresa tu nombre.</div>
                <div class="valid-feedback">¡Muy bien!</div>
            </div>
            <div class="col-md-4 mb-3 was-validated">
              <label for="nombre" class="form-label">Apellido Paterno:</label>
              <input type="text" class="form-control" id="apellidopaterno" aria-describedby="nombreHelp" placeholder="Apellido paterno" name="apellidoPaterno" 
              <?php if(ISSET($_SESSION["licencia"]))echo 'value="'.$_SESSION["licencia"]["apellidoPaterno"].'" disabled';?> 
              required>
              <div class="invalid-feedback">Ingresa tu apellido paterno.</div>
              <div class="valid-feedback">¡Muy bien!</div>
            </div>
            <div class="col-md-4 mb-3 was-validated">
              <label for="nombre" class="form-label">Apellido Materno:</label>
              <input type="text" class="form-control" id="apellidomaterno" aria-describedby="nombreHelp"
              <?php if(ISSET($_SESSION["licencia"]))echo 'value="'.$_SESSION["licencia"]["apellidoMaterno"].'" disabled';?> 
              placeholder="Apellido materno" name="apellidoMaterno" required>
              <div class="invalid-feedback">Ingresa tu apellido materno.</div>
              <div class="valid-feedback">¡Muy bien!</div>
            </div>
          </div>
          <hr class="mt-2 mb-4">
          <div class="row">
            <p><strong>DOMICILIO:</strong></p>
            <div class="col-md-6 mb-3 was-validated">
              <label for="" class="form-label">Calle o Avenida:</label>
              <input type="text" class="form-control" id="" aria-describedby="nombreHelp"
              <?php if(ISSET($_SESSION["licencia"]))echo 'value="'.$_SESSION["licencia"]["calle"].'" disabled';?> 
              placeholder="Calle o Avenida" name="calle" required>
              <div class="invalid-feedback">Ingresa el dato.</div>
              <div class="valid-feedback">¡Muy bien!</div>
            </div>
            <div class="col-md-2 mb-3 was-validated">
              <label for="" class="form-label">Número:</label>
              <input type="text" class="form-control" id="" aria-describedby="nombreHelp"
              <?php if(ISSET($_SESSION["licencia"]))echo 'value="'.$_SESSION["licencia"]["numero"].'" disabled';?> 
              placeholder="Número" name="numero" required>
              <div class="invalid-feedback">Ingresa el dato.</div>
              <div class="valid-feedback">¡Muy bien!</div>
            </div>
            <div class="col-md-4 mb-3 was-validated">
              <label for="" class="form-label">Colonia:</label>
              <input type="text" class="form-control" id="" aria-describedby="nombreHelp"
              <?php if(ISSET($_SESSION["licencia"]))echo 'value="'.$_SESSION["licencia"]["colonia"].'" disabled';?> 
              placeholder="Colonia" name="colonia" required>
              <div class="invalid-feedback">Ingresa el dato.</div>
              <div class="valid-feedback">¡Muy bien!</div>
            </div>
            <div class="col-md-6 mb-3 was-validated">
              <label for="" class="form-label">Municipio:</label>
              <input type="text" class="form-control" id="" aria-describedby="nombreHelp"
              <?php if(ISSET($_SESSION["licencia"]))echo 'value="'.$_SESSION["licencia"]["municipio"].'" disabled';?> 
              placeholder="Municipio" name="municipio" required>
              <div class="invalid-feedback">Ingresa el dato.</div>
              <div class="valid-feedback">¡Muy bien!</div>
            </div>
            <div class="col-md-6 mb-3">
              <label for="" class="form-label">Estado:</label>
             <input type="text" class="form-control" id="" aria-describedby="nombreHelp"
              <?php if(ISSET($_SESSION["licencia"]))echo 'value="'.$_SESSION["licencia"]["estado"].'" disabled';?> 
               name="estado" required>

            </div>
            <div class="col-md-6 mb-3">
              <label for="" class="form-label">País:</label>
              <input type="text" class="form-control" id="" aria-describedby="nombreHelp" placeholder="México" name="pais" value="México" disabled>
              <input type="text" class="form-control" id="" aria-describedby="nombreHelp" placeholder="México" name="pais" value="México" style="display:none;">

            </div>
            <div class="col-md-6 mb-3 was-validated">
              <label for="" class="form-label">Código Postal:</label>
              <input type="text" class="form-control" id="" aria-describedby="nombreHelp"
              <?php if(ISSET($_SESSION["licencia"]))echo 'value="'.$_SESSION["licencia"]["cp"].'" disabled';?> 
              placeholder="Código Postal" name="cp" required>
              <div class="invalid-feedback">Ingresa el dato.</div>
              <div class="valid-feedback">¡Muy bien!</div>
            </div>
          </div>
          <hr class="mt-2 mb-4">
          <div class="row">
            <div class="col-md-4 mb-3 was-validated">
              <label for="" class="form-label">CURP:</label>
              <input type="text" class="form-control" id="" aria-describedby="nombreHelp"
              <?php if(ISSET($_SESSION["licencia"]))echo 'value="'.$_SESSION["licencia"]["CURP"].'" disabled';?> 
              placeholder="CURP" name="CURP" required>
              <div class="invalid-feedback">Ingresa tu CURP.</div>
              <div class="valid-feedback">¡Muy bien!</div>
            </div>
            <div class="col-md-4 mb-3">
              <label for="" class="form-label">Tipo de licencia:</label>
              <input type="text" class="form-control" id="" aria-describedby="nombreHelp"
              <?php if(ISSET($_SESSION["licencia"]))echo 'value="'.$_SESSION["licencia"]["tipoLicencia"].'" disabled';?> 
              placeholder="CURP" name="CURP" required>

            </div>
          </div>
          <hr class="mt-2 mb-4">
          <div class="row">
            <div class="col-md-4 mb-3 was-validated">
              <label for="" class="form-label">Expedición:</label>
              <input type="date" class="form-control" id="" aria-describedby="nombreHelp"
              <?php if(ISSET($_SESSION["licencia"]))echo 'value="'.$_SESSION["licencia"]["expedicion"].'" disabled';?> 
              placeholder="Expedición" name="expedicion" required>
              <div class="invalid-feedback">Ingresa la fecha.</div>
              <div class="valid-feedback">¡Muy bien!</div>
            </div>
            <div class="col-md-4 mb-3 was-validated">
              <label for=" class="form-label">Vencimiento:</label>
              <input type="date" class="form-control" id="a" aria-describedby="nombreHelp"
              <?php if(ISSET($_SESSION["licencia"]))echo 'value="'.$_SESSION["licencia"]["vencimiento"].'" disabled';?> 
              placeholder="Vencimiento" name="vencimiento" required>
              <div class="invalid-feedback">Ingresa la fecha.</div>
              <div class="valid-feedback">¡Muy bien!</div>
            </div>
            <div class="col-md-4 mb-3">
              <label for=" class="form-label">Antigüedad:</label>
              <input type="date" class="form-control" id="a" aria-describedby="nombreHelp"
              <?php if(ISSET($_SESSION["licencia"]))echo 'value="'.$_SESSION["licencia"]["antiguedad"].'" disabled';?> 
              placeholder="Antigüedad" name="antiguedad" required>
              <div class="invalid-feedback">Ingresa la fecha.</div>
              <div class="valid-feedback">¡Muy bien!</div>
              </select>
            </div>
            <div class="col-md-4 mb-3">
              <label for="" class="form-label">Nacionalidad:</label>
              <input type="text" class="form-control" id="a" aria-describedby="nombreHelp"
              <?php if(ISSET($_SESSION["licencia"]))echo 'value="'.$_SESSION["licencia"]["nacionalidad"].'" disabled';?> 
              placeholder="Antigüedad" name="antiguedad" required>
            </div>
            <div class="col-md-4 mb-3">
              <label for="" class="form-label">Grupo sanguíneo:</label>
              <input type="text" class="form-control" id="a" aria-describedby="nombreHelp"
              <?php if(ISSET($_SESSION["licencia"]))echo 'value="'.$_SESSION["licencia"]["grupoSanguineo"].'" disabled';?> 
              placeholder="Antigüedad" name="antiguedad" required>
            </div>
            <div class="col-md-4 mb-3">
              <label for="" class="form-label">Donador de órganos:</label>
              <input type="text" class="form-control" id="a" aria-describedby="nombreHelp"
              <?php if(ISSET($_SESSION["licencia"]))echo 'value="'.$_SESSION["licencia"]["donadorOrganos"].'" disabled';?> 
              placeholder="Antigüedad" name="antiguedad" required>
            </div>
            <div class="col-md-4 mb-3">
              <label for="" class="form-label">Alergias medicamentos:</label>
              <input type="text" class="form-control" id="" aria-describedby="nombreHelp" 
              <?php if(ISSET($_SESSION["licencia"]))echo 'value="'.$_SESSION["licencia"]["alergiasMedicamento"].'" disabled';?> 
              placeholder="Alergia a..." name="alergiasMedicamento" required>
            </div>
          </div>
          <hr class="mt-2 mb-4">
          <div class="row">
            <div class="col-md-12 mb-3 was-validated">
              <label for="" class="form-label">Referencia familiar:</label>
              <textarea disabled class="form-control" id="" aria-describedby="nombreHelp" placeholder="Nombre completo, domicilio y teléfono" name="referencia" required><?php if(ISSET($_SESSION["licencia"]))echo ''.$_SESSION["licencia"]["referencia"].'';?> 
              </textarea>
              <div class="invalid-feedback">Ingresa la referencia.</div>
              <div class="valid-feedback">¡Muy bien!</div>
            </div>
          </div>
          <hr class="mt-2 mb-4">
          <div class="row">
            <div class="col-md-4 mb-3">
              <?php 
              if($_SESSION["licencia"]["fotoIdentificacion"]!="")
              echo '<img style="width:100%;cursor:pointer;" onclick="zoom(this)"  src="data:image/png;base64,'.base64_encode($_SESSION["licencia"]["fotoIdentificacion"]) .'">';
              ?>
            
              <!-- <label class="mb-2" for="exampleFormControlFile1">Identificación o CURP: (jpg, gif, bmp, png)</label>
              <input type="file" class="form-control-file" id="exampleFormControlFile1" name="fotoIdentificacion"> -->
            </div>
            <div class="col-md-4 mb-3">
            <?php 
              if($_SESSION["licencia"]["fotoIdentificacion"]!="")
              echo '<img style="width:100%;cursor:pointer;" onclick="zoom(this)" src="data:image/png;base64,'.base64_encode($_SESSION["licencia"]["fotoFirma"]) .'">';
              ?>
              <!-- <label class="mb-2" for="exampleFormControlFile1">Firma: (jpg, gif, bmp, png)</label>
              <input type="file" class="form-control-file" id="exampleFormControlFile1" name="fotoFirma"> -->
            </div>
            <div class="col-md-4 mb-3">
            <?php 
              if($_SESSION["licencia"]["fotoIdentificacion"]!="")
              echo '<img style="width:100%;cursor:pointer;" onclick="zoom(this)" src="data:image/png;base64,'.base64_encode($_SESSION["licencia"]["foto"]) .'">';
              ?>
              <!-- <label class="mb-2" for="exampleFormControlFile1">Foto: (jpg, gif, bmp, png)</label>
              <input type="file" class="form-control-file" id="exampleFormControlFile1" name="foto"> -->
            </div>
          </div>
        </form>
   
    </section>
    
    
    <p><a type="button" class="btn btn-success" href="listadolicencias.php">Regresar al Listado</a></p>
    
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
