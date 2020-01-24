<?php
require_once __DIR__ . "/database.php";
require_once __DIR__ . '/vendor/autoload.php';

/**
* Returns an authorized API client.
* @return Google_Client the authorized client object
*/
function getClient($id)
{

  $conn = getConnection();
  $client = new Google_Client();
  $client->setScopes(Google_Service_Calendar::CALENDAR);
  $client->setAuthConfig('credentials.json');
  $client->setAccessType('offline');

  $sql = "SELECT access_token, scope, token_type, created, expires_in, refresh_token FROM Clients WHERE id = \"" . $id . "\"";
  $result = mysqli_fetch_array($conn->query($sql));
  $accessToken = $result;
  if ($accessToken) {
    $client->setAccessToken($accessToken);
  }

  // If there is no previous token or it's expired.
  if ($client->isAccessTokenExpired()) {
      // Refresh the token if possible, else fetch a new one.
      if ($client->getRefreshToken()) {
          $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
          $sql = "UPDATE access_token, scope, token_type, created, expires_in, refresh_token FROM Clients WHERE id = \"" . $id . "\"";
          $conn->query($sql);
      } else {
        $redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/kalendar/verification.php';
        header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
      }
  }
  $conn->close();
  return $client;
}

?>
