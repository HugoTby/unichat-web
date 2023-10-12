<!DOCTYPE html>
<html lang="en" oncontextmenu="return true;">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UniChat</title>
    <link rel="stylesheet" href="first-login_style.css">
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
        background: rgba(255, 0, 0, 0.4);
        padding: 10px;
        border-radius: 5px;
        color: #fff;
    }
</style>

<body>
    <div class="center">
        <?php

        include("../bdd/database.php");

        // & On include les fichiers codes.php, black_list.php, white_list.php pour récupérer par la suite le nom et le drapeau du pays d'origine de l'adresse IP et l'autorisation d'accès si elle existe
        include("../ip-adresses/codes.php");
        include("../ip-adresses/black_list.php");
        include("../ip-adresses/white_list.php");

        if (isset($_POST["Deconnexion"])) {
            // Unset and destroy the session
            session_unset();
            session_destroy();
            // Redirect to the login page
            header("Location: http://192.168.65.143");
        }

        // & On utilise la fonction `file_get_contents` pour obtenir les informations géographiques à partir de l'adresse IP ( avec -> ipinfo.io )
        $ip = $_SERVER['REMOTE_ADDR'];
        $info = json_decode(file_get_contents("http://ipinfo.io/{$ip}/json"));

        // & On vérifie si l'ip correspond a une adresse bloquée dans la liste donnée dans le tableau `blacklist` présent dans le fichier 'black_list.php'
        if (array_key_exists($ip, $blacklist)) {
            $ip_adress_list = $blacklist[$ip];
            echo "
            <div class='error'>
                Désolé, le serveur à renvoyé l'erreur <strong>**Accès refusé**</strong> à UniChat pour le Web<br><br>
                Votre adresse IP est : <strong>" . $ip . "</strong>, elle correspond à <strong><mark style='border-radius:2px;padding:2px'>" . $ip_adress_list . "</mark></strong><br><br>
                Si cette erreur apparaît, il est probable que votre adresse IP ait été mise sur liste noire par les développeurs de ce site, ou qu'elle soit incompatible avec l'utilisation du site.<br><br>
                Pour corriger cette erreur, veuillez contacter un administrateur de site ou votre administrateur de réseau.
            </div>";
        }

        // & On vérifie si la propriété 'country' existe et si oui, si le pays de l'utilisateur est la France ( code = FR ) ou si il est dans la liste des IP autorisées.
        elseif (property_exists($info, 'country') && $info->country === "FR" or ($ip == in_array($ip, $whitelist) || strpos($ip, '192.168.') === 0)) {

            // & On autorise l'accès au site
            if (isset($_SESSION["IsConnected"]) && $_SESSION["IsConnected"] == true) // & Si l'utilisateur est connecté
            {
                header('Location: ../main/index.php'); // & Redirection page principale
            } else // & Sinon il y'a une erreur et on indique $erreur a 1 pour l'afficher
            {

        ?>
                <form class="login" method="post">
                    <div id="div-logo">
                        <img id="logo-unichat" src="../images/lapro-white-logo.png" alt="UniChat Logo">
                    </div>
                    <h1 style="color: #fff; font-size:16px;">Première connexion, veuillez modifier<br>votre mot de passe pour continuer.</h1>
                    <input style="cursor: not-allowed;" name="username" type="text" maxlength="50" value="prenom.nom" readonly>
                    <input name="password" type="password" maxlength="50" placeholder="Mot de passe" required>
                    <input name="re-password" type="password" maxlength="30" placeholder="Confirmer le mot de passe" required>
                    <button name="btnConnecting" type="submit">Continuer</button>
                </form>
                <form method="post" style=" position: fixed;bottom: 10px; left: 15px; ">
                    <button type="submit" name="Deconnexion">Déconnexion</button>
                </form>

        <?php
            }
        } else {

            // & Sinon, on refuse l'accès en affichant l'adresse IP de l'utilisateur, aisni que le nom et le drapeau de son pays récupérés dans le tableau du fichier codes.php
            $country = property_exists($info, 'country') ? (array_key_exists($info->country, $countryCodes) ? $countryCodes[$info->country] : 'Unknown location') : 'Unknown location';
            echo "
                <div class='error'>
                    Désolé, seule une adresse IP provenant de<strong> France 🇫🇷</strong> est autorisée à se connecter à UniChat pour le Web<br><br>
                    Votre adresse IP est : <strong>" . $ip . "</strong>, elle provient de <strong>" . $country . "</strong>
                </div>";
        }    ?>
    </div>
</body>
<script>
    // & Blocage de l'inspecteur d'élément(s)
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