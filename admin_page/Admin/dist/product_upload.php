<?php
require_once __DIR__ . '/../../../connection.php';

// ตรวจสอบว่ามีการอัปโหลดรูปภาพหรือไม่
if (isset($_FILES['image'])) {
    $prd_id = $_POST['prd_id'];

    $location = 'Location: ' . $_SERVER['HTTP_REFERER'];

    // ตรวจสอบว่าเกิดข้อผิดพลาดขณะอัปโหลดหรือไม่
    if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
        // ตรวจสอบประเภทของไฟล์
        // ตรวจสอบประเภทของไฟล์
        $allowed_image_types = array(
            IMAGETYPE_JPEG, // JPEG
            IMAGETYPE_PNG,  // PNG
            IMAGETYPE_GIF   // GIF
        );

        $image_info = getimagesize($_FILES['image']['tmp_name']);
        if (!$image_info || !in_array($image_info[2], $allowed_image_types)) {
            $_SESSION['status'] = "รูปภาพที่อัปโหลดต้องเป็นไฟล์ประเภท JPEG, PNG, หรือ GIF เท่านั้น";
            $_SESSION['status_code'] = "error";
            header($location);
            exit;
        }

        // กำหนดฟังก์ชันที่ใช้สำหรับอ่านไฟล์ภาพตามประเภท
        $create_image_function = null;
        switch ($image_info[2]) {
            case IMAGETYPE_JPEG:
                $create_image_function = 'imagecreatefromjpeg';
                break;
            case IMAGETYPE_PNG:
                $create_image_function = 'imagecreatefrompng';
                break;
            case IMAGETYPE_GIF:
                $create_image_function = 'imagecreatefromgif';
                break;
        }

        // อัปโหลดภาพและปรับขนาด
        $sourceImg = $create_image_function($_FILES['image']['tmp_name']);


        // กำหนดตัวแปรเก็บชื่อไฟล์ที่อัปโหลด
        $image_name = $_FILES['image']['name'];

        // ขนาดที่ต้องการให้รูปภาพปรับเป็น
        $targetWidth = 421;
        $targetHeight = 622;

        // ขนาดเดิมของรูปภาพ
        $sourceWidth = imagesx($sourceImg);
        $sourceHeight = imagesy($sourceImg);

        // คำนวณสัดส่วนการปรับขนาดของรูปภาพใหม่
        // $aspectRatio = $sourceWidth / $sourceHeight;
        // if ($targetWidth / $targetHeight > $aspectRatio) {
        //     $targetWidth = $targetHeight * $aspectRatio;
        // } else {
        //     $targetHeight = $targetWidth / $aspectRatio;
        // }

        // สร้างภาพใหม่ที่ปรับขนาดแล้ว
        $newImg = imagecreatetruecolor($targetWidth, $targetHeight);
        imagecopyresampled($newImg, $sourceImg, 0, 0, 0, 0, $targetWidth, $targetHeight, $sourceWidth, $sourceHeight);

        // บันทึกภาพใหม่
        $new_image_name = $prd_id . '.' . pathinfo($image_name, PATHINFO_EXTENSION);
        $new_target_file = "../../../prd_img/" . $new_image_name;
        imagejpeg($newImg, $new_target_file, 80); // 80 คือค่าคุณภาพของภาพ

        // ลบหน่วยความจำที่ใช้โดย GD
        imagedestroy($sourceImg);
        imagedestroy($newImg);

        // บันทึกชื่อไฟล์ใหม่ลงในฐานข้อมูล
        $sql_update_image = "UPDATE bk_prd_product SET prd_img = '$new_image_name' WHERE prd_id = '$prd_id'";
        $result_update_image = mysqli_query($proj_connect, $sql_update_image);

        if ($result_update_image) {
            // บันทึกสำเร็จ
            $_SESSION['status'] = "อัปโหลดรูปภาพเรียบร้อยแล้ว";
            $_SESSION['status_code'] = "success";
        } else {
            // บันทึกไม่สำเร็จ
            $_SESSION['status'] = "เกิดข้อผิดพลาดในการบันทึกชื่อไฟล์";
            $_SESSION['status_code'] = "error";
        }
    } else {
        // อัปโหลดไม่สำเร็จ
        $_SESSION['status'] = "เกิดข้อผิดพลาดในการอัปโหลดรูปภาพ";
        $_SESSION['status_code'] = "error";
    }
}

// ย้อนกลับไปที่หน้าแก้ไขสินค้า
header($location);
