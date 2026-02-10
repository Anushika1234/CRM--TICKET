<?php
session_start();
include("../config/db.php");

$user = $_SESSION['user_id'];

$data = json_decode(file_get_contents("php://input"), true);

$ticket_id = $data['id'];
$status = $data['status'] ?? null;
$name = $data['name'] ?? null;
$description = $data['description'] ?? null;

/* Fetch ticket */
$res = mysqli_query($conn, "SELECT * FROM tickets WHERE id=$ticket_id");
$ticket = mysqli_fetch_assoc($res);

if (!$ticket) {
    http_response_code(404);
    echo "Ticket not found";
    exit;
}

/* AUTHOR */
if ($ticket['created_by'] == $user) {
    mysqli_query($conn, "
        UPDATE tickets SET
        name='$name',
        description='$description',
        status='$status',
        updated_at=NOW()
        WHERE id=$ticket_id
    ");
    echo "Updated by author";
    exit;
}

/* ASSIGNEE */
if ($ticket['assigned_to'] == $user && $status) {
    mysqli_query($conn, "
        UPDATE tickets SET
        status='$status',
        updated_at=NOW()
        WHERE id=$ticket_id
    ");
    echo "Status updated by assignee";
    exit;
}

/* BLOCK OTHERS */
http_response_code(403);
echo "Forbidden";
