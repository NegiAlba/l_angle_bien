<?php

declare(strict_types=1);

require 'includes/config.php';

// ! DB FUNCTIONS

function db(string $dbname, string $host, string $user, string $password): PDO
{
    $db_string = "mysql:dbname=$dbname;host=$host";

    // ? Un bloc try-catch est une instruction de code qui permet de gérer explicitement les erreurs qui pourraient advenir.
    try {
        // ? PDO = PHP Data Object , c'est un objet qui a vocation a représenter une connexion entre une application PHP et un système de base de données. PDO support MySQL, PostGres.
        $db = new PDO($db_string, $user, $password);
        // ? setAttribute permet de changer les paramètres par défaut de PDO. Il nous permet de définir des comportements qui doivent s'appliquer en tout temps. On modifie les comportements de renvoi d'erreur (on souhaite toujours des exceptions PDO) et celui de fetching (la récupération depuis la BDD) avec des tableaux associatifs (plutôt que associatif + indexé).
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        // Vu que l'appel à la BDD est dans une fonction, je dois la retourner
        return $db;
    } catch (PDOException $e) {
        echo 'Erreur : '.$e->getMessage();
        // throw new MyPDODbException($e);
    }
}

// ! SIGNIN/SIGNUP FUNCTIONS

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

// ! CRUD FUNCTION

function addOffers(array $formData, int $author): void
{
    global $db;

    // Vérification des champs du form
    if (empty($formData['name']) || empty($formData['description']) || empty($formData['price']) || empty($formData['category'])) {
        header('Location:addOffers.php?error=missingInput');
        exit();
    } else {
        // Init et assainissement des vars
        $name = htmlspecialchars(trim($formData['name']));
        $description = htmlspecialchars(trim($formData['description']));
        $category = htmlspecialchars(trim($formData['category']));
        $price = floatval($formData['price']);
    }

    if ($price <= 0) {
        header('Location:addOffers.php?error=invalidPrice');
        exit();
    }

    if (strlen($name) < 3) {
        header('Location:addOffers.php?error=invalidName');
        exit();
    }

    if (!$category < 0) {
        header('Location:addOffers.php?error=invalidCategory');
        exit();
    }

    // Requête SQL d'insertion
    try {
        $sqlInsertOffer = 'INSERT INTO offers (name,description,category_id,price, author_id) VALUES (:name, :description, :category_id, :price, :author_id)';
        $reqInsertOffer = $db->prepare($sqlInsertOffer);
        $reqInsertOffer->execute(
            [':name' => $name, ':description' => $description, ':category_id' => $category, ':price' => $price, ':author_id' => $author]
        );

        // ? Cette méthode (lastInsertId()) sert à recupérer l'id de l'offre que l'on vient de rajouter, cela nous servira quand il faudra rediriger vers la page single.
        $insert = $db->lastInsertId();
        // TODO : redirect to single product page containing offer
        return header('Location:singleOffer.php?id='.$insert);
    } catch (PDOException $e) {
        echo 'Erreur :'.$e->getMessage().$e->getCode();
    }
}

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

function fetchSingleOffer(int $id_for_offer): array
{
    global $db;

    try {
        // ? Requête SQL qui permet de récupérer une offre (une seule en fonction de son id)
        // $offer_id = $_GET['id'];
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
        $reqOffer->bindValue(':offer_id', $id_for_offer);
        $reqOffer->execute();

        return $reqOffer->fetch();
    } catch (PDOException $e) {
        echo 'Erreur :'.$e->getMessage();
    }
}

function fetchCategories(): array
{
    global $db;

    try {
        // ? Pour récupérer tous les éléments depuis la BDD avec un SELECT on peut se contenter d'une requête avec un query. Ce n'est pas le cas des autres requêtes puisqu'elles attendent des arguments qu'il faudra valider et assainir nous-mêmes.
        $sqlViewCategories = 'SELECT * FROM categories';
        $dbViewCategories = $db->query($sqlViewCategories);

        return $dbViewCategories->fetchAll();
    } catch (PDOException $e) {
        echo 'Error: '.$e->getMessage();
    }
}