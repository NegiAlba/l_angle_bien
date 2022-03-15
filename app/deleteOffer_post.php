<?php

declare(strict_types=1);

echo '<pre>';
print_r($_POST);
echo '</pre>';

require 'includes/config.php';
require '_sqlFetchSingle.php';

if ($user !== $offer['author_id']) {
    header('Location:offers.php?error=unauthorizedAccess');
    exit();
}

$author_id = $user;
$offers_id = filter_input(INPUT_POST, 'offers_id');
$token = filter_input(INPUT_POST, 'csrf_token');

if ($token !== $_SESSION['token']) {
    header('Location:offers.php?error=csrfAttempt');
    exit();
}

echo '<pre>';
var_dump($token, $author_id);
echo '</pre>';

try {
    $sqlDeleteOffer = 'DELETE FROM offers WHERE offers_id = :offers_id AND author_id = :author_id';
    $reqDeleteOffer = $db->prepare($sqlDeleteOffer);
    $reqDeleteOffer->bindValue(':offers_id', $offers_id, PDO::PARAM_STR);
    $reqDeleteOffer->bindValue(':author_id', $author_id, PDO::PARAM_STR);
    $reqDeleteOffer->execute();

    header('Location:offers.php?success=deleteSuccess');
} catch (\PDOException $e) {
    echo 'Erreur :'.$e->getMessage();
}