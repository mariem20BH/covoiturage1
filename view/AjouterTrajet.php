<?php 

require_once 'C:/xampp/htdocs/webproj/controller/TrajetC.php';
require_once 'C:/xampp/htdocs/webproj/model/Trajet.php';


$pc = new TrajetC();
$p = new Trajet($_POST['ID_Inscription'],$_POST['Adresse_Depart'],$_POST['Adresse_Arrivee'],$_POST['Nombre_Places'],$_POST['Prix'],$_POST['Distance'],$_POST['Duree'];);

$pc-> AjouterTrajet($p);

header('Location:covoiturage.php');

?>