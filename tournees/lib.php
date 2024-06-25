<?php
include '../components/mesFonctionsGenerales.php';

function tournees_liste()
{
    $cnxBDD = connexion();
    $sql = "SELECT TRNNUM, TRNDTE, CHFID, VEHIMMAT FROM `TOURNEE` ORDER BY TRNNUM";
    $result = $cnxBDD->query($sql) or die("Requete invalide : " . $sql);
    $cnxBDD->close();
    return $result;
}

function tournees_create() {
    $VEHIMMAT = $_POST["VEHIMMAT"];
    $CHFID = $_POST["CHFID"];
    $TRNCOMMENTAIRE = $_POST["TRNCOMMENTAIRE"];
    $TRNPECCHAUFFEUR = $_POST["TRNPECCHAUFFEUR"];
    $TRNDTE = $_POST["TRNDTE"];

    $cnxBDD = connexion();
    $sql="INSERT INTO TOURNEE (VEHIMMAT, CHFID, TRNCOMMENTAIRE, TRNPECCHAUFFEUR, TRNDTE) VALUES ('$VEHIMMAT', '$CHFID', '$TRNCOMMENTAIRE', '$TRNPECCHAUFFEUR', '$TRNDTE');";
    $result = $cnxBDD->query($sql) or die ("Requete invalide : ".$sql);
    $cnxBDD->close();

    header('Location: gestion.php');
}

/*function tournees_create()
{
    $VEHIMMAT = $_POST["VEHIMMAT"];
    $CHFID = $_POST["CHFID"];
    $TRNCOMMENTAIRE = $_POST["TRNCOMMENTAIRE"];
    $TRNPECCHAUFFEUR = $_POST["TRNPECCHAUFFEUR"];
    $TRNDTE = $_POST["TRNDTE"];

    $cnxBDD = connexion();
    $sql = "INSERT INTO TOURNEE (VEHIMMAT, CHFID, TRNCOMMENTAIRE, TRNPECCHAUFFEUR, TRNDTE) VALUES ('?', '?', '?', '?', '?');";
    $stmt = $cnxBDD->prepare($sql);
    $stmt->bind_param("sssss", $VEHIMMAT, $CHFID, $TRNCOMMENTAIRE, $TRNPECCHAUFFEUR, $TRNDTE);
    $result = $stmt->execute() or die("Requete invalide : " . $sql);
    $cnxBDD->close();

    header('Location: gestion.php');
}*/

function tournees_update()
{
    $TRNNUM = $_GET["TRNNUM"];
    $VEHIMMAT = $_POST["VEHIMMAT"];
    $CHFID = $_POST["CHFID"];
    $TRNCOMMENTAIRE = $_POST["TRNCOMMENTAIRE"];
    $TRNPECCHAUFFEUR = $_POST["TRNPECCHAUFFEUR"];
    $TRNDTE = $_POST["TRNDTE"];

    $cnxBDD = connexion();
    $sql = "UPDATE TOURNEE SET VEHIMMAT = '$VEHIMMAT', CHFID = '$CHFID', TRNCOMMENTAIRE = '$TRNCOMMENTAIRE', TRNPECCHAUFFEUR = '$TRNPECCHAUFFEUR', TRNDTE = '$TRNDTE' WHERE TRNNUM = '$TRNNUM';";
    $result = $cnxBDD->query($sql) or die("Requete invalide : " . $sql);
    $cnxBDD->close();

    header('Location: gestion.php');
}

function tournees_delete()
{
    $TRNNUM = $_GET["TRNNUM"];

    $cnxBDD = connexion();
    $sql = "DELETE FROM `TOURNEE` WHERE TRNNUM = $TRNNUM";
    $result = $cnxBDD->query($sql) or die("Requete invalide : " . $sql);
    $cnxBDD->close();

    header('Location: gestion.php');
}

function tournees_fiche($TRNNUM)
{
    $cnxBDD = connexion();
    $sql = "SELECT * FROM `TOURNEE` WHERE TRNNUM = $TRNNUM";
    $result = $cnxBDD->query($sql) or die("Requete invalide : " . $sql);
    foreach ($result as $element) {
        $tournees = $element;
    }
    $cnxBDD->close();
    return $tournees;
}

