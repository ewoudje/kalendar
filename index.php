<?php
require __DIR__ . '/vendor/autoload.php';

use \Firebase\JWT\JWT;

$client = new Google_Client();
$client->setAuthConfig('credentials.json');

$key = $client->getClientSecret();
$payload = array(
    "date" => "2020-02-9",
    "user" => "ewoud.dierickx@hotmail.be",
    "period" => "2020-02-16",
    "campaign" => 3
);

$jwt = JWT::encode($payload, $key);
?>

<a href="/kalendar/share.php?code=<?=$jwt?>">Click here</a>
