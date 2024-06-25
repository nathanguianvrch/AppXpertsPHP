<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

ini_set("display_errors", 1);

include './components/mesFonctionsGenerales.php';
$cnxBDD = connexion();

$postData = file_get_contents("php://input");
$data = json_decode($postData);

if(isset($_GET["fetchChauffeurs"])) {
    $sql = "SELECT * FROM `CHAUFFEUR`";
    $result = $cnxBDD->query($sql) or die("Requete invalide : " . $sql);

    if (!$result) {
        die("Error in query: " . $cnxBDD->error);
    }

    $data = array();
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    $jsonData = json_encode($data);

    echo $jsonData;
}
elseif(isset($_GET["fetchChauffeurInfo"])) {
    $sql = "SELECT * FROM `CHAUFFEUR` WHERE CHFID = " . $data->CHFID;
    $result = $cnxBDD->query($sql) or die("Requete invalide : " . $sql);
    if (!$result) {
        die("Error in query: " . $cnxBDD->error);
    }
    $data = array();
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    $jsonData = json_encode($data);
    echo $jsonData;
}
elseif(isset($_GET["updateChauffeurInfo"])) {
    $CHFID = isset($data->CHFID) ? $data->CHFID : "";
    $CHFNOM = isset($data->CHFNOM) ? $data->CHFNOM : "";
    $CHFPRENOM = isset($data->CHFPRENOM) ? $data->CHFPRENOM : "";
    $CHFTEL = isset($data->CHFTEL) ? $data->CHFTEL : "";
    $CHFMAIL = isset($data->CHFMAIL) ? $data->CHFMAIL : "";

    $sql = "UPDATE CHAUFFEUR SET CHFNOM = ?, CHFPRENOM = ?, CHFTEL = ?, CHFMAIL = ? WHERE CHFID = ?";
    $stmt = $cnxBDD->prepare($sql);
    $stmt->bind_param("sssss", $CHFNOM, $CHFPRENOM, $CHFTEL, $CHFMAIL, $CHFID);
    $result = $stmt->execute() or die("Requete invalide : " . $sql);
    if (!$result) {
        die("Error in query: " . $cnxBDD->error);
    }
    echo "Chauffeur updated";
}
$cnxBDD->close();