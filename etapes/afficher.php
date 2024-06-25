<?php
session_start();
if (!isset($_SESSION["login"]) || !isset($_SESSION["typeuser"])) {
    header("Location: ../connexion.php");
}
include '../components/mesFonctionsGenerales.php';

if (isset($_GET["TRNNUM"])) {
    $tournee_num = $_GET["TRNNUM"];
} else {
    $tournee_num = 0;
}

function etapes_liste($tournee_num)
{
    $cnxBDD = connexion();
    $sql = "  SELECT ETAPE.ETPID, LIEU.LIEUNOM, ETAPE.ETPHREMIN, ETAPE.ETPHREMAX, ETAPE.ETPNBPALLIV, ETAPE.ETPNBPALLIVEUR, ETAPE.ETPNBPALCHARG, ETAPE.ETPNBPALCHARGEUR, ETAPE.ETPCOMMENTAIRE
            FROM ETAPE
            JOIN LIEU ON ETAPE.LIEUID = LIEU.LIEUID
            WHERE ETAPE.TRNNUM = $tournee_num";
    $lieux = $cnxBDD->query($sql) or die("Requete invalide : " . $sql);
    return $lieux;
}
$etapes = etapes_liste($tournee_num);

?>
<!DOCTYPE html>
<html lang="fr">
<?php
$title = "Listes des étapes";
include("../components/head.inc.php");
?>

<body>
    <?php include("../components/navbar.inc.php");
    $cnxBDD = connexion();
    ?>
    <h1 class="mx-10 my-5 text-3xl font-bold">Liste des étapes</h1>
    <div class="mx-10 my-5 grid grid-cols-2 gap-10">
        <form action="" method="GET">
            <select id="TRNNUM" onchange="this.form.submit()" name="TRNNUM" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 bg-green-700 border-green-600 placeholder-gray-400 text-white focus:ring-blue-500 focus:border-blue-500 mb-6">
                <?php
                $cnxBDD = connexion();
                $sql = "SELECT TRNNUM FROM `TOURNEE` ORDER BY TRNNUM";
                $result = $cnxBDD->query($sql) or die("Requete invalide : " . $sql);
                foreach ($result as $element) {
                ?>
                    <option <?php if ($element["TRNNUM"] == $tournee_num) {
                                echo ("selected");
                            } ?> value="<?php echo ($element["TRNNUM"]) ?>"><?php echo "Tournée " . ($element["TRNNUM"]) ?></option>
                <?php }
                $cnxBDD->close(); ?>
            </select>
        </form>
    </div>
    <div id="myDiv" class="relative overflow-x-auto m-10 rounded-lg">
        <table class="w-full text-sm text-left text-gray-500 text-gray-400">
            <thead class="text-xs uppercase bg-green-700 text-green-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Etape
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Lieu
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Heure minimum
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Heure maximum
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Palettes livrées
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Palettes Euro livrées
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Palettes chargées
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Palettes Euro chargées
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Commentaire
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php
                $cnxBDD = connexion();
                $trnnum = $element['TRNNUM'];
                $sql = "SELECT TRNNUM FROM `ETAPE` WHERE ETPID = 1";
                $result = $cnxBDD->query($sql) or die("Requete invalide : " . $sql);
                ?>
                <?php foreach ($etapes as $element) { ?>
                    <tr class="border-b bg-green-800 border-green-700">
                        <td class="px-6 py-4 text-white">
                            <?php echo ($element["ETPID"]); ?>
                        </td>
                        <td class="px-6 py-4 text-white">
                            <?php echo ($element["LIEUNOM"]) ?>
                        </td>
                        <td class="px-6 py-4 text-white">
                            <?php echo ($element["ETPHREMIN"]) ?>
                        </td>
                        <td class="px-6 py-4 text-white">
                            <?php echo ($element["ETPHREMAX"]); ?>
                        </td>
                        <td class="px-6 py-4 text-white">
                            <?php echo ($element["ETPNBPALLIV"]); ?>
                        </td>
                        <td class="px-6 py-4 text-white">
                            <?php echo ($element["ETPNBPALLIVEUR"]); ?>
                        </td>
                        <td class="px-6 py-4 text-white">
                            <?php echo ($element["ETPNBPALCHARG"]); ?>
                        </td>
                        <td class="px-6 py-4 text-white">
                            <?php echo ($element["ETPNBPALCHARGEUR"]); ?>
                        </td>
                        <td class="px-6 py-4 text-white">
                            <?php echo ($element["ETPCOMMENTAIRE"]); ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>