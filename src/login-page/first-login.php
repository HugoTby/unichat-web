<!DOCTYPE html>
<html lang="en" oncontextmenu="return false;">

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
        session_start();

        /*if (isset($_POST["Deconnexion"])) {
            // Unset and destroy the session
            /*session_unset();
            session_destroy();*/
            // Redirect to the login page
            /*header("Location: index.php");*/
        //}


            // & On autorise l'accès au site
            if ($_SESSION["ConnexionInformations"] === 1) // & Si l'utilisateur est connecté
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
                    <input style="cursor: not-allowed;" name="username" type="text" maxlength="50" value="<?php echo $_SESSION["Username"]; ?>" readonly>
                    <input name="password" type="password" maxlength="50" placeholder="Nouveau mot de passe" required autocomplete="off">
                    <input name="re-password" type="password" maxlength="30" placeholder="Confirmer le nouveau mot de passe" required autocomplete="off">
                    <button name="btnConnecting" type="submit">Continuer</button>
                </form>
                <!--<form method="post" style=" position: fixed;bottom: 10px; left: 15px; ">
                    <button type="submit" name="Deconnexion">Retour</button>
                </form>-->

        <?php
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