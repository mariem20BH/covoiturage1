EasyParki – Gestion de Covoiturage 
Le module Covoiturage d’EasyParki permet aux utilisateurs de partager leurs trajets facilement. Ils peuvent proposer un trajet ou s’inscrire à un trajet existant en fonction de leur destination et de l’horaire.
Ce service aide à réduire les frais de transport, limite l’impact écologique et facilite les déplacements vers les hôtels ou zones touristiques. Il est directement lié aux places de parking disponibles, pour une organisation complète et pratique du voyage.
L’objectif est d’offrir une interface conviviale, fonctionnelle et durable, centralisant hébergement et mobilité urbaine.

🎯 Objectifs Fonctionnels
Créer un trajet de covoiturage personnalisé (ville de départ, destination, date, heure, type de transport...).

Permettre l’inscription des utilisateurs à un trajet existant (avec coordonnées, mode de paiement, catégorie...).

Vérifier la cohérence des informations saisies (date de réservation valide, numéro de téléphone unique, places disponibles...).

Afficher un message de confirmation lors d’une inscription ou d’un ajout de trajet réussi.

🏗️ Architecture du Projet
/Model/
  └── Inscription.php         

/Controller/
  └── InscriptionC.php         

/View/
  ├── config.php              
  
  ├── front/
  │   └── template front/
  │       ├── assets/
  │       ├── forms/
  │       └── covoiturage.php      

  └── back/
      ├── assets/
      ├── github/
      ├── docs/
      ├── pages/
      │   └── tables.php           
      └── template.php              
           
Modèle de Données
Table : inscription

Attribut	
ID	
Telephone	
Categorie	
DateReservation
Paiement	



	
⚙️ Installation & Configuration
Cloner le projet :

bash
Copier
Modifier
git clone https://github.com/ton-utilisateur/easyparki.git
cd easyparki
Créer la base de données avec les tables ci-dessus (PostgreSQL recommandé).

Configurer config.php :
<?php
// config.php

class config {
    public static function getConnexion() {
        $host = 'localhost';
        $dbname = 'projeteasyparki';
        $username = 'root';
        $password = '';

        try {
            $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            echo "Erreur de connexion à la base de données : " . $e->getMessage();
            die();
        }
    }
}


Lancer le serveur local :

bash
Copier
Modifier
php -S localhost:8000
🚀 Utilisation
Accéder à http://localhost:8000/View/front/addplanVacancefront.php

Compléter le formulaire

Ajouter une inscription
Valider → message de succès 

🤝 Contribution
Fork du projet

Nouvelle branche : git checkout -b feature-nouvelle-fonction

Commit : git commit -m "Ajout d'une fonctionnalité"

Push : git push origin feature-nouvelle-fonction

Pull Request ✔️

Licence
Ce projet est sous licence MIT.
Libre d'utilisation, modification, distribution, avec attribution de l’auteur original.

Auteur
Mariem Ben Mustapha
Université Esprit – Projet EasyParki
Thème : Urbanisme, Mobilité et Communauté Durable
