<?php

declare(strict_types=1);
$auth = true;
require 'includes/config.php';

// Ici , on appelle la variable id de la session car on va en avoir besoin pour l'ajout d'offres, l'auteur sera toujours l'utilisateur connecté
$author = $_SESSION['id'];

// Vérification des champs du form
if (empty($_POST['name']) || empty($_POST['description']) || empty($_POST['price']) || empty($_POST['category'])) {
    header('Location:addOffers.php?error=missingInput');
    exit();
} else {
    // Init et assainissement des vars
    $name = htmlspecialchars(trim($_POST['name']));
    $description = htmlspecialchars(trim($_POST['description']));
    $category = htmlspecialchars(trim($_POST['category']));
    $price = htmlspecialchars(trim($_POST['price']));
}

// Requête SQL d'insertion
try {
    $sqlInsertOffer = 'INSERT INTO offers (name,description,category_id,price, author_id) VALUES (:name, :description, :category_id, :price, :author_id)';
    $reqInsertOffer = $db->prepare($sqlInsertOffer);
    $reqInsertOffer->execute(
        [':name' => $name, ':description' => $description, ':category_id' => $category, ':price' => $price, ':author_id' => $author]
    );

    // ? Cette méthode (lastInsertId()) sert à recupérer l'id de l'offre que l'on vient de rajouter, cela nous servira quand il faudra rediriger vers la page single.
    $insert = $db->lastInsertId();
    // TODO : redirect to single product page containing offer
    header('Location:singleOffer.php?id='.$insert);
} catch (PDOException $e) {
    echo 'Erreur :'.$e->getMessage().$e->getCode();
}