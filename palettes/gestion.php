<?php
session_start();
if (!isset($_SESSION["login"]) || !isset($_SESSION["typeuser"])) {
    header("Location: ../connexion.php");
}
ini_set('display_errors', 1);
include '../components/mesFonctionsGenerales.php';

if(isset($_GET["LIEUID"])) {
    $lieu_id = $_GET["LIEUID"];
}
else {
    $lieu_id = 0;
}
function palettes_liste($lieu_id) {
    $cnxBDD = connexion();
    $sql="  SELECT ETAPE.ETPNBPALLIVEUR, ETAPE.ETPNBPALCHARGEUR, TOURNEE.TRNDTE, CHAUFFEUR.CHFNOM, TOURNEE.TRNNUM
            FROM ETAPE
            JOIN TOURNEE ON ETAPE.TRNNUM = TOURNEE.TRNNUM
            JOIN CHAUFFEUR ON TOURNEE.CHFID = CHAUFFEUR.CHFID
            WHERE ETAPE.LIEUID = $lieu_id";
    $lieux = $cnxBDD->query($sql) or die ("Requete invalide : ".$sql);
    return $lieux;
}
$lieux = palettes_liste($lieu_id)
?>
<DOCTYPE! html>
<html lang="fr">
    <?php 
    $title = "Gestion des palettes";
    include("../components/head.inc.php"); 
    ?>
    <body>
        <?php include("../components/navbar.inc.php"); ?>
        <div class="m-10">
            <form action="" method="GET">
                <select id="LIEUID" onchange="this.form.submit()" name="LIEUID" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 bg-green-700 border-green-600 placeholder-gray-400 text-white focus:ring-blue-500 focus:border-blue-500 mb-6">
                    <?php 
                        $cnxBDD = connexion();
                        $sql="SELECT LIEUNOM, LIEUID FROM `LIEU` ORDER BY LIEUNOM";
                        $result = $cnxBDD->query($sql) or die ("Requete invalide : ".$sql);
                        foreach($result as $element) {
                        ?> <option
                        <?php if($element["LIEUID"] == $lieu_id) {echo("selected");} ?>
                         value="<?php echo($element["LIEUID"])?>"><?php echo($element["LIEUNOM"])?></option>
                    <?php }   
                        $cnxBDD->close();?>
                </select>
            </form>
        </div>
        
    <div id="myDiv" class="relative overflow-x-auto m-10 rounded-lg">
            <table class="w-full text-sm text-left text-gray-500 text-gray-400">
                <thead class="text-xs uppercase bg-green-700 text-green-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Tournée
                        </th>
                        <th scope="col" class="px-6 py-3">
                            
                        </th>
                        <th scope="col" class="px-6 py-3">
                            
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Livrées
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Chargées
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Crédit
                        </th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                    $cnxBDD = connexion();
                    $lieuid = $element['LIEUID'];
                    $sql="SELECT TRNNUM FROM `ETAPE` WHERE LIEUID = 1";
                    $result = $cnxBDD->query($sql) or die ("Requete invalide : ".$sql);
                    ?>
                <?php foreach ($lieux as $element){?>
                    <tr class="border-b bg-green-800 border-green-700">
                        <td class="px-6 py-4 text-white">
                            <?php echo($element["TRNNUM"]);?>
                        </td>
                        <td class="px-6 py-4 text-white">
                           <?php echo($element["TRNDTE"])?>
                        </td>
                        <td class="px-6 py-4 text-white">
                            <?php echo(strtoupper($element["CHFNOM"])) ?>
                        </td>
                        <td class="px-6 py-4 text-white">
                            <?php echo($element["ETPNBPALLIVEUR"]);?>
                        </td>
                        <td class="px-6 py-4 text-white">
                            <?php echo($element["ETPNBPALCHARGEUR"]);?>
                        </td>
                        <td class="px-6 py-4 text-white">
                            <?php echo($element["ETPNBPALLIVEUR"] - $element["ETPNBPALCHARGEUR"]);?>
                        </td>
                    </tr>
                <?php }?>
                </tbody>
            </table>
        </div>
        <div class="m-10">
            <a href="../index.php" class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-yellow-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 focus:ring-yellow-900">Retour</a>
            <button onclick="generatePDF()" class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-yellow-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 focus:ring-yellow-900">Imprimer en PDF</button>
        </div>
    </body>    
</html>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.debug.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>
<script>

function generatePDF() {
  // Récupération de la div
  const div = document.getElementById("myDiv");
  
  // Capture d'écran de la div avec html2canvas
  html2canvas(div).then((canvas) => {
    const imgData = canvas.toDataURL("image/png");
    
    // Création d'un PDF avec jsPDF
    const pdf = new jsPDF();
    pdf.addImage(imgData, 'PNG', 0, 0);
    pdf.save('mydiv.pdf');
  });
}

</script>