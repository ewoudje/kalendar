<?php
require_once __DIR__ . "/database.php";

/**
* Returns an authorized API client.
* @return Google_Client the authorized client object
*/
function getClient($id)
{

  $conn = getConnection();
  $client = new Google_Client();
  $client->setScopes(Google_Service_Calendar::CALENDAR);
  $client->setPrompt('select_account consent');
  $client->setAuthConfig('credentials.json');

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
      } else {
          // Request authorization from the user.
          $authUrl = $client->createAuthUrl();
          printf("Open the following link in your browser: <a href=\"%s\">Click here </a>\n", $authUrl);
          echo '<p>Enter verification code: <form method="post" action="/kalendar/verification.php">
            <input type="text" name="code">
            <input type="submit" value="Submit">
          </form></p>';
      }
      // Save the token to a file.
      if ($result) {
        $sql = "UPDATE access_token, scope, token_type, created, expires_in, refresh_token FROM Clients WHERE id = \"" . $id . "\"";
        $conn->query($sql);
      }

  }
  $conn->close();
  return $client;
}

?>
