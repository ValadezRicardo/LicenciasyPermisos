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
    function create($user){
      $folio=$user["folio"];
      $nombre=$user["nombre"];
      $apellidoPaterno=$user["apellidoPaterno"];
      $apellidoMaterno=$user["apellidoMaterno"];
      $calle=$user["calle"];
      $numero=$user["numero"];
      $colonia=$user["colonia"];
      $municipio=$user["municipio"];
      $estado=$user["estado"];
      $pais=$user["pais"];
      $cp=$user["cp"];
      $CURP=$user["CURP"];
      $tipoLicencia=$user["tipoLicencia"];
      // $vigencia=$user["vigencia"];
      $expedicion=$user["expedicion"];
      $vencimiento=$user["vencimiento"];
      $antiguedad=$user["antiguedad"];
      $nacionalidad=$user["nacionalidad"];
      $grupoSanguineo=$user["grupoSanguineo"];
      $donadorOrganos=$user["donadorOrganos"];
      $alergiasMedicamento=$user["alergiasMedicamento"];
      $referencias=$user["referencia"];
 

      $image = $_FILES['foto']['tmp_name'];
      $foto = addslashes(file_get_contents($image));

      $image = $_FILES['fotoIdentificacion']['tmp_name'];
      $fotoIdentificacion = addslashes(file_get_contents($image));

      $image = $_FILES['fotoFirma']['tmp_name'];
      $fotoFirma = addslashes(file_get_contents($image));

      $info= DecryptedVal($_SESSION["token"]);
      $data=explode(",", $info);
      $user_id= $data[0];

      $q=execQuery("SELECT IFNULL(MAX(folio),0)+1 nextFolio FROM licencia where usuario_id=$user_id and id_prefijo=0");
      while ($row = mysqli_fetch_array($q)) {
        $nextFolio=$row["nextFolio"];
      }
      
      $q2=execQuery("SELECT 1 isValid FROM licenciarangos WHERE usuario_id=$user_id and deleted =0  and $nextFolio BETWEEN rangoInicial AND rangoFinal  and active=1");
     
      while ($row = mysqli_fetch_array($q2)) {
        $isValid=$row["isValid"];
      }

      if($isValid!=1){
        $q3=execQuery("SELECT rangoInicial FROM licenciarangos WHERE usuario_id=$user_id and deleted =0 and rangoInicial >$nextFolio  and active=1 ORDER BY rangoInicial asc LIMIT 1");
        while ($row = mysqli_fetch_array($q3)) {
          $nextFolio=$row["rangoInicial"];
        }
      }
      
      $info= DecryptedVal($_SESSION["token"]);
      $data=explode(",", $info);
      $user_id= $data[0];


      $q=execQuery("INSERT INTO licencia(id_prefijo,folio,nombre,apellidoPaterno,apellidoMaterno,calle,numero,colonia,municipio,estado,pais,cp,CURP,
      tipoLicencia,expedicion,vencimiento,antiguedad,nacionalidad,grupoSanguineo,
      donadorOrganos,alergiasMedicamento,referencia,foto,fotoIdentificacion,fotoFirma,usuario_id) 
      VALUES(0,'$folio','$nombre','$apellidoPaterno','$apellidoMaterno','$calle','$numero','$colonia','$municipio','$estado','$pais','$cp','$CURP',
      '$tipoLicencia','$expedicion','$vencimiento','$antiguedad','$nacionalidad','$grupoSanguineo',
      '$donadorOrganos','$alergiasMedicamento','$referencias','$foto','$fotoIdentificacion','$fotoFirma','$user_id')");
            echo '<script>window.location="licencias.php"</script>';


  }
  
  function delete($user){
      $id=$user['id'];
      $q=execQuery("UPDATE licencia SET deleted = 1 WHERE id=$id");
      echo '<script>window.location="listadolicencias.php"</script>';

  }
  
  function read($user){
      $_SESSION["id"]=$user['id'];
      $disabled='disabled';
      $id=$_SESSION["id"];
      $q=execQuery("SELECT * FROM licencia WHERE id=$id");
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

  $info= DecryptedVal($_SESSION["token"]);
  $data=explode(",", $info);
  $user_id= $data[0];

  $nextFolio=0;
  $q=execQuery("SELECT IFNULL(MAX(folio),0)+1 nextFolio FROM licencia where usuario_id=$user_id and id_prefijo=0");
  while ($row = mysqli_fetch_array($q)) {
    $nextFolio=$row["nextFolio"];
  }
  
  $q2=execQuery("SELECT 1 isValid FROM licenciarangos WHERE usuario_id=$user_id and deleted =0 and $nextFolio BETWEEN rangoInicial AND rangoFinal  and active=1");
  $isValid=0;
  while ($row = mysqli_fetch_array($q2)) {
    $isValid=$row["isValid"];
  }

  $q2=execQuery("SELECT 1 haveOtherRange FROM licenciarangos WHERE usuario_id=$user_id and deleted =0 and rangoInicial >$nextFolio  and active=1 ORDER BY rangoInicial asc LIMIT 1");
  $haveOtherRange=0;
  while ($row = mysqli_fetch_array($q2)) {
    $haveOtherRange=$row["haveOtherRange"];
  }

  if($isValid==1){
      
    // echo '<script>alert("No tienes folios para registrar");window.location="licencias.php"</script>';

  }
  else{
    if($haveOtherRange==1){
      $q3=execQuery("SELECT rangoInicial FROM licenciarangos WHERE usuario_id=$user_id and deleted =0 and rangoInicial >$nextFolio  and active=1 ORDER BY rangoInicial asc LIMIT 1");
      while ($row = mysqli_fetch_array($q3)) {
        $nextFolio=$row["rangoInicial"];
      }
    }
    else{
        echo '<script>alert("No tienes folios para registrar");window.location="licencias.php"</script>';
      
    
    }


  
  }

  IF(ISSET($_SESSION["licencia"])){
    $licencia=$_SESSION["licencia"];
    UNSET($_SESSION["licencia"]);
  }
  // echo DecryptedVal($_SESSION["token"]);
    ?>

    <section class="top-element">               
      <h2>REGISTRO DE FOLIOS</h2> 
<!--      <h2>PLATAFORMA LICENCIAS</h2>
      <h3>USUARIO QUE PUEDE VER ESTA SECCIÓN: SUPERADMIN, ADMIN, USUARIO</h3>
      <p class="my-5">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>-->
    </section>

    <section class="mb-5">

        <form action="registrolicencias.php?a=c" class="formulario"  method="POST" enctype="multipart/form-data">    <!-- novalidate -->
          <div class="row">
            <div class="col-md-4 mb-3 was-validated">
              <label for="" class="form-label">Número de folio:</label>
              <input type="text" class="form-control" id="" aria-describedby="nombreHelp" placeholder="Número de folio" value="<?php echo $_SESSION["prefijo"].$nextFolio ;?>" name="" required disabled>
              <div class="valid-feedback">Folio a asignar</div>
            </div>
          </div>
          <input style="display:none;" type="text"name="folio" value="<?php echo $nextFolio ;?>">

          <hr class="mt-2 mb-4">
          <div class="row">
            <div class="col-md-4 mb-3 was-validated">
                <label for="nombre" class="form-label">Nombre:</label>
                <input type="text" class="form-control" id="nombre" 
                aria-describedby="nombreHelp" placeholder="Nombre" name="nombre" required>
                <div class="invalid-feedback">Ingresa tu nombre.</div>
                <div class="valid-feedback">¡Muy bien!</div>
            </div>
            <div class="col-md-4 mb-3 was-validated">
              <label for="nombre" class="form-label">Apellido Paterno:</label>
              <input type="text" class="form-control" id="apellidopaterno" aria-describedby="nombreHelp" placeholder="Apellido paterno" name="apellidoPaterno" required>
              <div class="invalid-feedback">Ingresa tu apellido paterno.</div>
              <div class="valid-feedback">¡Muy bien!</div>
            </div>
            <div class="col-md-4 mb-3 was-validated">
              <label for="nombre" class="form-label">Apellido Materno:</label>
              <input type="text" class="form-control" id="apellidomaterno" aria-describedby="nombreHelp" placeholder="Apellido materno" name="apellidoMaterno" required>
              <div class="invalid-feedback">Ingresa tu apellido materno.</div>
              <div class="valid-feedback">¡Muy bien!</div>
            </div>
          </div>
          <hr class="mt-2 mb-4">
          <div class="row">
            <p><strong>DOMICILIO:</strong></p>
            <div class="col-md-6 mb-3 was-validated">
              <label for="" class="form-label">Calle o Avenida:</label>
              <input type="text" class="form-control" id="" aria-describedby="nombreHelp" placeholder="Calle o Avenida" name="calle" required>
              <div class="invalid-feedback">Ingresa el dato.</div>
              <div class="valid-feedback">¡Muy bien!</div>
            </div>
            <div class="col-md-2 mb-3 was-validated">
              <label for="" class="form-label">Número:</label>
              <input type="text" class="form-control" id="" aria-describedby="nombreHelp" placeholder="Número" name="numero" required>
              <div class="invalid-feedback">Ingresa el dato.</div>
              <div class="valid-feedback">¡Muy bien!</div>
            </div>
            <div class="col-md-4 mb-3 was-validated">
              <label for="" class="form-label">Colonia:</label>
              <input type="text" class="form-control" id="" aria-describedby="nombreHelp" placeholder="Colonia" name="colonia" required>
              <div class="invalid-feedback">Ingresa el dato.</div>
              <div class="valid-feedback">¡Muy bien!</div>
            </div>
            <div class="col-md-6 mb-3 was-validated">
              <label for="" class="form-label">Municipio:</label>
              <input type="text" class="form-control" id="" aria-describedby="nombreHelp" placeholder="Municipio" name="municipio" required>
              <div class="invalid-feedback">Ingresa el dato.</div>
              <div class="valid-feedback">¡Muy bien!</div>
            </div>
            <div class="col-md-6 mb-3">
              <label for="" class="form-label">Estado:</label>
              <!--<input type="text" class="form-control" id="" aria-describedby="nombreHelp" placeholder="Guerrero" name="estado" value="Guerrero" disabled>
              <input type="text" class="form-control" id="" aria-describedby="nombreHelp" placeholder="Guerrero" name="estado" value="Guerrero" style="display:none;">-->
                <select class="form-control" id="" name="estado">
                <option>Selecciona &#187;</option>
                <option>Aguascalientes</option>
                <option>Baja California</option>
                <option>Baja California Sur</option>
                <option>Campeche</option>
                <option>Chiapas</option>
                <option>Chihuahua</option>
                <option>Ciudad de México</option>
                <option>Coahuila</option>
                <option>Colima</option>
                <option>Durango</option>
                <option>Guanajuato</option>
                <option>Guerrero</option>
                <option>Hidalgo</option>
                <option>Jalisco</option>
                <option>México</option>
                <option>Michoacán</option>
                <option>Morelos</option>
                <option>Nayarit</option>
                <option>Nuevo León</option>
                <option>Oaxaca</option>
                <option>Puebla</option>
                <option>Querétaro</option>
                <option>Quintana Roo</option>
                <option>San Luis Potosí</option>
                <option>Sinaloa</option>
                <option>Sonora</option>
                <option>Tabasco</option>
                <option>Tamaulipas</option>
                <option>Tlaxcala</option>
                <option>Veracruz</option>
                <option>Yucatán</option>
                <option>Zacatecas</option>
              </select>

            </div>
            <div class="col-md-6 mb-3">
              <label for="" class="form-label">País:</label>
              <input type="text" class="form-control" id="" aria-describedby="nombreHelp" placeholder="México" name="pais" value="México" disabled>
              <input type="text" class="form-control" id="" aria-describedby="nombreHelp" placeholder="México" name="pais" value="México" style="display:none;">

            </div>
            <div class="col-md-6 mb-3 was-validated">
              <label for="" class="form-label">Código Postal:</label>
              <input type="text" class="form-control" id="" aria-describedby="nombreHelp" placeholder="Código Postal" name="cp" required>
              <div class="invalid-feedback">Ingresa el dato.</div>
              <div class="valid-feedback">¡Muy bien!</div>
            </div>
          </div>
          <hr class="mt-2 mb-4">
          <div class="row">
            <div class="col-md-4 mb-3 was-validated">
              <label for="" class="form-label">CURP/RFC:</label>
              <input type="text" class="form-control" id="" aria-describedby="nombreHelp" placeholder="CURP/RFC" name="CURP" required>
              <div class="invalid-feedback">Ingresa tu CURP/RFC.</div>
              <div class="valid-feedback">¡Muy bien!</div>
            </div>
            <div class="col-md-4 mb-3">
              <label for="" class="form-label">Tipo de licencia:</label>
              <select class="form-control" id="" name="tipoLicencia">
                <option>Selecciona &#187;</option>
                <option>Chofer</option>
                <option>Automovilista</option>
                <option>Motociclista</option>
                <option>Automovilista (menor de edad)</option>
                <option>Motociclista (menor de edad)</option>
              </select>
            </div>
          </div>
          <hr class="mt-2 mb-4">
          <div class="row">
            <div class="col-md-4 mb-3 was-validated">
              <label for="" class="form-label">Expedición:</label>
              <input type="date" class="form-control" id="" aria-describedby="nombreHelp" placeholder="Expedición" value="<?php echo date("Y-m-d");?>" disabled>
              <input type="date" class="form-control" style="display:none;" id="" aria-describedby="nombreHelp" placeholder="Expedición" name="expedicion" value="<?php echo date("Y-m-d");?>" required>
              <div class="invalid-feedback">Ingresa la fecha.</div>
              <div class="valid-feedback">¡Muy bien!</div>
            </div>
            <div class="col-md-4 mb-3 was-validated">
              <label for=" class="form-label">Vencimiento:</label>
              <input type="date" class="form-control" id="a" aria-describedby="nombreHelp" placeholder="Vencimiento" name="vencimiento" required>
              <div class="invalid-feedback">Ingresa la fecha.</div>
              <div class="valid-feedback">¡Muy bien!</div>
            </div>
            <div class="col-md-4 mb-3">
              <label for=" class="form-label">Antigüedad:</label>
              <input type="date" class="form-control" id="a" aria-describedby="nombreHelp" placeholder="Antigüedad" name="antiguedad" required>
              <div class="invalid-feedback">Ingresa la fecha.</div>
              <div class="valid-feedback">¡Muy bien!</div>
              </select>
            </div>
            <div class="col-md-4 mb-3">
              <label for="" class="form-label">Nacionalidad:</label>
              <select class="form-control" id="" name="nacionalidad">
                <option>Selecciona &#187;</option>
                <option>Mexicana</option>
                <option>Extranjero</option>
              </select>
            </div>
            <div class="col-md-4 mb-3">
              <label for="" class="form-label">Grupo sanguíneo:</label>
              <select class="form-control" id="e" name="grupoSanguineo">
                <option>Selecciona &#187;</option>
                <option>A+</option>
                <option>A</option>
                <option>0+</option>
                <option>0-</option>
                <option>B+</option>
                <option>B-</option>
                <option>AB+</option>
                <option>AB-</option>
                <option>XX</option>
              </select>
            </div>
            <div class="col-md-4 mb-3">
              <label for="" class="form-label">Donador de órganos:</label>
              <select class="form-control" id="" name="donadorOrganos">
                <option>Selecciona &#187;</option>
                <option>No</option>
                <option>Si</option>
              </select>
            </div>
            <div class="col-md-4 mb-3">
              <label for="" class="form-label">Alergias medicamentos:</label>
              <input type="text" class="form-control" id="" aria-describedby="nombreHelp" placeholder="Alergia a..." name="alergiasMedicamento" required>
            </div>
          </div>
          <hr class="mt-2 mb-4">
          <div class="row">
            <div class="col-md-12 mb-3 was-validated">
              <label for="" class="form-label">Referencia familiar:</label>
              <textarea class="form-control" id="" aria-describedby="nombreHelp" placeholder="Nombre completo, domicilio y teléfono" name="referencia" required></textarea>
              <div class="invalid-feedback">Ingresa la referencia.</div>
              <div class="valid-feedback">¡Muy bien!</div>
            </div>
          </div>
          <hr class="mt-2 mb-4">
          <div class="row">
            <div class="col-md-4 mb-3">
              <label class="mb-2" for="exampleFormControlFile1">Identificación o CURP: (jpg, gif, bmp, png)</label>
              <input type="file" class="form-control-file" id="exampleFormControlFile1" name="fotoIdentificacion" required>
            </div>
            <div class="col-md-4 mb-3">
              <label class="mb-2" for="exampleFormControlFile1">Firma: (jpg, gif, bmp, png)</label>
              <input type="file" class="form-control-file" id="exampleFormControlFile1" name="fotoFirma" required>
            </div>
            <div class="col-md-4 mb-3">
              <label class="mb-2" for="exampleFormControlFile1">Foto: (jpg, gif, bmp, png)</label>
              <input type="file" class="form-control-file" id="exampleFormControlFile1" name="foto" required> 
            </div>
            <hr class="my-5">
            <div class="col-md-6">
                <button type="submit" class="btn btn-warning" name="submit" id="submit">CANCELAR</button>
                <button type="submit" class="btn btn-success" name="submit" id="submit">GUARDAR</button>
            </div>
          </div>
        </form>

    </section>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  <script async src="./js/validate.js"></script>
  <script>
        $("input[type='file']").change(function(){
            var tamaño=this.files[0].size;
            if(tamaño>5000000){
                alert("El tamaño de la imagen supera los 5 MB");
                $(this).val("");
            }
            if (!(/\.(jpg|png|gif)$/i).test(this.files[0].name)) {
                  alert('El archivo a adjuntar no es una imagen');
                  $(this).val("");
               }
        })
  </script>
<style>






</style>
  </body>


</html>
        