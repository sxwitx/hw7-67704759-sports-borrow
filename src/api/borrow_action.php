<?php
session_start();
if (!isset($_SESSION['user_id'])) { http_response_code(401); exit; }
require_once '../config/db.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
$action = $data['action'] ?? '';

if ($action === 'borrow') {
    $stmt = $conn->prepare("INSERT INTO borrow_records (user_id, equipment_id, borrow_date, return_date, status) VALUES (?, ?, CURDATE(), ?, 'borrowed')");
    $stmt->execute([$_SESSION['user_id'], $data['equipment_id'], $data['return_date']]);
    $conn->prepare("UPDATE equipments SET available = available - 1 WHERE id = ?")->execute([$data['equipment_id']]);
    echo json_encode(['status' => 'success']);

} elseif ($action === 'return') {
    $conn->prepare("UPDATE borrow_records SET status = 'returned' WHERE id = ?")->execute([$data['borrow_id']]);
    $conn->prepare("UPDATE equipments SET available = available + 1 WHERE id = ?")->execute([$data['equipment_id']]);
    echo json_encode(['status' => 'success']);
}
?>