<?php

$offer_id = $_POST['offers_id'] ?? $_GET['id'];

$offer = fetchSingleOffer($offer_id);