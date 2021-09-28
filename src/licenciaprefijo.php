<?php
if(session_status() != PHP_SESSION_ACTIVE ){
    session_start();
  }
include_once 'utilities.php';

function create($prefijo){

    $desc=$prefijo["descripcion"];
    execQuery("update licenciaprefijo set  deleted=1");
    $q=execQuery("INSERT INTO licenciaprefijo(descripcion) 
    VALUES('$desc')");

    $q=execQuery("UPDATE licenciarangos set active = 0");
    echo '<script>window.location=window.location.origin+window.location.pathname</script>';

}

function delete($prefijo){
    $id=$prefijo['id'];
    $q=execQuery("UPDATE licenciaprefijo SET deleted=1 WHERE id=$id");
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
                    order: [[ 0, 'desc' ]],
                    pageLength: 50,
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
    if(isset($_SESSION["redirectPage"])){
        if($_SESSION["redirectPage"]=="permisos.php"){
            include_once 'headerpermisos.php';
        }
        else{
            include_once 'headerlicencias.php';

        }
    }
  
    ?>
        <hr class="my-5">
    <section class="mb-5">
    <h1>PREJIJO</h1>
<!--      <h2>PLATAFORMA LICENCIAS</h2>
      <h3>USUARIO QUE PUEDE VER ESTA SECCIÓN: SUPERADMIN</h3>-->
        <h1>NUEVO PREFIJO</h1>
        <form class="my-5" action="licenciaprefijo.php?a=c"  method="POST" style="margin-top:0px!important">
            <div class="row">
                <div class="col-md-6 mb-3 was-validated" >
                    <label for="" class="form-label">Descripción:</label>
                    <input type="text" class="form-control" name="descripcion" aria-describedby="emailHelp" placeholder="Descipción del prefijo" required>
                    <div class="invalid-feedback">Ingresa el prefijo.</div>
                    <div class="valid-feedback">¡Muy bien!</div>
                </div>
                <div class="col-md-6">
                    <!-- <button type="submit" class="btn btn-warning" name="submit" id="submit">CANCELAR</button> -->
                    <button type="submit" class="btn btn-success" name="submit" id="submit">GUARDAR</button>
                </div>
                </div>
          </form>
    </section>

    <section class="top-element" style="margin-top:5px!important">                
        <table id="FoliosLicencias" class="display table table-striped" style="width:100%">
            <thead>
                <tr>
                    <!--<th>Id</th>-->
                    <th>Descripcion</th>
                    <!-- <th>Acciones</th> -->
                </tr>
            </thead>
            <tbody>
            <?php
                 $q=execQuery("SELECT * FROM licenciaprefijo order by id desc");
                 while ($row = mysqli_fetch_array($q)) {

                    echo '<tr';
                    if($row["deleted"]==1){
                        echo ' class="deleted"';
                    }
                
                    echo '>
                    <td>'.$row["descripcion"].'</td>
                    <td>';
                   
                    // if($row["deleted"]==0){
                    // echo '
                    // <i class="fas fa-trash fa-icon-eliminar" onclick="prefijoDelete('.$row["id"].','."'".$row["descripcion"]."'".')"></i>';
                    // }
                   
                    echo '</td>
                </tr>';
                }
                
                ?>
                
             
            </tbody>
        </table>
    </section>

    
    <form action="licenciaprefijo.php?a=d" style="display:none;"  method="POST"> 
        <input type="text" name="id" id="deleteid"/>
        <button type="submit" id="submitdelete"></button>
    </form>

    <script>

        function prefijoDelete(id,nombre){
            $("#deleteid").val(id);
            var res=confirm("Desea eliminar el prefijo: "+nombre); 
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
  </body>
</html>