function getChauffeur($id)
{
    $cnxBDD = connexion();
    $temp = $cnxBDD->query("SELECT CHFNOM, CHFPRENOM FROM CHAUFFEUR WHERE CHFID = $id");
    foreach ($temp as $element) {
        $nomPrenom = $element["CHFPRENOM"];
        $nomPrenom .= strtoupper($element["CHFNOM"]);
    }
    $cnxBDD->close();
    return $nomPrenom;
}

function getDepartArrivee($trnnum)
{
    $cnxBDD = connexion();
    $temp = $cnxBDD->query("SELECT LIEU.LIEUNOM FROM LIEU, ETAPE WHERE ETAPE.TRNNUM = $trnnum AND ETAPE.LIEUID = LIEU.LIEUID ORDER BY ETAPE.ETPHREFIN");
    $cnxBDD->close();
    $lieux = [];
    foreach ($temp as $element) {
        $lieux[] = $element["LIEUNOM"];
    }
    if (isset($lieux[0])) {
        $depart_arrivee = [$lieux[0], end($lieux)];
    } else {
        $depart_arrivee = ["", end($lieux)];
    }
    return $depart_arrivee;
}


function etapes_fiche($ETPID)
{
    $cnxBDD = connexion();
    $sql = "SELECT * FROM `ETAPE` WHERE ETPID = $ETPID";
    $result = $cnxBDD->query($sql) or die("Requete invalide : " . $sql);
    foreach ($result as $element) {
        $etape = $element;
    }
    $cnxBDD->close();
    return $etape;
}

function etapes_create()
{
    $TRNNUM = $_GET["TRNNUM"];

    $ETPID = $_POST["ETPID"];
    $LIEUID = $_POST["LIEUID"];
    $ETPHREMIN = $_POST["ETPHREMIN"];
    $ETPHREMAX = $_POST["ETPHREMAX"];
    $ETPCOMMENTAIRE = $_POST["ETPCOMMENTAIRE"];



    $cnxBDD = connexion();
    $sql = "INSERT INTO ETAPE (ETPID, TRNNUM, LIEUID, ETPHREMIN, ETPHREMAX, ETPCOMMENTAIRE) VALUES ('$ETPID', '$TRNNUM','$LIEUID', '$ETPHREMIN', '$ETPHREMAX', '$ETPCOMMENTAIRE');";
    $result = $cnxBDD->query($sql) or die("Requete invalide : " . $sql);
    $cnxBDD->close();

    header('Location: fiche.php?TRNNUM=' . $TRNNUM);
}

function etapes_update()
{
    $ETPID = $_GET["ETPID"];

    $LIEUID = $_POST["LIEUID"];
    $ETPHREMIN = $_POST["ETPHREMIN"];
    $ETPHREMAX = $_POST["ETPHREMAX"];
    $ETPCOMMENTAIRE = $_POST["ETPCOMMENTAIRE"];
    var_dump($LIEUID);
    var_dump($ETPHREMIN);
    var_dump($ETPHREMAX);
    var_dump($ETPCOMMENTAIRE);

    $cnxBDD = connexion();
    $sql = "UPDATE ETAPE SET LIEUID = '$LIEUID' ETPHREMIN = '$ETPHREMIN', ETPHREMAX = '$ETPHREMAX', ETPCOMMENTAIRE = '$ETPCOMMENTAIRE' WHERE ETPID = '$ETPID';";
    $result = $cnxBDD->query($sql) or die("Requete invalide : " . $sql);
    $cnxBDD->close();

    //header('Location: tournees_fiche.php?TRNNUM='.$TRNNUM);
}

function etapes_delete()
{
    $ETPID = $_GET["ETPID"];
    $TRNNUM = $_GET["TRNNUM"];

    $cnxBDD = connexion();
    $sql = "DELETE FROM `ETAPE` WHERE ETPID = $ETPID";
    $result = $cnxBDD->query($sql) or die("Requete invalide : " . $sql);
    $cnxBDD->close();

    header('Location: fiche.php?TRNNUM=' . $TRNNUM);
}
