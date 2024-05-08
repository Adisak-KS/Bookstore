<?php
require_once __DIR__ . '/../../../connection.php';

// ตรวจสอบว่ามีการอัปโหลดรูปภาพหรือไม่
if (isset($_POST["submit_img"])) {
    $pay_id = $_POST["pay_id"];
    $location = 'Location: ' . $_SERVER['HTTP_REFERER'];

    // ตรวจสอบไฟล์ที่อัปโหลด
    if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
        $allowed_types = array("image/jpeg", "image/png", "image/gif");
        $file_type = $_FILES["image"]["type"];

        if (in_array($file_type, $allowed_types)) {
            $file_extension = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
            $new_filename = $pay_id . "." . $file_extension;
            $target_path = "../../../pay_img/" . $new_filename;

            // อัปโหลดไฟล์
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_path)) {
                // อัปเดตในฐานข้อมูล
                $sql_update = "UPDATE bk_ord_payment SET pay_img = '$new_filename' WHERE pay_id = $pay_id";
                mysqli_query($proj_connect, $sql_update) or die(mysqli_error($proj_connect));

                echo "อัปโหลดรูปภาพสำเร็จ";
                $_SESSION['status'] = "อัปโหลดรูปภาพสำเร็จ";
                $_SESSION['status_code'] = "สำเร็จ";
            } else {
                echo "มีข้อผิดพลาดในการอัปโหลดรูปภาพ";
                $_SESSION['status'] = "อัปโหลดรูปภาพไม่สำเร็จ โปรดลองอีกครั้ง";
                $_SESSION['status_code'] = "ผิดพลาด";
            }
        } else {
            echo "ประเภทของไฟล์ไม่ถูกต้อง";
            $_SESSION['status'] = "ประเภทของไฟล์ไม่ถูกต้อง โปรดเลือกไฟล์รูปภาพ";
            $_SESSION['status_code'] = "ผิดพลาด";
        }
    } else {
        echo "กรุณาเลือกไฟล์ที่ต้องการอัปโหลด";
        $_SESSION['status'] = "กรุณาเลือกไฟล์ที่ต้องการอัปโหลด";
        $_SESSION['status_code'] = "ผิดพลาด";
    }
    header($location);
}
elseif(isset($_POST["submit_logo"])){
    $pay_id = $_POST["pay_id"];
    $location = 'Location: ' . $_SERVER['HTTP_REFERER'];

    // ตรวจสอบไฟล์ที่อัปโหลด
    if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
        $allowed_types = array("image/jpeg", "image/png", "image/gif");
        $file_type = $_FILES["image"]["type"];

        if (in_array($file_type, $allowed_types)) {
            $file_extension = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
            $new_filename = $pay_id . "." . $file_extension;
            $target_path = "../../../pay_logo/" . $new_filename;

            // อัปโหลดไฟล์
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_path)) {
                // อัปเดตในฐานข้อมูล
                $sql_update = "UPDATE bk_ord_payment SET pay_logo = '$new_filename' WHERE pay_id = $pay_id";
                mysqli_query($proj_connect, $sql_update) or die(mysqli_error($proj_connect));

                echo "อัปโหลดรูปภาพสำเร็จ";
                $_SESSION['status'] = "อัปโหลดรูปภาพสำเร็จ";
                $_SESSION['status_code'] = "สำเร็จ";
            } else {
                echo "มีข้อผิดพลาดในการอัปโหลดรูปภาพ";
                $_SESSION['status'] = "อัปโหลดรูปภาพไม่สำเร็จ โปรดลองอีกครั้ง";
                $_SESSION['status_code'] = "ผิดพลาด";
            }
        } else {
            echo "ประเภทของไฟล์ไม่ถูกต้อง";
            $_SESSION['status'] = "ประเภทของไฟล์ไม่ถูกต้อง โปรดเลือกไฟล์รูปภาพ";
            $_SESSION['status_code'] = "ผิดพลาด";
        }
    } else {
        echo "กรุณาเลือกไฟล์ที่ต้องการอัปโหลด";
        $_SESSION['status'] = "กรุณาเลือกไฟล์ที่ต้องการอัปโหลด";
        $_SESSION['status_code'] = "ผิดพลาด";
    }
    header($location);
}
