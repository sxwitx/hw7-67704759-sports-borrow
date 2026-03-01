<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>Dashboard | ระบบยืม-คืนอุปกรณ์กีฬา</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style> body { font-family: 'Kanit', sans-serif; } </style>
</head>
<body class="bg-slate-900 min-h-screen text-white">
    <nav class="bg-slate-800 border-b border-slate-700 px-6 py-4 flex justify-between items-center">
        <h1 class="text-xl font-bold text-cyan-400">🏆 ระบบยืม-คืนอุปกรณ์กีฬา</h1>
        <div class="flex gap-4 items-center">
            <a href="equipments.php" class="bg-cyan-600 hover:bg-cyan-500 px-4 py-2 rounded-lg text-sm">จัดการอุปกรณ์</a>
            <a href="borrow.php" class="bg-violet-600 hover:bg-violet-500 px-4 py-2 rounded-lg text-sm">ยืม-คืนอุปกรณ์</a>
            <a href="api/logout.php" class="bg-red-600 hover:bg-red-500 px-4 py-2 rounded-lg text-sm">ออกจากระบบ</a>
        </div>
    </nav>
    <div class="max-w-4xl mx-auto mt-16 text-center">
        <h2 class="text-3xl font-bold mb-4">ยินดีต้อนรับ 👋</h2>
        <p class="text-slate-400 text-lg">คุณ <span class="text-cyan-400 font-semibold"><?= $_SESSION['username'] ?></span> เข้าสู่ระบบสำเร็จ</p>
        <div class="mt-10 grid grid-cols-2 gap-6">
            <a href="equipments.php" class="bg-slate-800 border border-slate-700 rounded-2xl p-8 hover:border-cyan-500 transition">
                <div class="text-4xl mb-4">🏅</div>
                <div class="text-xl font-semibold">จัดการอุปกรณ์กีฬา</div>
                <div class="text-slate-400 text-sm mt-2">เพิ่ม แก้ไข ลบ อุปกรณ์</div>
            </a>
            <a href="borrow.php" class="bg-slate-800 border border-slate-700 rounded-2xl p-8 hover:border-violet-500 transition">
                <div class="text-4xl mb-4">📋</div>
                <div class="text-xl font-semibold">ยืม-คืนอุปกรณ์</div>
                <div class="text-slate-400 text-sm mt-2">ดูรายการและทำรายการยืม</div>
            </a>
        </div>
    </div>
</body>
</html>