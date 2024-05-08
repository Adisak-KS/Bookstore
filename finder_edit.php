<?php
require_once('connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // เชื่อมต่อกับฐานข้อมูล

    // ดึงข้อมูลจากฟอร์ม
    $fnd_id = $_POST['fnd_id'];
    $fnd_name = $_POST['fnd_name'];
    $fnd_author = $_POST['fnd_author'];
    $fnd_publisher = $_POST['fnd_publisher'];
    $fnd_volumn = $_POST['fnd_volumn'];

    $mmb_id = $_POST['mmb_id'];

    $location = 'Location: finder_detail.php';

    // ตรวจสอบว่าไฟล์รูปถูกอัปโหลดหรือไม่
    if (isset($_FILES['fnd_img']) && $_FILES['fnd_img']['error'] === 0) {
        // กำหนดตัวแปรเก็บข้อมูลของไฟล์รูป
        $file_name = $_FILES['fnd_img']['name'];
        $file_tmp = $_FILES['fnd_img']['tmp_name'];

        // ตรวจสอบประเภทของไฟล์รูปภาพ
        $allowed_types = array(IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_GIF);
        $detected_type = exif_imagetype($file_tmp);
        if (!in_array($detected_type, $allowed_types)) {
            echo "ประเภทของไฟล์รูปภาพไม่ถูกต้อง";
            $_SESSION['status'] = "ประเภทของไฟล์รูปภาพไม่ถูกต้อง โปรดอัปโหลดเฉพาะรูปภาพ";
            $_SESSION['status_code'] = 'ERROR';
            header('Location: finder_detail.php');
            exit(); // หยุดการทำงานเมื่อประเภทของไฟล์ไม่ถูกต้อง
        }

        // กำหนดตำแหน่งที่จะบันทึกไฟล์รูป
        $upload_path = 'fnd_img/'; // แทนที่ your_upload_directory ด้วยไดเร็กทอรีที่คุณต้องการบันทึกไฟล์

        // ตรวจสอบว่ามีไฟล์ซ้ำหรือไม่
        $file_extension = pathinfo($file_name, PATHINFO_EXTENSION);
        $file_name_without_extension = pathinfo($file_name, PATHINFO_FILENAME);
        $counter = 1;
        while (file_exists($upload_path . $file_name)) {
            $file_name = $file_name_without_extension . '_' . $counter . '.' . $file_extension;
            $counter++;
        }

        $target_path = $upload_path . $file_name;

        // บันทึกไฟล์รูป
        move_uploaded_file($file_tmp, $target_path);
    } else {
        if (isset($_POST['fnd_oldimg'])) {
            $file_name = $_POST['fnd_oldimg'];
        } else {
            // หากไม่มีการอัปโหลดไฟล์รูป
            $file_name = '';
        }
        // กำหนดให้ชื่อไฟล์เป็นค่าว่าง
    }

    $update_fnd_finder_query = "UPDATE bk_fnd_finder SET fnd_name = '$fnd_name', fnd_author = '$fnd_author', fnd_publisher = '$fnd_publisher', fnd_volumn = '$fnd_volumn', fnd_img = '$file_name' WHERE fnd_id = $fnd_id";

    // ทำการ execute SQL query
    if (mysqli_query($proj_connect, $update_fnd_finder_query)) {
        echo "อัปเดตข้อมูลสำเร็จ";
        $_SESSION['status'] = 'บันทึกข้อมูลสำเร็จ';
        $_SESSION['status_code'] = 'สำเร็จ';
        header($location);
    } else {
        echo "Error: " . $update_fnd_finder_query . "<br>" . mysqli_error($proj_connect);
        $_SESSION['status'] = $update_fnd_finder_query . "<br>" . mysqli_error($proj_connect);
        $_SESSION['status_code'] = 'Error';
    }

    // ปิดการเชื่อมต่อฐานข้อมูล
    mysqli_close($proj_connect);
}
