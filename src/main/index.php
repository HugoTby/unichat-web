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
    <script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>
</head>

<body>
    <div id="topbar">
        <?php
        session_start();

        // Check if the user is connected
        if (isset($_SESSION["IsConnected"]) && $_SESSION["IsConnected"] == true) {
        ?>
            <!-- Display a form for user logout -->
            <form action="" method="post">
                <li class="nav-item">
                    <!-- Button for user logout -->
                    <button type='submit' name='Deconnexion' class="btn btn-primary">Se déconnecter</button>
                </li>
            </form>


            Top - Menu section

    </div>
    <!-- Main content container -->
    <div class="container">
        <!-- Left side with a video -->
        <div class="left">
            <!-- <video autoplay muted>
            <source src="http://commondatastorage.googleapis.com/gtv-videos-bucket/sample/BigBuckBunny.mp4" type="video/mp4">
            Votre navigateur ne prend pas en charge la lecture de vidéos.
        </video> -->
        <div class="embed-responsive embed-responsive-16by9">
		   <video id="video" class="embed-responsive-item video-js vjs-default-skin" controls muted="muted"></video>
		 </div>
		</div>
        

		<script>
			if(Hls.isSupported()) {
				var video = document.getElementById('video');
				var hls = new Hls();
				hls.loadSource('http://192.168.64.233:8080/hls/test.m3u8');
				hls.attachMedia(video);
				hls.on(Hls.Events.MANIFEST_PARSED,function() {
				  video.play();
				});
			}
		</script>
            <!-- <iframe src="https://1stream.buzz/fr/2/1" webkitallowfullscreen="true" mozallowfullscreen="true" allow="autoplay" allowfullscreen="true" scrolling="no" frameborder="0" allowtransparency="true" width="1150" height="600"></iframe> -->
        </div>
        <!-- Right side with LiveChat section -->
        <!-- <div class="right">
            Right - LiveChat section<br>/*Reste a dev jquery et ajax pour la gestion du rechargement dynamique des div. Voir projet de l'an dernier sur GitHub pour le code.*/
            <pre><script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
function scrollToBottom() {
var messagesContainer = document.getElementById("messages");
$(messagesContainer).animate({
    scrollTop: messagesContainer.scrollHeight
}, 1000);
}

// Faire défiler jusqu'en bas au chargement de la page
$(window).on("load", function() {
scrollToBottom();
});

setInterval(load_messages, 1000);

function load_messages() {
$('#messages').load('messages.php');
scrollToBottom();
}
        </pre>
        </div> -->
    </div>


<?php

            // Check if the user clicked the logout button
            if (isset($_POST["Deconnexion"])) {
                // Unset and destroy the session
                session_unset();
                session_destroy();
                // Redirect to the login page
                header("Location: ../login-page/index.php");
            }
        } else {
            session_unset();
            session_destroy();
            // Redirect to the login page
            header("Location: ../login-page/index.php");
        }
?>



</body>

</html>