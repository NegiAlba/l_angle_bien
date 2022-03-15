<?php

try {
    // ? Requête SQL qui permet de récupérer une offre (une seule en fonction de son id)
    // $offer_id = $_GET['id'];
    $offer_id = $_POST['offers_id'] ?? $_GET['id'];
    // $offer_id = null alors $offer_id = $_GET['id'];

    // ? Opérateur ternaire
    // ? L'opérateur ternaire s'appelle parce qu'il attend 3 facteurs
    // ? Le premier facteur est l'expression à vérifier (par exemple if $a > 3)
    // ? Les deux autres vont être le résultat si l'expression est vraie et si elle est fausses
    // ? Ce sera l'équivalent d'un if construit de cette façon :
    // if(isset($_POST['offers_id'])){
    // if ($_POST['offers_id']) {
    //     $offer_id = $_POST['offers_id'];
    // } else {
    //     $offer_id = $_GET['id'];
    // }
    // }

    // $offer_id = $_POST['offers_id'] ? $_POST['offers_id'] : $_GET['id'];

    $sqlOffer = 'SELECT * FROM offers AS off INNER JOIN categories AS cat ON cat.categories_id = off.category_id WHERE offers_id = :offer_id';
    $reqOffer = $db->prepare($sqlOffer);
    $reqOffer->bindValue(':offer_id', $offer_id);
    $reqOffer->execute();

    $offer = $reqOffer->fetch();
} catch (PDOException $e) {
    echo 'Erreur :'.$e->getMessage();
}