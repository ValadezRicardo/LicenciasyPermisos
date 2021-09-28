<?php
if(isset($_GET["folio"])){
    $folio=$_GET["folio"];
    $image=$_GET["image"];
    $prefix=0;
    //  ,fotoIdentificacion,fotoFirma
    $con= new mysqli('localhost','lypixcat_licencias','lKEyXGnvn*=R','lypixcat_licenciasypermisosfinal')or die("No se pudo conectar a la base de datos".mysqli_error($con));
    $q = mysqli_query($con,"SELECT ".$image." FROM licencia WHERE id_prefijo=$prefix and folio=".$folio) or die('Query Error:'."error");
    while ($row = mysqli_fetch_array($q)){
        echo 'data:image/jpeg;base64,'.base64_encode($row[$image]);
        
    }
}
?>