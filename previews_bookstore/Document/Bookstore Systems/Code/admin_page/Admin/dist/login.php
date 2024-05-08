<?php
require_once __DIR__ . '/../../../connection.php';
session_start();

if (isset($_POST['loginbtn'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $username_query = "SELECT * FROM bk_auth_staff WHERE stf_username ='$username'";
    $username_query_run = mysqli_query($proj_connect, $username_query);

    if (mysqli_num_rows($username_query_run) > 0) {
        $user_data = mysqli_fetch_assoc($username_query_run);
        $hashed_password_from_db = $user_data['stf_password'];

        if (password_verify($password, $hashed_password_from_db)) {
            unset($_SESSION['status_code']);
            $_SESSION['login_id'] = $user_data['stf_id'];

            if (isset($_SESSION['login_id'])) {
                // ดึงค่า login_id ออกมา
                $login_id = $_SESSION['login_id'];

                // คิวรี่เพื่อค้นหาข้อมูลสมาชิกด้วย login_id
                $query = "SELECT * FROM bk_auth_staff WHERE stf_id = '$login_id'";
                $query_run = mysqli_query($proj_connect, $query);
                $staff_result = mysqli_fetch_assoc($query_run);

                $_SESSION['username'] = $staff_result['stf_username'];
                $_SESSION['firstname'] = $staff_result['stf_firstname'];
                $_SESSION['lastname'] = $staff_result['stf_lastname'];
                $_SESSION['email'] = $staff_result['stf_email'];

                $location = 'product_show.php';
                if ($staff_result['stf_active'] == 0) {
                    $location = 'blocked.php';
                } elseif (mysqli_num_rows($query_run) == 1) {

                    // ตำแหน่งของสมาชิกในตาราง staff
                    $staff_chk = "SELECT * FROM bk_auth_staff WHERE stf_id = '$login_id'";
                    $staff_chk_run = mysqli_query($proj_connect, $staff_chk);
                    $staff_result = mysqli_fetch_assoc($staff_chk_run);
                    $_SESSION['staff'] = $staff_result['stf_id'];

                    // ตรวจสอบว่าสมาชิกเป็น super admin หรือไม่

                    // ตรวจสอบตำแหน่งในตาราง super_admin
                    $stf_id = $staff_result['stf_id'];
                    $superadmin_chk = "SELECT * FROM bk_auth_super_admin WHERE stf_id = '$stf_id'";
                    $superadmin_chk_run = mysqli_query($proj_connect, $superadmin_chk);
                    $superadmin_result = mysqli_fetch_assoc($superadmin_chk_run);
                    if (!empty($superadmin_result['supadm_id'])) {
                        $_SESSION['super_admin'] = $superadmin_result['supadm_id'];
                    }

                    // ตรวจสอบว่าสมาชิกเป็น admin หรือไม่
                    if (!empty($staff_result['stf_id'])) {
                        // ตรวจสอบตำแหน่งในตาราง admin
                        $stf_id = $staff_result['stf_id'];
                        $admin_chk = "SELECT * FROM bk_auth_admin";
                        $admin_chk_run = mysqli_query($proj_connect, $admin_chk);

                        while ($admin_result = mysqli_fetch_assoc($admin_chk_run)) {
                            // ใช้ base64_encode เพื่อตรวจสอบถูกต้องของ stf_id
                            if (base64_encode($stf_id) == $admin_result['stf_id']) {
                                $_SESSION['admin'] = $admin_result['adm_id'];
                                break; // พบ stf_id ที่ตรงกัน ออกจากลูป
                            }
                        }

                        // ตรวจสอบว่าสมาชิกเป็น Sale หรือไม่
                        $stf_id = $staff_result['stf_id'];
                        $sale_chk = "SELECT * FROM bk_auth_sale";
                        $sale_chk_run = mysqli_query($proj_connect, $sale_chk);

                        while ($sale_result = mysqli_fetch_assoc($sale_chk_run)) {
                            // ใช้ base64_encode เพื่อตรวจสอบถูกต้องของ stf_id
                            if (base64_encode($stf_id) == $sale_result['stf_id']) {
                                $_SESSION['sale'] = $sale_result['sle_id'];
                                break; // พบ stf_id ที่ตรงกัน ออกจากลูป
                            }
                        }

                        // ปลายทางการเข้าสู่ระบบ
                        if (!empty($superadmin_result['supadm_id'])) {
                            $location = 'admin_show.php';
                        } elseif (!empty($admin_result['adm_id'])) {
                            $location = 'index.php';
                        } elseif (!empty($sale_result['sle_id'])) {
                            $location = 'product_show.php';
                        } else {
                            $location = 'index.php';
                        }
                    }
                }
            } else {

                header('Location: login_form.php');
            }

            //ยกเลิกออเดอร์
            // กำหนดวันที่สั่งซื้อในอดีต (7 วันที่ผ่านมา)
            $cancel_time = '-' . $_SESSION['cancel_time'] . ' days';
            $cutOffDate = date('Y-m-d H:i:s', strtotime($cancel_time));

            // คำสั่ง SQL สำหรับอัปเดตสถานะ
            $updateOrderStatusSQL = "UPDATE bk_ord_orders SET ord_status = 'cancel' WHERE ord_date <= '$cutOffDate' AND (ord_status = 'รอการชำระเงิน' OR ord_status = 'การชำระเงินไม่ถูกต้อง')";
            $cancelordresult = mysqli_query($proj_connect, $updateOrderStatusSQL);

            $SuccessOrderStatusSQL = "UPDATE bk_ord_orders SET ord_status = 'จัดส่งสำเร็จ' WHERE ord_date <= '$cutOffDate' AND ord_status = 'อยู่ระหว่างการขนส่ง'";
            $successordresult = mysqli_query($proj_connect, $SuccessOrderStatusSQL);

            $updateFinderStatusSQL = "UPDATE bk_fnd_finder SET fnd_status = 'cancel' WHERE fnd_date <= '$cutOffDate' AND (fnd_status = 'รอการชำระเงิน' OR fnd_status = 'การชำระเงินไม่ถูกต้อง')";
            $cancelfndresult = mysqli_query($proj_connect, $updateFinderStatusSQL);

            $SuccessFinderStatusSQL = "UPDATE bk_fnd_finder SET fnd_status = 'จัดส่งสำเร็จ' WHERE fnd_date <= '$cutOffDate' AND fnd_status = 'อยู่ระหว่างการขนส่ง'";
            $successfndresult = mysqli_query($proj_connect, $SuccessFinderStatusSQL);


            $_SESSION['status'] = "เข้าสู่ระบบสำเร็จ";
            $_SESSION['status_code'] = "สำเร็จ";
            header('Location: ' . $location);
        } else {
            echo "Error";
            $_SESSION['status'] = "รหัสผ่านผิดพลาด โปรดลองใหม่อีกครั้ง";
            $_SESSION['status_code'] = "ผิดพลาด";
            header('Location: login_form.php');
        }
    } else {
        echo "Error";
        $_SESSION['status'] = "ไม่พบชื่อผู้ใช้นี้";
        $_SESSION['status_code'] = "แจ้งเตือน";
        header('Location: login_form.php');
    }
} else {
    echo "Error";
    $_SESSION['status'] = "เกิดข้อผิดพลาด";
    $_SESSION['status_code'] = "ผิดพลาด";
    header('Location: login_form.php');
exit;
}

