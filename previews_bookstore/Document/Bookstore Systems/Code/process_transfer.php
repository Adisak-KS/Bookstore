<?php
require_once('connection.php');
session_start();

// รับข้อมูลจากฟอร์ม
$sender_id = $_POST['mmb_id'];
$recipient = $_POST['recipient'];
$amount = $_POST['amount'];

// ตรวจสอบว่ามีเหรียญพอสำหรับโอนหรือไม่
$sql_check_balance = "SELECT mmb_coin FROM bk_auth_member WHERE mmb_id = '$sender_id'";
$result_check_balance = $proj_connect->query($sql_check_balance);
$row = $result_check_balance->fetch_assoc();

if ($row['mmb_coin'] >= $amount) {
    // ตรวจสอบว่า mmb_username ของผู้รับมีในฐานข้อมูลหรือไม่
    $sql_check_recipient = "SELECT mmb_id FROM bk_auth_member WHERE mmb_username = '$recipient'";
    $result_check_recipient = $proj_connect->query($sql_check_recipient);

    if ($result_check_recipient->num_rows === 0) {
        echo "ไม่พบ mmb_username ของผู้รับในระบบ";
        $_SESSION['status'] = "ไม่พบ mmb_username ของผู้รับในระบบ";
        $_SESSION['status_code'] = "แจ้งเตือน";
        header('Location: my-account.php');
        exit(); // ยกเลิกการทำงานต่อทันที
    }

    // ทำการโอนเหรียญ
    $sql_transfer = "UPDATE bk_auth_member SET mmb_coin = mmb_coin - $amount WHERE mmb_id = '$sender_id'";
    $sql_receive = "UPDATE bk_auth_member SET mmb_coin = mmb_coin + $amount WHERE mmb_username = '$recipient'";

    if ($proj_connect->query($sql_transfer) === TRUE && $proj_connect->query($sql_receive) === TRUE) {
        echo "โอนเหรียญสำเร็จ";
        $_SESSION['status'] = "โอนเหรียญสำเร็จ";
        $_SESSION['status_code'] = "สำเร็จ";
        header('Location: my-account.php');
    } else {
        echo "การโอนเหรียญล้มเหลว: " . $proj_connect->error;
        $_SESSION['status'] = "การโอนเหรียญล้มเหลว" . $proj_connect->error;
        $_SESSION['status_code'] = "แจ้งเตือน";
        header('Location: my-account.php');
    }
} else {
    echo "เหรียญไม่เพียงพอสำหรับการโอน";
    $_SESSION['status'] = "เหรียญไม่เพียงพอสำหรับการโอน" . "ผู้ส่ง : " . $sender_id . "   เหรียญ : " . $amount;
    $_SESSION['status_code'] = "สำเร็จ";
    header('Location: my-account.php');
}
?>
