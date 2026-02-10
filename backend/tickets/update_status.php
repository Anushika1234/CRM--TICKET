<?php
session_start();
include("../config/db.php");

$user = $_SESSION['user_id'];
$data = json_decode(file_get_contents("php://input"), true);

$id = $data['id'];
$status = $data['status'];

$res = mysqli_query($conn, "SELECT * FROM tickets WHERE id=$id");
$ticket = mysqli_fetch_assoc($res);

if (!$ticket) {
    http_response_code(404);
    exit("Ticket not found");
}

if ($ticket['assigned_to'] != $user) {
    http_response_code(403);
    exit("Not allowed");
}

mysqli_query($conn, "
  UPDATE tickets
  SET status='$status', updated_at=NOW()
  WHERE id=$id
");

echo "Status updated";
