<?php
$sql_script = "SELECT * FROM bk_auth_member";

$mmb_result = mysqli_query($proj_connect, $sql_script) or die(mysqli_connect_error());
$mmb_row_result = mysqli_fetch_assoc($mmb_result);
$mmb_totalrows_result = mysqli_num_rows($mmb_result);

$sql_script = "SELECT * FROM bk_mmb_address";

$addr_result = mysqli_query($proj_connect, $sql_script) or die(mysqli_connect_error());
$addr_row_result = mysqli_fetch_assoc($addr_result);
$addr_totalrows_result = mysqli_num_rows($addr_result);
?>