<?php
session_start();
if (!isset($_SESSION["login"]) || !isset($_SESSION["typeuser"])) {
    header("Location: ../connexion.php");
}
ini_set('display_errors', 1);
include 'lib.php';

if (isset($_GET["methode"])) {
    if ($_GET["methode"] == "create") {
        tournees_create();
    }
    if ($_GET["methode"] == "update") {
        tournees_update();
    }
    if ($_GET["methode"] == "delete") {
        tournees_delete();
    }
}

$liste = tournees_liste();
?>
<!DOCTYPE html>
<html lang="fr">
<?php
$title = "Gestion des tournées";
include("../components/head.inc.php");
?>

<body>
    <?php include("../components/navbar.inc.php"); ?>
    <h1 class="mx-10 my-5 text-3xl font-bold">Liste des tournées</h1>
    <div class="relative overflow-x-auto m-10 rounded-lg">
        <table class="w-full text-sm text-left text-gray-500 text-gray-400">
            <thead class="text-xs uppercase bg-green-700 text-green-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Tournée
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Date
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Chauffeur
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Véhicule
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Départ
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Arrivée
                    </th>
                    <th scope="col" class="px-6 py-3 text-center">
                        Modifier
                    </th>
                    <th scope="col" class="px-6 py-3 text-center">
                        Supprimer
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($liste as $element) { ?>
                    <tr class="border-b bg-green-800 border-green-700">
                        <td class="px-6 py-4 text-white">
                            <?php echo ($element["TRNNUM"]); ?>
                        </td>
                        <td class="px-6 py-4 text-white">
                            <?php echo ($element["TRNDTE"]); ?>
                        </td>
                        <td class="px-6 py-4 text-white">
                            <?php echo (getChauffeur($element["CHFID"])); ?>
                        </td>
                        <td class="px-6 py-4 text-white">
                            <?php echo ($element["VEHIMMAT"]); ?>
                        </td>
                        <?php
                        $lieux_depart_arrivee = getDepartArrivee($element["TRNNUM"]);
                        ?>
                        <td class="px-6 py-4 text-white">
                            <?php echo ($lieux_depart_arrivee[0]); ?>
                        </td>
                        <td class="px-6 py-4 text-white">
                            <?php echo ($lieux_depart_arrivee[1]); ?>
                        </td>
                        <td class="px-6 text-2xl text-center">
                            <a href="fiche.php?TRNNUM=<?php echo ($element["TRNNUM"]); ?>" class="font-medium text-blue-500 hover:underline"><i class="fa-solid fa-pen-to-square"></i></a>
                        </td>
                        <td class="px-6 text-2xl text-center">
                            <a href="gestion.php?methode=delete&TRNNUM=<?php echo ($element["TRNNUM"]); ?>" class="font-medium text-red-500 hover:underline"> <i class="fa-solid fa-trash"></i></a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <a href="ajouter.php" class="ml-10 focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 bg-green-600 hover:bg-green-700 focus:ring-green-800">Ajouter</a>
    <a href="../index.php" class="focus:outline-none text-white focus:ring-4 focus:ring-yellow-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 bg-yellow-600 hover:bg-yellow-700">Retour</a>
</body>

</html>