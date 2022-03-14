<?php

declare(strict_types=1);

require 'includes/config.php';

echo '<pre>';
print_r($_POST);
echo '</pre>';

// ? Première vérification : Mes champs ont bien été remplis
if (in_array('', $_POST)) {
    echo 'Missing input';
    header('Location:signIn.php?error=missingInput');
    exit();
} else {
    // ? Initialisation & assainissement des variables
    $username = trim(htmlspecialchars($_POST['username']));
    $password = htmlspecialchars($_POST['password']);
}

// ? Vérification de la validité des infos
if (filter_var($username, FILTER_VALIDATE_EMAIL) || strlen($username) < 3) {
    echo 'Invalid username or email';
    exit();
}

// Vérification dans la BDD de l'existence de l'utilisateur
try {
    // Requête qui permet de comparer l'input (seul) avec les deux champs : On réassigne à l'email et à l'username la même valeur
    $sqlVerifUser = 'SELECT * FROM users WHERE email = :email OR username = :username LIMIT 1';
    $reqVerifUser = $db->prepare($sqlVerifUser);
    $reqVerifUser->bindValue(':email', $username, PDO::PARAM_STR);
    $reqVerifUser->bindValue(':username', $username, PDO::PARAM_STR);
    $reqVerifUser->execute();

    // Il existe 3 façons de fetch :
    // fetch() permet de récupérer le premier résultat.
    // fetchAll() permet de récupérer tous les résultats.
    // fetchColumn() permet de récupérer la première column (en réalité c'est au choix) liée au résultat.

    // On récupère le résultat de la requête et on initialise une variable user qui contient le résultat.
    $user = $reqVerifUser->fetch();
} catch (\PDOException $e) {
    echo 'Erreur : '.$e->getMessage();
    exit();
}

// Si la variable user est false ou null, alors on retourne un message d'erreur
if (!$user) {
    echo 'Username/password combination does not match any record !';
    exit();
    // echo 'Unknown user, try again !';
}

// On vérifie aussi la concordance du mot de passe entré avec celui de la BDD
// Si c'est faux on retourne un message d'erreur
// Sinon on initialise une session (en enregistrant des tokens de session)
if (!password_verify($password, $user['password'])) {
    echo 'Username/password combination does not match any record !';
    exit();
} else {
    $_SESSION['user'] = $user['username'];
    $_SESSION['id'] = $user['users_id'];
    echo 'Sign-in has been a success !';
    exit();
}