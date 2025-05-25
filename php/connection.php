<?php
$con = mysqli_connect("localhost", "root", "", "project");

if (mysqli_connect_errno()) {
    die("Database connection failed: " . mysqli_connect_error());
}

mysqli_set_charset($con, "utf8mb4");
