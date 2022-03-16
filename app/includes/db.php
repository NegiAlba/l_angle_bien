<?php

    require 'local.env.php';

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

    // ? Notre variable $db correspond à l'appel à la BDD, il sera disponible comme avant dans la vrible $db
    $db = db(DBNAME, HOST, USER, PASSWORD);