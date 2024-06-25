<?php
session_start();
if (!isset($_SESSION["login"]) || !isset($_SESSION["typeuser"])) {
    header("Location: connexion.php");
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.8/dist/alpine.js" defer></script>
    <title>Accueil</title>
</head>

<body>
    <?php include("./components/navbar.inc.php"); ?>
    <section class="py-16">
        <div class="flex gap-4">
            <div class="border rounded-lg p-8 flex flex-col">
                <h4 class="text-gray-800 font-semibold text-xl"><img src="src/forklift.svg">Tournées</h4>
                <a href="/AppXpertsPHP/tournees/gestion.php" class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">
                    Voir
                </a>
            </div>
            <div class="border rounded-lg p-8 flex flex-col">
                <h4 class="text-gray-800 font-semibold text-xl"><img src="src/position-marker.svg">Étapes</h4>
                <a href="/AppXpertsPHP/etapes/afficher.php" class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">
                    Voir
                </a>
            </div>
            <div class="border rounded-lg p-8 flex flex-col">
                <h4 class="text-gray-800 font-semibold text-xl"><img src="src/blockchain.svg">Palettes</h4>
                <a href="/AppXpertsPHP/palettes/gestion.php" class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">
                    Voir
                </a>
            </div>
        </div>
    </section>
</body>

</html>