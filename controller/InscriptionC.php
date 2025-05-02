<?php 

include_once(__DIR__ . '/../config.php');

class InscriptionC {

    public function ListeInscription() {
        $db = config::getConnexion();
    
        try {
            // Requête SQL pour récupérer toutes les inscriptions
            $query = $db->query('SELECT * FROM inscription');
            
            // Retourner les résultats sous forme de tableau associatif
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            // Gérer les erreurs de la base de données
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

    public function updateInscription($inscription) {
        $db = config::getConnexion();
        
        try {
            $req = $db->prepare('
                UPDATE inscription 
                SET telephone = :telephone, 
                    categorie = :categorie, 
                    dateReservation = :dateReservation, 
                    paiement = :paiement
                WHERE id = :id
            ');
            
            $req->execute([
                'id' => $inscription->getID(),
                'telephone' => $inscription->getTelephone(),
                'categorie' => $inscription->getCategorie(),
                'dateReservation' => $inscription->getDateReservation(),
                'paiement' => $inscription->getPaiement()
            ]);
            
            return true;
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
            return false;
        }
    }
    
    public function getInscriptionByTelephone($telephone) {
        $db = config::getConnexion();
        
        try {
            $req = $db->prepare('SELECT * FROM inscription WHERE telephone = :telephone');
            $req->execute([
                'telephone' => $telephone
            ]);
            
            return $req->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }
    
    // Fonction pour obtenir les statistiques des catégories d'inscription
    public function getStatistiqueCategories() {
        $db = config::getConnexion();
        
        try {
            $query = $db->query('
                SELECT categorie, COUNT(*) as nombre 
                FROM inscription 
                GROUP BY categorie
            ');
            
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
            return [];
        }
    }
    
    // Fonction pour obtenir les statistiques des modes de paiement
    public function getStatistiquePaiements() {
        $db = config::getConnexion();
        
        try {
            $query = $db->query('
                SELECT paiement, COUNT(*) as nombre 
                FROM inscription 
                GROUP BY paiement
            ');
            
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
            return [];
        }
    }
    
    // Fonction pour obtenir les statistiques des inscriptions par mois
    public function getStatistiqueParMois() {
        $db = config::getConnexion();
        
        try {
            $query = $db->query('
                SELECT DATE_FORMAT(dateReservation, "%Y-%m") as mois, COUNT(*) as nombre 
                FROM inscription 
                GROUP BY DATE_FORMAT(dateReservation, "%Y-%m")
                ORDER BY mois
            ');
            
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
            return [];
        }
    }
   
}

?>