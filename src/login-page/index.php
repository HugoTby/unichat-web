<!DOCTYPE html>
<html lang="en" oncontextmenu="return true;">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UniChat</title>
    <link rel="stylesheet" href="login_style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@300&family=Exo:wght@100;200&display=swap" rel="stylesheet">
    <link href='https://unpkg.com/css.gg@2.0.0/icons/css/info.css' rel='stylesheet'>
    <link rel="shortcut icon" href="../images/lapro-ico.png" type="image/x-icon">
</head>
<style>
    /* Pour les erreurs d'adresses IP*/
    .center {
        text-align: center;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    .error {
        background: rgba(202, 181, 181, 0.4);
        padding: 10px;
        border-radius: 5px;
        color: #fff;
    }
</style>
<body>
    <div class="center">

        <?php

        include("../bdd/database.php");
        include('../functions/form.php');
        include("../ip-adresses/codes.php");
        include("../ip-adresses/black_list.php");
        include("../ip-adresses/white_list.php");
        session_start();



        $ip = $_SERVER['REMOTE_ADDR'];
        $info = json_decode(file_get_contents("http://ipinfo.io/{$ip}/json"));

        //  On vérifie si l'ip correspond a une adresse bloquée dans la liste donnée dans le tableau `blacklist` présent dans le fichier 'black_list.php'
        if (array_key_exists($ip, $blacklist)) {
            $ip_adress_list = $blacklist[$ip];
            echo "
        <div class='error'>
            Désolé, le serveur à renvoyé l'erreur <strong>**Accès refusé**</strong> à UniChat pour le Web<br><br>
            Si cette erreur apparaît, il est probable que votre adresse IP ait été mise sur liste noire<br>par les développeurs de ce site, ou qu'elle soit incompatible avec l'utilisation du site.<br><br>
            Pour corriger cette erreur, veuillez contacter un administrateur de site ou votre<br>administrateur de réseau.
        </div>";
        } elseif (property_exists($info, 'country') && $info->country === "FR" or ($ip == in_array($ip, $whitelist) || strpos($ip, '192.168.') === 0)) {


            if (isset($_POST['btnConnecting'])) {
                // Récupération des données du formulaire avec échappement
                $username = mysqli_real_escape_string($conn, $_POST['username']);
                $password = mysqli_real_escape_string($conn, hash('sha256', $_POST["password"]));

                // Préparation de la requête SQL avec des paramètres de substitution
                $query = "SELECT * FROM utilisateurs WHERE username=? AND passwd=?";
                $stmt = mysqli_prepare($conn, $query);

                // Liaison des valeurs aux paramètres de substitution
                mysqli_stmt_bind_param($stmt, "ss", $username, $password);

                // Exécution de la requête préparée
                mysqli_stmt_execute($stmt);

                // Récupération des résultats
                $result = mysqli_stmt_get_result($stmt);
                $row = mysqli_fetch_assoc($result);

                // Si un utilisateur est trouvé avec les informations de connexion données
                if (mysqli_num_rows($result) > 0) {

                    $isAlreadyConnected = $row['isAlreadyConnected'];

                    if ($isAlreadyConnected === 0) {
                        //echo "0";
                        $_SESSION["Username"] = $username;
                        $_SESSION["ConnexionInformations"] = $isAlreadyConnected;
                        header('Location: first-login.php');
                        exit(); // Terminer le script après la redirection*/
                    } else {
                        //echo "1";
                        $_SESSION["Username"];
                        $_SESSION["Password"];
                        $_SESSION["ConnexionInformations"] = 1;
                        $_SESSION["IsConnected"] = true;
                        header('Location: ../main/index.php');
                        exit(); // Terminer le script après la redirection*/
                    }
                } else {
                    // Affichage d'un message d'erreur si les informations de connexion sont incorrectes
                    formulaire($erreur = 1);
                }
            } else {
                formulaire($erreur = 0);
            }
        } else {

            // Sinon, on bloque l'accès au site
            $country = property_exists($info, 'country') ? (array_key_exists($info->country, $countryCodes) ? $countryCodes[$info->country] : 'Unknown location') : 'Unknown location';
        ?>
            <div class='error'>
                Désolé, UniChat n'est pas disponible pour le moment.<br>Veuillez contacter un administrateur du site.
            </div>

        <?php
        }



        ?>
    </div>

</body>
<script>
    // Blocage de l'inspecteur d'élément(s)
    document.onkeydown = function(e) {
        if (event.keyCode == 123) {
            return false;
        }
        if (e.ctrlKey && e.shiftKey && e.keyCode == 'I'.charCodeAt(0)) {
            return false;
        }
        if (e.ctrlKey && e.shiftKey && e.keyCode == 'J'.charCodeAt(0)) {
            return false;
        }
        if (e.ctrlKey && e.shiftKey && e.keyCode == 'C'.charCodeAt(0)) {
            return false;
        }
        if (e.ctrlKey && e.keyCode == 'U'.charCodeAt(0)) {
            return false;
        }
    }
</script>

</html>