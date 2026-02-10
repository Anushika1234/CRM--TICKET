<?php
include("../middleware/auth.php");
include("../config/db.php");

header("Content-Type: application/json");

$user = $_SESSION['user_id'];

$query = "
SELECT * FROM tickets
WHERE (created_by=$user OR assigned_to=$user)
AND deleted_at IS NULL
";

$res = mysqli_query($conn, $query);

$data = [];
while ($row = mysqli_fetch_assoc($res)) {
    $row['current_user'] = $user;
    $data[] = $row;
}

echo json_encode($data);