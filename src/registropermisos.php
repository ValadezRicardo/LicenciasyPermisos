<?php
if(session_status() != PHP_SESSION_ACTIVE ){
  session_start();
}
include_once 'utilities.php';
?>

<html>
  <head>
    <title>PERMISOS</title>
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

 </head>

<body>

    <div class="container">
    <?php
    include_once 'headerpermisos.php';
    function create($user){
      $prefix=$user["prefix"];
      $folio=$user["folio"];
      $razonSocial=$user["razonSocial"];
      $RFC=$user["RFC"];

      $calle=$user["calle"];
      $numero=$user["numero"];
      $colonia=$user["colonia"];
      $municipio=$user["municipio"];
      $estado=$user["estado"];
      $pais=$user["pais"];
      $cp=$user["cp"];

      $marca=$user["marca"];
      $linea=$user["linea"];
      $color=$user["color"];
      $serie=$user["serie"];
      $motor=$user["motor"];
      $anio=$user["anio"];

      $expedicion=$user["expedicion"];
      $vencimiento=$user["vencimiento"];
      $numeroFactura=$user["numeroFactura"];
    
 
      $image = $_FILES['fotoFactura']['tmp_name'];
      $foto = addslashes(file_get_contents($image));

      $image = $_FILES['fotoIdentificacion']['tmp_name'];
      $fotoIdentificacion = addslashes(file_get_contents($image));

    
      $info= DecryptedVal($_SESSION["tokenp"]);
      $data=explode(",", $info);
      $user_id= $data[0];

      // $q=execQueryP("SELECT IFNULL(MAX(folio),0)+1 nextFolio FROM permiso where usuario_id=$user_id and id_prefijo=(select id from permisoprefijo where deleted=0)");
      // while ($row = mysqli_fetch_array($q)) {
      //   $nextFolio=$row["nextFolio"];
      // }
      
      // $q2=execQueryP("SELECT 1 isValid FROM permisorangos WHERE usuario_id=$user_id and deleted =0  and $nextFolio BETWEEN rangoInicial AND rangoFinal  and active=1");
     
      // while ($row = mysqli_fetch_array($q2)) {
      //   $isValid=$row["isValid"];
      // }

      // if($isValid!=1){
      //   $q3=execQueryP("SELECT rangoInicial FROM permisorangos WHERE usuario_id=$user_id and deleted =0 and rangoInicial >$nextFolio  and active=1 ORDER BY rangoInicial asc LIMIT 1");
      //   while ($row = mysqli_fetch_array($q3)) {
      //     $nextFolio=$row["rangoInicial"];
      //   }
      // }
      
      $info= DecryptedVal($_SESSION["tokenp"]);
      $data=explode(",", $info);
      $user_id= $data[0];

      $dv= mt_rand(10,99);
      $q=execQueryP("INSERT INTO permiso(id_prefijo,folio,razonSocial,RFC,calle,numero,colonia,municipio,estado,pais,cp,marca,
      linea,color,serie,motor,anio,expedicion,vencimiento,numeroFactura,
      fotoFactura,fotoIdentificacion,usuario_id,dv) 
      VALUES('$prefix','$folio','$razonSocial','$RFC','$calle','$numero','$colonia','$municipio','$estado','$pais','$cp','$marca',
      '$linea','$color','$serie','$motor','$anio','$expedicion',
      '$vencimiento','$numeroFactura','$foto','$fotoIdentificacion','$user_id','$dv')");
            echo '<script>window.location="permisos.php"</script>';


  }
  
  function delete($user){
      $id=$user['id'];
      $q=execQueryP("UPDATE permiso SET deleted = 1 WHERE id=$id");
      echo '<script>window.location="listadopermisos.php"</script>';

  }
  
  function read($user){
      $_SESSION["id"]=$user['id'];
      $disabled='disabled';
      $id=$_SESSION["id"];
      $q=execQueryP("SELECT * FROM permiso WHERE id=$id");
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

  $info= DecryptedVal($_SESSION["tokenp"]);
  $data=explode(",", $info);
  $user_id= $data[0];

  $nextFolio=0;
  // $q=execQueryP("SELECT IFNULL(MAX(folio),0)+1 nextFolio FROM permiso where usuario_id=$user_id and id_prefijo=(select id from permisoprefijo where deleted=0)");
  // while ($row = mysqli_fetch_array($q)) {
  //   $nextFolio=$row["nextFolio"];
  // }
  
  // $q2=execQueryP("SELECT 1 isValid FROM permisorangos WHERE usuario_id=$user_id and deleted =0 and $nextFolio BETWEEN rangoInicial AND rangoFinal and active=1");
  // $isValid=0;
  // while ($row = mysqli_fetch_array($q2)) {
  //   $isValid=$row["isValid"];
  // }

  // $q2=execQueryP("SELECT 1 haveOtherRange FROM permisorangos WHERE usuario_id=$user_id and deleted =0 and rangoInicial >$nextFolio and active=1 ORDER BY rangoInicial asc LIMIT 1");
  // $haveOtherRange=0;
  // while ($row = mysqli_fetch_array($q2)) {
  //   $haveOtherRange=$row["haveOtherRange"];
  // }

  // if($isValid==1){
      
  //   // echo '<script>alert("No tienes folios para registrar");window.location="permisos.php"</script>';

  // }
  // else{
  //   if($haveOtherRange==1){
  //     $q3=execQueryP("SELECT rangoInicial FROM permisorangos WHERE usuario_id=$user_id and deleted =0 and rangoInicial >$nextFolio ORDER BY rangoInicial asc LIMIT 1");
  //     while ($row = mysqli_fetch_array($q3)) {
  //       $nextFolio=$row["rangoInicial"];
  //     }
  //   }
  //   else{
  //       echo '<script>alert("No tienes folios para registrar");window.location="permisos.php"</script>';
      
    
  //   }


  
  // }

  IF(ISSET($_SESSION["permiso"])){
    $permiso=$_SESSION["permiso"];
    UNSET($_SESSION["permiso"]);
  }
  // echo DecryptedVal($_SESSION["token"]);
    ?>

    <section class="top-element">               
      <h2>REGISTRO DE FOLIOS</h2> 
<!--      <h2>PLATAFORMA PERMISOS</h2>
      <h3>USUARIO QUE PUEDE VER ESTA SECCIÓN: SUPERADMIN, ADMIN, USUARIO</h3>
      <p class="my-5">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>-->
    </section>

    <section class="mb-5">

        <form action="registropermisos.php?a=c" class="formulario"  method="POST" enctype="multipart/form-data">    <!-- novalidate -->
          <div class="row">
          <div class="col-md-4 mb-3 was-validated">
              <label for="" class="form-label">Prefijo:</label>
              <select name="prefix" aria-describedby="prefixHelp" id="prefixSelect" onChange="changePrefix()"  class="form-control"  required>
              </select>
              <!-- <input id="txtPrefix"  style="display:block"/> -->
              <div class="invalid-feedback">Prefijo a asignar</div>
              <div class="valid-feedback">¡Muy bien!</div>
            </div>
            <div class="col-md-4 mb-3 was-validated">
              <label for="" class="form-label">Número de folio:</label>
              <input type="text" class="form-control" id="txtFolioDisplay" aria-describedby="nombreHelp" placeholder="Número de folio" value="" name="" required disabled>
              <div class="valid-feedback">Folio a asignar</div>
            </div>
          </div>
          <input style="display:none;" type="text"name="folio" id="txtFolio" value="" required>

          <hr class="mt-2 mb-4">
          <div class="row">
            <div class="col-md-12 mb-12 was-validated">
                <label for="razonSocial" class="form-label">Razón Social/Nombre:</label>
                <input type="text" class="form-control" id="razonSocial" 
                aria-describedby="razonSocialHelp" placeholder="Razón Social/Nombre" name="razonSocial" required>
                <div class="invalid-feedback">Ingresa tu Razon Social/Nombre.</div>
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
              <input type="text" class="form-control" id="" aria-describedby="nombreHelp" placeholder="CURP/RFC" name="RFC" required>
              <div class="invalid-feedback">Ingresa tu CURP/RFC.</div>
              <div class="valid-feedback">¡Muy bien!</div>
            </div>
            <div class="col-md-4 mb-3 was-validated">
              <label for="" class="form-label">Marca:</label>
              <input type="text" class="form-control" id="" aria-describedby="marcaHelp" placeholder="Marca" name="marca" required>
              <div class="invalid-feedback">Ingresa la Marca.</div>
              <div class="valid-feedback">¡Muy bien!</div>
            </div>
            <div class="col-md-4 mb-3 was-validated">
              <label for="" class="form-label">Línea:</label>
              <input type="text" class="form-control" id="" aria-describedby="lineaHelp" placeholder="Línea" name="linea" required>
              <div class="invalid-feedback">Ingresa la fecha.</div>
              <div class="valid-feedback">¡Muy bien!</div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4 mb-3 was-validated">
              <label for="" class="form-label">Color:</label>
              <input type="text" class="form-control" id="" aria-describedby="colorHelp" placeholder="Color" name="color" required>
              <div class="invalid-feedback">Ingresa el Color</div>
              <div class="valid-feedback">¡Muy bien!</div>
            </div>
            <div class="col-md-4 mb-3 was-validated">
              <label for="" class="form-label">Serie:</label>
              <input type="text" class="form-control" id="" aria-describedby="marcaHelp" placeholder="Serie" name="serie" required>
              <div class="invalid-feedback">Ingresa Serie.</div>
              <div class="valid-feedback">¡Muy bien!</div>
            </div>
            <div class="col-md-4 mb-3 was-validated">
              <label for="" class="form-label">Motor:</label>
              <input type="text" class="form-control" id="" aria-describedby="motorHelp" placeholder="Motor" name="motor" required>
              <div class="invalid-feedback">Ingresa número de motor.</div>
              <div class="valid-feedback">¡Muy bien!</div>
            </div>
          </div>
          <div class="row">
          <div class="col-md-4 mb-3">
              <label for="" class="form-label">Año o Modelo:</label>
              <input type="text" class="form-control" id="" aria-describedby="anioHelp" placeholder="Año o Modelo" name="anio" >
              <!-- <div class="invalid-feedback">Ingresa la fecha.</div> -->
              <!-- <div class="valid-feedback">¡Muy bien!</div> -->
              <!-- </select> -->
            </div>
            <div class="col-md-4 mb-3 was-validated">
              <label for="" class="form-label">Expedición:</label>
              <input type="date" class="form-control" id="" aria-describedby="nombreHelp" placeholder="Expedición" value="<?php echo date("Y-m-d");?>" disabled>
              <input type="date" class="form-control" style="display:none;" id="" aria-describedby="nombreHelp" placeholder="Expedición" name="expedicion" value="<?php echo date("Y-m-d");?>" required>
              <div class="invalid-feedback">Ingresa la fecha.</div>
              <div class="valid-feedback">¡Muy bien!</div>
            </div>
            <div class="col-md-4 mb-3 was-validated">
              <label for="" class="form-label">Vencimiento:</label>
              <input type="date" class="form-control" id="" aria-describedby="nombreHelp" placeholder="Vencimiento" name="vencimiento" required>
              <div class="invalid-feedback">Ingresa la fecha.</div>
              <div class="valid-feedback">¡Muy bien!</div>
            </div>

          <div class="row">
          <div class="col-md-4 mb-3">
              <label for="" class="form-label">Numero de factura, carta factura o pedimento:</label>
              <input type="text" class="form-control" id="" aria-describedby="nombreHelp" placeholder="Número" name="numeroFactura" >
              <!-- <div class="invalid-feedback">Ingresa la fecha.</div>
              <div class="valid-feedback">¡Muy bien!</div> -->
            </div>
            <div class="col-md-4 mb-3">
              <label class="mb-2" for="">Factura: (jpg, gif, bmp, png)</label>
              <input type="file" class="form-control-file" id="" name="fotoFactura" required>
            </div>
            <div class="col-md-4 mb-3">
              <label class="mb-2" for="">Identificación: (jpg, gif, bmp, png)</label>
              <input type="file" class="form-control-file" id="" name="fotoIdentificacion" required> 
            </div>
            <hr class="my-5">
            <div class="col-md-6">
                <button type="submit" class="btn btn-warning" name="submit" id="submit">CANCELAR</button>
                <button type="submit" class="btn btn-success" name="submit" id="submit">GUARDAR</button>
            </div>
          </div>
        </form>

    </section>
<!-- 
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script async src="./js/validate.js"></script> -->
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


          $.ajax({
            method: "GET",
            url: "foliadorPermisos.php?a=getUserPrefix&usuario_id=<?php echo $user_id;?>",
            success:function(a){
              $('#prefixSelect').append("<option value=''>Selecciona un prefijo</option>");

              JSON.parse(a).forEach(function(item){
                  $('#prefixSelect').append("<option data-value='"+item.nextFolio+"' value='"+item.id+"'>"+item.descripcion+"</option>");

              })
            }
          });

    function changePrefix (){
      let nextFolio=$('#prefixSelect>option:selected').attr("data-value");
      $('#txtFolio').val(nextFolio);
      $('#txtFolioDisplay').val(nextFolio);
      // $('#txtPrefix').val($('#prefixSelect').val());
    }
  </script>
<style>






</style>
  </body>


</html>
        