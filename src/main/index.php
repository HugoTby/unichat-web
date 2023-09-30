<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UniChat</title>
    <link rel="stylesheet" href="main_style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@300&family=Exo:wght@100;200&display=swap" rel="stylesheet">
    <link href='https://unpkg.com/css.gg@2.0.0/icons/css/info.css' rel='stylesheet'>
    <link rel="shortcut icon" href="../images/lapro-ico.png" type="image/x-icon">
</head>

<body>

    <?php
    session_start();

    if (isset($_SESSION["IsConnected"]) && $_SESSION["IsConnected"] == true) {
    ?>
        <form action="" method="post">
            <li class="nav-item">
                <button type='submit' name='Deconnexion' class="btn btn-primary">Se déconnecter</button>
            </li>
        </form>
    <?php

        if (isset($_POST["Deconnexion"])) // Sinon si l'utilisateur appuis sur le bouton de déconnexion
        {
            session_unset(); // On supprime tout les tableaux de la session
            session_destroy(); // On détruit la session
            header("Location: ../login-page/index.php");
        }
    }
    ?>




    <div class="container">
        <div class="left">
            Left
        </div>
        <div class="right">
            Right
        </div>
    </div>





</body>

</html>