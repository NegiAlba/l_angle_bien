<?php

declare(strict_types=1);
$auth = true;
require 'includes/functions.php';
// Ici , on appelle la variable id de la session car on va en avoir besoin pour l'ajout d'offres, l'auteur sera toujours l'utilisateur connecté
$author = $_SESSION['id'];

addOffers($_POST, $author);