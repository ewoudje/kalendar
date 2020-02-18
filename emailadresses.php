<?php

session_start();

// Check if the user is logged in, if not then redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

include_once __DIR__ . "/database.php";

$con = getConnection();

if(isset($_POST['submit'])) {
    $mail = $_POST['email'];
    $slq_post = "INSERT INTO email (Email) VALUES ('$mail')";
    $result = mysqli_query($con, $slq_post);
}

if(isset($_POST['delete'])) {
    $delete_email = $_POST['delete_email'];
    $slq_post = "DELETE FROM email WHERE Email_Id = '$delete_email' ";
    $result = mysqli_query($con, $slq_post);
}

?>

<!DOCTYPE html>
<html lang="en">

<body>
    <table>

        <thead>
            <tr>
                <th> E-mail Id </th>
                <th> E-mail adresses </th>
            </tr>
        </thead>

        <tbody>
            <!--Use a while loop to make a table row for every DB row-->
            <?php
            $sql_select_mail = "SELECT Email_Id, Email FROM email";
            if ($result = mysqli_query($con, $sql_select_mail)) {
                while ($row = mysqli_fetch_row($result)) {
                    printf(
                        "<tr>
                            <td> %s </td>
                            <td> %s </td>
                            <td><form action='/kalendar/emailadresses.php' method='POST'>
                                <input type='hidden' name='delete_email' value='%s' />
                                <input type='submit' value='delete' name='delete' />
                            </form>
                        </tr>",
                        $row[0],
                        $row[1],
                        $row[0]
                    );
                }
            }
            ?>
        </tbody>

    </table>

    <form action="/kalendar/emailadresses.php" method="POST">
        <input type="email" name="email" />
        <input type="submit" value="submit" name="submit" />
    </form>

    <a href="welcome.php">Back</a>

</body>

</html>
