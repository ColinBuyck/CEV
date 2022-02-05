<?php
//liking a company
function liked()
{
 $thumb_arr = json_decode($_COOKIE["thumbs"], true);
 if (!in_array($_POST["thumbed"], $thumb_arr)) {
  $thumb_arr[] = $_POST["thumbed"];
  setcookie("thumbs", json_encode($thumb_arr, time() + 3600));
 }
}
//unliking a company
function unlike(&$thumb_arr)
{
 $thumb_arr = array_diff($thumb_arr, array($_POST["unthumbed"]));
 setcookie("thumbs", json_encode($thumb_arr), time() + 3600);
}

?>
