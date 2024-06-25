<?php
include("./components/mesFonctionsGenerales.php");
ini_set("display_errors", 1);

$login = $_POST['login'];
$password = $_POST['password'];

$cnxBDD = connexion();
$sql = "SELECT * FROM USER WHERE LOGIN='" . $login . "' AND PASSWORD='". $password ."';";

$result = $cnxBDD->query($sql) or die ("Requete invalide : ".$sql);

if ($result->num_rows > 0) {

    $row = $result->fetch_assoc();

    $user_id = $row['id'];
    $user_login = $row['login'];
    $user_password = $row['password'];
    $user_typeuser = $row['typeuser'];

    session_start();
    $_SESSION["login"] = $user_login;
    $_SESSION["typeuser"] = $user_typeuser;

    echo $user_login;
    echo $user_typeuser;

    echo $_SESSION["login"];
    echo $_SESSION["typeuser"];

    header("Location: index.php");
    exit;
} else {
    echo "Connexion impossible : identifiant ou mot de passe incorrect.";
}

