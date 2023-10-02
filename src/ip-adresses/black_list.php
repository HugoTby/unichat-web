<?php

$blacklist = array(
    // * IP addresses refused by default
    // ! "127.0.0.1" => "Localhost",
    "192.168.0.1" => "Default Gateway",
    "10.0.0.1" => "Private Network",
    "8.8.8.8" => "Google Public DNS server",
    "192.168.65.233" => "Ordinateur non-autorisé",
    // ! "192.168.64.129" => "Ordinateur non-autorisé", //Ordinateur Hugo
    
    // * here you can add the addresses you want to block, and the reason or the origin
    // * " IP " => " Reason or origin",
);

/* 

--
-- Structure de la table `blacklist`
--

CREATE TABLE `blacklist` (
  `id` int(11) NOT NULL,
  `ip` varchar(15) NOT NULL,
  `reason` varchar(100) NOT NULL,
  `statut` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `blacklist`
--

INSERT INTO `blacklist` (`id`, `ip`, `reason`, `statut`) VALUES
(1, '127.0.0.1', 'Localhost', 1),
(2, '192.168.0.1', 'Default Gateway', 1),
(3, '10.0.0.1', 'Private Network', 1),
(4, '8.8.8.8', 'Google Public DNS Server', 1),
(6, '192.168.65.70', 'Le nom ou le prénom renseigné est invalide', 0);


***********************************************************

<?php

$host =                "192.168.65.92";           // Adresse IP //
$username =            "root";                    // Username   //
$password =            "root";                    // Password   //
$dbname =              "meet";                    // Nom base   //
$conn = mysqli_connect($host, $username, $password, $dbname);


if ($conn) { // Si la connexion à la bdd est réussie
    // Requête 1 : sélectionne les données de la table `adress`
    $stmt1 = $conn->prepare("SELECT `ip`, `reason`, `statut` FROM `adress`");
    $stmt1->execute();
    $result1 = $stmt1->get_result();

    // Requête 2 : sélectionne les données de la table `blacklist`
    $stmt2 = $conn->prepare("SELECT `ip`, `reason`, `statut` FROM `blacklist`");
    $stmt2->execute();
    $result2 = $stmt2->get_result();

    $blacklist = array(
        // IP addresses refused by default
        //"127.0.0.1" => "Localhost",
        //"192.168.0.1" => "Default Gateway",
        //"10.0.0.1" => "Private Network",
        //"8.8.8.8" => "Google Public DNS Server",

            
    // here you can add the addresses you want to block, and the reason or the origin
    // " IP " => " Reason or origin",
    );

    if ($result1->num_rows > 0) {
        while ($row = $result1->fetch_assoc()) {
            $ip = $row['ip'];
            $reason = $row['reason'];
            $statut = $row['statut'];
            if ($statut == 1) {
                $blacklist[$ip] = $reason;
            }
        }
    }
    if ($result2->num_rows > 0) {
        while ($row = $result2->fetch_assoc()) {
            $ip = $row['ip'];
            $reason = $row['reason'];
            $statut = $row['statut'];
            if ($statut == 1) {
                $blacklist[$ip] = $reason;
            }
        }
    }
} else {
    // Si la connexion à la bdd échoue
    die("Erreur de connexion à la base de données");
}

?>
*/
?>