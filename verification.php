<?php
session_start();

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/database.php';

$client = new Google_Client();
$client->setAuthConfigFile('credentials.json');
$client->setRedirectUri('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']);
$client->addScope(Google_Service_Calendar::CALENDAR);
$client->setAccessType('offline');
$client->setIncludeGrantedScopes(true);

if (isset($_GET['code'])) {
  $access_token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
  $client->setAccessToken($access_token);
  $sql = "INSERT INTO Clients (access_token, scope, token_type, created, expires_in, refresh_token)
    VALUES('{$access_token['access_token']}', '{$access_token['scope']}', '{$access_token['token_type']}', {$access_token['created']}
    , {$access_token['expires_in']}, '{$access_token['refresh_token']}')";
  $conn = getConnection();

  $conn->query($sql);

  $clientid = mysqli_insert_id($conn);


  $_SESSION["client"] = $clientid;

  $sql = "UPDATE admins SET client = {$clientid} WHERE id = {$_SESSION['id']}";

  $conn->query($sql);

  $conn->close();

  $redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/kalendar/welcome.php';
  header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
} else {
  $auth_url = $client->createAuthUrl();
  header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
}

?>
