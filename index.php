<?php
/** https://cs4640.cs.virginia.edu/cjb2utf/sprint4
 *  https://cs4640.cs.virginia.edu/rjw3kk/sprint4
 * **/
/** DATABASE SETUP **/
include 'database_variables.php';
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // Extra Error Printing
$mysqli = new mysqli($SERVER, $USERNAME, $PASSWORD, $DATABASE);
//$mysqli = new mysqli("localhost", "root", "", "example"); // XAMPP

$error_msg = "";
session_start();
setcookie("thumbs", json_encode([0]), time() + 3600);
setcookie("industry", "All", time() + 3600);
// Check if the user submitted the form (the form in the HTML below
// submits back to this page, which is okay for now.  We will check for
// form data and determine whether to re-show this form with a message
// or to redirect the user to the trivia game.
if (isset($_POST["name"]) && isset($_POST["username"]) && isset($_POST["email"])) { // validate the email coming in
 $stmt = $mysqli->prepare("select * from user where username = ?;");
 $stmt->bind_param("s", $_POST["username"]);
 if (!$stmt->execute()) {
  $error_msg = "Error checking for user";
 } else {
  // result succeeded
  $res  = $stmt->get_result();
  $data = $res->fetch_all(MYSQLI_ASSOC);
  if (!empty($data)) {
   // user was found!

   // validate the user's password
   if (password_verify($_POST["password"], $data[0]["password"])) {
    // Save user information into the session to use later
    $_SESSION["name"]     = $data[0]["name"];
    $_SESSION["username"] = $data[0]["username"];
    $_SESSION["email"]    = $data[0]["email"];
    if ($data[0]["thumbs"] != null) {
     setcookie("thumbs", $data[0]["thumbs"], time() + 3600);
    }
    header("Location: home.php");
    exit();
   } else {
    // User was found but entered an invalid password
    $error_msg = "Invalid Password";
   }
  } else {
   // User was not found.  For our game, we'll just insert them!
   // NEVER store passwords into the database, use a secure hash instead:
   $hash   = password_hash($_POST["password"], PASSWORD_DEFAULT);
   $insert = $mysqli->prepare("insert into user (name, username, email, password) values (?,?,?,?);");
   $insert->bind_param("ssss", $_POST["name"], $_POST["username"], $_POST["email"], $hash);
   if (!$insert->execute()) {
    $error_msg = "Error creating new user";
   }
   // Send them to the game
   // Save user information into the session to use later
   $_SESSION["name"]     = $_POST["name"];
   $_SESSION["username"] = $_POST["username"];
   $_SESSION["email"]    = $_POST["email"];
   header("Location: home.php");
   exit();
  }
 }

}

?>

<!DOCTYPE html>
<!--
Sources used: https://cs4640.cs.virginia.edu, https: //getbootstrap.com/docs/,
https://www.php.net/docs.php, https: //stackoverflow.com/questions/2448964/php-how-to-remove-specific-element-from-an-array/2449093,
https://developer.mozilla.org/en-US/docs/Web/API/Element/mouseover_event , https://stackoverflow.com/questions/9334636/how-to-create-a-dialog-with-yes-and-no-options
-->
<html lang="en">
<head>
  <link rel="stylesheet" href="styles.css">
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author" content="Rena Wolinsky and Colin Buyck">
  <meta name="description" content="Login page for website where users can search for climate footprints of companies to educate and empower consumers">
  <meta name="keywords" content="Climate, CO2, Footprint, green washing, companies, sustainability, consumerism ">

  <title>CEV</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
</head>

<body onload = "autofillOption()">
  <!-- Navigation bar code -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark" aria-label="Main Navigation Bar">
        <div class="container-xl">
            <a class="navbar-brand" href="home.php"><img src="cevLogo.png" width="30" height="30" class="d-inline-block align-top" alt="cev Logo"> Corporate Emissions Viewer</a>

            </div>
        </div>
    </nav>


        <div class="container" style="margin-top: 15px;">
            <div class="row col-xs-8">
                <h2 class="text-center">Sign-In</h2>
                <p class = "text-center">Are you ready to learn more about the environmental impact of corporations?   To get started, login below or enter a new username, name, and password to create an account.</p>
            </div>
            <div class="row justify-content-center">
                <div class="col-4">
                <?php
                    if (!empty($error_msg)) {
                    echo "<div class='alert alert-danger'>$error_msg</div>";
                    }
                ?>
                <div class="text-center">
                    <button id="autofill" onclick="formFill()" class="btn btn-secondary" disabled> No autofill info </button>
                </div>
                <form action="index.php" method="post" onsubmit="return validate();">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username"  maxlength = "30"/>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" />
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label" maxlength = "30">Name</label>
                        <input type="text" class="form-control" id="name" name="name" />
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password"
                         class="form-control  is-invalid" id="password" name="password"/>
                        <div id="help" class="form-text"></div>
                    </div>

                    <div class="text-center">
                    <button type="submit" id="submit" class="btn btn-primary" disabled>Log in / Create Account</button>
                    </div>
                </form>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
        <script>
            function validate () {
                var username = document.getElementById("email").value;
                var email = document.getElementById("username").value;
                var name = document.getElementById("name").value;
                var password = document.getElementById("password").value; 
                if (username.length > 0 && email.length > 0 && name.length > 0 && password.length > 0) {
                    setAutofill();
                    return true;
                }
                alert("Username, Email, and Name are all required.");    
                return false;
            }

            passwordLength = (num) => {
                var password = document.getElementById("password");
                var help = document.getElementById("help");
                var submit = document.getElementById("submit");              
                if (password.value.length < num) {
                    help.textContent = "Password must be at least " + num + " characters";
                    submit.disabled = true;
                } else {
                    help.textContent = "";
                    password.classList.remove("is-invalid");
                    submit.disabled = false;
                    
                }
            }
            setAutofill = () => {
                var userInfo = {
                    "username": document.getElementById("username").value,
                    "email": document.getElementById("email").value,
                    "name": document.getElementById("name").value,
                }
                if(confirm("Do you want to save your info to autofill in the future?")){
                    localStorage.setItem("userInfo", JSON.stringify(userInfo));
                }
            }
            
            document.getElementById("password").addEventListener("keyup", function() {
                passwordLength(8); 
            });

            autofillOption = () => {
                if(localStorage.getItem("userInfo") != null){
                    console.log(localStorage.getItem("userInfo"));
                    var autofillButton = document.getElementById("autofill");
                    autofillButton.disabled = false;
                    autofillButton.classList.remove("btn-secondary");
                    autofillButton.classList.add("btn-success");
                    autofillButton.textContent = "Use Autofill!";
                }
            }
            formFill = () =>{
                var userInfo = JSON.parse(localStorage.getItem("userInfo"));
                document.getElementById("username").value = userInfo["username"];
                document.getElementById("email").value = userInfo["email"];
                document.getElementById("name").value = userInfo["name"];
                autofill = true;
            }

        </script>
    </body>
</html>
