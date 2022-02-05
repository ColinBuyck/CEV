<?php
  /** SETUP **/
include('database_variables.php');
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // Extra Error Printing
$db = new mysqli($SERVER, $USERNAME, $PASSWORD, $DATABASE); 

//start fresh question table
$db->query("drop table if exists corporation;");
//create question table
$db->query("create table corporation (
          id int not null auto_increment,
          name text not null,
          industry text not null,
          cost text not null,
          primary key(id));");

//start fresh user table
$db->query("drop table if exists user;");
//create question table
//last is last viewed corporation
$db->query("create table user (
          id int not null auto_increment,
          name text not null,
          username text not null,
          email text not null,
          password text not null,
          thumbs text,
          primary key(id));");

//start fresh user_question table -- allows us to see the user_question
//might also want to add the category here so that it can be displayed
$db->query("drop table if exists corporate_comment;");
$db->query("create table corporate_comment (
           user_id int not null,
           corporation_id int not null,
           comment int not null);");

//inserting into db using csv file
/* sources of questions (from within csv file):
https://ribble-pack.co.uk/blog/seven-ways-wasteful-packaging-hurting-environment
https://www.alsoknownas.ca/12-interesting-facts-about-packaging-waste-and-disposal/
https://www.roadrunnerwm.com/blog/50-interesting-recycling-facts
https://www.earthday.org/fact-sheet-plastics-in-the-ocean/?gclid=CjwKCAjw2bmLBhBREiwAZ6ugo3JuKYUnFvvjvlJJ_ZGy8SadpdVPBVNb5ygkWRnkkS9x9r9sVTBilBoC3dUQAvD_BwE
https://www.seametrics.com/blog/water-conservation-facts/
https://www.thinkh2onow.com/water_conservation_facts.php
https://www.alsoknownas.ca/12-interesting-facts-about-packaging-waste-and-disposal/
https://uncw.edu/campuslife/documents/recyclingtriviaquestions.pdf
https://www.ecofriendlyhabits.com/sustainability-facts/
https://www.iliyanastareva.com/blog/44-social-media-and-sustainability-facts-and-figures-businesses-cannot-ignore
https://www.funtrivia.com/quizzes/sci__tech/environment.php
*/

//actual attempt
//source/ inspiration:  https://www.php.net/manual/en/function.fgetcsv.php

$row = 1; // starts with first row of csv file/ first question
if (($handle = fopen("us-corporate-env-updated.csv", "r")) !== FALSE) { //make sure csv can open
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) { //access csv contents
      $num = count($data);
      echo $num;
      print_r($data);
      //$row++;
      $stmt = $db->prepare("insert into corporation (name, industry, cost) values (?,?,?);");
      for ($c=0; $c < $num; $c++){
          if ($c == 1){
            $nameInsert = trim($data[$c]);
          }
          else if ($c == 2){
            $industryInsert = trim($data[$c]);
          }
          else if ($c == 3){
            $costInsert = trim($data[$c]);
        }
    }
      $stmt->bind_param("sss", $nameInsert, $industryInsert, $costInsert);
        if (!$stmt->execute()) {
            echo "Could not add corporation: {$nameInsert}\n";
        }
        $row++;
    }
}
    fclose($handle);
    echo "Setup";

?>