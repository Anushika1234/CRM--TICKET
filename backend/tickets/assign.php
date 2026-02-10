<?php
include("../middleware/auth.php");
include("../config/db.php");

header("Content-Type: application/json");

$user = $_SESSION['user_id'];
$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['ticket_id'], $data['assigned_to'])) {
    http_response_code(400);
    echo json_encode(["error" => "Invalid input"]);
    exit;
}

$ticket_id = (int)$data['ticket_id'];
$assignee = (int)$data['assigned_to'];

/* Check ownership */
$stmt = $conn->prepare(
    "SELECT id FROM tickets WHERE id=? AND created_by=?"
);
$stmt->bind_param("ii", $ticket_id, $user);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    http_response_code(403);
    echo json_encode(["error" => "Unauthorized"]);
    exit;
}

/* Assign ticket */
$update = $conn->prepare(
    "UPDATE tickets 
     SET assigned_to=?, assigned_at=NOW() 
     WHERE id=?"
);
$update->bind_param("ii", $assignee, $ticket_id);
$update->execute();

echo json_encode(["status" => "assigned"]);
