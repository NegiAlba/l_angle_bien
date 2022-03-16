<?php

    require 'local.env.php';

    // ? Notre variable $db correspond à l'appel à la BDD, il sera disponible comme avant dans la vrible $db
    $db = db(DBNAME, HOST, USER, PASSWORD);