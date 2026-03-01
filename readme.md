# 🏆 ระบบยืม-คืนอุปกรณ์กีฬา (Sports Borrowing System)

ระบบจัดการการยืม-คืนอุปกรณ์กีฬาสำหรับบุคลากรและนักศึกษา
พัฒนาด้วย PHP PDO + AJAX + Tailwind CSS บน Docker

## 🚀 วิธีรันโปรเจกต์

### ความต้องการเบื้องต้น
- Docker Desktop (เปิดให้ไอคอนเป็นสีเขียว)
- VS Code

### ขั้นตอนการรัน
1. Clone โปรเจกต์
   git clone https://github.com/YOUR_USERNAME/hw7-67704759-sports-borrow.git

2. เข้าโฟลเดอร์
   cd hw7-67704759-sports-borrow

3. รัน Docker
   docker-compose up -d --build

4. เปิดเบราว์เซอร์
   - หน้าเว็บ: http://localhost:8080
   - phpMyAdmin: http://localhost:8081

### ข้อมูล Login ทดสอบ
- Username: admin
- Password: 1234

## 🛠 Tech Stack
- Backend: PHP 8.2 + PDO
- Database: MySQL 8.0
- Frontend: Tailwind CSS + jQuery + AJAX
- Server: Apache (Docker)