<?php

// ? Requête SQL qui permet de récupérer les offres (sauf celles du user connecté)
    $sqlOffers = 'SELECT * FROM offers AS off INNER JOIN categories AS cat ON cat.categories_id = off.category_id WHERE off.author_id <> :user';
    $reqOffers = $db->prepare($sqlOffers);
    $reqOffers->bindValue(':user', $user);
    $reqOffers->execute();

    $offers = $reqOffers->fetchAll();