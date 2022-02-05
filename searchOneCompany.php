<?php
/** DATABASE SETUP **/
include 'database_variables.php';
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // Extra Error Printing
$mysqli  = new mysqli($SERVER, $USERNAME, $PASSWORD, $DATABASE);
$user    = null;
$pattern = "/^[A-Za-z]+$/";
session_start();
// If the user's username is not set in the session, then it's not
// a valid session (they didn't get here from the login page),
// so we should send them over to log in first before doing
// anything else!
if ($_SESSION["username"] == "") {
 header("Location: index.php");
 exit();
}
$JSON_selected = isset($_POST["JSON"]);

if (isset($_POST["thumbed"])) {
 $thumb_arr = json_decode($_COOKIE["thumbs"], true);
 if (!in_array($_POST["thumbed"], $thumb_arr)) {
  $thumb_arr[] = $_POST["thumbed"];
  setcookie("thumbs", json_encode($thumb_arr, time() + 3600));
 }
}
else {
 $thumb_arr = json_decode($_COOKIE["thumbs"], true);
}

if (isset($_POST["search"])) {
 if (preg_match($pattern, $_POST["search"])) {
  $search_string = strtoupper($_POST["search"]);
  $res_query     = "select * from corporation where name LIKE '%" . $search_string . "%';";
  $res           = $mysqli->query($res_query);
  if ($res === false) {
   die("MySQL database failed");
  }
  $data = $res->fetch_all(MYSQLI_ASSOC);
  if (!isset($data[0])) {
   $no_list = true;
  } else {
   $no_list = false;
  }

 } 
}

$message = "";

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

  <title>Search One Company</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
</head>

<body class="bg-yellow">
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark" aria-label="Main Navigation Bar">
        <div class="container-xl">
            <a class="navbar-brand" href="home.php"><img src="cevLogo.png" width="30" height="30" class="d-inline-block align-top" alt="cev Logo"> Corporate Emissions Viewer</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsTop" aria-controls="navbarsTop" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarsTop">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link  href= "home.php" >Home</a>
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

<!-- See one company's sustainability efforts-->
<h1 class="title text-center"> Search One Company's Environmental Impact</h1>

<!-- One form to search for one company -->
<div class="col-md-8 mx-auto">
<form action="searchOneCompany.php" onsubmit ="return validate();" method="post" class="mb-2 text-center" >
    <input id ="search" class="form-control" type="text" name="search"></input>
    <label class="form-check-label" for="JSON">
        Results in JSON?
    </label>
    <input id="JSON" class="form-check-input" type ="checkbox" name="JSON"></input>
    <br>
    <br>
    <p id="company_info"></p>
    <button type="submit"  class="btn btn-dark btn-lg mx-auto oneSearchButton">See All Search Companies Environmental Impacts</button>
</form>

</div>

<div>
<p id="message"></p>
</div>

<?php if (isset($no_list) && !$no_list && !$JSON_selected) {
 foreach ($data as $corp) {
  $selected = in_array($corp["id"], json_decode($_COOKIE["thumbs"], true)) || (isset($_POST["thumbed"]) && $_POST["thumbed"] == $corp["id"]);
  $env_cost = substr($corp["cost"], 1, -1);
  ?>
  <div style="margin-left: 25%">
        <div class="card" style="width: 66%">
        <div class="card-body">
            <div class="d-flex">
            <h5 class="card-title"><?=$corp["name"]?></h5>
            <form action="searchOneCompany.php" method="post">
                <input type="hidden" value=<?=$_POST["search"]?>  name="search"></input>
                <input type="hidden" value=<?=$corp["id"]?> name="thumbed"></input>
                <?php if (!$selected) {?>
                <button type="submit" class="btn btn-primary">Add to my list</button>
                <?php } else {?>
                <a class="btn btn-secondary">Already Added</a>
                <?php }?>
            </form>
            </div>
            <h6 class="card-subtitle mb-2 text-muted"><?=$corp["industry"]?> Industry</h6>
            <p class="card-text-center">Environmental Cost: $<?=$env_cost?></p>
        </div>
        </div>
</div>
        <?php }
} else if (isset($no_list) && !$no_list && $JSON_selected) {
 print_r($data);
} else if (isset($no_list) && $no_list) {?>
  <div style="margin-left: 25%">
    No results
    </div>
    <?php }?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
    <script>
    function validate() {
        var search = document.getElementById("search");
        if (search.value.length > 0){
            return true;
        }
        alert("Search cannot be empty. Enter one or more letters or navigate to Explore Corporations.");
        return false;
        
    }
    
    //use ajax query to return the first company out of a list of searched companies without reloading the page
    var company = null; //first company result, will be displayed 
    var cost = null;
    function getCompany() {
            
            // instantiate the object
            var ajax = new XMLHttpRequest();
            // open the request
            var search = document.getElementById("search").value;
            ajax.open("GET", "redirect.php?search=random", true);
            // ask for a specific response
            ajax.responseType = "json";
            // send the request
            ajax.send(null);
            
            // What happens if the load succeeds
            ajax.addEventListener("load", function() {
                // set question
                if (this.status == 200) { // worked 
                    company = this.response;
                    displayCompany();
                }
            });
            
            // What happens on error
            ajax.addEventListener("error", function() {
                document.getElementById("message").innerHTML = 
                    "<div class='alert alert-danger'>An Error Occurred</div>";
            });
        }
        
        // Method to display a company
        function displayCompany() {
            document.getElementById("company_info").innerHTML =  "Try searching something like " + company.name;
        }
        
        
        // Need to add the initial company load
        getCompany();
    </script>
</body>
</html>
