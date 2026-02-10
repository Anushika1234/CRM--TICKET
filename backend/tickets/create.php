<?php
include("../middleware/auth.php");
include("../config/db.php");

$data = json_decode(file_get_contents("php://input"), true);
$user = $_SESSION['user_id'];

mysqli_query($conn,
"INSERT INTO tickets(name,description,created_by)
 VALUES('{$data['name']}','{$data['description']}',$user)");

echo "success";