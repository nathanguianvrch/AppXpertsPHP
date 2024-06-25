<?php
session_start();
if (!isset($_SESSION["login"]) || !isset($_SESSION["typeuser"])) {
    header("Location: ../connexion.php");
}
ini_set('display_errors', 1);
include 'lib.php';
$TRNNUM = $_GET['TRNNUM'];
$tournees = tournees_fiche($TRNNUM);

if (isset($_GET["methode"])) {
    if ($_GET["methode"] == "create") {
        etapes_create();
    }
    if ($_GET["methode"] == "update") {
        etapes_update();
    }
    if ($_GET["methode"] == "delete") {
        etapes_delete();
    }
}

?>
<!DOCTYPE html>
<html lang="fr">
<?php
$title = "Fiche de la tournée";
include("../components/head.inc.php");
?>

<body>
    <?php include("../components/navbar.inc.php"); ?>
    <h1 class="mx-10 my-5 text-3xl font-bold">Fiche de la tournée N°<?php echo ($tournees["TRNNUM"]); ?></h1>
    <div class="mx-10 my-5 grid grid-cols-2 gap-10">
        <form action="gestion.php?methode=update&TRNNUM=<?php echo ($tournees["TRNNUM"]); ?>" method="POST">
            <div class="grid grid-cols-2 gap-10">
                <div class="relative max-w-sm mb-6">
                    <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Date</label>
                    <input type="datetime-local" name="TRNDTE" class="bg-green-700 text-white text-sm rounded-lg block w-full p-2.5" value="<?php echo ($tournees["TRNDTE"]); ?>" required>
                </div>
                <div class="mb-6">
                    <label for="CHFID" class="block mb-2 text-sm font-medium text-gray-900">Chauffeur</label>
                    <select id="CHFID" name="CHFID" class="bg-green-700 text-white text-sm rounded-lg block w-full p-2.5">
                        <?php
                        $cnxBDD = connexion();
                        $sql = "SELECT CHFID, CHFNOM, CHFPRENOM FROM `CHAUFFEUR` ORDER BY CHFNOM";
                        $result = $cnxBDD->query($sql);
                        foreach ($result as $chauffeur) {
                            $selected = ($chauffeur['CHFID'] == $tournees['CHFID']) ? 'selected' : '';
                            echo '<option value="' . $chauffeur['CHFID'] . '" ' . $selected . '>' . strtoupper($chauffeur['CHFNOM']) . ' ' . $chauffeur['CHFPRENOM'] . '</option>';
                        }
                        $cnxBDD->close(); ?>
                    </select>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-10">
                <div class="mb-6">
                    <label for="VEHIMMAT" class="block mb-2 text-sm font-medium text-gray-900">Immatriculation véhicule</label>
                    <select id="VEHIMMAT" name="VEHIMMAT" class="bg-green-700 text-white text-sm rounded-lg block w-full p-2.5">
                        <?php
                        $cnxBDD = connexion();
                        $sql = "SELECT VEHIMMAT FROM `VEHICULE`";
                        $result = $cnxBDD->query($sql) or die("Requete invalide : " . $sql);
                        foreach ($result as $vehicules) {
                        ?> <option value="<?php echo ($vehicules["VEHIMMAT"]) ?>" <?php if ($vehicules["VEHIMMAT"] == $tournees["VEHIMMAT"]) {
                                                                                        echo ("selected");
                                                                                    } ?> <?php echo ($vehicules["VEHIMMAT"]) ?> </option>
                            <?php }
                        $cnxBDD->close(); ?>
                    </select>
                </div>
                <div class="mb-6">
                    <label for="TRNPECCHAUFFEUR" class="block mb-2 text-sm font-medium text-gray-900">Prise en charge par le chauffeur</label>
                    <input type="text" name="TRNPECCHAUFFEUR" id="TRNPECCHAUFFEUR" class="bg-green-700 text-white text-sm rounded-lg block w-full p-2.5" value="<?php echo ($tournees["TRNPECCHAUFFEUR"]); ?>">
                </div>
            </div>
            <div class="mb-6">
                <label for="TRNCOMMENTAIRE" class="block mb-2 text-sm font-medium text-gray-900">Commentaire</label>
                <textarea name="TRNCOMMENTAIRE" rows="4" id="TRNCOMMENTAIRE" class="block w-full p-4 text-white rounded-lg bg-green-700 sm:text-md focus:ring-green-500 focus:border-green-500 border-green-600 placeholder-gray-400 focus:ring-green-500 focus:border-green-500"><?php echo ($tournees["TRNCOMMENTAIRE"]); ?></textarea>
            </div>
            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:outline-none font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center hover:bg-blue-700">Modifier</button>
            <a href="gestion.php" class="focus:outline-none text-white bg-yellow-500 hover:bg-yellow-600 focus:ring-4 focus:ring-yellow-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 focus:ring-yellow-900">Retour</a>
        </form>
        <?php

        function etapes()
        {
            $cnxBDD = connexion();
            $TRNNUM = $_GET['TRNNUM'];
            $sql = "SELECT * FROM `ETAPE` WHERE TRNNUM = $TRNNUM";
            $result = $cnxBDD->query($sql) or die("Requete invalide : " . $sql);
            $cnxBDD->close();
            return $result;
        }
        $etapes = etapes();

        function lieux($lieuid)
        {
            $cnxBDD = connexion();
            $sql = "SELECT LIEUNOM FROM `LIEU` WHERE LIEUID = $lieuid";
            $result = $cnxBDD->query($sql) or die("Requete invalide : " . $sql);
            $cnxBDD->close();
            foreach ($result as $lieu) {
            }
            return $lieu;
        }
        ?>
        <div>
            <label class="block mb-2 text-sm font-medium text-gray-900">Liste des étapes</label>
            <div class="relative overflow-x-auto rounded-lg mb-6">
                <table class="w-full text-sm text-left text-gray-500 text-gray-400">
                    <thead class="text-xs uppercase bg-green-700 text-green-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Etapes
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Lieux
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
                        <?php foreach ($etapes as $element) { ?>
                            <tr class="border-b bg-green-800 border-green-700">
                                <th scope="row" class="px-6 py-4 font-medium text-white whitespace-nowrap">
                                    <?php echo ($element["ETPID"]); ?>
                                </th>
                                <td class="px-6 py-4 text-white">
                                    <?php $lieu = lieux($element["LIEUID"]);
                                    echo ($lieu["LIEUNOM"]); ?>
                                </td>
                                <td class="px-6 text-2xl text-center">
                                    <a href="../etapes/fiche.php?ETPID=<?php echo ($element["ETPID"]); ?>&TRNNUM=<?php echo ($TRNNUM); ?>" class="font-medium text-blue-500 hover:underline"><i class="fa-solid fa-pen-to-square"></i></a>
                                </td>
                                <td class="px-6 text-2xl text-center">
                                    <a href="fiche.php?methode=delete&TRNNUM=<?php echo ($TRNNUM); ?>&ETPID=<?php echo ($element["ETPID"]); ?>" class="font-medium text-red-500 hover:underline"><i class="fa-solid fa-trash"></i></a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <a href="../etapes/gestion.php?TRNNUM=<?php echo ($tournees["TRNNUM"]); ?>" class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center hover:bg-green-700 focus:ring-green-800">Ajouter</a>
        </div>

    </div>
</body>

</html>