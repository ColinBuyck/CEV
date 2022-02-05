<?php
// REQUIRED HEADERS FOR CORS
// Allow access to our development server, localhost:4200
header("Access-Control-Allow-Origin: http://localhost:4200");
header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Authorization, Accept, Client-Security-Token, Accept-Encoding");
header("Access-Control-Max-Age: 1000");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT");
/** DATABASE SETUP **/
include 'database_variables.php';
include 'common-func.php';
//include 'likedList.php';
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // Extra Error Printing
$mysqli = new mysqli($SERVER, $USERNAME, $PASSWORD, $DATABASE);
$user   = null; //unused variable
$count = 0; //count is used
session_start(); 
$no_list = false; //do if in html with this
// If the user's username is not set in the session, then it's not
// a valid session (they didn't get here from the login page),
// so we should send them over to log in first before doing
// anything else!
if ($_SESSION["username"] == "") {
 header("Location: index.php");
 exit();
}
$thumb_arr = json_decode($_COOKIE["thumbs"], true); //thumb array is for green thumb idea -- what user has liked
//keep it in cookies until they log out and then it saves to the database
//within database is an array of their thumbs
//thumb array is php array of ids of the companies but not full set of information about companies


if (isset($_POST["unthumbed"])) {
 //$thumb_arr = array_diff($thumb_arr, array($_POST["unthumbed"]));
 //setcookie("thumbs", json_encode($thumb_arr), time() + 3600);
 unlike($thumb_arr);
}

/*
function likedList($thumb_arr, $mysqli, $data){
$search_arr = "(";
foreach ($thumb_arr as $id) {
$search_arr .= $id . ", ";
}
$search_arr = substr($search_arr, 0, -2) . ")";
$res_query  = "SELECT * FROM corporation WHERE id IN" . $search_arr . ";";
$res        = $mysqli->query($res_query);

if ($res === false) {
die("MySQL database failed");
}
$data = $res->fetch_all(MYSQLI_ASSOC);

if (!isset($data[0])) {
die("No corporations in the database");
}

// Message variable to display if needed
$message = "";
//return $data;
// If the user submitted (POST) an answer to a question, we should check
// to see if they got it right!
}
 */

if ($thumb_arr != null && $thumb_arr != [0]) {
 $search_arr = "(";
 foreach ($thumb_arr as $id) {
  $search_arr .= $id . ", ";
 }
 $search_arr = substr($search_arr, 0, -2) . ")";
 $res_query  = "SELECT * FROM corporation WHERE id IN" . $search_arr . ";";
 $res        = $mysqli->query($res_query);

 if ($res === false) {
  die("MySQL database failed");
 }
 $data = $res->fetch_all(MYSQLI_ASSOC);

 if (!isset($data[0])) {
  die("No corporations in the database");
 }

// Message variable to display if needed
 $message = "";
// If the user submitted (POST) an answer to a question, we should check
 // to see if they got it right!

 //likedList($thumb_arr, $mysqli, $data);
} else {
 $no_list = true;

}


?>

<!DOCTYPE html> <!-- is it fine to have this here for the javascript or will it cause problems in angular?? -->
<html>
<head>
<script src= 'https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js' integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
<script>
    function highlightRemove(id){
        var removeElement = document.getElementById(id);
        removeElement.classList.remove("btn-warning");
        removeElement.classList.add("btn-danger");
        removeElement.textContent = "Click to remove.";
    }
    function unhighlightRemove(id){
        var removeElement = document.getElementById(id);
        removeElement.classList.remove("btn-danger");
        removeElement.classList.add("btn-warning");
        removeElement.textContent = "Remove from list";
    }
</script>
</head>
</html>

<!--
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

<body onload="test()">
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
    <?php if ($no_list == false) {?>
    <div class="text-white bg-darkGreen sbg-gradient">
        <div class="container py-5">
            <h1 class="display-5 fw-bold">Your List!</h1>
        </div>
    </div>
    <div style="margin-left: 25%">
    <?php foreach ($data as $corp) {

 $env_cost = substr($corp["cost"], 1, -1);
 ?>
        <div class="card" style="width: 66%">
        <div class="card-body">
            <div class="d-flex">
            <h5 class="card-title"><?=$corp["name"]?></h5>
            <form action="my_list.php" method="post">
                <input type="hidden" value=<?=$corp["id"]?> name="unthumbed"></input>
                <button type="submit" class="btn btn-warning" id=<?=$count?> onmouseenter ="highlightRemove(<?=$count?>)" onmouseleave="unhighlightRemove(<?=$count?>)">Remove from list</button>
            </form>
            </div>
            <h6 class="card-subtitle mb-2 text-muted"><?=$corp["industry"]?> Industry</h6>
            <p class="card-text-center">Environmental Cost: $<?=$env_cost?></p>
        </div>
        </div>
    <?php
    $count+=1;
    }?>
    </div>
    <?php } else {?>
        <div class="text-white bg-darkGreen sbg-gradient">
        <div class="container py-5">
            <h1 class="display-5 fw-bold">You Need to Add Corporations to Your List First!</h1>
        </div>
    </div>
    <?php }?>
</body>
</html>
-->
