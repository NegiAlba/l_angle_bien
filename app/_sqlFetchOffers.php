<?php

function fetchOffers(int $onlineUser): array
{
    global $db;

    // ? Requête SQL qui permet de récupérer les offres (sauf celles du user connecté)
    try {
        $sqlOffers = 'SELECT * FROM offers AS off INNER JOIN categories AS cat ON cat.categories_id = off.category_id WHERE off.author_id <> :user';
        $reqOffers = $db->prepare($sqlOffers);
        $reqOffers->bindValue(':user', $onlineUser);
        $reqOffers->execute();

        return $reqOffers->fetchAll();
    } catch (PDOException $e) {
        echo 'Erreur :'.$e->getMessage();
    }
}

$offers = fetchOffers($user);