<?php

use App\Autoloader;
use App\Models\AnnoncesModel;
use App\Models\UsersModel;

require_once "Autoloader.php";
Autoloader::register();

// Obtention du timestamp et de la date actuelle
$currentTimestamp = time();
$currentDate = date("Y-m-d H:i:s", $currentTimestamp);

// Instanciation du modèle AnnoncesModel
$model = new AnnoncesModel;

// Données pour l'annonce
$donnees = [
    "titre" => "Annonce modifiée",
    "description" => "Description de l'annonce modifiée",
    "created_at" => $currentDate,
    "actif" => 0
];

// Hydratation du modèle avec les données
$annonces = $model->hydrate($donnees);

// Création d'une annonce
$model->create($annonces);

// Mise à jour d'une annonce
//$model->update(2, $annonces);

// Suppression d'une annonce
$model->delete(23);

// Instanciation du modèle UsersModel
$modelUser = new UsersModel;

// Données pour l'utilisateur
$user = $modelUser->setEmail("sg.jiri@yahoo.fr")
                  ->setPassword(password_hash('azerty', PASSWORD_ARGON2ID));

// Création d'un utilisateur
$modelUser->create($user);