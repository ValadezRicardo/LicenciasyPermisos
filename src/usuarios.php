<?php
if(session_status() != PHP_SESSION_ACTIVE ){
    session_start();
  }
include_once 'utilities.php';

function create($user){

    $usuario=$user["usuario"];
    $nombre=$user["nombre"];
    $contrasena=EncryptedVal($user["contrasena"]);
    $email=$user["email"];
    $telefono=$user["telefono"];
    $rol_id=$user["rol_id"];

    $q=execQuery("INSERT INTO usuario(usuario,nombre,contrasena,email,telefono,rol_id) 
    VALUES('$usuario','$nombre','$contrasena','$email','$telefono','$rol_id')");

}

function delete($user){
    $id=$user['id'];
    $q=execQuery("DELETE FROM usuario WHERE id=$id");
    //$q=execQuery("UPDATE usuario SET deleted=1 WHERE id=$id");
}

function update($user){
    $id=$user['id'];
    $usuario=$user["usuario"];
    $nombre=$user["nombre"];
    $contrasena=EncryptedVal($user["contrasena"]);
    $email=$user["email"];
    $telefono=$user["telefono"];
    $rol_id=$user["rol_id"];
    if($user["contrasena"] !=''){
    $q=execQuery("UPDATE usuario SET usuario='$usuario', nombre='$nombre', contrasena='$contrasena',
     email='$email',telefono='$telefono', rol_id='$rol_id' WHERE id=$id");
    }
    else{
    $q=execQuery("UPDATE usuario SET usuario='$usuario', nombre='$nombre',
     email='$email',telefono='$telefono', rol_id='$rol_id' WHERE id=$id");
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
        case 'u':
            update($_POST);
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
                    order: [[ 0, 'asc' ]],
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

    <section class="top-element">               
      <h2 class="my-5">LISTADO DE USUARIOS</h2>
<!--      <h2>PLATAFORMA LICENCIAS</h2>
      <h3>USUARIO QUE PUEDE VER ESTA SECCIÓN: SUPERADMIN</h3>
      <p class="mt-2 mb-5">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>-->
        <table id="FoliosLicencias" class="display table table-striped" style="width:100%">
            <thead>
                <tr>
                    <th>Nombre usuario</th>
                    <th>Usuario</th>
                    <th>Email</th>
                    <th>Teléfono</th>
                    <th>Tipo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
            <?php
                 $q=execQuery("select * from usuario");
                 while ($row = mysqli_fetch_array($q)) {
                    $tipo='';
                    switch ($row["rol_id"]) {
                        case 1:
                            $tipo="SuperAdmin";
                            break;
                        case 2:
                            $tipo="Admin";
                            break;
                        default:
                        $tipo="Usuario general";
                            break;
                    }

                    echo '<tr';
                    if($row["deleted"]==1){
                        echo ' class="deleted"';
                    }
                
                    echo '><td>'.$row["nombre"].'</td>
                    <td>'.$row["usuario"].'</td>
                    <td>'.$row["email"].'</td>
                    <td>'.$row["telefono"].'</td>
                    <td>'.$tipo.'</td>
                    <td>';
                   
                    if($row["deleted"]==0){
                    echo '<i class="fas fa-edit fa-icon-cuadro" onclick="userUpdate('."'".$row["id"]."','".$row["nombre"]."','".$row["usuario"]."','".$row["email"]."','".$row["rol_id"]."','".$row["telefono"]."'".')"></i>
                    <i class="fas fa-trash fa-icon-eliminar" onclick="userDelete('.$row["id"].','."'".$row["nombre"]."'".')"></i>';
                    }
                   
                    echo '</td>
                </tr>';
                }
                
                ?>
                
             
            </tbody>
        </table>
    </section>
    <hr class="my-5">
    <section class="mb-5">
        <h2>NUEVO USUARIO</h2>
        <!--<h3>USUARIO QUE PUEDE VER ESTA SECCIÓN: SUPERADMIN</h3>-->
        <form class="my-5" action="usuarios.php?a=c"  method="POST">
          
            <div class="row">
                <div class="col-md-12 mb-3 was-validated" >
                    <label for="" class="form-label">Nombre completo:</label>
                    <input type="text" class="form-control" name="nombre" aria-describedby="emailHelp" placeholder="Nombre completo" required>
                    <div class="invalid-feedback">Ingresa tu nombre.</div>
                    <div class="valid-feedback">¡Muy bien!</div>
                </div>
                <div class="col-md-4 mb-3 was-validated">
                    <label for="" class="form-label">Usuario:</label>
                    <input type="text" class="form-control" name="usuario" aria-describedby="emailHelp" placeholder="Usuario" required>
                     <div class="invalid-feedback">Ingresa tu usuario.</div>
                     <div class="valid-feedback">¡Muy bien!</div>
                </div>
                <div class="col-md-4 mb-3 was-validated">
                    <label for="" class="form-label">Contraseña:</label>
                    <input type="password" class="form-control" name="contrasena"  id="contrasena" aria-describedby="emailHelp" placeholder="Contraseña" required>
                     <div class="invalid-feedback">Ingresa tu password.</div>
                     <div class="valid-feedback">¡Muy bien!</div>
                </div>
                <div class="col-md-4 mb-3 was-validated">
                    <label for="" class="form-label">Confirmar contraseña:</label>
                    <input type="password" class="form-control" id="ccontrasena" aria-describedby="emailHelp" placeholder="Contraseña" required>
                    <div class="invalid-feedback">Ingresa tu password nuevamente.</div>
                    <div class="valid-feedback">¡Muy bien!</div>
                </div>
                <div class="col-md-4 mb-3 was-validated">
                    <label for="" class="form-label">Telefono:</label>
                    <input type="phone" class="form-control"  name="telefono" id="" aria-describedby="emailHelp" placeholder="Telefono" required>
                    <div class="invalid-feedback">Ingresa tu telefono.</div>
                    <div class="valid-feedback">¡Muy bien!</div>
                </div>
                <div class="col-md-4 mb-3 was-validated">
                    <label for="" class="form-label">Email:</label>
                    <input type="email" class="form-control"  name="email" id="" aria-describedby="emailHelp" placeholder="Email" required>
                    <div class="invalid-feedback">Ingresa tu email.</div>
                    <div class="valid-feedback">¡Muy bien!</div>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="" class="form-label">Tipo de usuario:</label>
                    <select class="form-control" id="rol_id"  name="rol_id" required>
                    <option value="3">Usuario general</option>
                    <option value="2">Admin</option>
                    <option value="1">SuperAdmin</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <!-- <button type="submit" class="btn btn-warning" name="submit" id="submit">CANCELAR</button> -->
                    <button type="submit" class="btn btn-success" name="submit" id="submit">GUARDAR</button>
                </div>
                </div>
          </form>
    </section>
    
    <form action="usuarios.php?a=d" style="display:none;"  method="POST"> 
        <input type="text" name="id" id="deleteid"/>
        <button type="submit" id="submitdelete"></button>
    </form>

    <div class="modal fade" id="EditModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <label style="color: #004380; font-size: 30px; ">
                        EDITAR USUARIO</label>
                            <!-- <br/>
                            <label>Alta y Cambio en Webinar</label> -->
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="my-5" action="usuarios.php?a=u"  method="POST">
                <input type="text" style="display:none" name="id"/>    
                <div class="row">
                    <div class="col-md-12 mb-3 was-validated" >
                        <label for="" class="form-label">Nombre completo:</label>
                        <input type="text" class="form-control" name="nombre" aria-describedby="emailHelp" placeholder="Nombre completo" required>
                        <div class="invalid-feedback">Ingresa tu nombre.</div>
                        <div class="valid-feedback">¡Muy bien!</div>
                    </div>
                    <div class="col-md-6 mb-3 was-validated">
                        <label for="" class="form-label">Usuario:</label>
                        <input type="text" class="form-control" name="usuario" aria-describedby="emailHelp" placeholder="Usuario" required>
                        <div class="invalid-feedback">Ingresa tu usuario.</div>
                        <div class="valid-feedback">¡Muy bien!</div>
                    </div>
                    <div class="col-md-6 mb-3 was-validated">
                        <label for="" class="form-label">Contraseña:</label>
                        <input type="password" class="form-control" name="contrasena"  id="contrasena" aria-describedby="emailHelp" placeholder="Contraseña">
                        <div class="invalid-feedback">Ingresa tu password.</div>
                        <div class="valid-feedback">¡Muy bien!</div>
                    </div>
                    <div class="col-md-6 mb-3 was-validated">
                        <label for="" class="form-label">Confirmar contraseña:</label>
                        <input type="password" class="form-control" id="ccontrasena" aria-describedby="emailHelp" placeholder="Contraseña" >
                        <div class="invalid-feedback">Ingresa tu password nuevamente.</div>
                        <div class="valid-feedback">¡Muy bien!</div>
                    </div>
                    <div class="col-md-6 mb-3 was-validated">
                        <label for="" class="form-label">Telefono:</label>
                        <input type="phone" class="form-control"  name="telefono" id="" aria-describedby="emailHelp" placeholder="Telefono" required>
                        <div class="invalid-feedback">Ingresa tu telefono.</div>
                        <div class="valid-feedback">¡Muy bien!</div>
                    </div>
                    <div class="col-md-6 mb-3 was-validated">
                        <label for="" class="form-label">Email:</label>
                        <input type="email" class="form-control"  name="email" id="" aria-describedby="emailHelp" placeholder="Email" required>
                        <div class="invalid-feedback">Ingresa tu email.</div>
                        <div class="valid-feedback">¡Muy bien!</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="" class="form-label">Tipo de usuario:</label>
                        <select class="form-control" id="rol_id"  name="rol_id" required>
                        <option value="3">Usuario general</option>
                        <option value="2">Admin</option>
                        <option value="1">SuperAdmin</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <!-- <button type="submit" class="btn btn-warning" name="submit" id="submit">CANCELAR</button> -->
                        <button  type="submit" class="btn btn-success" style="display:none;" name="submit" id="btnsubmit">GUARDAR</button>
                    </div>
                    </div>
            </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" onclick="$('#btnsubmit').click()" ">Guardar</button>
                <button type="button" class="btn btn-warning" data-dismiss="modal">Cancelar</button>
            </div>
            </div>
        </div>
        </div>


    <script>
        $('.modal #ccontrasena').change(function(){
          var confirm= $('.modal #ccontrasena').val();
          var contra= $('.modal #contrasena').val();
          if(confirm!=contra){
            alert("Las contraseñas no coinciden.")
            $('.modal #ccontrasena').val(''); 
            
          }
        });
        $('#ccontrasena').change(function(){
          var confirm= $('#ccontrasena').val();
          var contra= $('#contrasena').val();
          if(confirm!=contra){
            alert("Las contraseñas no coinciden.")
            $('#ccontrasena').val(''); 
            
          }
        });
        
        $('.modal #contrasena').change(function(){
            $('.modal #ccontrasena').val(''); 
        });
        $('#contrasena').change(function(){
            $('#ccontrasena').val(''); 
        });

        function userDelete(id,nombre){
            $("#deleteid").val(id);
            var res=confirm("Desea eliminar el usuario:"+nombre); 
            if(res){
                $('#submitdelete').click();
            }

        }
       
        function userUpdate(id,nombre,usuario,email,rol_id,telefono){
            $('.modal [name="id"]').val(id);
            $('.modal [name="nombre"]').val(nombre);
            $('.modal [name="usuario"]').val(usuario);
            $('.modal [name="email"]').val(email);
            $('.modal [name="telefono"]').val(telefono);
            console.log(rol_id);
            $('.modal [name="rol_id"]').val(rol_id);

            
            $('#EditModal').modal();
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
