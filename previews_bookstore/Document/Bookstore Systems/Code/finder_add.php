<?php
require_once('connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // เชื่อมต่อกับฐานข้อมูล

    // ดึงข้อมูลจากฟอร์ม
    $fnd_name = $_POST['fnd_name'];
    $fnd_author = $_POST['fnd_author'];
    $fnd_publisher = $_POST['fnd_publisher'];
    $fnd_volumn = $_POST['fnd_volumn'];
    $mmb_id = $_POST['mmb_id'];

    $location = 'Location: my-account-finder-order.php';

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
            header('Location: finder.php');
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
        // หากไม่มีการอัปโหลดไฟล์รูป
        $file_name = ''; // กำหนดให้ชื่อไฟล์เป็นค่าว่าง
    }

    // เตรียม SQL query
    $insert_query = "INSERT INTO bk_fnd_finder (fnd_name, fnd_date, fnd_author, fnd_publisher, fnd_volumn, fnd_img, mmb_id, pay_id, shp_id)
                VALUES ('$fnd_name', CURRENT_TIMESTAMP(), '$fnd_author', '$fnd_publisher', '$fnd_volumn', '$file_name', '$mmb_id',
                        (SELECT pay_id FROM bk_ord_payment WHERE pay_show = 1 LIMIT 1),
                        (SELECT shp_id FROM bk_ord_shipping WHERE shp_show = 1 LIMIT 1))";


    // ทำการ execute SQL query
    if (mysqli_query($proj_connect, $insert_query)) {
        echo "เพิ่มข้อมูลสำเร็จ";
        $_SESSION['status'] = "ดำเนินการสำเร็จ โปรดรอผลการค้นหาหนังสือตามสั่ง";
        $_SESSION['status_code'] = 'สำเร็จ';
        header($location);
    } else {
        echo "Error: " . $insert_query . "<br>" . mysqli_error($proj_connect);
        $_SESSION['status'] = "Error: " . $insert_query . "<br>" . mysqli_error($proj_connect);
        $_SESSION['status_code'] = 'Error';
        header('Location: finder.php');
    }

    // ปิดการเชื่อมต่อฐานข้อมูล
    mysqli_close($proj_connect);
}
?>
