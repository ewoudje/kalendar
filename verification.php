<?php
require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/database.php';

$client = new Google_Client();
$client->setAuthConfig('credentials.json');
$client->setPrompt('select_account consent');


$authCode = $_POST['code'];

// Exchange authorization code for an access token.
$accessToken = $client->fetchAccessTokenWithAuthCode($authCode);
$client->setAccessToken($accessToken);

// Check to see if there was an error.
if (array_key_exists('error', $accessToken)) {
    throw new Exception(join(', ', $accessToken));
}

$sql = "INSERT INTO Clients (access_token, scope, token_type, created, expires_in, refresh_token)
  VALUES(\'{$accessToken['access_token']}\', \'{$accessToken['scope']}\', \'{$accessToken['token_type']}\', {$accessToken['created']}
  , {$accessToken['expires_in']}, \'{$accessToken['refresh_token']}\')";
echo $sql;
$conn = getConnection();
echo $conn->query($sql);
$conn->close();

?>
