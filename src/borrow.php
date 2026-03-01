<?php
session_start();
if (!isset($_SESSION['user_id'])) { header('Location: index.php'); exit; }
require_once 'config/db.php';

$stmt = $conn->query("SELECT * FROM equipments WHERE available > 0 AND status = 'active' ORDER BY name");
$equipments = $stmt->fetchAll();

$stmt2 = $conn->prepare("SELECT br.*, e.name as equipment_name, u.username 
                          FROM borrow_records br 
                          JOIN equipments e ON br.equipment_id = e.id 
                          JOIN users u ON br.user_id = u.id 
                          ORDER BY br.id DESC");
$stmt2->execute();
$records = $stmt2->fetchAll();
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>ยืม-คืนอุปกรณ์ | ระบบยืม-คืนอุปกรณ์กีฬา</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.4/jquery-confirm.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.4/jquery-confirm.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style> body { font-family: 'Kanit', sans-serif; } </style>
</head>
<body class="bg-slate-900 min-h-screen text-white">
    <nav class="bg-slate-800 border-b border-slate-700 px-6 py-4 flex justify-between items-center">
        <h1 class="text-xl font-bold text-cyan-400">🏆 ระบบยืม-คืนอุปกรณ์กีฬา</h1>
        <div class="flex gap-4">
            <a href="dashboard.php" class="bg-slate-600 hover:bg-slate-500 px-4 py-2 rounded-lg text-sm">Dashboard</a>
            <a href="equipments.php" class="bg-cyan-600 hover:bg-cyan-500 px-4 py-2 rounded-lg text-sm">จัดการอุปกรณ์</a>
            <a href="api/logout.php" class="bg-red-600 hover:bg-red-500 px-4 py-2 rounded-lg text-sm">ออกจากระบบ</a>
        </div>
    </nav>

    <div class="max-w-5xl mx-auto mt-8 px-4 space-y-8">

        <!-- ส่วนยืมอุปกรณ์ -->
        <div class="bg-slate-800 rounded-2xl border border-slate-700 p-6">
            <h2 class="text-xl font-bold mb-4">📋 ยืมอุปกรณ์</h2>
            <div class="flex gap-4">
                <select id="selectEquipment" class="flex-1 px-4 py-3 bg-slate-900 border border-slate-700 rounded-lg text-white outline-none focus:border-cyan-500">
                    <option value="">-- เลือกอุปกรณ์ที่ต้องการยืม --</option>
                    <?php foreach ($equipments as $eq): ?>
                    <option value="<?= $eq['id'] ?>">
                        <?= htmlspecialchars($eq['name']) ?> (<?= htmlspecialchars($eq['category']) ?>) - ว่าง <?= $eq['available'] ?> ชิ้น
                    </option>
                    <?php endforeach; ?>
                </select>
                <input type="date" id="returnDate" class="px-4 py-3 bg-slate-900 border border-slate-700 rounded-lg text-white outline-none focus:border-cyan-500" 
                       min="<?= date('Y-m-d') ?>">
                <button onclick="borrowEquipment()" class="bg-violet-600 hover:bg-violet-500 px-6 py-3 rounded-lg font-semibold whitespace-nowrap">
                    ยืมเลย
                </button>
            </div>
        </div>

        <!-- ตารางประวัติการยืม -->
        <div class="bg-slate-800 rounded-2xl border border-slate-700 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-700">
                <h2 class="text-xl font-bold">📜 ประวัติการยืม</h2>
            </div>
            <table class="w-full">
                <thead class="bg-slate-700">
                    <tr>
                        <th class="px-4 py-3 text-left">#</th>
                        <th class="px-4 py-3 text-left">อุปกรณ์</th>
                        <th class="px-4 py-3 text-left">ผู้ยืม</th>
                        <th class="px-4 py-3 text-center">วันที่ยืม</th>
                        <th class="px-4 py-3 text-center">กำหนดคืน</th>
                        <th class="px-4 py-3 text-center">สถานะ</th>
                        <th class="px-4 py-3 text-center">จัดการ</th>
                    </tr>
                </thead>
                <tbody id="borrowTable">
                    <?php foreach ($records as $rec): ?>
                    <tr class="border-t border-slate-700 hover:bg-slate-700/50" id="brow-<?= $rec['id'] ?>">
                        <td class="px-4 py-3"><?= $rec['id'] ?></td>
                        <td class="px-4 py-3 font-medium"><?= htmlspecialchars($rec['equipment_name']) ?></td>
                        <td class="px-4 py-3 text-slate-400"><?= htmlspecialchars($rec['username']) ?></td>
                        <td class="px-4 py-3 text-center"><?= $rec['borrow_date'] ?></td>
                        <td class="px-4 py-3 text-center"><?= $rec['return_date'] ?? '-' ?></td>
                        <td class="px-4 py-3 text-center">
                            <?php if ($rec['status'] === 'borrowed'): ?>
                                <span class="bg-yellow-500/20 text-yellow-400 px-3 py-1 rounded-full text-sm">กำลังยืม</span>
                            <?php else: ?>
                                <span class="bg-green-500/20 text-green-400 px-3 py-1 rounded-full text-sm">คืนแล้ว</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <?php if ($rec['status'] === 'borrowed'): ?>
                            <button onclick="returnEquipment(<?= $rec['id'] ?>, <?= $rec['equipment_id'] ?>)"
                                class="bg-green-600 hover:bg-green-500 px-3 py-1 rounded text-sm">คืนอุปกรณ์</button>
                            <?php else: ?>
                            <span class="text-slate-500 text-sm">-</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
    function borrowEquipment() {
        let equipmentId = $('#selectEquipment').val();
        let returnDate = $('#returnDate').val();

        if (!equipmentId) {
            $.alert({ title: '⚠️ แจ้งเตือน', content: 'กรุณาเลือกอุปกรณ์ก่อน', type: 'orange', theme: 'modern' });
            return;
        }
        if (!returnDate) {
            $.alert({ title: '⚠️ แจ้งเตือน', content: 'กรุณาเลือกวันที่คืน', type: 'orange', theme: 'modern' });
            return;
        }

        $.confirm({
            title: '📋 ยืนยันการยืม',
            content: 'ต้องการยืมอุปกรณ์นี้ใช่ไหม?',
            type: 'blue', theme: 'modern',
            buttons: {
                confirm: {
                    text: 'ยืมเลย', btnClass: 'btn-blue',
                    action: function() {
                        $.ajax({
                            url: 'api/borrow_action.php',
                            method: 'POST',
                            contentType: 'application/json',
                            data: JSON.stringify({ action: 'borrow', equipment_id: equipmentId, return_date: returnDate }),
                            success: function(res) {
                                if (res.status === 'success') {
                                    $.confirm({
                                        title: '✅ สำเร็จ!', content: 'ยืมอุปกรณ์สำเร็จ',
                                        type: 'green', theme: 'modern',
                                        buttons: { ok: { text: 'ตกลง', btnClass: 'btn-green',
                                            action: function() { location.reload(); }
                                        }}
                                    });
                                }
                            }
                        });
                    }
                },
                cancel: { text: 'ยกเลิก' }
            }
        });
    }

    function returnEquipment(borrowId, equipmentId) {
        $.confirm({
            title: '🔄 ยืนยันการคืน', content: 'ต้องการคืนอุปกรณ์นี้ใช่ไหม?',
            type: 'green', theme: 'modern',
            buttons: {
                confirm: {
                    text: 'คืนเลย', btnClass: 'btn-green',
                    action: function() {
                        $.ajax({
                            url: 'api/borrow_action.php',
                            method: 'POST',
                            contentType: 'application/json',
                            data: JSON.stringify({ action: 'return', borrow_id: borrowId, equipment_id: equipmentId }),
                            success: function(res) {
                                if (res.status === 'success') {
                                    $.confirm({
                                        title: '✅ คืนสำเร็จ!', content: 'คืนอุปกรณ์เรียบร้อยแล้ว',
                                        type: 'green', theme: 'modern',
                                        buttons: { ok: { text: 'ตกลง', btnClass: 'btn-green',
                                            action: function() { location.reload(); }
                                        }}
                                    });
                                }
                            }
                        });
                    }
                },
                cancel: { text: 'ยกเลิก' }
            }
        });
    }
    </script>
</body>
</html>