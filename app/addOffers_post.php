<?php

declare(strict_types=1);
$auth = true;
require 'includes/config.php';

echo '<pre>';
var_dump($_FILES);
echo '</pre>';

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
    $image = $_FILES['image'];
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

// ? Après avoir initialisé le fichier dans $image on vérifie que celui-ci soit de la bonne taille avant de continuer;
if ($image['size'] > 0 && $image['size'] <= 1000000) {
    // ? On vérifie dans un premier temps l'extension du fichier qui est uploadé, on crée un array d'extensions valides et ensuite on va comparer ces extensions valides par rapport à l'extension du fichier reçu.
    $valid_ext = ['png', 'jpeg', 'jpg', 'gif'];
    $get_ext = strtolower(substr(strrchr($image['name'], '.'), 1));

    if (!in_array($get_ext, $valid_ext)) {
        echo 'image format is invalid';
        header('Location:addOffers.php?error=invalidImageFIle');
        exit();
    }

    // ? On procède de la même façon pour la vérification du type
    $valid_type = ['image/png', 'image/jpeg', 'image/jpg', 'image/gif'];
    if (!in_array($image['type'], $valid_type)) {
        echo 'image type is invalid';
        header('Location:addOffers.php?error=invalidImageFile');
        exit();
    }
    // ! Ne pas oublier créer le dossier public/uploads parfois des problèmes de droits risquent de limiter l'accès
    // ? On crée le chemin intégral du fichier
    $image_path = 'public/uploads/'.uniqid().'/'.$image['name'];

    // ? On crée le dossier qui va accueillir le fichier
    mkdir(dirname($image_path));

    // ? On réalise l'upload dans le serveur au chemin précédemment déclaré
    if (!move_uploaded_file($image['tmp_name'], $image_path)) {
        echo 'couldn\'t upload';
        header('Location:addOffers.php?error=uploadError');
        exit();
    }
}

// Requête SQL d'insertion
try {
    $sqlInsertOffer = 'INSERT INTO offers (name,description,category_id,price,image, author_id) VALUES (:name, :description, :category_id, :price, :image,:author_id)';
    $reqInsertOffer = $db->prepare($sqlInsertOffer);
    $reqInsertOffer->execute(
        [':name' => $name, ':description' => $description, ':category_id' => $category, ':price' => $price, ':image' => $image_path, ':author_id' => $author]
    );

    // ? Cette méthode (lastInsertId()) sert à recupérer l'id de l'offre que l'on vient de rajouter, cela nous servira quand il faudra rediriger vers la page single.
    $insert = $db->lastInsertId();
    // TODO : redirect to single product page containing offer
    header('Location:singleOffer.php?id='.$insert);
} catch (PDOException $e) {
    echo 'Erreur :'.$e->getMessage().$e->getCode();
}