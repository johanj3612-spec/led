<?php
// On définit le nom du petit fichier qui stockera l'état de la LED (0 ou 1)
$fichier_etat = "etat_led.txt";

// Si le fichier n'existe pas encore, on l'initialise à 0 (Éteint)
if (!file_exists($fichier_etat)) {
    file_put_contents($fichier_etat, "0");
}

// 🎛️ CONDITION IF/ELSE : Si l'utilisateur clique sur un bouton, on change l'état
if (isset($_GET['action'])) {
    if ($_GET['action'] == "on") {
        file_put_contents($fichier_etat, "1"); // On écrit 1 pour allumer
    } elseif ($_GET['action'] == "off") {
        file_put_contents($fichier_etat, "0"); // On écrit 0 pour éteindre
    }
    
    // On redirige vers la page principale pour nettoyer l'URL
    header("Location: index.php");
    exit();
}

// 🤖 Lecture de l'état actuel pour l'affichage et pour l'ESP32
$etat_actuel = trim(file_get_contents($fichier_etat));

// Si c'est l'ESP32 qui demande la page (on ajoute un paramètre dans son code plus bas),
// on lui répond UNIQUEMENT le texte brut "1" ou "0" sans le design HTML
if (isset($_GET['device']) && $_GET['device'] == "esp32") {
    echo $etat_actuel;
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contrôle LED Providence</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; background: #f4f4f9; padding-top: 50px; }
        h1 { color: #333; }
        .status { font-size: 20px; margin-bottom: 30px; font-weight: bold; }
        .status.on { color: #2ecc71; }
        .status.off { color: #e74c3c; }
        .btn { display: inline-block; padding: 15px 35px; font-size: 18px; font-weight: bold; color: white; border: none; border-radius: 8px; cursor: pointer; text-decoration: none; margin: 10px; transition: 0.2s; }
        .btn-on { background-color: #2ecc71; box-shadow: 0 4px #27ae60; }
        .btn-on:active { box-shadow: 0 0 #27ae60; transform: translateY(4px); }
        .btn-off { background-color: #e74c3c; box-shadow: 0 4px #c0392b; }
        .btn-off:active { box-shadow: 0 0 #c0392b; transform: translateY(4px); }
    </style>
</head>
<body>

    <h1>Contrôle de la LED</h1>
    
    <div class="status <?php echo ($etat_actuel == "1") ? "on" : "off"; ?>">
        Statut actuel : <?php echo ($etat_actuel == "1") ? "ALLUMÉ" : "ÉTEINT"; ?>
    </div>

    <!-- Boutons d'action -->
    <a href="index.php?action=on" class="btn btn-on">ALLUMER (ON)</a>
    <a href="index.php?action=off" class="btn btn-off">ÉTEINDRE (OFF)</a>

</body>
</html>
