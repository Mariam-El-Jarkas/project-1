<?php
session_start();
include "connection.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = $_POST['password'];

    $sql = "SELECT users.*, admins.admin_id FROM users 
            LEFT JOIN admins ON users.id = admins.user_id 
            WHERE email = '$email'";
    $result = mysqli_query($con, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['admin_id'] ? 'admin' : 'user';

            // Redirect based on role
            if ($_SESSION['role'] === 'admin') {
                header("Location: ../admin/dashboard.php");
            } else {
                header("Location: ../Home.html");
            }
            exit();
        }
    }
    
    header("Location: ../login.php?error=1");
    exit();
}
?>