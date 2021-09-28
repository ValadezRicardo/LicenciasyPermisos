<?php

if(session_status() != PHP_SESSION_ACTIVE ){
  session_start();
}
include_once 'utilities.php';

function delete($rango){
    $id=$rango['id'];
    $q=execQueryP("UPDATE permisorangos SET deleted =1 WHERE id=$id");
}

function create($rango){
    $existPrefix=0;
    $q=execQueryP("select 1 as prefix from permisoprefijo where deleted=0");
    while ($row = mysqli_fetch_array($q)) {
        $existPrefix=$row["prefix"];
    }

    if($existPrefix==0){
        echo '<script>alert("No se ha asignado un prefijo");window.location=window.location.origin+window.location.pathname</script>';
        return;
    }
    
    $usuario_id=$rango["usuario_id"];
    $rangoInicial=$rango["rangoInicial"];
    $rangoFinal=$rango["rangoFinal"];
    $prefix=$rango["prefix"];
    execQueryP("UPDATE permisorangos SET deletedPermission=0 WHERE usuario_id=$usuario_id");
    $q=execQueryP("INSERT INTO permisorangos(usuario_id,rangoInicial,rangoFinal,deletedPermission,permisoprefijo_id) 
    VALUES('$usuario_id','$rangoInicial','$rangoFinal',1,'$prefix')");
echo '<script>window.location=window.location.origin+window.location.pathname</script>';

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
        default:
            # code...
            break;
    }



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

            $('#FoliosPermisos').DataTable( {
                    language: {
                        url: 'https://cdn.datatables.net/plug-ins/1.10.22/i18n/Spanish.json'
                    },
                    order: [[ 2, 'desc' ]],
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
    <?php
    include_once 'headerpermisos.php';
    ?>

    <section class="top-element">               
      <h2>ASIGNACIÓN DE FOLIOS</h2>
<!--      <h2>PLATAFORMA Permisos</h2>
      <h3>USUARIO QUE PUEDE VER ESTA SECCIÓN: SUPERADMIN Y ADMIN</h3>
      <p class="mt-2 mb-5">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>-->
      <form action="asignacionfoliopermisos.php?a=c" method="POST">
        <div class="row">
            <div class="col-md-3 mb-3">
                <label for="" class="form-label">Usuario:</label>
                <select class="form-control" name="usuario_id">
                <?php
                $q=execQueryP("select * from usuariop where deleted=0");
                 while ($row = mysqli_fetch_array($q)) {
                     echo '<option value="'.$row["id"].'">'.$row["nombre"].'</option>';
                 }
                 ?>
                </select>
            </div>
            <div class="col-md-3 mb-3">
                <label for="" class="form-label">Prefijo</label>  
                <select id="prefixSelect" onChange="changePrefix()"  class="form-control" name="prefix"></select>
            </div>
            <div class="col-md-3 mb-3">
                <label for="" class="form-label">Folio inicial</label>
                <?php
                // $q=execQueryP("SELECT IFNULL(MAX(rangoFinal),0)+1 as folio FROM permisorangos where active=1");
                //  while ($row = mysqli_fetch_array($q)) {
                //      $folio=$row["folio"];
                //  }
                //  $_SESSION["prefijop"]="";
                //  $folio=str_pad($folio,5,'0',STR_PAD_LEFT);
                 echo '<div class="col-md-12"><input disabled type="number" class="form-control" style="width:90%" id="txtrangoInicialDisplay" aria-describedby="emailHelp" value="" ></div>';
                 echo '<input style="display:none;" type="number" id="txtrangoInicial" name="rangoInicial" class="form-control" id="" aria-describedby="emailHelp" placeholder="0000" value="" required>';

                ?>
               
              
            </div>
            <div class="col-md-3 mb-3">
                <label for="" class="form-label">Folio final</label>
                <?php
                // $folio++;
                echo '<div class="col-md-12"><input  style="width:90%"  type="number" id="txtrangoFinal" name="rangoFinal" class="form-control" id="" aria-describedby="emailHelp" placeholder="Ingresa folio" required></div>';

                 ?>
            </div>
            <div class="col-md-6">
                <!-- <button type="submit" class="btn btn-warning" name="submit" id="submit">CANCELAR</button> -->
                <button type="submit" class="btn btn-success" name="submit" id="submit">GUARDAR</button>
            </div>
        </div>
        </form>
    </section>
    <hr class="my-5">
    <section class="mb-5">
        <h2>FOLIOS ASIGNADOS</h2>
<!--        <h2 class="mb-5">SUPERADMIN Y ADMIN</h2>-->
        <table id="FoliosPermisos" class="display table table-striped" style="width:100%">
            <thead>
                <tr>
                    <th>Nombre usuario</th>
                    <th>Prefijo</th>
                    <th># inicial</th>
                    <th># final</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                 <?php
                $q=execQueryP("SELECT r.*,u.nombre,pp.descripcion as prefix FROM permisorangos r LEFT JOIN usuariop u on r.usuario_id=u.id LEFT JOIN permisoprefijo pp on pp.id=r.permisoprefijo_id order by r.id");
                $_SESSION["prefijop"]="";
                 while ($row = mysqli_fetch_array($q)) {
                     echo '<tr';
                     if($row["deleted"]==1){
                        echo ' class="deleted"';
                    }
                     echo '>
                     <td>'.$row["nombre"].'</td>
                     <td>'.$row["prefix"].'</td>
                     <td>'.$_SESSION["prefijop"].$row["rangoInicial"].'</td>
                     <td>'.$_SESSION["prefijop"].$row["rangoFinal"].'</td>
                     <td>';
                    if($row["deletedPermission"]==1){
                        if($row["deleted"]==0){
                        echo '<i class="fas fa-trash fa-icon-eliminar" onclick="Delete('.$row["id"].','."'".$row["nombre"]."'".')"></i>';
                        }
                    }
                    echo '</td>
                 </tr>';
                 }
                 ?>
            </tbody>
        </table>
    </section>
    <form action="asignacionfoliopermisos.php?a=d" style="display:none;" method="POST"> 
        <input type="text" name="id" id="deleteid"/>
        <button type="submit" id="submitdelete"></button>
    </form>

    <script>
        
    function Delete(id, nombre){
            $("#deleteid").val(id);
            var res=confirm("Deseas eliminar los folios asignados a "+ nombre); 
            if(res){
                $('#submitdelete').click();
            }

        }
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script async src="./js/validate.js"></script>
    <style>

.deleted,.deleted td[class^='sorting_']{
  background-color:red!important;
}
</style>
<script>
$.ajax({
  method: "GET",
  url: "foliadorPermisos.php?a=getPrefixs",
  success:function(a){
    $('#prefixSelect').append("<option value=''>Selecciona un prefijo</option>");

    JSON.parse(a).forEach(function(item){
        $('#prefixSelect').append("<option value='"+item.id+"'>"+item.descripcion+"</option>");

    })
  }
});

function changePrefix(){
  $.ajax({
  method: "GET",
  url: "foliadorPermisos.php?a=nextFolio&prefixId="+$('#prefixSelect').val(),
  success:function(a){
    $('#txtrangoInicial').val(a)
    $('#txtrangoInicialDisplay').val(a)
    $('#txtrangoFinal').attr("min",a)
  }
});

}
</script>
  </body>

</html>
