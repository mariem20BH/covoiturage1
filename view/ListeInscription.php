<?php

require_once 'C:/xampp/htdocs/webproj/controller/InscriptionC.php';



$pc = new InscriptionC();
$liste = $pc->ListeInscription();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Inscriptions</title>
</head>
<body>

<ul>
    <?php foreach ($liste as $p) {

    ?>
        <li> 

            <?php echo ($p['ID']); ?>
            <?php echo ($p['Telephone']); ?> 
            <?php echo ($p['Categorie']); ?>
            <?php echo ($p['DateReservation']); ?>  
            <?php echo ($p['Paiement']); ?> 
            <a href="Delete.php?idé=<?= $p['ID']; ?> ">delete</a>
            <form action="update.php" >
                <input type="hidden" name="ID" value ="<?php echo ($p['ID']); ?> ">
                <input type="submit" name="ID" value ="update ">
                

            </form>
        </li>

      
    <?php } ?>

    </ul>



</body>
</html>
 
