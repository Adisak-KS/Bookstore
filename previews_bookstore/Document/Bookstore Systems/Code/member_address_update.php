<?php
require_once('connection.php');
$location = 'Location: my-account-address.php';
if (isset($_POST['updateaddrbtn'])) {

    $addr_name = $_POST['addr_name'];
    $addr_lastname = $_POST['addr_lastname'];
    $addr_detail = $_POST['addr_detail'];
    $addr_provin = $_POST['addr_provin'];
    $addr_amphu = $_POST['addr_amphu'];
    $addr_postal = $_POST['addr_postal'];
    $addr_phone = $_POST['addr_phone'];
    $addr_active = $_POST['addr_active'];
    $mmb_id = $_POST['mmb_id'];
    $addr_id = $_POST['addr_id'];

    $edit_id = $_POST['mmb_id']; // รับค่า edit_id จากฟอร์ม
    $new_addr_active = 1;

    $phone_pattern = '/^[0-9\+\-\#]{9,12}$/';
    if (!preg_match($phone_pattern, $addr_phone)) {
        $_SESSION['status'] = "กรุณากรอกเบอร์ติดต่อให้ถูกต้อง";
        $_SESSION['status_code'] = "ผิดพลาด";
        header($location);
        exit(); // ยกเลิกการทำงานต่อไป
    }
    // เพิ่มการตรวจสอบรูปแบบของรหัสไปรษณีย์
    if (!preg_match('/^\d{5}$/', $addr_postal)) {
        $_SESSION['status'] = "กรุณากรอกรหัสไปรษณีย์ให้ถูกต้อง (5 หลัก)";
        $_SESSION['status_code'] = "ผิดพลาด";
        header($location);
        exit(); // ยกเลิกการทำงานต่อไป
    }

    $query = "UPDATE bk_mmb_address 
              SET addr_name = '$addr_name',
              addr_lastname = '$addr_lastname',
              addr_detail = '$addr_detail',
                  addr_provin = '$addr_provin',
                  addr_amphu = '$addr_amphu',
                  addr_postal = '$addr_postal',
                  addr_phone = '$addr_phone',
                  addr_active = '$addr_active'
              WHERE addr_id = '$addr_id'";
    $query_run = mysqli_query($proj_connect, $query);

    // ปรับ query ให้เปลี่ยน addr_active เป็น 0 สำหรับที่อยู่ที่มี mmb_id เดียวกัน
    $update_other_addresses_query = "UPDATE bk_mmb_address 
                                SET addr_active = 0
                                WHERE mmb_id = '$mmb_id' 
                                  AND addr_id != '$addr_id'";

    $query_run_update_other_addresses = mysqli_query($proj_connect, $update_other_addresses_query);


    echo mysqli_error($proj_connect);

    if ($query_run) {
        echo "Saved";
        $_SESSION['status'] = "แก้ไขที่อยู่สำเร็จ";
        $_SESSION['status_code'] = "ผิดพลาด";
    } else {
        $_SESSION['status'] = "ไม่สามารถแก้ไขที่อยู่" . mysqli_error($proj_connect);
        $_SESSION['status_code'] = "ผิดพลาด";
    }
}
if (isset($_POST['deleteaddrbtn'])) {
    $addr_detail = $_POST['addr_detail'];
    $addr_provin = $_POST['addr_provin'];
    $addr_amphu = $_POST['addr_amphu'];
    $addr_postal = $_POST['addr_postal'];
    $addr_phone = $_POST['addr_phone'];
    $addr_active = $_POST['addr_active'];
    $mmb_id = $_POST['mmb_id'];
    $addr_id = $_POST['addr_id'];

    // ลบที่อยู่ตาม addr_id
    $delete_query = "DELETE FROM bk_mmb_address WHERE addr_id = '$addr_id'";
    $delete_query_run = mysqli_query($proj_connect, $delete_query);

    if ($delete_query_run) {
        $check_active_query = "SELECT * FROM bk_mmb_address WHERE addr_id = '$addr_id' AND addr_active = 0";
        $check_active_result = mysqli_query($proj_connect, $check_active_query);

        if (mysqli_num_rows($check_active_result) > 0) {
            // มี addr_active เป็น 1 ใน addr_id ที่ต้องการลบ
            // ตรวจสอบว่า mmb_id นี้มี addr_id อื่นที่ไม่ใช่ addr_id ที่ต้องการลบหรือไม่
            $mmb_id = $mmb_row_result['mmb_id'];
            $check_other_address_query = "SELECT addr_id FROM bk_mmb_address WHERE mmb_id = '$mmb_id' AND addr_id != '$addr_id'";
            $check_other_address_result = mysqli_query($proj_connect, $check_other_address_query);

            if (mysqli_num_rows($check_other_address_result) > 0) {
                // มี addr_id อื่นที่ไม่ใช่ addr_id ที่ต้องการลบ
                // เลือก addr_id อื่นที่ไม่ใช่ addr_id ที่ต้องการลบและตั้ง addr_active เป็น 1
                $new_active_address = mysqli_fetch_assoc($check_other_address_result);
                $new_active_addr_id = $new_active_address['addr_id'];

                // ตั้ง addr_active เป็น 1 สำหรับ addr_id ที่ถูกเลือก
                $update_active_query = "UPDATE bk_mmb_address SET addr_active = 1 WHERE addr_id = '$new_active_addr_id'";
                $update_active_result = mysqli_query($proj_connect, $update_active_query);

                if (!$update_active_result) {
                    // ไม่สามารถตั้ง addr_active เป็น 1 ได้
                    echo "ไม่สามารถตั้ง addr_active เป็น 1 สำหรับ addr_id ใหม่ได้: " . mysqli_error($proj_connect);
                    exit;
                }
            }
        }

        $_SESSION['status'] = "ลบที่อยู่สำเร็จ";
        $_SESSION['status_code'] = "สำเร็จ";
        header($location);
    } else {
        $_SESSION['status'] = "ไม่สามารถลบที่อยู่ได้" . mysqli_error($proj_connect);
        $_SESSION['status_code'] = "ผิดพลาด";
        header($location);
    }
}

header($location);
