<?php
/** DATABASE SETUP **/
include 'database_variables.php';
include 'industry-list.php';
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // Extra Error Printing
$mysqli = new mysqli($SERVER, $USERNAME, $PASSWORD, $DATABASE);
$user   = null;

session_start();

// If the user's username is not set in the session, then it's not
// a valid session (they didn't get here from the login page),
// so we should send them over to log in first before doing
// anything else!
if ($_SESSION["username"] == "") {
 header("Location: index.php");
 exit();
}

?>
<!DOCTYPE html>
<html>
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

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsTop" aria-controls="navbarsTop" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarsTop">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link  href="home.php" >Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="industries.php">Explore Corporations</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="climate-itionSearch.php">Climate-ition</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="searchOneCompany.php">Search One Company</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="my_list.php">My List</a>
                    </li>
                </ul>
                <span class="navbar-text">
                  Hello, <?=$_SESSION["username"]?>!
                </span>
                <a style="margin-left: 15px" class="btn btn-danger" href="logout.php">Log out</a>
            </div>
        </div>
    </nav>
    <div class="p-5 mb-4 text-white bg-darkGreen sbg-gradient">
        <div class="container py-5">
            <h1 class="display-5 fw-bold">Select an Industry to Begin Exploring</h1>
        </div>
    </div>
    <div style = "margin: auto">
        <form action="corporation_explorer.php?industry=<?=$_COOKIE["industry"]?>" method="post">
            <label class="radio-inline" style = "align-items: center">
                <input type="radio" value="All" name="industry">All</input>
            </label>
            <?php foreach ($industries as $industry) {
 $industry = trim($industry)?>
            <label class="radio-inline">
                <input onClick="activateButton()" type="radio" value=<?=$industry?> name="industry"> <?=$industry?> </input>
            </label>
            <?php }?>
            <button type="submit" id="submit" class="btn btn-danger" disabled>Select One!</button>
        </form>
    </div>


        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
        <script>
            activateButton = () => {
                button = document.getElementById("submit");
                button.classList.remove("btn-danger");
                button.classList.add("btn-primary");
                button.disabled = false;
                button.textContent = "Learn More!";
            }
        </script>
    </body>
</html>