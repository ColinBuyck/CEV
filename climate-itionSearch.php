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
  <meta name="keywords" content="Climate, CO2, Footprint, green washing, companies, sustainability, consumerism">

  <title>Climate-ition Search</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
</head>

<!--Nav bar with different active link (so climate-ition is highlighted when this page is active in nav bar) -->
<body class="bg-lightGreen" onload = "functionalityWarning()">
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

<!--Climate-ition content:  users search for two companies' sustainability efforts...here is just the search page/ action, clicking button leads to different page-->
  <h1 class="title" style="text-align:center;"> Climate-ition </h1>
  <p class="text-center">For each of the two search bars, type in one company and click â€œFind Companyâ€ to check if sustainability information for that company is available (after sprint 3).<br>After you have two companies typed in, click the â€œCompare Sustainability Effortsâ€ button to see both companiesâ€™ sustainability efforts side by side.  </p>

<!-- 3 divs in form (2 search boxes and the search button -->
  <div class="col-md-8 mx-auto">
  <form class="mb-3">
    <div class="mb-3 text-center">
      <input class="form-control me-2 climateitionSearchBars text-center" type="search" placeholder="Type Company 1 (In next sprint, autocomplete and search will work along with Find Company 1 button)" aria-label="Search">
      <button class="btn btn-dark my-auto" type="submit">Find Company 1</button>
    </div>
    <div class="mb-3 text-center">
      <input class="form-control me-2 climateitionSearchBars text-center" type="search" placeholder="Type Company 2 (In next sprint, autocomplete and search will work along with Find Company 2 button)" aria-label="Search">
      <button class="btn btn-dark" type="submit">Find Company 2</button>
    </div>
    <div class="mb-3 text-center">
    <a class="btn btn-success btn-lg compareButton" href="climate-itionResult.php">Compare Sustainability Efforts</a>
    </div>
  </form>
  </div>
  <script>
    function functionalityWarning() {
        alert("Warning: This page is still under construction. If you are looking for search functionality, it is available via the 'Search One Company' tab.");  
    }
  </script>

</body>
</html>