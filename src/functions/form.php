<?php

include("../bdd/database.php");

function formulaire($erreur)
{



?>
<div class="center">
    <form class="login" method="post">
        <div id="div-logo">
            <img id="logo-unichat" src="../images/lapro-white-logo.png" alt="UniChat Logo">
        </div>
        <input name="username" type="text" maxlength="50" placeholder="Nom d'utilisateur (ex: prenom.nom)" required>
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
        ?>
    </form>
</div>
    
<?php

}
?>