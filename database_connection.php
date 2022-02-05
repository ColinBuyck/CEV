
<?php
function connect()
{
  include 'database_variables.php';
  mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // Extra Error Printing
  $mysqli = new mysqli($SERVER, $USERNAME, $PASSWORD, $DATABASE);
}
