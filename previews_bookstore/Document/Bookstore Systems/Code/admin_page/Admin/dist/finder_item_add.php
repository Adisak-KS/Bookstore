<?php
require_once __DIR__ . '/../../../connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // ดึงข้อมูลจากฟอร์ม
    $fnd_id = $_POST['fnd_id'];
    $fnd_price = $_POST['fnd_price'];

    $fdit_name = $_POST['fdit_name'];
    $fdit_author = $_POST['fdit_author'];
    $fdit_volumn = $_POST['fdit_volumn'];
    $fdit_detail = $_POST['fdit_detail'];
    $fdit_publisher = $_POST['fdit_publisher'];
    $fdit_status = 'รอการยืนยัน';

    // ตรวจสอบว่าไฟล์รูปถูกอัปโหลดหรือไม่
    if (isset($_FILES['fdit_img']) && $_FILES['fdit_img']['error'] === 0) {
        // กำหนดตัวแปรเก็บข้อมูลของไฟล์รูป
        $file_tmp = $_FILES['fdit_img']['tmp_name'];

        // กำหนดตำแหน่งที่จะบันทึกไฟล์รูป
        $upload_path = '../../../fdit_img/';
        $file_name = generateUniqueFileName($_FILES['fdit_img']['name'], $upload_path);
        $target_path = $upload_path . $file_name;

        // บันทึกไฟล์รูป
        move_uploaded_file($file_tmp, $target_path);
    } else {
        // หากไม่มีการอัปโหลดไฟล์รูป
        $file_name = ''; // กำหนดให้ชื่อไฟล์เป็นค่าว่าง
    }

    // เตรียม SQL query
    $insert_query = "INSERT INTO bk_fnd_item (fnd_id, fdit_name, fdit_author, fdit_publisher, fdit_volumn, fdit_detail, fdit_img, fdit_status)
                    VALUES ('$fnd_id', '$fdit_name', '$fdit_author', '$fdit_publisher', '$fdit_volumn', '$fdit_detail', '$file_name', '$fdit_status')";

    // ทำการ execute SQL query
    if (mysqli_query($proj_connect, $insert_query)) {
        $fnd_status = 'รอสมาชิกตรวจสอบ';
        // อัปเดตค่าในตาราง bk_fnd_finder เป็น '$fnd_status'
        $update_fnd_status_query = "UPDATE bk_fnd_finder SET fnd_status = '$fnd_status', fnd_price = '$fnd_price' WHERE fnd_id = '$fnd_id'";
        //mysqli_query($proj_connect, $update_fnd_status_query);

        if (mysqli_query($proj_connect, $update_fnd_status_query)) {
            echo "เพิ่มข้อมูลสำเร็จ";
            $_SESSION['status'] = 'ดำเนินการสำเร็จ โปรดรอผลการค้นหาหนังสือตามสั่ง';
            $_SESSION['status_code'] = 'สำเร็จ';
            header('Location: finder_show.php');
        }
    } else {
        echo "Error: " . $insert_query . "<br>" . mysqli_error($proj_connect);
        $_SESSION['status'] = "Error: " . $insert_query . " " . mysqli_error($proj_connect);
        $_SESSION['status_code'] = 'Error';
        header('Location: finder_form.php?edit_id=' . $fnd_id);
    }

    // ปิดการเชื่อมต่อฐานข้อมูล
    mysqli_close($proj_connect);
}

function generateUniqueFileName($filename, $upload_path)
{
    $ext = pathinfo($filename, PATHINFO_EXTENSION);
    $basename = pathinfo($filename, PATHINFO_FILENAME);

    // Generate unique name
    $unique_name = $basename . '_' . time() . '.' . $ext;

    // Check if the file name already exists, if so, generate a new unique name
    while (file_exists($upload_path . $unique_name)) {
        $unique_name = $basename . '_' . time() . mt_rand(100, 999) . '.' . $ext;
    }

    return $unique_name;
}
