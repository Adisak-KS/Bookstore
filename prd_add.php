<?php

require_once('connection.php');

$sql_script = "INSERT INTO book (name, type, price) VALUES ('".$_POST['name']."', '".$_POST['type']."', '".$_POST['price']."')";

$result = mysqli_query($proj_connect, $sql_script) or die (mysqli_connect_error());

mysqli_close($proj_connect);

header("Location: " . "show_prd.php");

 ?>
