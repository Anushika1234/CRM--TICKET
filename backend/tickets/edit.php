<?php
include("../middleware/auth.php");
include("../config/db.php");

$user = $_SESSION['user_id'];
$data = json_decode(file_get_contents("php://input"), true);
$id = $data['id'];

$check = mysqli_query($conn,
"SELECT id FROM tickets WHERE id=$id AND created_by=$user");

if(mysqli_num_rows($check)==0){
 http_response_code(403);
 echo "forbidden";
 exit;
}

mysqli_query($conn,
"UPDATE tickets SET
 name='{$data['name']}',
 description='{$data['description']}',
 updated_at=NOW()
 WHERE id=$id");

echo "updated";