<?php

    require 'includes/config.php';
    // echo '<pre>';
    // print_r($_POST);
    // echo '</pre>';

    function signUp($formEmail, $formUsername, $formPassword, $formPassword2): void
    {
        global $db;

        // ! Etape du processing formulaire

        // //? Alternate method to check all fields
        // if (in_array('', $_POST)) {
        //     echo 'Missing input in the sign up form !';
        // }
        // ? Vérifier que tous les champs requis soient remplis (on vérifie leur existence)
        if (empty($formEmail) || empty($formUsername) || empty($formPassword) || empty($formPassword2)) {
            return header('Location:signUp.php?error=missingInput');
        } else {
            // ? Assainir les variables afin de préparer l'inscription
            // * trim permet d'enlever les espaces avant et après la chaine de caractères.
            // * htmlspecialchars permet de transformer tout le contenu HTML en chaines de caractères qui n'exécutent pas de code
            // * strip_tags permet de supprimer les balises HTML contenu dans l'input totalement.
            $email = trim(htmlspecialchars($formEmail));
            $username = trim(htmlspecialchars($formUsername));
            $password = trim(htmlspecialchars($formPassword));
            $password2 = trim(htmlspecialchars($formPassword2));
        }

        // ? Vérifier la validité des inputs de l'utilisateur
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return header('Location:signUp.php?error=invalidEmail');
        }

        if (strlen($username) < 3 || strlen($username) > 100) {
            return header('Location:signUp.php?error=invalidUsername');
        }

        if (strlen($password) < 3 || strlen($password) > 100) {
            return header('Location:signUp.php?error=invalidPassword');
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
            return header('Location:signUp.php?error=alreadyExists');
        }

        // ? Vérifier concordance des mdp
        if ($password !== $password2) {
            return header('Location:signUp.php?error=passwordNotMatching');
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
            return header('Location:index.php?success=signupSuccess');
        } else {
            return header('Location:signUp.php?error=unknownError');
        }
    }

    signUp($_POST['email'], $_POST['username'], $_POST['password'], $_POST['password2']);