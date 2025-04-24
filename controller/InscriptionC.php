<?php 

include_once(__DIR__ . '/../config.php');



class InscriptionC {

    public function ListeInscription () {
        $db=config::getConnexion();
    
        try {
            $liste=$db->query('SELECT *FROM inscription');
            return $liste;
        } catch (Exception $e){
            die ('Error: '.$e->getMessage());
        }
    }
    public function DeleteInscription ($id) {

        $db=config::getConnexion();

        try{

            $req=$db->prepare('
            DELETE FROM inscription WHERE id=:id
            ');
            $req->execute ([
                'id' => $id
            ]);

        }  catch (Exception $e){
            die ('Error: '.$e->getMessage());
        }
    }

    
  
  public function AjouterInscription($inscription) {
    $db = config::getConnexion();

    try {
        $req = $db->prepare('
            INSERT INTO inscription (telephone, categorie, dateReservation, paiement)
            VALUES (:p, :a, :o, :m)
        ');
        $req->execute([
            'p' => $inscription->getTelephone(),
            'a' => $inscription->getCategorie(),
            'o' => $inscription->getDateReservation(),
            'm' => $inscription->getPaiement(),
        ]);
        return $db->lastInsertId(); 
    } catch (Exception $e) {
        die('Error: ' . $e->getMessage());
    }
}
    

   public function GetInscription($id) {

    $db=config::getConnexion();

    try {

        $req=$db->prepare ('SELECT * FROM inscription WHERE id =:id');
        $req-> execute ([
            'id' => $id

        ]);

        return $req ->fetch ();

    } catch (Exception $e){
        die ('Error: '.$e->getMessage());
    }
   }



   public function ajouterInscriptionAvecRetourID(Inscription $inscription) {
    try {
        $pdo = config::getConnexion();

        $sql = "INSERT INTO inscription (Telephone, Categorie, DateReservation, Paiement) 
                VALUES (:Telephone, :Categorie, :DateReservation, :Paiement)";

        $query = $pdo->prepare($sql);

        $query->execute([
            ':Telephone' => $inscription->getTelephone(),
            ':Categorie' => $inscription->getCategorie(),
            ':DateReservation' => $inscription->getDateReservation(),
            ':Paiement' => $inscription->getPaiement()
        ]);

        return $pdo->lastInsertId(); // Correctement utilisé
    } catch (PDOException $e) {
        echo "Erreur lors de l'ajout : " . $e->getMessage();
        return false;
    }
}
ublic function rechercherInscriptionParID($id) {
    $sql = "SELECT * FROM inscription WHERE ID = :id";
    $db = config::getConnexion();
    try {
        $query = $db->prepare($sql);
        $query->bindValue(':id', $id);
        $query->execute();
        return $query->fetch();
    } catch (PDOException $e) {
        die('Erreur: '.$e->getMessage());
    }
}
   
}










?>