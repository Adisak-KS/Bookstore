<?php
if(isset($_POST['pwd']) && isset($_POST['hashedPassword'])) {
    // รับรหัสผ่านจากฟอร์ม
    $password = $_POST['pwd'];
    
    // รับรหัสผ่านที่ถูก hash จากฟอร์ม
    $hashedPasswordFromForm = $_POST['hashedPassword'];
    
    // ตรวจสอบรหัสผ่าน
    if(password_verify($password, $hashedPasswordFromForm)) {
        // รหัสผ่านถูกต้อง
        echo "รหัสผ่านถูกต้อง!";
    } else {
        // รหัสผ่านไม่ถูกต้อง
        echo "รหัสผ่านไม่ถูกต้อง!";
    }
    
        // เพิ่มลิงก์หรือปุ่มกลับไปยัง hash.php
        echo '<br><a href="hash.php">กลับ</a>';
}
?>
