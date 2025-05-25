<?php
session_start();

if(!isset($_SESSION['email']))
   header("location:login.php");

   
echo"<br><h2> Website Administration </h2>";


?>