<?php
    /*try {
        $ipserver = "127.0.0.1";
        $nomBase = "unichat";
        $loginPrivilege = "root";
        $passPrivilege = "root";
        
        $GLOBALS["pdo"] = new PDO('mysql:host='.$ipserver.';dbname='.$nomBase.";charset=utf8mb4",$loginPrivilege,$passPrivilege);
    } 
    catch (Exception $error) 
    {
        $error->getMessage();
        echo "Erreur BDD : " .$error;
    }*/


    $host =                "127.0.0.1";      // Adresse IP //
    $username =            "root";        // Username   //
    $password =            "root";           // Password   //
    $dbname =              "unichat";           // Nom base   //

    $conn = mysqli_connect($host, $username, $password, $dbname);
?>