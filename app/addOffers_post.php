<?php

declare(strict_types=1);
$auth = true;
require 'includes/config.php';
require 'includes/functions.php';

// Ici , on appelle la variable id de la session car on va en avoir besoin pour l'ajout d'offres, l'auteur sera toujours l'utilisateur connecté

function addOffers(array $formData, int $author): void
{
    global $db;

    // Vérification des champs du form
    if (empty($formData['name']) || empty($formData['description']) || empty($formData['price']) || empty($formData['category'])) {
        header('Location:addOffers.php?error=missingInput');
        exit();
    } else {
        // Init et assainissement des vars
        $name = htmlspecialchars(trim($form['name']));
        $description = htmlspecialchars(trim($form['description']));
        $category = htmlspecialchars(trim($form['category']));
        $price = floatval($form['price']);
    }

    if ($price <= 0) {
        header('Location:addOffers.php?error=invalidPrice');
        exit();
    }

    if (strlen($name) < 3) {
        header('Location:addOffers.php?error=invalidName');
        exit();
    }

    if (!$category < 0) {
        header('Location:addOffers.php?error=invalidCategory');
        exit();
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
        return header('Location:singleOffer.php?id='.$insert);
    } catch (PDOException $e) {
        echo 'Erreur :'.$e->getMessage().$e->getCode();
    }
}

$author = $_SESSION['id'];

addOffers($_POST, $author);