<?php

session_start();

// Check if the user is logged in, if not then redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

require __DIR__ . '/vendor/autoload.php';
include_once __DIR__ . "/database.php";

use \Firebase\JWT\JWT;

if (isset($_POST['data'])) {


  $client = new Google_Client();
  $client->setAuthConfig('credentials.json');

  $key = $client->getClientSecret();

  $con = getConnection();

  $sql = "SELECT client from admins WHERE admins.id = {$_SESSION['id']}";

  if ($result = mysqli_query($con, $sql)) {
    $id = mysqli_fetch_row($result);
    $sql = "SELECT Email_Id, Email FROM email";
    if ($result = mysqli_query($con, $sql)) {
        while ($row = mysqli_fetch_row($result)) {
          $day = new DateTime($_POST['op']);
          $payload = array(
              "date" => date("d-m-Y", strtotime("-1 day", $day->getTimestamp())),
              "user" => $row[1],
              "period" => $_POST['tot'],
              "campaign" => $id[0]
          );

          $jwt = JWT::encode($payload, $key);

          $data = $_POST['data'];

          $data = str_replace("href=\"link\"", "href='/kalendar/share.php?code=" . $jwt . "'", $data);

          echo $data;
        }
    }
  }


}


?>
<!DOCTYPE html>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="robots" content="noindex, nofollow">
    <title>Kalendar</title>
    <script src="lib/ckeditor_4.13/ckeditor/ckeditor.js"></script>
</head>

<body>
    <textarea id="editor1"></textarea>
    <script>
	CKEDITOR.replace( 'editor1', '' );
    </script>

    <form action="" method="POST" >
        <input type="hidden" id="text" name="data" />
        <label for="tot">Tot waneer kunnen mensen registreren</label>
        <input type="date" id="tot" name="tot" /><br>
        <label for="op">Welke week? (Selecteer de eerste dag van de week)</label>
        <input type="date" id="op" name="op" />
        <input type="submit" id="verder" value="Verder" onclick="myFunction()">
    </form>

</body>

<script>
    function myFunction(){
        var data = CKEDITOR.instances.editor1.getData();
        document.getElementById("text").value = data;
        // Your code to save "data", usually through Ajax.
    }
</script>

</html>

</html>
