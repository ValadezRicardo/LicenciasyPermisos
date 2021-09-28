<?php

function execQuery($query,$validate=false){
    $con= new mysqli('localhost','lypixcat_licencias','lKEyXGnvn*=R','lypixcat_licenciasypermisosfinal')or die("No se pudo conectar a la base de datos".mysqli_error($con));
    $isvalid=false;
    if(ISSET($_SESSION["token"])){
        $token=$_SESSION["token"];
        $info=DecryptedVal($token);
        $data=explode(",", $info);
        $id =$data[0];
        $user=mysqli_query($con,"SELECT * FROM usuario where deleted=0 and id=$id");
       
    
        while ($row = mysqli_fetch_array($user)){
            $isvalid=true;
            
        }
    
    }
    
    if(!$isvalid && !$validate){
        UNSET($_SESSION["token"]);
        echo '<script>(function(){window.location="./"})()</script>';
    }
    
    $q = mysqli_query($con,$query) or die('Query Error:'.$query);
    return $q;
}


function execQueryP($query,$validate=false){
    
    $con= new mysqli('localhost','lypixcat_licencias','lKEyXGnvn*=R','lypixcat_licenciasypermisosfinal')or die("No se pudo conectar a la base de datos".mysqli_error($con));
    $isvalid=false;
    if(ISSET($_SESSION["tokenp"])){
        $token=$_SESSION["tokenp"];
        $info=DecryptedVal($token);
        $data=explode(",", $info);
        $id =$data[0];
        $user=mysqli_query($con,"SELECT * FROM usuariop where deleted=0 and id=$id");
       
    
        while ($row = mysqli_fetch_array($user)){
            $isvalid=true;
            
        }
    
    }
    
    if(!$isvalid && !$validate){
        UNSET($_SESSION["tokenp"]);
        echo '<script>(function(){window.location="./"})()</script>';
    }
    
    $q = mysqli_query($con,$query) or die('Query Error:'.$query);
    return $q;
}

function EncryptedVal($val){
        // Store the cipher method 
        $ciphering = "AES-128-CTR"; 
        
        // Use OpenSSl Encryption method 
        $iv_length = openssl_cipher_iv_length($ciphering); 
        $options = 0; 
        // Non-NULL Initialization Vector for encryption 
        $encryption_iv = '1234567891011121'; 
        
        // Store the encryption key 
        $encryption_key = "Encript"; 
        // Use openssl_encrypt() function to encrypt the data 
        $encryption = openssl_encrypt($val, $ciphering, 
                    $encryption_key, $options, $encryption_iv); 
        return $encryption;
}

function DecryptedVal ($val){
        // Store the cipher method 
        $ciphering = "AES-128-CTR"; 
        
        // Use OpenSSl Encryption method 
        $iv_length = openssl_cipher_iv_length($ciphering); 
        $options = 0; 
        // Non-NULL Initialization Vector for decryption 
        $decryption_iv = '1234567891011121'; 
        
        // Store the decryption key 
        $decryption_key = "Encript"; 
        

        // Use openssl_decrypt() function to decrypt the data 
        $decryption=openssl_decrypt ($val, $ciphering,  
                $decryption_key, $options, $decryption_iv); 
        return $decryption;
}

function validateToken($token){
    $validate=false;
    $info=DecryptedVal($token);
    $data=explode(",", $info);
  
    if(isset($data[1])){
        if(ISSET($_SESSION["token"])){
            return true;
        }
        else{
            return false;       
         }
    }
    else{
        return false;
    }
}

function validateTokenP($token){
    $validate=false;
    $info=DecryptedVal($token);
    $data=explode(",", $info);
  
    if(isset($data[1])){
        if(ISSET($_SESSION["tokenp"])){
            return true;
        }
        else{
            return false;       
         }
    }
    else{
        return false;
    }
}

?>