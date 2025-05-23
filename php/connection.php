<?php
$con = mysqli_connect("localhost", "rubby01", "SHOO123$", "project-1");

if (mysqli_connect_errno()) {
    die("Database connection failed: " . mysqli_connect_error());
}

mysqli_set_charset($con, "utf8mb4");
?>