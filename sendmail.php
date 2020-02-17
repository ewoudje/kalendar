<?php

require __DIR__ . '/vendor/autoload.php';
include_once __DIR__ . "/database.php";

use \Firebase\JWT\JWT;

$client = new Google_Client();
$client->setAuthConfig('credentials.json');

$key = $client->getClientSecret();

$con = getConnection();

$sql_select_mail = "SELECT Email_Id, Email FROM email";
if ($result = mysqli_query($con, $sql_select_mail)) {
    while ($row = mysqli_fetch_row($result)) {
      $payload = array(
          "date" => "2020-02-9",
          "user" => $row[1],
          "period" => "2020-02-16",
          "campaign" => 3
      );

      $jwt = JWT::encode($payload, $key);

      $data = $_POST['data'];

      $data = str_replace("href=\"link\"", "href='/kalendar/share.php?code=" . $jwt . "'", $data);

      echo $data;
    }
}



?>
