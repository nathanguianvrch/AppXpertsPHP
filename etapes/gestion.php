<?php
session_start();
if (!isset($_SESSION["login"]) || !isset($_SESSION["typeuser"])) {
    header("Location: ../connexion.php");
}
include '../components/mesFonctionsGenerales.php';
$TRNNUM = $_GET["TRNNUM"];
?>
<!DOCTYPE html>
<html lang="fr">
<?php
$title = "Ajouter une étape";
include("../components/head.inc.php");
?>

<body>
    <?php include("../components/navbar.inc.php");
    $cnxBDD = connexion();
    ?>
    <h1 class="mx-10 my-5 text-3xl font-bold">Ajouter une étape à la tournée n°<?php echo ($TRNNUM); ?></h1>
    <div class="mx-10 my-5 grid grid-cols-2 gap-10">
        <form action="../tournees/fiche.php?methode=create&TRNNUM=<?php echo ($TRNNUM); ?>" method="POST">
            <div class="mb-6">
                <label for="company" class="block mb-2 text-sm font-medium text-gray-900">ETPID</label>
                <input type="number" name="ETPID" class="bg-green-700 text-white text-sm rounded-lg block w-full p-2.5" required>
            </div>
            <div class="grid grid-cols-2 gap-10 mb-6">
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900">Lieu</label>
                    <select required name="LIEUID" class="bg-green-700 text-white text-sm rounded-lg block w-full p-2.5">
                        <option selected>Choisissez le lieu</option>
                        <?php
                        $cnxBDD = connexion();
                        $sql = "SELECT LIEUID,LIEUNOM FROM `LIEU` WHERE VILID IN (SELECT VILID FROM COMMUNE) order by LIEUNOM;";
                        echo $sql;
                        $result = $cnxBDD->query($sql) or die("Requete invalide : " . $sql);
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value=" . $row['LIEUID'] . ">" . $row['LIEUNOM'] . "</option>;";
                        }
                        $cnxBDD->close(); ?>
                    </select>
                </div>
                <div>
                    <label for="company" class="block mb-2 text-sm font-medium text-gray-900">Pris en charge le</label>
                    <input type="datetime-local" name="" class="bg-green-700 text-white text-sm rounded-lg block w-full p-2.5" required>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-10 mb-6">
                <div>
                    <label for="last_name" class="block mb-2 text-sm font-medium text-gray-900">Rendez-vous entre</label>
                    <input type="datetime-local" name="ETPHREMIN" class="bg-green-700 text-white text-sm rounded-lg block w-full p-2.5" required>
                </div>
                <div>
                    <label for="company" class="block mb-2 text-sm font-medium text-gray-900">Et</label>
                    <input type="datetime-local" name="ETPHREMAX" class="bg-green-700 text-white text-sm rounded-lg block w-full p-2.5" required>
                </div>
            </div>
            <div class="mb-6">
                <label for="company" class="block mb-2 text-sm font-medium text-gray-900">Commentaire</label>
                <input type="text" name="ETPCOMMENTAIRE" class="bg-green-700 text-white text-sm rounded-lg block w-full p-2.5" required>
            </div>
            <button type="submit" class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Valider</button>
            <button type="submit" class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Annuler</button>
        </form>
    </div>
</body>