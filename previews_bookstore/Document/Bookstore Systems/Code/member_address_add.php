<?php
require_once('connection.php');

$addr_name = $_POST['addr_name'];
$addr_lastname = $_POST['addr_lastname'];
$addr_detail = $_POST['addr_detail'];
$addr_provin = $_POST['addr_provin'];
$addr_amphu = $_POST['addr_amphu'];
$addr_postal = $_POST['addr_postal'];
$addr_phone = $_POST['addr_phone'];
$mmb_id = $_POST['mmb_id'];
$addr_active = 0;

$edit_id = $_POST['mmb_id']; // รับค่า edit_id จากฟอร์ม

$location = 'Location: my-account-address.php';

// เพิ่มการตรวจสอบรูปแบบของรหัสไปรษณีย์
if (!preg_match('/^\d{5}$/', $addr_postal)) {
    $_SESSION['status'] = "กรุณากรอกรหัสไปรษณีย์ให้ถูกต้อง (5 หลัก)";
    $_SESSION['status_code'] = "ผิดพลาด";
    header($location);
    exit(); // ยกเลิกการทำงานต่อไป
}

// เพิ่มการตรวจสอบว่า mmb_id นี้ไม่มี addr_active เป็น 1 หรือไม่
$check_query = "SELECT * FROM bk_mmb_address WHERE mmb_id = '$mmb_id' AND addr_active = 1";
$check_result = mysqli_query($proj_connect, $check_query);

// เพิ่มการตรวจสอบรูปแบบของเลขโทรศัพท์
if (!preg_match('/^[0-9+\-\/()#*]+$/', $addr_phone)) {
    $_SESSION['status'] = "กรุณากรอกเลขโทรศัพท์ให้ถูกต้อง";
    $_SESSION['status_code'] = "ผิดพลาด";
    header($location);
    exit(); // ยกเลิกการทำงานต่อไป
}

if (mysqli_num_rows($check_result) == 0){
    $addr_active = 1;
}
$query = "INSERT INTO bk_mmb_address (addr_name, addr_lastname, addr_detail, addr_provin, addr_amphu, addr_postal, addr_phone, mmb_id, addr_active) VALUES ('$addr_name', '$addr_lastname', '$addr_detail', '$addr_provin', '$addr_amphu', '$addr_postal', '$addr_phone', '$mmb_id', '$addr_active')";
$query_run = mysqli_query($proj_connect, $query);

echo mysqli_error($proj_connect);

if ($query_run) {
    echo "Saved";
    $_SESSION['status'] = "เพิ่มที่อยู่สำเร็จ";
    $_SESSION['status_code'] = "สำเร็จ";
} else {
    $_SESSION['status'] = "ไม่สามารถเพิ่มที่อยู่ได้";
    $_SESSION['status_code'] = "ผิดพลาด";
}

header($location);
