<?php 

require_once 'C:/xampp/htdocs/webproj/controller/InscriptionC.php';
require_once 'C:/xampp/htdocs/webproj/model/Inscription.php';


$pc = new InscriptionC();
$p = new Inscription($_POST['Telephone'],$_POST['Categorie'],$_POST['DateReservation'],$_POST['Paiement']);

$pc-> AjouterInscription($p);

header('Location:covoiturage.php');

?>