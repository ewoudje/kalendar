<?php
putenv('GOOGLE_APPLICATION_CREDENTIALS=' . __DIR__ .  '/service.json');

function getClient($id)
{
  $client = new Google_Client();
  $client->useApplicationDefaultCredentials();

  return $client;
}

?>
