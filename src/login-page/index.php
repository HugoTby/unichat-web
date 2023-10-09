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
        background: rgba(255, 0, 0, 0.4);
        padding: 10px;
        border-radius: 5px;
        color: #fff;
    }
</style>

<body>

    <div class="center">
        <?php
        session_start();
        $erreur = 0;

        include("../bdd/database.php");

        // & On include les fichiers codes.php, black_list.php, white_list.php pour récupérer par la suite le nom et le drapeau du pays d'origine de l'adresse IP et l'autorisation d'accès si elle existe
        include("../ip-adresses/codes.php");
        include("../ip-adresses/black_list.php");
        include("../ip-adresses/white_list.php");

        if (isset($_POST["btnConnecting"])) // & Si le bouton 'se connecter' est pressé
        {
            if ($GLOBALS["pdo"]) // & Si la connexion à la bdd est réussi
            {
                // & Récupération des données du formulaire

                $username = $_POST["username"];
                $password = hash('sha256', $_POST["password"]);

                // & Préparation requête
                $select = "SELECT username, passwd FROM utilisateurs WHERE username='$username'";
                $selectResult = $GLOBALS["pdo"]->query($select);

                if ($selectResult) // & Si la requête est réussie
                {
                    $row_count = $selectResult->rowCount();

                    if ($row_count > 0) {
                        $tabUser = $selectResult->fetchALL();

                        foreach ($tabUser as $user) // & On va parcourir le tableau d'utilisateur
                        {
                            if ($username == $user['username'] &&  $password == $user['passwd']) // Si un user avec le même mdp à était trouvé alors on le connecte
                            {
                                // & On va ainsi prendre le pseudo pour la session
                                $_SESSION["Username"] = $user['username']; // & Tableau de session Login = login de l'utilsateur
                                $_SESSION["IsConnected"] = true;

                                $erreur = 0;
                            } else if ($password != $user['passwd']) // & Si le mot de passe est  différent
                            {
                                $erreur = 1;
                            }
                        }
                    } else if ($row_count == 0) // & Si aucun utilisateur ne correspond
                    {
                        $erreur = 1;
                    }
                } else // & Si la requête n'est pas réussie
                {
                    $erreur = 2;
                }
            } else // & Si la connexion à la bdd n'est pas réussie
            {
                $erreur = 2;
            }
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
                    <input name="username" type="text" maxlength="50" placeholder="Nom d'utilisateur (ex: nom.prenom)" required>
                    <input name="password" type="password" maxlength="30" placeholder="Mot de passe (ex: KUmiX57!)" required>
                    <button name="btnConnecting" type="submit">Se connecter</button>
                <?php

                if ($erreur === 1) {
                    // & Message d'erreur si le mdp ou login incorrets
                    echo "
                        <div style='display:flex; align-items:center; justify-content:center;padding-top:20px;'>
                            <i class='gg-info' style='margin-right:5px; color:#fff;background-color:red'></i>
                            <span style='color:#fff;background-color:red;border-radius:4px;padding:5px;font-size:12px'>
                                Le nom d'utilisateur ou le mot de passe est incorrect
                            </span>
                        </div>
                        ";
                } else if ($erreur === 2) {
                    // & Message d'erreur si le mdp ou login incorrets
                    echo "
                        <div style='display:flex; align-items:center; justify-content:center;padding-top:20px;'>
                            <i class='gg-info' style='margin-right:5px; color:#fff;background-color:red'></i>
                            <span style='color:#fff;background-color:red;border-radius:4px;padding:5px;font-size:12px'>
                                Code erreur 409 (SQL REQUEST FAILED)
                            </span>
                        </div>
                        ";
                }
            } ?>
                </form>
            <?php
        } else {

            // & Sinon, on refuse l'accès en affichant l'adresse IP de l'utilisateur, aisni que le nom et le drapeau de son pays récupérés dans le tableau du fichier codes.php
            $country = property_exists($info, 'country') ? (array_key_exists($info->country, $countryCodes) ? $countryCodes[$info->country] : 'Unknown location') : 'Unknown location';
            echo "
                <div class='error'>
                    Désolé, seule une adresse IP provenant de<strong> France 🇫🇷</strong> est autorisée à se connecter à UniChat pour le Web<br><br>
                    Votre adresse IP est : <strong>" . $ip . "</strong>, elle provient de <strong>" . $country . "</strong>
                </div>";
        }

            ?>

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