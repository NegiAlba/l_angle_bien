<?php

declare(strict_types=1);

require 'includes/config.php';

/*
 * ! ETAPES LOGIQUE D'UN UPDATE
 * ? Elles sont les mêmes qu'a l'insert à peu de choses près :
 * La requête SQL est différente : il s'agit d'une requête UPDATE plutôt qu'INSERT INTO
 * On doit aussi vérifier plus de choses : le lien avec l'auteur est à vérifier
 * Il faut aussi prendre garde aux redirections d'erreur, il faut y ajouter l'id en requête GET
 */

if (in_array('', $_POST)) {
    header("Location: editOffer.php?id={$_POST['offers_id']}&error=missingInput");
} else {
    $name = htmlspecialchars(trim($_POST['name']));
    $description = htmlspecialchars(trim($_POST['description']));
    $category = htmlspecialchars(trim($_POST['category']));
    $price = htmlspecialchars(trim($_POST['price']));
    $offers_id = htmlspecialchars(trim($_POST['offers_id']));
}

if ($price <= 0) {
    header("Location:editOffer.php?id={$_POST['offers_id']}&error=invalidPrice");
    exit();
}

if (strlen($name) < 3) {
    header("Location:editOffer.php?id={$_POST['offers_id']}&error=invalidName");
    exit();
}

if (!$category < 0) {
    header("Location:editOffer.php?id={$_POST['offers_id']}&error=invalidCategory");
    exit();
}

// ! EDIT Avec une image
// ? Il va falloir si la personne a ajouté une image
// ? Si il en a rajouté une, c'est qu'il souhaite modifier l'image d'origine et on va réaliser l'upload de cette image
// ? Sinon il souhaite conserver l'ancienne image.
// ? Il faudra récupérer les infos de l'ancienne image et les renvoyer dans le formulaire ou alors faire une requête SQL sans mention de l'image

try {
    $sqlUpdateOffer = 'UPDATE offers SET name=:name, description=:description, price=:price, category_id=:category_id WHERE offers_id=:offers_id AND author_id=:author_id';
    $reqUpdateOffer = $db->prepare($sqlUpdateOffer);
    $reqUpdateOffer->execute([
        'name' => $name,
        'description' => $description,
        'price' => $price,
        'category_id' => $category,
        'offers_id' => $offers_id,
        'author_id' => $user,
    ]);

    header("Location:singleOffer?success=editSuccess&id={$offers_id}");
} catch (PDOException $e) {
    echo 'Erreur : '.$e->getMessage();
    echo "<meta http-equiv='refresh' content='3;URL=editOffer.php?id={$offers_id}'>";
}