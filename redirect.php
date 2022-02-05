<?php
    session_start();
    if (isset($_GET["search"]) && $_SESSION["username"] != "") {
        $search = strtoupper($_GET["search"]);
    }else{
        header("Location: home.php");
    }
    include('database_variables.php');
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // Extra Error Printing
    $db = new mysqli($SERVER, $USERNAME, $PASSWORD, $DATABASE); 
    //query to find one random company
    $query = "select * from corporation order by rand() limit 1;";
    $res = $db->query($query);
    $data = $res->fetch_all(MYSQLI_ASSOC);
    if (!isset($data[0])) {
        die("No corporations available");
    }
    $company = $data[0];
    // Return JSON only
    header("Content-type: application/json");
    echo json_encode($company, JSON_PRETTY_PRINT);
    
?>