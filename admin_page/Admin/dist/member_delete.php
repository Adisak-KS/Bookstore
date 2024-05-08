<?php
require_once __DIR__ . '/../../../connection.php';

if (isset($_POST['deletebtn'])) {
    $mmb_id = $_POST['mmb_id'];

    // ทำการลบข้อมูลในตาราง bk_mmb_wish_list ก่อน
    $deleteWishlistQuery = "DELETE FROM bk_mmb_wishlist WHERE mmb_id = '$mmb_id'";
    $deleteWishlistResult = mysqli_query($proj_connect, $deleteWishlistQuery);

    if (!$deleteWishlistResult) {
        $_SESSION['status'] = "เกิดข้อผิดพลาดในการลบข้อมูลในตาราง bk_mmb_wishlist";
        $_SESSION['status_code'] = "ผิดพลาด";
        header('Location: member_show.php');
        exit();
    }

    // ทำการลบข้อมูลในตาราง bk_ord_orders สำหรับ mmb_id ที่ ord_status ไม่ใช่ 'อยู่ระหว่างการขนส่ง' หรือ 'จัดส่งสำเร็จ'
    $deleteOrderQuery = "DELETE FROM bk_ord_orders WHERE mmb_id = '$mmb_id' AND ord_status NOT IN ('อยู่ระหว่างการขนส่ง', 'จัดส่งสำเร็จ')";
    $deleteOrderResult = mysqli_query($proj_connect, $deleteOrderQuery);

    if ($deleteOrderResult) {
        // ทำการลบข้อมูลในตาราง bk_auth_member
        $deleteMemberQuery = "DELETE FROM bk_auth_member WHERE mmb_id = '$mmb_id'";
        mysqli_query($proj_connect, $deleteMemberQuery);
        // ทำการลบข้อมูลในตาราง bk_fnd_finder
        $deleteFinderQuery = "DELETE FROM bk_fnd_finder WHERE mmb_id = '$mmb_id'";
        mysqli_query($proj_connect, $deleteFinderQuery);
        // หลังจากที่ลบข้อมูลสมาชิกสำเร็จ ก็ลบข้อมูลในตาราง bk_mmb_coin_history
        $deleteCoinHistoryQuery = "DELETE FROM bk_mmb_coin_history WHERE mmb_id = '$mmb_id'";
        mysqli_query($proj_connect, $deleteCoinHistoryQuery); // ไม่ต้องตรวจสอบผลลัพธ์เนื่องจากเป็นการลบที่ไม่ส่งคืนค่า

        $deleteCommentQuery = "DELETE FROM bk_prd_comment WHERE mmb_id = '$mmb_id'";
        mysqli_query($proj_connect, $deleteCommentQuery);


        $_SESSION['status'] = "ลบสมาชิกสำเร็จ";
        $_SESSION['status_code'] = "สำเร็จ";
       
    } else {
        $_SESSION['status'] = "เกิดข้อผิดพลาดในการลบสมาชิก";
        $_SESSION['status_code'] = "ผิดพลาด";
    }

    // ส่งกลับไปยังหน้าที่คุณต้องการ
    header('Location: member_show.php');
    exit();
}
