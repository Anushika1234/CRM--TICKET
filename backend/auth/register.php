<?php
include("../config/db.php");

$name = $_POST['name'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

mysqli_query($conn,
"INSERT INTO users (name,email,password)
 VALUES ('$name','$email','$password')"
);

header("Location: ../../frontend/login.html");
