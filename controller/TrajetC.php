<?php

include_once(__DIR__ . '/../config.php');
require_once(__DIR__ . '/../Model/Trajet.php');

class TrajetC {

    public function AjouterTrajet($trajet) {
        $db = config::getConnexion();
    
        try {
            $req = $db->prepare('
                INSERT INTO trajet (ID_Inscription, Adresse_Depart, Adresse_Arrivee, Nombre_Places, Prix, Distance, Duree)
                VALUES (:p, :a, :o, :m, :n, :j, :e)
            ');
            $req->execute([
                'p' => $trajet->getID_Inscription(),
                'a' => $trajet->getAdresseDepart(),
                'o' => $trajet->getAdresseArrivee(),
                'm' => $trajet->getNombrePlaces(),
                'n' => $trajet->getPrix(),
                'j' => $trajet->getDistance(),
                'e' => $trajet->getDuree(),
            ]);
            return $db->lastInsertId(); 
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }

    public function ListeTrajet() {
        $db = config::getConnexion();

        try {
            $liste = $db->query('SELECT * FROM trajet');
            return $liste;
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }

    public function DeleteTrajet($id) {
        $sql = "DELETE FROM trajet WHERE ID_Trajet = :id";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->bindValue(':id', $id, PDO::PARAM_INT);
            $query->execute();
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }
    

    public function GetTrajet($id) {
        $db = config::getConnexion();

        try {
            $req = $db->prepare('SELECT * FROM trajet WHERE ID_Trajet = :id');
            $req->execute([
                'id' => $id
            ]);

            return $req->fetch();
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }

    
    public function ajouterTrajetAvecRetourID($trajet) {
        $sql = "INSERT INTO trajet (ID_Inscription, Adresse_Depart, Adresse_Arrivee, Nombre_Places, Prix, Distance, Duree)
                VALUES (:ID_Inscription, :Adresse_Depart, :Adresse_Arrivee, :Nombre_Places, :Prix, :Distance, :Duree)";
        
        $db = config::getConnexion();
    
        try {
            $query = $db->prepare($sql);
    
            $query->execute([
                'ID_Inscription'   => $trajet->getID_Inscription(),
                'Adresse_Depart'   => $trajet->getAdresseDepart(),
                'Adresse_Arrivee'  => $trajet->getAdresseArrivee(),
                'Nombre_Places'    => $trajet->getNombrePlaces(),
                'Prix'            => $trajet->getPrix(),
                'Distance'        => $trajet->getDistance(),
                'Duree'           => $trajet->getDuree()
            ]);
    
            // Retourne l'ID du trajet inséré
            return $db->lastInsertId();
    
        } catch (PDOException $e) {
            // Tu peux aussi logger cette erreur dans un fichier si besoin
            echo "Erreur lors de l'ajout du trajet : " . $e->getMessage();
            return false;
        }
    }
    
    
    




    public function updateTrajet($trajet) {
        $sql = "UPDATE trajet SET 
                    Adresse_Arrivee = :Adresse_Arrivee,
                    Nombre_Places = :Nombre_Places,
                    Prix = :Prix,
                    Distance = :Distance,
                    Duree = :Duree
                WHERE ID_Trajet = :ID_Trajet";
        
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute([
                'Adresse_Arrivee' => $trajet['Adresse_Arrivee'],
                'Nombre_Places' => $trajet['Nombre_Places'],
                'Prix' => $trajet['Prix'],
                'Distance' => $trajet['Distance'],
                'Duree' => $trajet['Duree'],
                'ID_Trajet' => $trajet['ID_Trajet'],
            ]);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    
    
    
}


?>
