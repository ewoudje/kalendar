<?php

$con = mysqli_connect("localhost", "root", "", "kalendar");

if(isset($_POST['submit'])) {
    $mail = $_POST['email'];
    $slq_post = "INSERT INTO email (Email) VALUES ('$mail')";
    if ($result = mysqli_query($con, $slq_post)) {
    }
    } else {
}

if(isset($_POST['delete'])) {
    $delete_email = $_POST['delete_email'];
    $slq_post = "DELETE FROM email WHERE Email_Id = '$delete_email' ";
    if ($result = mysqli_query($con, $slq_post)) {
    }
    } else {
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
                            <td><form action='/Kalendar/kalendar/emailadresses.php' method='POST'>
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

    <form action="/Kalendar/kalendar/emailadresses.php" method="POST">
        <input type="email" name="email" />
        <input type="submit" value="submit" name="submit" />
    </form>

</body>

</html>