<?php
session_start();
include("../config/db.php");

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

$res = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
$user = mysqli_fetch_assoc($res);

if ($user && password_verify($password, $user['password'])) {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['user_name'] = $user['name'];

    header("Location: ../../frontend/ticket.html");
    exit;
} else {
    echo "<script>
        alert('Invalid Credentials');
        window.location.href='../../frontend/login.html';
    </script>";
}
