<?php
session_start();
if (!isset($_SESSION["login"]) || !isset($_SESSION["typeuser"])) {
    header("Location: ../connexion.php");
}
include("lib.php");
?>
<!DOCTYPE html>
<html lang="fr">
<?php
$title = "Ajouter une tournée";
include("../components/head.inc.php");
?>

<body>
    <?php include("../components/navbar.inc.php"); ?>
    <h1 class="mx-10 my-5 text-3xl font-bold">Ajouter une tournée</h1>
    <div class="mx-10 my-5 grid grid-cols-2 gap-10">
        <form action="gestion.php?methode=create" method="POST">
            <div class="grid grid-cols-2 gap-10">
                <div class="relative max-w-sm">
                    <label class="block mb-2 text-sm font-medium text-gray-900">Date</label>
                    <input type="datetime-local" name="TRNDTE" class="bg-green-700 text-white text-sm rounded-lg block w-full p-2.5" required>
                </div>
                <div class="mb-6">
                    <label for="CHFID" class="block mb-2 text-sm font-medium text-gray-900">Chauffeur</label>
                    <select id="CHFID" name="CHFID" class="bg-green-700 text-white text-sm rounded-lg block w-full p-2.5">
                        <?php
                        $cnxBDD = connexion();
                        $sql = "SELECT CHFID, CHFNOM, CHFPRENOM FROM `CHAUFFEUR` ORDER BY CHFNOM";
                        $result = $cnxBDD->query($sql) or die("Requete invalide : " . $sql);
                        foreach ($result as $chauffeurs) { ?>
                            <option value="<?php echo ($chauffeurs["CHFID"]) ?>">
                                <?php echo (strtoupper($chauffeurs["CHFNOM"]) . $chauffeurs["CHFPRENOM"]) ?>
                            </option>
                        <?php }
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
                        ?> <option value="<?php echo ($vehicules["VEHIMMAT"]) ?>">
                                <?php echo ($vehicules["VEHIMMAT"]) ?>
                            </option>
                        <?php }
                        $cnxBDD->close(); ?>
                    </select>
                </div>
                <div class="mb-6">
                    <label for="TRNPECCHAUFFEUR" class="block mb-2 text-sm font-medium text-gray-900">Prise en charge par le chauffeur</label>
                    <input type="text" name="TRNPECCHAUFFEUR" id="TRNPECCHAUFFEUR" class="bg-green-700 text-white text-sm rounded-lg block w-full p-2.5">
                </div>
            </div>
            <div class="mb-6">
                <label for="TRNCOMMENTAIRE" class="block mb-2 text-sm font-medium text-gray-900">Commentaire</label>
                <textarea name="TRNCOMMENTAIRE" rows="4" id="TRNCOMMENTAIRE" class="block w-full p-4 text-white border border-gray-300 rounded-lg bg-green-700 sm:text-md focus:ring-green-500 focus:border-green-500 border-green-600 placeholder-gray-400 focus:ring-green-500 focus:border-green-500"></textarea>
            </div>
            <button type="submit" class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center hover:bg-green-700 focus:ring-green-800">Ajouter</button>
        </form>
        <?php

        function etapes()
        {
            $cnxBDD = connexion();
            $id = $_GET['id'];
            $sql = "SELECT * FROM `ETAPE` WHERE TRNNUM = $id";
            $result = $cnxBDD->query($sql) or die("Requete invalide : " . $sql);
            $cnxBDD->close();
            return $result;
        }

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
    </div>
</body>

</html>