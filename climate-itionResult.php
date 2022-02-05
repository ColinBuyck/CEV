<?php
/** DATABASE SETUP **/
include 'database_variables.php';
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // Extra Error Printing
$mysqli = new mysqli($SERVER, $USERNAME, $PASSWORD, $DATABASE);
$user   = null;

session_start();

// If the user's username is not set in the session, then it's not
// a valid session (they didn't get here from the login page),
// so we should send them over to log in first before doing
// anythin2g else!
if ($_SESSION["username"] == "") {
 header("Location: index.php");
 exit();
}
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

  <title>Climate-ition Result</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
</head>

<body onload = "functionalityWarning()">
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark" aria-label="Main Navigation Bar">
        <div class="container-xl">
            <a class="navbar-brand" href="home.php"><img src="cevLogo.png" width="30" height="30" class="d-inline-block align-top" alt="cev Logo"> Corporate Emissions Viewer</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsTop" aria-controls="navbarsTop" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarsTop">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link  href="home.php">Home</a>
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

  <!-- Example page of what climate-ition result could look like:  two companies sustainability info side by side -->
  <p class="text-center"> Below is an example of what a "Climate-ition search result" page might look like if companies searched were McDonald's and Cook Out. </p>

  <div class="bg-darkBlue mx-auto">
  <div class="container">
      <div class="row mx-auto" style="padding-top:50px;">

          <!-- 2 cards, one for each company -->
          <div class="card mx-auto mcdonaldsIndexCard bg-darkBlue" style="width: 18rem;">
            <img class="card-img-top mcdonaldsLogo" src="mcdonaldsLogo.png" alt="McDonald's Logo">
            <div class="card-body">
              <h5 class="card-title">McDonalds</h5>
              <p class="card-text">McDonalds produces about three tons of packaging waste every minute, almost two million tons of packaging waste a year according to takeawaypackaging.co.uk.</p>
            </div>
          </div>

          <div class="card mx-auto chipotleIndexCard" style="width: 18rem;">
            <img class="card-img-top chipotleLogo" src="chipotleLogo.png" alt="Chipotle Logo">
            <div class="card-body">
              <h5 class="card-title">Chipotle</h5>
              <p class="card-text">Chipotle is 51% waste free according to Nation's Restaurant news, meeting their 2020 goal.</p>
            </div>
          </div>
      </div>
  </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
  <script>
    function functionalityWarning() {
        alert("Warning: This page is still under construction. If you are looking for search functionality, it is available via the 'Search One Company' tab.");  
    }
  </script>




</body>
</html>