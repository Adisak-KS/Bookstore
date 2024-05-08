<?php
require_once('connection.php');

// ตรวจสอบว่ามีการส่งข้อมูลมาจากฟอร์มหรือไม่
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // รับค่าจากฟอร์ม
    $fdnf_date = $_POST['fdnf_date'];
    $pay_id = $_POST['pay_id'];
    $fdnf_amount = $_POST['fdnf_amount'];
    $fnd_id = $_POST['fnd_id'];
    $mmb_id = $_POST['mmb_id'];

    $location = 'Location: finder_notify.php?fnd_id=' . $fnd_id;

    // Echo each variable
    echo "fdnf_date: " . $fdnf_date . "<br>";
    echo "pay_id: " . $pay_id . "<br>";
    echo "fdnf_amount: " . $fdnf_amount . "<br>";
    echo "fnd_id: " . $fnd_id . "<br>";
    echo "mmb_id: " . $mmb_id . "<br>";

    // ตรวจสอบว่าได้เลือกไฟล์ภาพหรือไม่
    if (isset($_FILES['fnimg_image'])) {
        // สร้างตำแหน่งที่จะบันทึกไฟล์
        $upload_directory = "fnimg_image/";

        // ตรวจสอบนามสกุลของไฟล์
        $allowed_extensions = array("jpg", "jpeg", "png", "gif");

        isset($_FILES['fnimg_image']['tmp_name']) ? $file_tmp_name = $_FILES['fnimg_image']['tmp_name'] : $file_tmp_name = array();
        isset($_FILES['fnimg_image']['name']) ? $file_name = $_FILES['fnimg_image']['name'] : $file_name = array();

        $insert_sql = "INSERT INTO bk_fnd_notification (fdnf_date, pay_id, fdnf_amount, fnd_id, mmb_id) 
                               VALUES ('$fdnf_date', '$pay_id', '$fdnf_amount', '$fnd_id', '$mmb_id')";
        // ทำการ execute SQL query
        if (mysqli_query($proj_connect, $insert_sql)) {
            // อ่านค่า fdnf_id ที่เพิ่มลงในตาราง bk_ord_notification
            $fdnf_id = mysqli_insert_id($proj_connect);

            // วนลูปทุกไฟล์ที่ถูกอัปโหลด
            for ($i = 0; $i < count($file_tmp_name); $i++) {
                $upload_extension = pathinfo($file_name[$i], PATHINFO_EXTENSION);

                // ตรวจสอบนามสกุลของไฟล์
                if (in_array($upload_extension, $allowed_extensions)) {
                    // สร้างรหัสที่ไม่ซ้ำกันเป็นส่วนหนึ่งของชื่อไฟล์
                    $fnimg_image = uniqid();

                    // ตั้งชื่อไฟล์เป็น nimg_id ตามด้วยนามสกุลไฟล์
                    $upload_filename = $fnimg_image . "." . $upload_extension;
                    $upload_path = $upload_directory . $upload_filename;

                    // บันทึกไฟล์
                    if (move_uploaded_file($file_tmp_name[$i], $upload_path)) {
                        // เพิ่มข้อมูลลงในตาราง bk_ord_notification




                        // เพิ่มข้อมูลลงในตาราง bk_ord_fdnf_image
                        $insert_img_sql = "INSERT INTO bk_fnd_ntf_image (fdnf_id, fnimg_image) VALUES ('$fdnf_id', '$upload_filename')";
                        mysqli_query($proj_connect, $insert_img_sql);

                        // อัปเดต ord_status ในตาราง bk_ord_orders
                        $update_sql = "UPDATE bk_fnd_finder SET fnd_status = 'รอการตรวจสอบการชำระเงิน' WHERE fnd_id = '$fnd_id'";
                        mysqli_query($proj_connect, $update_sql);

                        echo "ชำระเงินเสร็จสิ้น";
                    } else {
                        echo "เกิดข้อผิดพลาดในการอัปโหลดไฟล์";
                        $_SESSION['status'] = "เกิดข้อผิดพลาดในการอัปโหลดไฟล์";
                        $_SESSION['status_code'] = "success";
                        header($location);
                    }
                } else {
                    echo "รูปภาพต้องเป็นไฟล์รูปภาพเท่านั้น";
                    $_SESSION['status'] = "รูปภาพต้องเป็นไฟล์รูปภาพเท่านั้น";
                    $_SESSION['status_code'] = "success";
                    header($location);
                }
            }
        } else {
            echo "เกิดข้อผิดพลาดในการบันทึกข้อมูล: " . mysqli_error($proj_connect);
            $_SESSION['status'] = "เกิดข้อผิดพลาดในการบันทึกข้อมูล";
            $_SESSION['status_code'] = "success";
            header($location);
        }
    } else {
        echo "กรุณาเลือกไฟล์ภาพ";
        $_SESSION['status'] = "กรุณาเลือกไฟล์ภาพ";
        $_SESSION['status_code'] = "success";
        header($location);
    }
} else {
    echo "ไม่มีการส่งข้อมูลมาจากฟอร์ม";
    $_SESSION['status'] = "ไม่มีการส่งข้อมูลมาจากฟอร์ม";
    $_SESSION['status_code'] = "success";
    header($location);
}

$_SESSION['status'] = "ชำระเงินเสร็จสิ้น";
$_SESSION['status_code'] = "success";
header('Location: my-account-finder-order.php');
mysqli_close($proj_connect);
