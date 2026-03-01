# 📋 กระดานวางแผนงาน (Task Checklist)

## Phase 1: Setup & Documentation
- [x] สร้างโครงสร้างโฟลเดอร์โปรเจกต์
- [x] สร้างไฟล์ Dockerfile
- [x] สร้างไฟล์ docker-compose.yml
- [x] สร้างไฟล์ .gitignore
- [x] สร้างเอกสาร readme.md
- [x] สร้างเอกสาร architecture.md
- [x] สร้างเอกสาร task.md
- [x] สร้างเอกสาร CONTRIBUTING.md

## Phase 2: Database & Connection
- [ ] รัน Docker สำเร็จ (docker-compose up -d --build)
- [ ] สร้างตาราง users ใน phpMyAdmin
- [ ] สร้างตาราง equipments ใน phpMyAdmin
- [ ] สร้างตาราง borrow_records ใน phpMyAdmin
- [ ] Insert ข้อมูลทดสอบ
- [ ] สร้างไฟล์ src/config/db.php

## Phase 3: Login System
- [ ] สร้างหน้า src/index.php (Login UI)
- [ ] สร้างไฟล์ src/api/login_action.php
- [ ] เชื่อมต่อ AJAX กับ Backend จริง
- [ ] ทดสอบ Login สำเร็จ/ล้มเหลว

## Phase 4: Dashboard
- [ ] สร้างหน้า src/dashboard.php
- [ ] เช็ค Session Guard
- [ ] แสดงเมนูนำทาง

## Phase 5: Equipment CRUD
- [ ] สร้างหน้า src/equipments.php
- [ ] สร้างไฟล์ src/api/equipment_action.php
- [ ] ฟังก์ชัน เพิ่มอุปกรณ์
- [ ] ฟังก์ชัน แก้ไขอุปกรณ์
- [ ] ฟังก์ชัน ลบอุปกรณ์
- [ ] ทุก Action ใช้ AJAX + jQuery Confirm

## Phase 6: Borrow System
- [ ] สร้างหน้า src/borrow.php
- [ ] สร้างไฟล์ src/api/borrow_action.php
- [ ] ฟังก์ชันยืมอุปกรณ์
- [ ] ฟังก์ชันคืนอุปกรณ์

## Phase 7: GitHub
- [ ] git init และ commit แรก
- [ ] Push ขึ้น GitHub
- [ ] ตรวจสอบ Repository เป็น Public