<?php
if(session_status() != PHP_SESSION_ACTIVE ){
  session_start();
}
include_once 'utilities.php';

// if(ISSET($_POST["fecha1"])&&ISSET($_POST["fecha2"])){
//   $fecha1=$_POST["fecha1"];
//   $fecha2=$_POST["fecha2"];
// }

$FoliosAsignados="0";
// if(ISSET($_POST["fecha1"]) && ISSET($_POST["fecha2"])){
 $q1=execQueryP("SELECT SUM(rangoFinal-rangoInicial+1) FoliosAsignados FROM permisorangos");
 while ($row = mysqli_fetch_array($q1)) {
   $FoliosAsignados=$row["FoliosAsignados"];
 }
// }

$FoliosRegistrados="0";
// if(ISSET($_POST["fecha1"]) && ISSET($_POST["fecha2"])){
 $q1=execQueryP("SELECT SUM(1) FoliosRegistrados FROM permiso ");
 while ($row = mysqli_fetch_array($q1)) {
   $FoliosRegistrados=$row["FoliosRegistrados"];
 }
// }


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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.min.js"></script>
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

            $('#Foliospermisos').DataTable( {
                    language: {
                        url: 'https://cdn.datatables.net/plug-ins/1.10.22/i18n/Spanish.json'
                    },
                    order: [[ 0, 'desc' ]],
                    dom: 'Bfrtlip',
                    pageLength: 50,
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


    <section class="top-element mb-5">
      <h2>REPORTE</h2>
<!--      <h2>PLATAFORMA PERMISOS</h2>
      <h3>USUARIO QUE PUEDE VER ESTA SECCIÓN: SUPERADMIN Y ADMIN</h3>
      <p class="mt-2 mb-5">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>-->

      <h4>FOLIOS TOTALES ASIGNADOS: <?php echo $FoliosAsignados;?></h4>
      <h4>FOLIO TOTALES REGISTRADOS: <?php echo $FoliosRegistrados;?></h4>
      <select id="month">
      <?php
        $months=["Enero","Febrero","Marzo","Abril","Mayo","Junio",
        "Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"];
        $nDate=date("m");
        
        for($i=0;$i<(int)($nDate);$i++){
          echo '<option value="'.($i+1).'">'.$months[$i].'</option>';
        }  
      ?>
      </select>
      <select id="year">
      <?php
        $initialYear=2021;
        $nDate=date("Y");
        echo '<option value="'.$nDate.'">'.$nDate.'</option>';
        for($i=$initialYear;$i<(int)($nDate);$i++){
          echo '<option value="'.($i).'">'.$i.'</option>';
        }  
      ?>
      </select>
      <button type="submit" style="margin-left:5px;" class="btn btn-success" name="submit" id="descargar" onclick="descargar()">DESCARGAR BASE DE DATOS</button>
      <hr class="my-5">
      <h3 class="my-2"><strong>Selecciona el rango de fechas del reporte:</strong> </h3>
      <?php
      if(ISSET($_GET["d"])&&ISSET($_GET["y"]))
      {
        $q1=execQueryP("SELECT p.*,pp.descripcion as prefijo FROM permiso p join permisoprefijo pp on p.id_prefijo = pp.id where expedicion BETWEEN '".$_GET["y"]."-".$_GET["d"]."-01' and '".$_GET["y"]."-".$_GET["d"]."-31'");
        echo '
        <table id="Foliospermisos2" class="display table table-striped" style="width:100%;display:none">
        <thead>
            <tr>
                <th>#</th>
                <th>Razón Social</th>
                <th>Expedición</th>
                <th>Vencimiento</th>
                <th>Estatus</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>';
        while ($row = mysqli_fetch_array($q1)) {
          $expedicion=  date("d/m/Y", strtotime($row["expedicion"]));
          $vencimiento=  date("d/m/Y", strtotime($row["vencimiento"]));
          $status="Activo";
          if($row["deleted"]==1){
            $status="Cancelado";
          }
          echo '
          <tr>
            <td>'.$row["prefijo"].$row["folio"].'</td>
            <td>'.$row["razonSocial"].'</td>
            <td>'.$expedicion.'</td>
            <td>'.$vencimiento.'</td>
            <td>'.$status.'</td>
            <td></td>
          </tr>       
          ';
        }
        echo ' </tbody></table>';
      }
        $date =date("Y-m-d");
        // $fecha1=date("Y-m-d",strtotime('-30 days',strtotime($date)));
        // $fecha2=date("Y-m-d");
        if(ISSET($_POST["fecha1"])&&ISSET($_POST["fecha2"])){
            $fecha1=$_POST["fecha1"];
            $fecha2=$_POST["fecha2"];
        }
    ?>
      <form action="reportepermisos.php"  method="POST">
        <div class="row">
            <div class="col-md-3 mb-3">
                <label for="" class="form-label">Fecha inicial</label>
                <input type="date" class="form-control" name="fecha1" aria-describedby="emailHelp" value="<?php
                echo $fecha1;?>">
            </div>
            <div class="col-md-3 mb-3">
                <label for="" class="form-label">Fecha final</label>
                <input type="date" class="form-control"name="fecha2" aria-describedby="emailHelp" value="<?php
                 echo $fecha2;?>">
            </div>
            <div class="col-md-6 mt-4">
                <button type="submit" class="btn btn-success" name="submit" id="submit">GENERAR</button>
            </div>
        </div>
        </form>

    </seciton>
    <hr class="my-5">
    <section class="mb-5">
        <table id="Foliospermisos" class="display table table-striped" style="width:100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nombre completo</th>
                    <th>Expedición</th>
                    <th>Vencimiento</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if(ISSET($_POST["fecha1"]) && ISSET($_POST["fecha2"])){
                 $q=execQueryP("select p.*,pp.descripcion as prefijo FROM permiso p join permisoprefijo pp on p.id_prefijo = pp.id where expedicion>='$fecha1' and expedicion<='$fecha2'");
                 while ($row = mysqli_fetch_array($q)) {
                    $expedicion=  date("d/m/Y", strtotime($row["expedicion"]));
                    $vencimiento=  date("d/m/Y", strtotime($row["vencimiento"]));
                    echo '<tr ';
                    if($row["deleted"]==1){
                      echo 'class="deleted"';
                    }
                    echo
                    '><td>'.$row["prefijo"].$row["folio"].'</td>
                    <td>'.$row["razonSocial"].'</td>
                    <td>'.$expedicion.'</td>
                    <td>'.$vencimiento.'</td>
                    <td>';
                   echo  '<i class="fas fa-search fa-icon-cuadro"  onclick="Readpermiso('.$row["id"].')"></i>';
                    if($row["deleted"]==0){
                    echo '
                    <i class="fas fa-qrcode fa-icon-cuadro" onclick="qrModal('.$row["folio"].','."'".$row["prefijo"]."'".')"></i>
                    <i class="fas fa-print fa-icon-cuadro" onclick="openpermisoModal('."'".$row["prefijo"].$row["folio"]."'".",'"
                    .$row["razonSocial"]."','".
                    $row["RFC"]."','".
                    $row["calle"]."','".
                    $row["numero"]."','".
                    $row["colonia"]."','".
                    $row["municipio"]."','".
                    $row["estado"]."','".
                    $row["pais"]."','".
                    $row["cp"]."','".
                    $row["marca"]."','".
                    $row["linea"]."','".
                    $row["color"]."','".
                    $row["serie"]."','".
                    $row["motor"]."','".
                    $row["anio"]."','".                 
                    $row["expedicion"]."','".       
                    $row["vencimiento"]."','".            
                    $row["numeroFactura"]."'"                    
                                        .')"></i>';
                    }
                    echo '</td>
                </tr>';
                }
              }
                ?>
            </tbody>
        </table>
    </section>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">permiso QR</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style=" text-align: center; ">
        <div id="qrcodeTable"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="PermisosModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">permiso</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style=" text-align: center; ">
      <iframe id="frame" title="PDF Preview" style="width:100%;height:490px;"></iframe>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

    <form action="permisosdisabled.php?a=r"  target="_self" style="display:none;"  method="POST">
        <input type="text" name="id" id="readid"/>
        <button type="submit" id="submitread"></button>
    </form>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script async src="./js/validate.js"></script>
    <script>
        function Readpermiso(id){
            $("#readid").val(id);
            $('#submitread').click();


        }
        function qrModal(folio,prefijo){
          generateQr(folio,prefijo);
            $('#exampleModal').modal();
        }


    </script>
  </body>
  <style>

.deleted,.deleted td[class^='sorting_']{
  background-color:red!important;
}
</style>
      <script src="qrencode.js"></script>
    <script src="jqueryqrencode.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script>
function descargar(){
  window.location="./reportepermisos.php?d="+$('#month').val()+"&y="+$('#year').val();
}
function downloadCSV(csv, filename) {
            var csvFile;
            var downloadLink;

            // CSV file
            csv="\ufeff"+csv;
            csvFile = new Blob([csv], {
                type: "text/csv"
            });

            // Download link
            downloadLink = document.createElement("a");

            // File name
            downloadLink.download = filename;

            // Create a link to the file
            downloadLink.href = window.URL.createObjectURL(csvFile);

            // Hide download link
            downloadLink.style.display = "none";

            // Add the link to DOM
            document.body.appendChild(downloadLink);

            // Click download link
            downloadLink.click();
        }
          function exportTableToCSV(filename) {
            var csv = [];
            var rows = document.querySelectorAll("#Foliospermisos2 tr");

            for (var i = 0; i < rows.length; i++) {
                var row = [],
                 cols = rows[i].querySelectorAll("td:not(.accion), th:not(.accion)");

                for (var j = 0; j < cols.length; j++)
                    row.push(cols[j].innerText);

                csv.push(row.join(","));
            }

            // Download CSV file
            downloadCSV(csv.join("\n"), filename);
        }

        /*$('[name="fecha1"]').change(function(){
          var format1 = "YYYY-MM-DD"
var format2 = "YYYY-MM-DD"
var date1 = new Date($('[name="fecha1"]').val());

var dateTime1 = moment(date1).format(format1);
var dateTime2 = moment(date1).add(7,"days").format(format2);
// console.log(dateTime2);
$('[name="fecha2"]').val(dateTime2);
        });

        //$('[name="fecha2"]').change(function(){
          var format1 = "YYYY-MM-DD"
          var format2 = "YYYY-MM-DD"
var date1 = new Date($('[name="fecha2"]').val());

var dateTime1 = moment(date1).format(format1);
var dateTime2 = moment(date1).add(-7,"days").format(format2);
// console.log(dateTime2);
$('[name="fecha1"]').val(dateTime2);


        });*/

        function generateQr(folio,prefijo){
        jQuery('#qrcodeTable').text("");
           jQuery('#qrcodeTable').qrcode({
		render	: "canvas",
		text	: "<?php echo "http://$_SERVER[HTTP_HOST]/consultapermisociudadano.php?folio=";?>"+folio+"&prefix="+prefijo
	});
       }
       function getDataUri(url, cb)
 {
        var image = new Image();
        image.setAttribute('crossOrigin', 'anonymous'); //getting images from external domain

        image.onload = function () {
            var canvas = document.createElement('canvas');
            canvas.width = this.naturalWidth;
            canvas.height = this.naturalHeight; 

            //next three lines for white background in case png has a transparent background
            var ctx = canvas.getContext('2d');
            ctx.fillStyle = '#fff';  /// set white fill style
            ctx.fillRect(0, 0, canvas.width, canvas.height);

            canvas.getContext('2d').drawImage(this, 0, 0);

            cb(canvas.toDataURL('image/jpeg'));
        };

        image.src = url;
   }


   function openpermisoModal(prefijo ,folio,razonSocial,RFC,calle,numero,colonia,municipio,estado,pais,cp,marca,linea,color,serie
,motor,anio,expedicion,vencimiento,numeroFactura){
  var doc = new jsPDF()

doc.setFontSize(26)
getDataUri("./imgs/P1-01.jpeg", function(dataUri) {
  logo = dataUri;
    var vigencia=(moment(new Date(vencimiento+" 00:00"))).year()-(moment(new Date(expedicion+" 00:00"))).year();
    doc.addImage(logo,'JPEG',0,0,210,280);
    doc.setFontSize(16)

    doc.setFontType("bold");
    doc.text("No DE FOLIO:",20, 100)
    doc.text("DV:",100, 100);
    doc.text("LUGAR Y FECHA DE EXPEDICION:",20, 120);
    doc.text("MARCA:",20, 140);
    doc.text("LINEA:",20, 160);
    doc.text("No DE MOTOR:",20, 180);
    doc.text("Modelo:",20, 200);
    doc.text("COLOR:",70, 200);
    doc.text("EXPIRA EL:",20, 220);


    doc.setFontType("normal");
    doc.text(folio,60, 100)
    
    var splitTitle = doc.splitTextToSize("AYUNT. IXCATEOPAN, GRO;", 150);
    doc.text(splitTitle,120, 120);
    doc.text((moment(new Date(expedicion+" 00:00"))).format("DD/MM/Y"),120, 130);
    
    doc.text(marca,43, 140);
   
    doc.text(linea,40, 160);

    doc.text(motor,65, 180);
    
     doc.text(""+anio,50, 200);

     doc.text(color,100, 200);

     doc.text((moment(new Date(vencimiento+" 00:00"))).format("DD/MM/Y"),55, 220);
     
    generateQr(folio,prefijo);
    var imgData=$("#qrcodeTable canvas")[0].toDataURL("image/jpeg", 1.0);
    doc.addImage(imgData,'JPEG',155,205,40,40);

$('#frame').attr("src",doc.output('bloburl'));
$("#PermisosModal").modal();
});
}
<?php
if(ISSET($_GET["d"]) && ISSET($_GET["y"]))
{
  echo 'exportTableToCSV("reporte.csv")';
}
?>

</script>
</html>
