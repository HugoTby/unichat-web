<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UniChat</title>
    <link rel="stylesheet" href="main_style.css">
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