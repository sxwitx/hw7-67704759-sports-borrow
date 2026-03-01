# 🤝 กฎกติกาการเขียนโค้ด (Contributing Guidelines)

## การตั้งชื่อตัวแปร (Naming Conventions)

### PHP
- ตัวแปรทั่วไป: camelCase → $userName, $equipmentId
- ฟังก์ชัน: camelCase → getUserById(), deleteEquipment()
- คลาส: PascalCase → UserModel, EquipmentController
- ค่าคงที่: UPPER_SNAKE_CASE → DB_HOST, MAX_BORROW

### Database
- ชื่อตาราง: snake_case พหูพจน์ → users, equipments, borrow_records
- ชื่อคอลัมน์: snake_case → user_id, created_at, borrow_date
- Primary Key: ตั้งชื่อว่า id เสมอ
- Foreign Key: ชื่อตาราง_id → user_id, equipment_id

### JavaScript / jQuery
- ตัวแปร: camelCase → userName, equipmentList
- ฟังก์ชัน: camelCase → handleSubmit(), loadEquipments()

## รูปแบบการ Commit Git

### โครงสร้าง Commit Message
[emoji] [ประเภท]: [คำอธิบายสั้นๆ ภาษาไทยหรืออังกฤษ]

### ประเภทและ Emoji
- 🚀 feat: เพิ่มฟีเจอร์ใหม่
- 🐛 fix: แก้ไขบัก
- 📝 docs: อัปเดตเอกสาร
- 🎨 style: แก้ไข UI/CSS
- ♻️ refactor: ปรับโครงสร้างโค้ด
- ✅ test: เพิ่ม/แก้ไขการทดสอบ

### ตัวอย่าง
🚀 feat: เพิ่มหน้า Login ด้วย Tailwind CSS
🐛 fix: แก้ไขบัก SQL ในหน้า equipments
📝 docs: อัปเดต task.md เช็คถูก Phase 2

## มาตรฐานโค้ด PHP
- ใช้ PDO Prepared Statements ทุกครั้งที่ Query ข้อมูล
- ห้ามใช้ $_GET/$_POST โดยตรงโดยไม่ Sanitize
- ทุกไฟล์ API ต้องเช็ค Session ก่อนเสมอ
- ส่งผลลัพธ์กลับเป็น JSON เสมอสำหรับ AJAX