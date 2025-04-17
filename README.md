EasyParki – Gestion de Covoiturage 
Description du Projet
Le module Gestion de Plans de Vacances d’EasyParki permet aux utilisateurs de planifier leurs séjours de manière intuitive. En plus de choisir un hôtel, ils peuvent visualiser en temps réel les places de parking disponibles associées à chaque hôtel.
L’objectif est d’offrir une interface conviviale, fonctionnelle et durable, centralisant hébergement et mobilité urbaine.

🎯 Objectifs Fonctionnels
Créer un plan de vacances personnalisé (dates, transport, location voiture...).

Sélectionner un hôtel avec informations de parking : nombre total et nombre de places disponibles.

Vérifier la cohérence des dates (date de retour > date de départ).

Afficher un message de confirmation lors d’une soumission réussie.

🏗️ Architecture du Projet
/Model/*
  ├── Hotel.php                
  └── PlanVacance.php     

/Controller/
  ├── HotelC.php              
  └── PlanVacanceC.php        

/View/front/
  ├── about.php     
  ├── addplanVacancefront.php         
  └── deleteplanVacancefront.php   
  ├── listHotelsfront.php     
  ├── listplansVacancefront.php         
  └── updateplanVacance.php  
 
/View/Back/
  ├── addHotel.php     
  ├── addplanVacance.php         
  └── deleteHotel.php   
  ├── deleteplanVacance.php     
  ├── listHotels.php         
  └── listplanVacance.php   
  ├── tables.php     
  ├── updateHotel.php         
  └── updateplanVacance.php  


/config/
  └── config.php   
           
Modèle de Données
Table : hotel

Attribut	
id_hotel	
nom_hotel	
adresse	
ville	
categorie	
nombre_places_parking	
places_parking_disponibles	
Table : plan_vacance

Attribut	
id_plan	SERIAL 
nom_utilisateur	
date_depart	
date_retour	
type_transport	
location_voiture	
besoin_parking	
id_hotel
	
⚙️ Installation & Configuration
Cloner le projet :

bash
Copier
Modifier
git clone https://github.com/ton-utilisateur/easyparki.git
cd easyparki
Créer la base de données avec les tables ci-dessus (PostgreSQL recommandé).

Configurer config/config.php :

php
Copier
Modifier
<?php
$pdo = new PDO('pgsql:host=localhost;dbname=easyparki', 'utilisateur', 'motdepasse');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>
Lancer le serveur local :

bash
Copier
Modifier
php -S localhost:8000
🚀 Utilisation
Accéder à http://localhost:8000/View/front/addplanVacancefront.php

Compléter le formulaire

Sélectionner un hôtel : les infos de parking s’affichent

Valider → message de succès animé + redirection

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
Emna Ben Hassine
Université Esprit – Projet EasyParki
Thème : Urbanisme, Mobilité et Communauté Durable
