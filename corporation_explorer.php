<?php
/** DATABASE SETUP **/
//include 'database_connection.php';
include 'database_variables.php';
include 'common-func.php';
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // Extra Error Printing
$mysqli = new mysqli($SERVER, $USERNAME, $PASSWORD, $DATABASE);
//connect();
$user = null;
$count = 0;
session_start();

// If the user's username is not set in the session, then it's not
// a valid session (they didn't get here from the login page),
// so we should send them over to log in first before doing
// anything else!
if ($_SESSION["username"] == "") {
 header("Location: index.php");
 exit();
}


if (isset($_POST["thumbed"])) {
 /*
 $thumb_arr = json_decode($_COOKIE["thumbs"], true);
 if (!in_array($_POST["thumbed"], $thumb_arr)) {
 $thumb_arr[] = $_POST["thumbed"];
 setcookie("thumbs", json_encode($thumb_arr, time() + 3600));
  */
 liked();
 //}
 //;
} else {
 $thumb_arr = json_decode($_COOKIE["thumbs"], true);
}

if (isset($_POST["industry"])) {
 setcookie("industry", $_POST["industry"], time() + 3600);
 $industry = $_POST["industry"];
} else {
 $industry = $_COOKIE["industry"];
}
// if user selects industry all then find all company info 
if ($industry == "All") {
 $res_query = "select * from corporation;";
} else {
 $res_query = "SELECT * FROM corporation WHERE industry='" . $industry . "';";
}
$res = $mysqli->query($res_query);
if ($res === false) {
 die("MySQL database failed");
}
$data = $res->fetch_all(MYSQLI_ASSOC);

if (!isset($data[0])) {
 die("No corporations in the database");
}
// Message variable to display if needed
$message = "";


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
    <div class="text-white bg-darkGreen sbg-gradient">
        <div class="container py-5">
            <h1 class="display-5 fw-bold">Learn more about <?=$industry?> Corporations</h1>
            <h5> Environmental Cost is the total monetized environmental impact of the firm's operations in 2018. </h5>
            <?php if ($_GET["industry"] == $industry) {?>
            <h6>You just looked at this industry!</h6>
            <?php } else if ($_GET["industry"] == "All") {?>
            <h6> You looked at all industries last time! </h6>
            <?php } else {?>
            <h6> You looked at the <?=$_GET["industry"]?> industry last time!</h6>
            <?php }?>

        </div>
    </div>
    <div style="margin-left: 25%">
    <a class="btn btn-link" id="back" href="industries.php">Back to Industry Selection</a>
    <?php foreach ($data as $corp) {
 $selected = in_array($corp["id"], json_decode($_COOKIE["thumbs"], true)) || (isset($_POST["thumbed"]) && $_POST["thumbed"] == $corp["id"]);
 $env_cost = substr($corp["cost"], 1, -1);
 ?>
        <div class="card" style="width: 66%">
        <div class="card-body">
            <div class="d-flex">
            <h5 class="card-title"><?=$corp["name"]?></h5>
            <form action="corporation_explorer.php?industry=<?=$_GET["industry"]?>" method="post">
                <input type="hidden" value=<?=$corp["id"]?> name="thumbed"></input>
                <?php if (!$selected) {?>
                <button type="submit" id=<?=$count?> onmouseenter ="highlightAdd(<?=$count?>)" onmouseleave="unhighlightAdd(<?=$count?>)" class="btn btn-primary">Add to my list</button>
                <?php } else {?>
                <a class="btn btn-secondary">Already Added</a>
                <?php }?>
            </form>
            </div>
            <h6 class="card-subtitle mb-2 text-muted"><?=$corp["industry"]?> Industry</h6>
            <p class="card-text-center">Environmental Cost: $<?=$env_cost?></p>
        </div>
        </div>
    <?php $count += 1;
    }?>
    </div>
    <script src= 'https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js' integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
    <script>
         
        function highlightBack(){
            var backElement = document.getElementById("back");
            backElement.classList.remove("btn-link");
            backElement.classList.add("btn-warning");
        }
        function highlightAdd(id){
            var addElement = document.getElementById(id);
            addElement.classList.remove("btn-primary");
            addElement.classList.add("btn-success");
            addElement.textContent = "Click to add!";
        }
        function unhighlightBack(){
            var backElement = document.getElementById("back");
            backElement.classList.remove("btn-warning");
            backElement.classList.add("btn-link");
        }
        function unhighlightAdd(id){
            var addElement = document.getElementById(id);
            addElement.classList.add("btn-primary");
            addElement.classList.remove("btn-success");
            addElement.textContent = "Add to my list";
        }
        document.getElementById("back").addEventListener("mouseover", function(){
            highlightBack();
            // setTimeout(function() {
            //     backElement.classList.add("btn-link");
            //     backElement.classList.remove("btn-warning");
            // }, 2000);
        })
        document.getElementById("back").addEventListener("mouseleave", function(){
            //console.log("jwilkc");
            unhighlightBack();
        })
        // backElement.addEventListener("mouseleave", function(){
        //     highlight(backElement);
        //     setTimeout(function() {
        //         backElement.classList.add("btn-link");
        //         backElement.classList.remove("btn-warning");
        //     }, 2000);
        // })

    </script>

</body>
</html>