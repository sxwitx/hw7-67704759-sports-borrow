# 🏛 พิมพ์เขียวระบบ (System Architecture)

## โครงสร้างโฟลเดอร์
hw7-67704759-sports-borrow/
├── docker-compose.yml
├── Dockerfile
├── .gitignore
├── readme.md
├── architecture.md
├── task.md
├── CONTRIBUTING.md
└── src/
    ├── index.php          ← หน้า Login
    ├── dashboard.php      ← หน้าหลัก
    ├── equipments.php     ← จัดการอุปกรณ์ (CRUD)
    ├── borrow.php         ← ยืม-คืนอุปกรณ์
    ├── config/
    │   └── db.php         ← เชื่อมต่อฐานข้อมูล
    └── api/
        ├── login_action.php
        ├── equipment_action.php
        └── borrow_action.php

## โครงสร้างฐานข้อมูล

### ตาราง users
| คอลัมน์    | ชนิด         | หมายเหตุ       |
|-----------|--------------|----------------|
| id        | INT PK AUTO  | รหัสผู้ใช้     |
| username  | VARCHAR(50)  | ชื่อผู้ใช้     |
| password  | VARCHAR(255) | รหัสผ่าน       |
| role      | VARCHAR(20)  | admin / user   |
| created_at| TIMESTAMP    | วันที่สร้าง    |

### ตาราง equipments
| คอลัมน์    | ชนิด         | หมายเหตุ         |
|-----------|--------------|------------------|
| id        | INT PK AUTO  | รหัสอุปกรณ์      |
| name      | VARCHAR(100) | ชื่ออุปกรณ์      |
| category  | VARCHAR(50)  | ประเภท           |
| quantity  | INT          | จำนวนทั้งหมด     |
| available | INT          | จำนวนที่ว่าง     |
| status    | VARCHAR(20)  | active/inactive  |

### ตาราง borrow_records
| คอลัมน์      | ชนิด         | หมายเหตุ        |
|-------------|--------------|-----------------|
| id          | INT PK AUTO  | รหัสการยืม      |
| user_id     | INT FK       | ผู้ยืม          |
| equipment_id| INT FK       | อุปกรณ์ที่ยืม   |
| borrow_date | DATE         | วันที่ยืม        |
| return_date | DATE         | วันที่คืน        |
| status      | VARCHAR(20)  | borrowed/returned|

## โค้ด SQL สร้างตาราง

CREATE DATABASE IF NOT EXISTS sports_borrow_db;
USE sports_borrow_db;

CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(20) DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE equipments (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    category VARCHAR(50),
    quantity INT DEFAULT 1,
    available INT DEFAULT 1,
    status VARCHAR(20) DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE borrow_records (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    equipment_id INT NOT NULL,
    borrow_date DATE NOT NULL,
    return_date DATE,
    status VARCHAR(20) DEFAULT 'borrowed',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (equipment_id) REFERENCES equipments(id)
);

-- ข้อมูลทดสอบ
INSERT INTO users (username, password, role) VALUES ('admin', '1234', 'admin');
INSERT INTO equipments (name, category, quantity, available) VALUES
('ลูกฟุตบอล', 'ฟุตบอล', 5, 5),
('ไม้แบดมินตัน', 'แบดมินตัน', 10, 10),
('ลูกบาสเกตบอล', 'บาสเกตบอล', 3, 3);