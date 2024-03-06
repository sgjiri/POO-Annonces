<?php

use App\Autoloader;
use App\Models\AnnoncesModel;
use App\Models\UsersModel;

require_once "Autoloader.php";
Autoloader::register();
// $currentTimestamp = time();
// $currentDate = date("Y-m-d H:i:s", $currentTimestamp);

$model = new AnnoncesModel;
$donnees = [
     "titre" => "Annonce modifiée",
    "description" => "Description de l'annonce modifiée",
     "created_at" => $currentDate,
     "actif" => 0
 ];
$annonces = $model->hydrate($donnees);

// $annonces = $model->setTitre("brouette")
//                     ->setDescription("Lorem ipsum loudanum huijhgf ijhiodsfjh qlojeçàie oju ezaçijh oigfsçàq")
//                     ->setCreated_at($currentDate)
//                     ->setActif(1);



$model->create($annonces);
//$model->update(2, $annonces);
$model->delete(23);

$modelUser = new UsersModel;
$user = $modelUser->setEmail("sg.jiri@yahoo.fr")
                    ->setPassword(password_hash('azerty', PASSWORD_ARGON2ID));
$modelUser->create($user);

