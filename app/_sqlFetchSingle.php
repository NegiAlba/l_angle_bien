<?php

// ? Requête SQL qui permet de récupérer une offre (une seule en fonction de son id)
    $offer_id = $_GET['id'];

    $sqlOffer = 'SELECT * FROM offers AS off INNER JOIN categories AS cat ON cat.categories_id = off.category_id WHERE offers_id = :offer_id';
    $reqOffer = $db->prepare($sqlOffer);
    $reqOffer->bindValue(':offer_id', $offer_id);
    $reqOffer->execute();

    $offer = $reqOffer->fetch();