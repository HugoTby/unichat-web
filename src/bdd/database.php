<?php
    try {
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
    }
?>