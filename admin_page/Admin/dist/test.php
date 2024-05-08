<?php
require_once __DIR__ . '/../../../connection.php';



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
$sql_script = "SELECT * FROM bk_prd_type";
$pty_result = mysqli_query($proj_connect, $sql_script) or die(mysqli_connect_error());
$pty_row_result = mysqli_fetch_assoc($pty_result);
$pty_totalrows_result = mysqli_num_rows($pty_result);
?>

<table id="datatable" class="table table-bordered dt-responsive table-responsive nowrap">
    <thead>
        <tr>
            <th data-priority="1">ชื่อประเภทสินค้า</th>
            <th data-priority="2">รายละเอียด</th>
            <th data-priority="3"></th>
            <th data-priority="4"></th>
        </tr>
    </thead>
    <tbody>
        <?php do { ?>
            <tr>
                <!-- ส่วนแสดงข้อมูลสมาชิก -->
                <td><?php echo $pty_row_result['pty_name']; ?></td>
                <td><?php echo $pty_row_result['pty_detail']; ?></td>
                <td>
                    <!-- ปุ่มแก้ไข -->
                    <form action="product_type_edit_form.php" method="post">
                        <input type="hidden" name="edit_id" value="<?php echo $pty_row_result['pty_id']; ?>">
                        <button type="submit" name="edit_btn" class="btn btn-warning waves-effect waves-light"> แก้ไข</button>
                    </form>
                </td>
                <td>
                    <!-- ปุ่มลบ -->
                    <form action="member_delete_form.php" method="post">
                        <input type="hidden" name="edit_id" value="<?php echo $pty_row_result['pty_id']; ?>">
                        <button type="submit" name="delete_btn" class="btn btn-danger waves-effect waves-light"> ลบ</button>
                    </form>
                </td>
            </tr>
        <?php } while ($pty_row_result = mysqli_fetch_assoc($pty_result)); ?>
    </tbody>
</table>

<script>
    $(document).ready(function() {
        $('#datatable').DataTable({
            "pagingType": "full_numbers" // ตั้งค่าประเภทของการแบ่งหน้า
        });
    });
</script>

</body>
</html>