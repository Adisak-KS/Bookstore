<?php
require_once __DIR__ . '/../../../connection.php';


if (isset($_POST['editbtn'])) {
    $mmb_id = $_POST['mmb_id'];
    $mmb_username = $_POST['mmb_username'];
    $mmb_firstname = $_POST['mmb_firstname'];
    $mmb_lastname = $_POST['mmb_lastname'];
    $mmb_email = $_POST['mmb_email'];
    $mmb_coin = $_POST['mmb_coin'];

    $location = 'Location: member_edit_form.php';

    // ตรวจสอบว่าชื่อผู้ใช้ที่แก้ไขซ้ำกับชื่อผู้ใช้อื่นที่มีในฐานข้อมูลหรือไม่
    $checkDuplicateQuery = "SELECT mmb_id FROM bk_auth_member WHERE mmb_username = '$mmb_username' AND mmb_id != '$mmb_id'";
    $checkDuplicateResult = mysqli_query($proj_connect, $checkDuplicateQuery);
    $checkEmailQuery = "SELECT mmb_id FROM bk_auth_member WHERE mmb_email = '$mmb_email' AND mmb_id != '$mmb_id'";
    $checkEmailResult = mysqli_query($proj_connect, $checkEmailQuery);

    if ((mysqli_num_rows($checkDuplicateResult) > 0) || (mysqli_num_rows($checkEmailResult) > 0)) {
        // ถ้าชื่อผู้ใช้ซ้ำ กำหนดข้อความแจ้งเตือน
        $_SESSION['status'] = "ชื่อผู้ใช้หรืออีเมลซ้ำกับที่มีในระบบ โปรดลองชื่ออื่น";
        $_SESSION['status_code'] = "ผิดพลาด";

        // ส่งกลับไปยังหน้าแก้ไข
        header($location);
    } else {
        // ถ้าชื่อผู้ใช้ไม่ซ้ำ ทำการอัปเดตข้อมูลผู้ใช้
        $query = "SELECT mmb_coin FROM bk_auth_member WHERE mmb_id = '$mmb_id'";
        $result = mysqli_query($proj_connect, $query);
        $row = mysqli_fetch_assoc($result);
        $old_coin = $row['mmb_coin'];
        $coin_difference = $mmb_coin - $old_coin;

        $updateQuery = "UPDATE bk_auth_member 
                        SET mmb_username = '$mmb_username', 
                        mmb_firstname = '$mmb_firstname',
                        mmb_lastname = '$mmb_lastname',
                        mmb_email = '$mmb_email',
                        mmb_coin = '$mmb_coin'
                        WHERE mmb_id = '$mmb_id'";
        $updateResult = mysqli_query($proj_connect, $updateQuery);
        if ($updateResult) {
            // อัปเดตผู้ใช้สำเร็จ
            $_SESSION['status'] = "อัปเดตผู้ใช้สำเร็จ";
            $_SESSION['status_code'] = "สำเร็จ";

            // คำนวณจำนวนเหรียญที่เพิ่มหรือลด


            // ถ้ามีการเปลี่ยนแปลงเหรียญ
            if ($coin_difference != 0) {
                // บันทึกข้อมูลลงในตาราง bk_mmb_coin_history
                $insert_query = "INSERT INTO bk_mmb_coin_history (mmb_id, cnh_income, cnh_outcome, cnh_coin, cnh_date) 
                                 VALUES ('$mmb_id', '" . ($coin_difference > 0 ? $coin_difference : 0) . "', '" . ($coin_difference < 0 ? abs($coin_difference) : 0) . "', '$mmb_coin', NOW())";
                $insert_result = mysqli_query($proj_connect, $insert_query);

                if ($insert_result) {
                    // สำเร็จในการเพิ่มข้อมูลลงใน bk_mmb_coin_history
                    // ส่งกลับไปยังหน้าที่คุณต้องการ
                    header($location);
                } else {
                    // เกิดข้อผิดพลาดในการเพิ่มข้อมูลลงใน bk_mmb_coin_history
                    $_SESSION['status'] = "เกิดข้อผิดพลาดในการบันทึกประวัติเหรียญ";
                    $_SESSION['status_code'] = "ผิดพลาด";
                    header($location);
                }
            } else {
                // ไม่มีการเปลี่ยนแปลงเหรียญ
                // ส่งกลับไปยังหน้าที่คุณต้องการ
                echo $mmb_coin . ' - ' . $old_coin;
                header($location);
            }
        } else {
            // เกิดข้อผิดพลาดในการอัปเดตผู้ใช้
            $_SESSION['status'] = "เกิดข้อผิดพลาดในการอัปเดตผู้ใช้";
            $_SESSION['status_code'] = "ผิดพลาด";
            header($location);
        }


        // ส่งกลับไปยังหน้าที่คุณต้องการ
        //header('Location: member_edit_form.php?edit_id=' . $mmb_id);
    }
}
