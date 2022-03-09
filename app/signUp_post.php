<?php

    echo '<pre>';
    print_r($_POST);
    echo '</pre>';

    //! Etape du processing formulaire

    //? Vérifier que tous les champs requis soient remplis
    if (empty($_POST['email']) || empty($_POST['username']) || empty($_POST['password']) || empty($_POST['password2'])) {
        echo 'Missing input in the sign up form !';
    }

    //? Alternate method to check all fields
    if (in_array('', $_POST)) {
        echo 'Missing input in the sign up form !';
    }

    // header('Location:signUp.php');