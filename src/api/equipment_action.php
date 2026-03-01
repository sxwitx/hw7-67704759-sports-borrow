<?php
session_start();
if (!isset($_SESSION['user_id'])) { http_response_code(401); exit; }
require_once '../config/db.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
$action = $data['action'] ?? '';

if ($action === 'add') {
    $stmt = $conn->prepare("INSERT INTO equipments (name, category, quantity, available) VALUES (?, ?, ?, ?)");
    $stmt->execute([$data['name'], $data['category'], $data['quantity'], $data['quantity']]);
    echo json_encode(['status' => 'success', 'message' => 'เพิ่มอุปกรณ์สำเร็จ']);

} elseif ($action === 'edit') {
    $stmt = $conn->prepare("UPDATE equipments SET name=?, category=?, quantity=? WHERE id=?");
    $stmt->execute([$data['name'], $data['category'], $data['quantity'], $data['id']]);
    echo json_encode(['status' => 'success', 'message' => 'แก้ไขอุปกรณ์สำเร็จ']);

} elseif ($action === 'delete') {
    $stmt = $conn->prepare("DELETE FROM equipments WHERE id=?");
    $stmt->execute([$data['id']]);
    echo json_encode(['status' => 'success']);
}
?>