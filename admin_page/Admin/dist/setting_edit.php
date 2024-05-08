<?php
require_once __DIR__ . '/../../../connection.php';

if (isset($_POST['editbtn'])) {

    $previous_page_url = $_SERVER['HTTP_REFERER'];
    $location = 'Location: ' . $previous_page_url;
    // ตรวจสอบว่ามีค่าใน $_POST['set_id'] หรือไม่
    if (isset($_POST['set_detail'])) {
        // ดึงค่า set_id และ set_detail จาก $_POST
        $set_detail = $_POST['set_detail'];
        $set_id = $_POST['set_id'];

        // อัปเดตค่า set_detail ในฐานข้อมูล
        $updateQuery = "UPDATE bk_setting SET set_detail = '$set_detail' WHERE set_id = '$set_id'";
        $updateResult = mysqli_query($proj_connect, $updateQuery);

        if ($updateResult) {
            if($set_id == 1){
                $_SESSION['titleweb'] =$set_detail;
            }
            elseif($set_id == 3){
                $_SESSION['maintitle'] =$set_detail;
            }
            elseif($set_id == 5){
                $_SESSION['banner_1_text'] =$set_detail;
            }
            elseif($set_id == 9){
                $_SESSION['url_banner_1'] =$set_detail;
            }
            elseif($set_id == 10){
                $_SESSION['url_banner_2'] =$set_detail;
            }
            elseif($set_id == 11){
                $_SESSION['url_banner_3'] =$set_detail;
            }
            elseif($set_id == 12){
                $_SESSION['url_banner_4'] =$set_detail;
            }
            elseif($set_id == 14){
                $_SESSION['banner_5_text'] =$set_detail;
            }
            elseif($set_id == 15){
                $_SESSION['url_banner_5'] =$set_detail;
            }
            elseif($set_id == 16){
                $_SESSION['cancel_time'] =$set_detail;
            }
            elseif($set_id == 17){
                $_SESSION['contact_map'] =$set_detail;
            }
            elseif($set_id == 18){
                $_SESSION['contact_address'] =$set_detail;
            }
            elseif($set_id == 19){
                $_SESSION['contact_mail'] =$set_detail;
            }
            elseif($set_id == 20){
                $_SESSION['contact_phone'] =$set_detail;
            }
            elseif($set_id == 22){
                $_SESSION['remain_quantity'] =$set_detail;
            }
            
            $_SESSION['status'] = "อัปเดตข้อมูลสำเร็จ";
            $_SESSION['status_code'] = "สำเร็จ";
        } else {
            $_SESSION['status'] = "เกิดข้อผิดพลาดในการอัปเดตข้อมูล";
            $_SESSION['status_code'] = "ผิดพลาด";
        }
    } else {
        $_SESSION['status'] = "ไม่พบข้อมูลที่จะอัปเดต";
        $_SESSION['status_code'] = "ผิดพลาด";
    }
}

// ส่งกลับไปยังหน้าที่คุณต้องการ

//header($location);
header('Location: setting_edit_form.php');
