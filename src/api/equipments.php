<?php
session_start();
if (!isset($_SESSION['user_id'])) { header('Location: index.php'); exit; }
require_once 'config/db.php';
$stmt = $conn->query("SELECT * FROM equipments ORDER BY id DESC");
$equipments = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>จัดการอุปกรณ์ | ระบบยืม-คืนอุปกรณ์กีฬา</title>
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
            <a href="api/logout.php" class="bg-red-600 hover:bg-red-500 px-4 py-2 rounded-lg text-sm">ออกจากระบบ</a>
        </div>
    </nav>
    <div class="max-w-5xl mx-auto mt-8 px-4">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold">🏅 จัดการอุปกรณ์กีฬา</h2>
            <button onclick="openAddModal()" class="bg-cyan-600 hover:bg-cyan-500 px-4 py-2 rounded-lg">+ เพิ่มอุปกรณ์</button>
        </div>
        <div class="bg-slate-800 rounded-2xl border border-slate-700 overflow-hidden">
            <table class="w-full">
                <thead class="bg-slate-700">
                    <tr>
                        <th class="px-4 py-3 text-left">#</th>
                        <th class="px-4 py-3 text-left">ชื่ออุปกรณ์</th>
                        <th class="px-4 py-3 text-left">ประเภท</th>
                        <th class="px-4 py-3 text-center">จำนวนทั้งหมด</th>
                        <th class="px-4 py-3 text-center">ว่าง</th>
                        <th class="px-4 py-3 text-center">จัดการ</th>
                    </tr>
                </thead>
                <tbody id="equipmentTable">
                    <?php foreach ($equipments as $eq): ?>
                    <tr class="border-t border-slate-700 hover:bg-slate-700/50" id="row-<?= $eq['id'] ?>">
                        <td class="px-4 py-3"><?= $eq['id'] ?></td>
                        <td class="px-4 py-3 font-medium"><?= htmlspecialchars($eq['name']) ?></td>
                        <td class="px-4 py-3 text-slate-400"><?= htmlspecialchars($eq['category']) ?></td>
                        <td class="px-4 py-3 text-center"><?= $eq['quantity'] ?></td>
                        <td class="px-4 py-3 text-center">
                            <span class="<?= $eq['available'] > 0 ? 'text-green-400' : 'text-red-400' ?>">
                                <?= $eq['available'] ?>
                            </span>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <button onclick="openEditModal(<?= $eq['id'] ?>, '<?= htmlspecialchars($eq['name']) ?>', '<?= htmlspecialchars($eq['category']) ?>', <?= $eq['quantity'] ?>)"
                                class="bg-yellow-500 hover:bg-yellow-400 text-black px-3 py-1 rounded text-sm mr-2">แก้ไข</button>
                            <button onclick="deleteEquipment(<?= $eq['id'] ?>)"
                                class="bg-red-600 hover:bg-red-500 px-3 py-1 rounded text-sm">ลบ</button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal เพิ่ม/แก้ไข -->
    <div id="modal" class="hidden fixed inset-0 bg-black/60 flex items-center justify-center z-50">
        <div class="bg-slate-800 rounded-2xl p-8 w-full max-w-md border border-slate-700">
            <h3 id="modalTitle" class="text-xl font-bold mb-6">เพิ่มอุปกรณ์</h3>
            <input type="hidden" id="editId">
            <div class="space-y-4">
                <input type="text" id="inputName" placeholder="ชื่ออุปกรณ์" class="w-full px-4 py-3 bg-slate-900 border border-slate-700 rounded-lg text-white outline-none focus:border-cyan-500">
                <input type="text" id="inputCategory" placeholder="ประเภท" class="w-full px-4 py-3 bg-slate-900 border border-slate-700 rounded-lg text-white outline-none focus:border-cyan-500">
                <input type="number" id="inputQuantity" placeholder="จำนวน" min="1" class="w-full px-4 py-3 bg-slate-900 border border-slate-700 rounded-lg text-white outline-none focus:border-cyan-500">
            </div>
            <div class="flex gap-4 mt-6">
                <button onclick="saveEquipment()" class="flex-1 bg-cyan-600 hover:bg-cyan-500 py-3 rounded-lg font-semibold">บันทึก</button>
                <button onclick="closeModal()" class="flex-1 bg-slate-600 hover:bg-slate-500 py-3 rounded-lg">ยกเลิก</button>
            </div>
        </div>
    </div>

    <script>
    function openAddModal() {
        $('#modalTitle').text('เพิ่มอุปกรณ์');
        $('#editId').val('');
        $('#inputName, #inputCategory, #inputQuantity').val('');
        $('#modal').removeClass('hidden');
    }

    function openEditModal(id, name, category, quantity) {
        $('#modalTitle').text('แก้ไขอุปกรณ์');
        $('#editId').val(id);
        $('#inputName').val(name);
        $('#inputCategory').val(category);
        $('#inputQuantity').val(quantity);
        $('#modal').removeClass('hidden');
    }

    function closeModal() { $('#modal').addClass('hidden'); }

    function saveEquipment() {
        let id = $('#editId').val();
        let data = {
            id: id,
            name: $('#inputName').val(),
            category: $('#inputCategory').val(),
            quantity: $('#inputQuantity').val(),
            action: id ? 'edit' : 'add'
        };
        $.ajax({
            url: 'api/equipment_action.php',
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(data),
            success: function(res) {
                if (res.status === 'success') {
                    closeModal();
                    $.confirm({
                        title: '✅ สำเร็จ!', content: res.message,
                        type: 'green', theme: 'modern',
                        buttons: { ok: { text: 'ตกลง', btnClass: 'btn-green',
                            action: function() { location.reload(); }
                        }}
                    });
                }
            }
        });
    }

    function deleteEquipment(id) {
        $.confirm({
            title: '🗑 ยืนยันการลบ', content: 'ต้องการลบอุปกรณ์นี้ใช่ไหม?',
            type: 'red', theme: 'modern',
            buttons: {
                confirm: { text: 'ลบเลย', btnClass: 'btn-red',
                    action: function() {
                        $.ajax({
                            url: 'api/equipment_action.php',
                            method: 'POST',
                            contentType: 'application/json',
                            data: JSON.stringify({ action: 'delete', id: id }),
                            success: function(res) {
                                if (res.status === 'success') {
                                    $('#row-' + id).fadeOut(300, function() { $(this).remove(); });
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