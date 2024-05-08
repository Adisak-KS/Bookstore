<?php
require_once __DIR__ . '/../../../connection.php';

// ตรวจสอบสิทธิ์
if (!(isset($_SESSION['admin']) || isset($_SESSION['super_admin']))) {
    $_SESSION['status'] = "ไม่พบสิทธิ์การใช้งานในหน้านี้";
    $_SESSION['status_code'] = "ผิดพลาด";
    header('Location: login_form.php');
exit;
}

$page_title = basename($_SERVER['PHP_SELF']);

if (isset($_SESSION['status']) && isset($_SESSION['status_code'])) {
    $status = $_SESSION['status'];
    $status_code = $_SESSION['status_code'];

    // เคลียร์ค่า session
    unset($_SESSION['status']);
    unset($_SESSION['status_code']);

    // แสดงหน้าต่างข้อความแจ้งเตือน
    echo "<script>alert('$status');</script>";
    echo "<script>window.location.href = '$page_title';</script>";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    require_once('head.php');
    ?>
</head>

<!-- body start -->

<body class="loading" data-layout-color="light" data-layout-mode="default" data-layout-size="fluid" data-topbar-color="light" data-leftbar-position="fixed" data-leftbar-color="light" data-leftbar-size='default' data-sidebar-user='true'>

    <!-- Begin page -->
    <div id="wrapper">

        <!-- Topbar Start -->
        <?php
        require_once('nav.php');
        ?>
        <!-- end Topbar -->

        <!-- ========== Left Sidebar Start ========== -->
        <?php
        require_once('slidebar.php');
        ?>
        <!-- Left Sidebar End -->

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <div class="content-page">
            <div class="content">


                <!-- Start Content-->
                <div class="container-fluid">
                    <!-- ฟอร์มแก้ไขสมาชิก -->



                    <div class="row">
                        <div class="col-12">
                            <!-- ไตเติลเว็บไซต์ -->
                            <div id="webtitle" class="modal fade" tabindex="-1" aria-labelledby="webtitle_Label" aria-hidden="true" style="display: none;">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="webtitle_Label">ไตเติลเว็บไซต์</h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <?php

                                            $sql_script = "SELECT * FROM bk_setting WHERE set_id = '1'";
                                            $set_result = mysqli_query($proj_connect, $sql_script) or die(mysqli_connect_error());
                                            $set_row_result = mysqli_fetch_assoc($set_result);
                                            $set_totalrows_result = mysqli_num_rows($set_result);
                                            ?>
                                            <form action="setting_edit.php" class="parsley-examples" method="POST">
                                                <?php do { ?>
                                                    <div class="mb-3">
                                                        <input type="text" hidden id="set_id" name="set_id" value="<?php echo $set_row_result['set_id'] ?>">
                                                        <label for="userName" class="form-label"><?php echo $set_row_result['set_name'] ?><span class="text-danger">*</span></label>
                                                        <input type="text" name="set_detail" required parsley-trigger="change" class="form-control" id="set_detail" value="<?php echo $set_row_result['set_detail'] ?>" />
                                                    </div>
                                                <?php } while ($set_row_result = mysqli_fetch_assoc($set_result)); ?>

                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-warning btn-sm waves-effect waves-light" type="submit" id="editbtn" name="editbtn"><i class="far fa-edit"></i> บันทึก</button>
                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">ปิด</button>
                                        </div>
                                        </form>
                                    </div><!-- /.modal-content -->
                                </div><!-- /.modal-dialog -->
                            </div><!-- /.modal -->

                            <!-- ข้อความบนบานเนอร์ 1 -->
                            <div id="banner_1_text" class="modal fade" tabindex="-1" aria-labelledby="webtitle_Label" aria-hidden="true" style="display: none;">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="webtitle_Label">ข้อความบนบานเนอร์ 1</h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <?php

                                            $sql_script = "SELECT * FROM bk_setting WHERE set_id = '5'";
                                            $set5_result = mysqli_query($proj_connect, $sql_script) or die(mysqli_connect_error());
                                            $set5_row_result = mysqli_fetch_assoc($set5_result);
                                            $set5_totalrows_result = mysqli_num_rows($set5_result);
                                            ?>
                                            <form action="setting_edit.php" class="parsley-examples" method="POST">
                                                <?php do { ?>
                                                    <div class="mb-3">
                                                        <input type="text" hidden id="set_id" name="set_id" value="<?php echo $set5_row_result['set_id'] ?>">
                                                        <label for="userName" class="form-label"><?php echo $set5_row_result['set_name'] ?><span class="text-danger">*</span></label>
                                                        <input type="text" name="set_detail" required parsley-trigger="change" class="form-control" id="set_detail" value="<?php echo $set5_row_result['set_detail'] ?>" />
                                                    </div>
                                                <?php } while ($set5_row_result = mysqli_fetch_assoc($set5_result)); ?>

                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-warning btn-sm waves-effect waves-light" type="submit" id="editbtn" name="editbtn"><i class="far fa-edit"></i> บันทึก</button>
                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">ปิด</button>
                                        </div>
                                        </form>
                                    </div><!-- /.modal-content -->
                                </div><!-- /.modal-dialog -->
                            </div><!-- /.modal -->

                            <!-- logo -->
                            <div id="logo" class="modal fade" tabindex="-1" aria-labelledby="logo_Label" aria-hidden="true" style="display: none;">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="logo_Label">โลโก้</h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <?php

                                            $sql_script = "SELECT * FROM bk_setting WHERE set_id = '2'";
                                            $icon_result = mysqli_query($proj_connect, $sql_script) or die(mysqli_connect_error());
                                            $icon_row_result = mysqli_fetch_assoc($icon_result);
                                            $icon_totalrows_result = mysqli_num_rows($icon_result);
                                            ?>
                                            <div class="mb-3">
                                                <label for="userName" class="form-label"><?php echo $icon_row_result['set_name'] ?>: <span class="text-danger">*</span></label>

                                                <img src="assets/images/<?php echo $icon_row_result['set_detail'] ?>" alt="image" class="img-fluid img-thumbnail" width="100" />
                                            </div>
                                            <br>
                                            <form action="upload_setting.php" method="post" enctype="multipart/form-data">
                                                เลือกรูปภาพ:
                                                <input type="file" class="form-control" name="fileToUpload" id="fileToUpload">
                                                <br><br>
                                                <input type="submit" value="อัปโหลดรูปภาพ" name="submit">
                                                <input type="text" value="<?php echo $icon_row_result['set_id'] ?>" id="set_id" name="set_id" hidden>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">ปิด</button>

                                        </div>
                                        </form>
                                    </div><!-- /.modal-content -->
                                </div><!-- /.modal-dialog -->
                            </div><!-- /.modal -->
                            <!-- maintitle -->
                            <div id="maintitle" class="modal fade" tabindex="-1" aria-labelledby="maintitle_Label" aria-hidden="true" style="display: none;">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="maintitle_Label">ไตเติลหลัก</h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <?php

                                            $sql_script = "SELECT * FROM bk_setting WHERE set_id = '3'";
                                            $set3_result = mysqli_query($proj_connect, $sql_script) or die(mysqli_connect_error());
                                            $set3_row_result = mysqli_fetch_assoc($set3_result);
                                            $set3_totalrows_result = mysqli_num_rows($set3_result);
                                            ?>
                                            <form action="setting_edit.php" class="parsley-examples" method="POST">
                                                <?php do { ?>
                                                    <div class="mb-3">
                                                        <input type="text" hidden id="set_id" name="set_id" value="<?php echo $set3_row_result['set_id'] ?>">
                                                        <label for="userName" class="form-label"><?php echo $set3_row_result['set_name'] ?><span class="text-danger">*</span></label>
                                                        <input type="text" name="set_detail" required parsley-trigger="change" class="form-control" id="set_detail" value="<?php echo $set3_row_result['set_detail'] ?>" />
                                                    </div>
                                                <?php } while ($set3_row_result = mysqli_fetch_assoc($set_result)); ?>
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-warning btn-sm waves-effect waves-light" type="submit" id="editbtn" name="editbtn"><i class="far fa-edit"></i> บันทึก</button>
                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">ปิด</button>
                                        </div>
                                        </form>
                                    </div><!-- /.modal-content -->
                                </div><!-- /.modal-dialog -->
                            </div><!-- /.modal -->

                            <!-- ตาราง -->
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="mt-0 header-title">แก้ไขรายยละเอียดเว็บไซต์</h4>
                                    <br>

                                    <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap dataTable no-footer dtr-inline">
                                        <thead class="table-light">
                                            <tr>
                                                <th style="width:50%;">รายการปรับแต่ง</th>
                                                <th>รายละเอียด</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $selected_ids = [1, 3, 18, 19, 20];
                                            $table_names = ['ชื่อเว็บไซต์', 'ไตเติลเว็บไซต์', 'ที่อยู่', 'อีเมลติดต่อ', 'เบอร์ติดต่อ'];
                                            $n = 0;

                                            foreach ($selected_ids as $selected_id) {
                                                $sql_script = "SELECT * FROM bk_setting WHERE set_id = '$selected_id'";
                                                $result = mysqli_query($proj_connect, $sql_script) or die(mysqli_connect_error());
                                                $row_result = mysqli_fetch_assoc($result);
                                            ?>
                                                <tr>
                                                    <td><?php echo $table_names[$n]; ?></td>
                                                    <td><?php echo $row_result['set_detail']; ?></td>
                                                    <td>
                                                        <form action="setting_url_edit_form.php" method="POST">
                                                            <input type="text" name="set_name" id="set_name" value="<?= $table_names[$n]; ?>" hidden>
                                                            <input type="text" name="edit_id" id="edit_id" value="<?= $row_result['set_id']; ?>" hidden>
                                                            <button type="submit" class="btn btn-warning btn-sm waves-effect waves-light"><i class="far fa-edit"></i> แก้ไข</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            <?php
                                            $n++;
                                            }
                                            ?>
                                             <?php
                                            $selected_ids = [16, 22];
                                            $table_names = ['เวลาหมดอายุของออเดอร์ (วัน)', 'แจ้งเตือนสินค้าใกล้หมด (ชิ้น)'];
                                            $n = 0;

                                            foreach ($selected_ids as $selected_id) {
                                                $sql_script = "SELECT * FROM bk_setting WHERE set_id = '$selected_id'";
                                                $result = mysqli_query($proj_connect, $sql_script) or die(mysqli_connect_error());
                                                $row_result = mysqli_fetch_assoc($result);
                                            ?>
                                                <tr>
                                                    <td><?php echo $table_names[$n]; ?></td>
                                                    <td><?php echo $row_result['set_detail']; ?></td>
                                                    <td>
                                                        <form action="setting_number_edit_form.php" method="POST">
                                                            <input type="text" name="set_name" id="set_name" value="<?= $table_names[$n]; ?>" hidden>
                                                            <input type="text" name="edit_id" id="edit_id" value="<?= $row_result['set_id']; ?>" hidden>
                                                            <button type="submit" class="btn btn-warning btn-sm waves-effect waves-light"><i class="far fa-edit"></i> แก้ไข</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            <?php
                                            $n++;
                                            }
                                            ?>
                                            <?php
                                            $selected_ids = [2];
                                            $table_name = ['โลโก้เว็บไซต์'];
                                            $i = 0;

                                            foreach ($selected_ids as $selected_id) {
                                                $sql_script = "SELECT * FROM bk_setting WHERE set_id = '$selected_id'";
                                                $result = mysqli_query($proj_connect, $sql_script) or die(mysqli_connect_error());
                                                $row_result = mysqli_fetch_assoc($result);
                                            ?>
                                                <tr>
                                                    <td><?php echo $table_name[$i]; ?></td>
                                                    <td><img src="assets/images/<?php echo $row_result['set_detail']; ?>" alt="image" class="img-fluid img-thumbnail" style="max-width: 100px; max-height: 100px;" /></td>
                                                    <td>
                                                        <form action="setting_banner_edit_form.php" method="POST">
                                                            <input type="text" name="set_name" id="set_name" value="<?=$table_name[$i]; ?>" hidden>
                                                            <input type="text" name="edit_id" id="edit_id" value="<?php echo $row_result['set_id']; ?>" hidden>
                                                            <button type="submit" class="btn btn-warning btn-sm waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#banner_1"><i class="far fa-edit"></i> แก้ไข</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            <?php
                                                $i++;
                                            }
                                            ?>
                                            <?php
                                            $selected_ids = [21];
                                            $table_name = ['ฟาวิคอน'];
                                            $i = 0;

                                            foreach ($selected_ids as $selected_id) {
                                                $sql_script = "SELECT * FROM bk_setting WHERE set_id = '$selected_id'";
                                                $result = mysqli_query($proj_connect, $sql_script) or die(mysqli_connect_error());
                                                $row_result = mysqli_fetch_assoc($result);
                                            ?>
                                                <tr>
                                                    <td><?php echo $table_name[$i]; ?></td>
                                                    <td><img src="assets/images/<?php echo $row_result['set_detail']; ?>" alt="image" class="img-fluid img-thumbnail" style="max-width: 100px; max-height: 100px;" /></td>
                                                    <td>
                                                        <form action="setting_favicon_edit_form.php" method="POST">
                                                            <input type="text" name="set_name" id="set_name" value="<?=$table_name[$i]; ?>" hidden>
                                                            <input type="text" name="edit_id" id="edit_id" value="<?php echo $row_result['set_id']; ?>" hidden>
                                                            <button type="submit" class="btn btn-warning btn-sm waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#banner_1"><i class="far fa-edit"></i> แก้ไข</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            <?php
                                                $i++;
                                            }
                                            ?>
                                             <?php
                                            $selected_ids = [17];
                                            $table_names = ['แผนที่'];
                                            $n = 0;

                                            foreach ($selected_ids as $selected_id) {
                                                $sql_script = "SELECT * FROM bk_setting WHERE set_id = '$selected_id'";
                                                $result = mysqli_query($proj_connect, $sql_script) or die(mysqli_connect_error());
                                                $row_result = mysqli_fetch_assoc($result);
                                            ?>
                                                <tr>
                                                    <td><?php echo $table_names[$n]; ?></td>
                                                    <td><?php echo $row_result['set_detail']; ?></td>
                                                    <td>
                                                        <form action="setting_map_edit_form.php" method="POST">
                                                            <input type="text" name="set_name" id="set_name" value="<?= $table_names[$n]; ?>" hidden>
                                                            <input type="text" name="edit_id" id="edit_id" value="<?= $row_result['set_id']; ?>" hidden>
                                                            <button type="submit" class="btn btn-warning btn-sm waves-effect waves-light"><i class="far fa-edit"></i> แก้ไข</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            <?php
                                            $n++;
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div> <!-- end row -->
                </div> <!-- container-fluid -->

            </div> <!-- content -->

            <!-- Footer Start -->
            <?php
            require_once('footer.php');
            ?>
            <!-- end Footer -->

        </div>

        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->


    </div>
    <!-- END wrapper -->

    <!-- Right Sidebar -->
    <?php
    require_once('right_ridebar.php');
    ?>

</body>

</html>