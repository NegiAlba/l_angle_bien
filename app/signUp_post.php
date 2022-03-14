<?php

    require 'includes/config.php';
    // echo '<pre>';
    // print_r($_POST);
    // echo '</pre>';

    // ! Etape du processing formulaire

    // ? Vérifier que tous les champs requis soient remplis (on vérifie leur existence)
    if (empty($_POST['email']) || empty($_POST['username']) || empty($_POST['password']) || empty($_POST['password2'])) {
        echo 'Missing input in the sign up form !';
    } else {
        // ? Assainir les variables afin de préparer l'inscription
        // * trim permet d'enlever les espaces avant et après la chaine de caractères.
        // * htmlspecialchars permet de transformer tout le contenu HTML en chaines de caractères qui n'exécutent pas de code
        // * strip_tags permet de supprimer les balises HTML contenu dans l'input totalement.
        $email = trim(htmlspecialchars($_POST['email']));
        $username = trim(htmlspecialchars($_POST['username']));
        $password = trim(htmlspecialchars($_POST['password']));
        $password2 = trim(htmlspecialchars($_POST['password2']));
    }

    // ? Vérifier la validité des inputs de l'utilisateur
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo 'Email address is invalid...';
    }

    if (strlen($username) < 3 || strlen($username) > 100) {
        echo 'Username is invalid...';
    }

    if (strlen($password) < 3 || strlen($password) > 100) {
        echo 'Password is invalid...';
    }

    // ? Les requêtes préparées en PDO
    // * Les requêtes préparées fonctionnent deux étapes :
    // * D'abord on fait la déclaraction de préparation avec prepare() et une requête SQL qui contient des marqueurs
    // * Ensuite on attache à ce marqueur une valeur provenant d'une variable (bindValue())
    // * On peut ensuite executer la requête sur la BDD (execute())

    // ? On vérifie l'unicité de l'email et du username avec un SELECT COUNT
    try {
        $sqlVerif = 'SELECT COUNT(*) FROM users WHERE email = :email OR username = :username';
        $reqVerif = $db->prepare($sqlVerif);
        $reqVerif->bindValue(':email', $email, PDO::PARAM_STR);
        $reqVerif->bindValue(':username', $username, PDO::PARAM_STR);
        $reqVerif->execute();

        $resultVerif = $reqVerif->fetchColumn();
    } catch (PDOException $e) {
        echo 'Erreur :'.$e->getMessage();
    }

    if ($resultVerif > 0) {
        echo 'This email or this username already exists';
    }

    // ? Vérifier concordance des mdp
    if ($password !== $password2) {
        echo 'The passwords are not matching';
    }

    // ! Fin des vérifications, insertion dans la BDD
    $password = password_hash($password, PASSWORD_DEFAULT);

    try {
        $sqlInsert = 'INSERT INTO users (email,username,password) VALUES (:email,:username,:password)';
        $reqInsert = $db->prepare($sqlInsert);
        $reqInsert->bindValue(':email', $email, PDO::PARAM_STR);
        $reqInsert->bindValue(':username', $username, PDO::PARAM_STR);
        $reqInsert->bindValue(':password', $password, PDO::PARAM_STR);

        $resultInsert = $reqInsert->execute();
    } catch (PDOException $e) {
        echo 'Erreur :'.$e->getMessage();
    }

    if ($resultInsert) {
        echo 'Vous êtes bien inscrits';
        exit();
    // header('Location:index.php');
    } else {
        echo 'Une erreur est survenue';
        exit();
        // header('Location:signUp.php');
    }
    // //? Alternate method to check all fields
    // if (in_array('', $_POST)) {
    //     echo 'Missing input in the sign up form !';
    // }