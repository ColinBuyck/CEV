<?php
/** DATABASE SETUP **/
include('database_variables.php');
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // Extra Error Printing
$mysqli = new mysqli($SERVER, $USERNAME, $PASSWORD, $DATABASE);
$user = null;
session_start();

// If the user's username is not set in the session, then it's not
// a valid session (they didn't get here from the login page),
// so we should send them over to log in first before doing
// anything else!
if ($_SESSION["username"] == "") {
    header("Location: index.php");
    exit();
}

//join or start cookie
//setcookie("username", "", time()+3600); //what should be put as these key value pairs be?? COME BACK TO!
//initially set cookie when set website b



?><!-- Rena Wolinsky rjw3kk and Colin Buyck cjb2utf
URL to project on CS4640 server
cs4640.cs.virginia.edu/rjw3kk/sprint4/
cs4640.cs.virginia.edu/cjb2utf/sprint4/
-->
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

  <script
  src="https://code.jquery.com/jquery-3.6.0.js"
  integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
  crossorigin="anonymous"></script>

<script> //jquery script to get mcdonalds sustainabiity info onto card after button click
    $(document).ready(function(){
     // console.log("inside j query");
    $("#mcdonaldsCard").click(function(){
      $("#mcdonaldsText").append("<b>Today, McDonalds is approximately 78% of the way toward our ambition to source all packaging from renewable, recycled and certified sources.</b>");
      //console.log("appended");
      });
    });
</script>

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
                  Hello, <?= $_SESSION["username"]?>!
                </span>
                <a style="margin-left: 15px" class="btn btn-danger" href="logout.php">Log out</a>
            </div>
        </div>
    </nav>
    <!-- div class for CEV (dark green part) that explains website's purpose and leads to actionable buttons for climate-ition and search one company-->
    <div class="p-5 mb-4 text-white bg-darkGreen sbg-gradient">
        <div class="container py-5">
            <h1 class="display-5 fw-bold">Corporate Emissions Viewer</h1>
            <h5 class="col-md-8 fs-4">Curious about whether your favorite companies have sustainable practices or are just green washing?  Look no further...</h5>
            <p> Click "Climate-ition" below to compare two companies' sustainability efforts side by side, or click "Search One Company" to see the sustainability efforts of one company. </p>
            <a class="btn btn-danger btn-lg climate-itionButton" href="climate-itionSearch.php">Climate-ition</a>
            <a class="btn btn-danger btn-lg oneCompanyButton" href="searchOneCompany.php">Search One Company</a>
        </div>
    </div>

    <!-- Section where various popular companies will be listed along with links to pages with their sustainability info-->
  <h2 style="margin-left: 50px; ">Explore Popular Companies </h2>
  <div class="bg-darkBlue mx-auto">
    <div class="container">
        <div class="row" style="padding-top:50px;">

            <!-- Columns start at 50% wide on mobile and bump up to 33.3% wide on desktop -->
            <!-- 3 cards for 3 separate companies (all fast food in the example) -->
            <div class="card mx-auto mcdonaldsIndexCard bg-darkBlue" id="mcdonaldsCard" style="width: 18rem;">
              <img class="card-img-top mcdonaldsLogo" src="mcdonaldsLogo.png" alt="McDonald's Logo">
              <div class="card-body">
                <h5 class="card-title">McDonalds</h5>
                <p class="card-text" id="mcdonaldsText"></p>
                <button id="McD" class="btn btn-info">Sustainability Info</button>
              </div>
            </div>
            <div class="card mx-auto chipotleIndexCard" style="width: 18rem;">
              <img class="card-img-top chipotleLogo" src="chipotleLogo.png" alt="Chipotle Logo">
              <div class="card-body">
                <h5 class="card-title">Chipotle</h5>
                <p class="card-text"></p>
                <button onclick="unavailable('Chip');" id="Chip" class="btn btn-info">Sustainability Info</button>
              </div>
            </div>

            <div class="card mx-auto cookoutIndexCard" style="width: 18rem;">
              <img class="card-img-top" src="cookoutLogo.png" alt="CookOut Logo">
              <div class="card-body">
                <h5 class="card-title">CookOut</h5>
                <p class="card-text"></p>
                <button onclick="unavailable('Cook');" id="Cook" class="btn btn-info">Sustainability Info</button>
              </div>
            </div>
        </div>
    </div>
  </div>
  <!-- Copyright and footer code below-->
    <div class="container">
        <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top">
            <p class="col-md-4 mb-0 text-muted">&copy; 2021 Rena Wolinsky and Colin Buyck</p>

            <ul class="nav col-md-4 justify-content-end">
                <li class="nav-item"><a href="home.php" class="nav-link px-2 text-muted">Home</a></li>
                <li class="nav-item"><a href="climate-itionSearch.php" class="nav-link px-2 text-muted">Climate-ition</a></li>
                <li class="nav-item"><a href="searchOneCompany.php" class="nav-link px-2 text-muted">Search One Company</a></li>
            </ul>
        </footer>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
    <script> //function for cards where sustainability info is unavailable
      unavailable = (id) => {
        var elem = document.getElementById(id);
        elem.disabled = true;
        alert("This information is not yet available.");
      }
    </script>
</body>
</html>