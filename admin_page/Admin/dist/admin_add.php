<?php
require_once __DIR__ . '/../../../connection.php';
session_start();

if (isset($_POST['addbtn'])) {
    $uname = $_POST['stf_username'];
    $pwd = $_POST['stf_password'];
    $cpassword = $_POST['cpassword'];
    $fname = $_POST['stf_firstname'];
    $lname = $_POST['stf_lastname'];
    $email = $_POST['stf_email'];

    $email_query = "SELECT * FROM bk_auth_staff WHERE stf_email='$email' OR stf_username='$uname'";
    $username_query = "SELECT * FROM bk_auth_staff WHERE stf_username='$uname'";

    $email_query_run = mysqli_query($proj_connect, $email_query);
    $username_query_run = mysqli_query($proj_connect, $username_query);

    $location = 'admin_show.php';

    if (mysqli_num_rows($username_query_run) > 0) {
        $_SESSION['status'] = "ชื่อผู้ใช้นี้ถูกใช้แล้ว โปรดลองชื่อผู้ใช้อื่น";
        $_SESSION['status_code'] = "ผิดพลาด";
        header('Location: ' . $location);
        exit();
    } else if (mysqli_num_rows($email_query_run) > 0) {
        $_SESSION['status'] = "อีเมลนี้ถูกใช้แล้ว โปรดลองอีเมลอื่น";
        $_SESSION['status_code'] = "ผิดพลาด";
        header('Location: ' . $location);
    } else {
        if ($pwd === $cpassword) {

            // ทำการเข้ารหัสรหัสผ่านก่อน
            $hashed_pwd = password_hash($pwd, PASSWORD_DEFAULT);

            $query = "INSERT INTO bk_auth_staff (stf_username, stf_password, stf_firstname, stf_lastname, stf_email) VALUES ('$uname', '$hashed_pwd', '$fname', '$lname', '$email')";
            $query_run = mysqli_query($proj_connect, $query);

            if ($query_run) {
                // รับค่า stf_id ที่ถูกสร้างใหม่
                $new_stf_id = mysqli_insert_id($proj_connect);
            
                // เข้ารหัส stf_id ก่อนเก็บลงในฐานข้อมูล
                $hashed_stf_id = base64_encode($new_stf_id);
            
                // เพิ่มข้อมูลในตาราง admin
                $admin_query = "INSERT INTO bk_auth_admin (stf_id) VALUES ('$hashed_stf_id')";
                $admin_query_run = mysqli_query($proj_connect, $admin_query);
            
                if ($admin_query_run) {
                    echo "Saved";
                    $_SESSION['status'] = "เพิ่มทีมงานสำเร็จ";
                    $_SESSION['status_code'] = "สำเร็จ";
                    header('Location: ' . $location);
                } else {
                    $_SESSION['status'] = "เพิ่มทีมงานไม่สำเร็จ1";
                    $_SESSION['status_code'] = "ผิดพลาด";
                    header('Location: ' . $location);
                }
            }
             else {
                $_SESSION['status'] = "เพิ่มทีมงานไม่สำเร็จ2";
                $_SESSION['status_code'] = "ผิดพลาด";
                header('Location: ' . $location);
            }
        } else {
            $_SESSION['status'] = "รหัสผ่านไม่ตรงกัน โปรดลองอีกครั้ง";
            $_SESSION['status_code'] = "แจ้งเตือน";
            header('Location: ' . $location);
        }
    }
}
