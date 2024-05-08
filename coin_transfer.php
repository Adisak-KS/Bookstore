<?php
require_once('connection.php');

$location = 'Location: my-account-trancoin.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mmb_id = $_POST['mmb_id'];
    $recipient = $_POST['recipient'];
    $amount = $_POST['amount'];
    $mmb_password = $_POST['mmb_password']; // เพิ่มรหัสผ่านของผู้ใช้

    // เรียกข้อมูลรหัสผ่านที่เข้ารหัสไว้จากฐานข้อมูล
    $password_query = "SELECT mmb_password FROM bk_auth_member WHERE mmb_id = '$mmb_id'";
    $password_result = mysqli_query($proj_connect, $password_query);
    $password_row = mysqli_fetch_assoc($password_result);

    // ตรวจสอบว่ารหัสผ่านที่ป้อนเข้ามาตรงกับรหัสผ่านที่เข้ารหัสหรือไม่
    if (!password_verify($mmb_password, $password_row['mmb_password'])) {
        $_SESSION['status'] = "รหัสผ่านไม่ถูกต้อง";
        $_SESSION['status_code'] = "ผิดพลาด";
        header($location);
        exit();
    }

    // ตรวจสอบว่าจำนวนเหรียญที่โอนมีค่ามากกว่า 0
    if ($amount <= 0) {
        $_SESSION['status'] = "กรุณาใส่จำนวนเหรียญที่ถูกต้อง";
        $_SESSION['status_code'] = "ผิดพลาด";
        header($location);
        exit();
    }

    // ตรวจสอบว่ามีเหรียญพอที่จะทำการโอนหรือไม่
    $check_query = "SELECT mmb_coin FROM bk_auth_member WHERE mmb_id = '$mmb_id'";
    $check_result = mysqli_query($proj_connect, $check_query);
    $mmb_row = mysqli_fetch_assoc($check_result);

    if ($mmb_row['mmb_coin'] < $amount) {
        $_SESSION['status'] = "เหรียญไม่เพียงพอที่จะทำการโอน";
        $_SESSION['status_code'] = "ผิดพลาด";
        header($location);
        exit();
    }

    // ตรวจสอบว่าผู้รับนี้มีอยู่ในระบบหรือไม่
    $recipient_query = "SELECT * FROM bk_auth_member WHERE mmb_username = '$recipient'";
    $recipient_result = mysqli_query($proj_connect, $recipient_query);

    if (mysqli_num_rows($recipient_result) > 0) {
        // ถ้ามีให้ทำการโอนเหรียญ
        $recipient_row = mysqli_fetch_assoc($recipient_result);

        // ทำการลดเหรียญของผู้โอน
        $update_sender_query = "UPDATE bk_auth_member SET mmb_coin = mmb_coin - $amount WHERE mmb_id = '$mmb_id'";
        $update_sender_result = mysqli_query($proj_connect, $update_sender_query);

        // ทำการเพิ่มเหรียญของผู้รับ
        $update_recipient_query = "UPDATE bk_auth_member SET mmb_coin = mmb_coin + $amount WHERE mmb_username = '$recipient'";
        $update_recipient_result = mysqli_query($proj_connect, $update_recipient_query);

        if ($update_sender_result && $update_recipient_result) {
            // เตรียมข้อมูลสำหรับบันทึกลงในตาราง bk_mmb_coin_history
            $cnh_income = 0;
            $cnh_outcome = $amount;
            $cnh_coin = $mmb_row['mmb_coin'] - $amount; // จำนวนเหรียญทั้งหมดหลังจากทำการโอน
            $cnh_detail = "โอนเหรียญไปยังสมาชิก $recipient_row[mmb_username]";

            // ทำการบันทึกประวัติลงในตาราง bk_mmb_coin_history
            $history_query = "INSERT INTO bk_mmb_coin_history (mmb_id, cnh_income, cnh_outcome, cnh_coin, cnh_detail, cnh_date) 
                VALUES ('$mmb_id', '$cnh_income', '$cnh_outcome', '$cnh_coin', '$cnh_detail', CURRENT_TIMESTAMP)";
            $history_result = mysqli_query($proj_connect, $history_query);

            if ($history_result) {
                $_SESSION['status'] = "โอนเหรียญสำเร็จและบันทึกประวัติเรียบร้อย";
                $_SESSION['status_code'] = "สำเร็จ";
            } else {
                $_SESSION['status'] = "โอนเหรียญสำเร็จ แต่ไม่สามารถบันทึกประวัติได้";
                $_SESSION['status_code'] = "ผิดพลาด";
            }
        } else {
            $_SESSION['status'] = "ไม่สามารถทำการโอนเหรียญได้";
            $_SESSION['status_code'] = "ผิดพลาด";
        }
    } else {
        // ถ้าไม่มีให้แจ้งเตือน
        $_SESSION['status'] = "ผู้รับไม่มีอยู่ในระบบ";
        $_SESSION['status_code'] = "ผิดพลาด";
    }

    header($location);
    exit();
} else {
    $_SESSION['status'] = "ไม่มีข้อมูลที่ส่งมา";
    $_SESSION['status_code'] = "ผิดพลาด";
    header($location);
    exit();
}
