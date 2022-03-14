<?php

try {
    // ? Pour récupérer tous les éléments depuis la BDD avec un SELECT on peut se contenter d'une requête avec un query. Ce n'est pas le cas des autres requêtes puisqu'elles attendent des arguments qu'il faudra valider et assainir nous-mêmes.
    $sqlViewCategories = 'SELECT * FROM categories';
    $dbViewCategories = $db->query($sqlViewCategories);
    $categories = $dbViewCategories->fetchAll();
} catch (PDOException $e) {
    echo 'Error: '.$e->getMessage();
}