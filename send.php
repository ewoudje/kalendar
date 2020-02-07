<?php
require __DIR__ . '/vendor/autoload.php';

use \Firebase\JWT\JWT;

$client = new Google_Client();
$client->setAuthConfig('credentials.json');

$key = $client->getClientSecret();
$payload = array(
    "date" => "2020-02-1",
    "user" => "ewoud.dierickx@hotmail.be",
    "campaign" => 3
);

$jwt = JWT::encode($payload, $key);
?>

<a href="/kalendar/test.php?code=<?=$jwt?>">Click here</a>
