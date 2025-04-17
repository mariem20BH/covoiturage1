<?php
include '../controller/InscriptionC.php';

$pc = new InscriptionC();
$pc->DeleteInscription($_GET["id"]);

header('Location:ListeInscription.php');
?>

