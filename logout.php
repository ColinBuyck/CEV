<?php
// Logout component -- this might be best in a separate
// logout.php page that handles the logout and shows the
// user their score.  Once the session is destroyed, we will
// need to recreate (re-start) a session inorder to move
// forward with login.  We should therefore move the next two lines
// into a logout page.
//session_destroy(); //CHANGE TO COOKIES!!
include 'database_variables.php';
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // Extra Error Printing
$mysqli = new mysqli($SERVER, $USERNAME, $PASSWORD, $DATABASE);
//$mysqli = new mysqli("localhost", "root", "", "example"); // XAMPP
$error_msg = '';
session_start();
$insertList = $mysqli->prepare("update user set thumbs = ? where username = ?;");
$insertList->bind_param("ss", $_COOKIE["thumbs"], $_SESSION["username"]);
if (!$insertList->execute()) {
 $error_msg = "Error storing information";
}
session_destroy();
setcookie("thumbs", json_encode([0]), time() - 3600);
setcookie("industry", "", time() - 3600);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="stylesheet" href="styles.css">
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author" content="Rena Wolinsky and Colin Buyck">
  <meta name="description" content="Home page for website where users can search for climate footprints of companies to educate and empower consumers">
  <meta name="keywords" content="Climate, CO2, Footprint, green washing, companies, sustainability, consumerism ">

  <title>CEV</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
</head>

<body>
  <!-- Navigation bar code -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark" aria-label="Main Navigation Bar">
        <div class="container-xl">
            <a class="navbar-brand" href="home.php"><img src="cevLogo.png" width="30" height="30" class="d-inline-block align-top" alt="cev Logo"> Corporate Emissions Viewer</a>

                <h3 style="margin-bottom: 20px"> Thank you for visiting, <?=$name?>!</h3>
        </div>
        <div style="margin-right:50px" >
            <a class="btn btn-primary" href="index.php"> Back to login </a>
        </div>
    </nav>

</html>