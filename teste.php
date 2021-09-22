<?php

require_once 'init.php';

$marvel_api_service = new MarvelApiService();

$character = $marvel_api_service->getCharacters('1016181');

if($character)
{
    var_dump($character);
}

?>
