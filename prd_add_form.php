<?php
require_once('connection.php');

$sql_script = "SELECT * FROM book";

$result = mysqli_query($proj_connect, $sql_script) or die(mysqli_connect_error());
$row_result = mysqli_fetch_assoc($result);
$totalrows_result = mysqli_num_rows($result);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<form method="post" action="prd_add.php">

<label>เพิ่มข้อมูล</label>
<br>
<label>ชื่อหนังสือ</label>
<input type="text" id="name" name="name">
<br>
<label>ประเภท</label>
<input type="text" id="type" name="type">
<br>
<label>ราคา</label>
<input type="number" id="price" name="price">
<br>
<input type="submit">
</form>

</body>
</html>
