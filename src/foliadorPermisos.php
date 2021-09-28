<?php
if(session_status() != PHP_SESSION_ACTIVE ){
    session_start();
  }
include_once 'utilities.php';

if(ISSET($_GET["a"])){
    if($_GET["a"]=="getPrefixs"){
        $q=execQueryP("SELECT CONCAT( '[', GROUP_CONCAT(JSON_OBJECT('id', id, 'descripcion', descripcion)), ']' ) as json from permisoprefijo WHERE deleted=0");
        while ($row = mysqli_fetch_array($q)) {
            echo $row["json"];
        }
    }
    if($_GET["a"]=="nextFolio" && ISSET($_GET["prefixId"])){
        $prefix=$_GET["prefixId"];
        $q=execQueryP("SELECT IFNULL(MAX(rangoFinal),0)+1 as folio FROM permisorangos where permisoprefijo_id=$prefix");
        while ($row = mysqli_fetch_array($q)) {
            echo $row["folio"];
        }
    }

    if($_GET["a"]=="getUserPrefix" && ISSET($_GET["usuario_id"])){
        $usuario_id=$_GET["usuario_id"];
        $q=execQueryP("SELECT pp.id,pp.descripcion FROM `permisorangos` p JOIN permisoprefijo pp ON p.permisoprefijo_id=pp.id WHERE usuario_id=$usuario_id and p.active=1 and p.deleted=0
        GROUP BY pp.id,pp.descripcion");
        $rows = array();
        $json="[";
        while ($row = mysqli_fetch_array($q)) {
            // echo $row["id"];
            $row["nextFolio"]=getNextFolio($row["id"],$usuario_id);
            if($row["nextFolio"]!=null)
            $rows[] = $row;
        }
        print json_encode($rows);

        // echo $json;
    }

    if($_GET["a"]=="nextFolioUser" && ISSET($_GET["prefixId"])&& ISSET($_GET["usuario_id"])){
        $prefix=$_GET["prefixId"];
        $user_id=$_GET["usuario_id"];
        
        $lastFolio=null;    
        $isValid=0;
        $q=execQueryP("SELECT MAX(folio) lastFolio FROM permiso p where p.usuario_id=$user_id and p.id_prefijo=$prefix");

        while ($row = mysqli_fetch_array($q)){
            $lastFolio = $row["lastFolio"];
        }

        if($lastFolio!=null){
            $nextFolio=$lastFolio+1;

            $q2=execQueryP("SELECT 1 as valid FROM permisorangos pr where pr.usuario_id=$user_id and pr.permisoprefijo_id=$prefix and $nextFolio>=pr.rangoInicial and $nextFolio <=pr.rangoFinal");

            while ($row = mysqli_fetch_array($q2)){
                $isValid = $row["valid"];
            }
            if($isValid==1){
                echo $nextFolio;
            }
            else{
                $q=execQueryP("SELECT MIN(rangoInicial) nextFolio FROM permisorangos pr where pr.usuario_id=$user_id and pr.permisoprefijo_id=$prefix
                and rangoInicial >=$nextFolio");
                while ($row = mysqli_fetch_array($q)){
                    $nextFolio = $row["nextFolio"];
                }
                echo $nextFolio;
            }
        }
        else{
            $q=execQueryP("SELECT MIN(rangoInicial) nextFolio FROM permisorangos pr where pr.usuario_id=$user_id and pr.permisoprefijo_id=$prefix");
            while ($row = mysqli_fetch_array($q)){
                $nextFolio = $row["nextFolio"];
            }
            echo $nextFolio;
        }
        


    }
}

function getNextFolio($prefix,$user_id){
    // $prefix=$_GET["prefixId"];
    // $user_id=$_GET["usuario_id"];
    $nextFolio=null;
    $lastFolio=null;    
    $isValid=0;
    $q=execQueryP("SELECT MAX(folio) lastFolio FROM permiso p where p.usuario_id=$user_id and p.id_prefijo=$prefix");

    while ($row = mysqli_fetch_array($q)){
        $lastFolio = $row["lastFolio"];
    }

    if($lastFolio!=null){
        $nextFolio=$lastFolio+1;

        $q2=execQueryP("SELECT 1 as valid FROM permisorangos pr where pr.usuario_id=$user_id and pr.permisoprefijo_id=$prefix and $nextFolio>=pr.rangoInicial and $nextFolio <=pr.rangoFinal");

        while ($row = mysqli_fetch_array($q2)){
            $isValid = $row["valid"];
        }
        if($isValid==1){
            // echo $nextFolio;
        }
        else{
            $q=execQueryP("SELECT MIN(rangoInicial) nextFolio FROM permisorangos pr where pr.usuario_id=$user_id and pr.permisoprefijo_id=$prefix
            and rangoInicial >=$nextFolio");
            while ($row = mysqli_fetch_array($q)){
                $nextFolio = $row["nextFolio"];
            }
            // echo $nextFolio;
        }
    }
    else{
        $q=execQueryP("SELECT MIN(rangoInicial) nextFolio FROM permisorangos pr where pr.usuario_id=$user_id and pr.permisoprefijo_id=$prefix");
        while ($row = mysqli_fetch_array($q)){
            $nextFolio = $row["nextFolio"];
        }
        // echo $nextFolio;
    }
return $nextFolio;

}
?>