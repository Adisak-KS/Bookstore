<?php
//header('content-Type: text/html; chaset=utf-8');

$hostname = "localhost";
$dbname = "bookstore";
$uname = "book";
$pwd = "book";
$proj_connect = mysqli_connect($hostname, $uname, $pwd, $dbname);

if (!$proj_connect) {
  die("Connection failed : " . mysqli_connect_error());
}

session_start();

if (!isset($_SESSION['titleweb'])) {
  $sql_titleweb = "SELECT * FROM bk_setting WHERE set_id = '1' ";
  $titleweb = mysqli_query($proj_connect, $sql_titleweb) or die(mysqli_connect_error());
  $row_titleweb = mysqli_fetch_assoc($titleweb);
  $_SESSION['titleweb'] = $row_titleweb['set_detail'];
}

if (!isset($_SESSION['logo'])) {
  $sql_logo = "SELECT * FROM bk_setting WHERE set_id = '2' ";
  $logo = mysqli_query($proj_connect, $sql_logo) or die(mysqli_connect_error());
  $row_logo = mysqli_fetch_assoc($logo);
  $_SESSION['logo'] = $row_logo['set_detail'];
}

if (!isset($_SESSION['maintitle'])) {
  $sql_maintitle = "SELECT * FROM bk_setting WHERE set_id = '3' ";
  $maintitle = mysqli_query($proj_connect, $sql_maintitle) or die(mysqli_connect_error());
  $row_maintitle = mysqli_fetch_assoc($maintitle);
  $_SESSION['maintitle'] = $row_maintitle['set_detail'];
}

if (!isset($_SESSION['banner_1'])) {
  $sql_banner_1 = "SELECT * FROM bk_setting WHERE set_id = '4' ";
  $banner_1 = mysqli_query($proj_connect, $sql_banner_1) or die(mysqli_connect_error());
  $row_banner_1 = mysqli_fetch_assoc($banner_1);
  $_SESSION['banner_1'] = $row_banner_1['set_detail'];
}

if (!isset($_SESSION['banner_1_text'])) {
  $sql_banner_1_text = "SELECT * FROM bk_setting WHERE set_id = '5' ";
  $banner_1_text = mysqli_query($proj_connect, $sql_banner_1_text) or die(mysqli_connect_error());
  $row_banner_1_text = mysqli_fetch_assoc($banner_1_text);
  $_SESSION['banner_1_text'] = $row_banner_1_text['set_detail'];
}

if (!isset($_SESSION['banner_2'])) {
  $sql_banner_2 = "SELECT * FROM bk_setting WHERE set_id = '6' ";
  $banner_2 = mysqli_query($proj_connect, $sql_banner_2) or die(mysqli_connect_error());
  $row_banner_2 = mysqli_fetch_assoc($banner_2);
  $_SESSION['banner_2'] = $row_banner_2['set_detail'];
}

if (!isset($_SESSION['banner_3'])) {
  $sql_banner_3 = "SELECT * FROM bk_setting WHERE set_id = '7' ";
  $banner_3 = mysqli_query($proj_connect, $sql_banner_3) or die(mysqli_connect_error());
  $row_banner_3 = mysqli_fetch_assoc($banner_3);
  $_SESSION['banner_3'] = $row_banner_3['set_detail'];
}

if (!isset($_SESSION['banner_4'])) {
  $sql_banner_4 = "SELECT * FROM bk_setting WHERE set_id = '8' ";
  $banner_4 = mysqli_query($proj_connect, $sql_banner_4) or die(mysqli_connect_error());
  $row_banner_4 = mysqli_fetch_assoc($banner_4);
  $_SESSION['banner_4'] = $row_banner_4['set_detail'];
}
if (!isset($_SESSION['url_banner_1'])) {
  $sql_banner_9 = "SELECT * FROM bk_setting WHERE set_id = '9' ";
  $banner_9 = mysqli_query($proj_connect, $sql_banner_9) or die(mysqli_connect_error());
  $row_banner_9 = mysqli_fetch_assoc($banner_9);
  $_SESSION['url_banner_1'] = $row_banner_9['set_detail'];
}
if (!isset($_SESSION['url_banner_2'])) {
  $sql_banner_10 = "SELECT * FROM bk_setting WHERE set_id = '10' ";
  $banner_10 = mysqli_query($proj_connect, $sql_banner_10) or die(mysqli_connect_error());
  $row_banner_10 = mysqli_fetch_assoc($banner_10);
  $_SESSION['url_banner_2'] = $row_banner_10['set_detail'];
}
if (!isset($_SESSION['url_banner_3'])) {
  $sql_banner_11 = "SELECT * FROM bk_setting WHERE set_id = '11' ";
  $banner_11 = mysqli_query($proj_connect, $sql_banner_11) or die(mysqli_connect_error());
  $row_banner_11 = mysqli_fetch_assoc($banner_11);
  $_SESSION['url_banner_3'] = $row_banner_11['set_detail'];
}

if (!isset($_SESSION['url_banner_4'])) {
  $sql_banner_12 = "SELECT * FROM bk_setting WHERE set_id = '12' ";
  $banner_12 = mysqli_query($proj_connect, $sql_banner_12) or die(mysqli_connect_error());
  $row_banner_12 = mysqli_fetch_assoc($banner_12);
  $_SESSION['url_banner_4'] = $row_banner_12['set_detail'];
}

if (!isset($_SESSION['banner_5'])) {
  $sql_banner_13 = "SELECT * FROM bk_setting WHERE set_id = '13' ";
  $banner_13 = mysqli_query($proj_connect, $sql_banner_13) or die(mysqli_connect_error());
  $row_banner_13 = mysqli_fetch_assoc($banner_13);
  $_SESSION['banner_5'] = $row_banner_13['set_detail'];
}

if (!isset($_SESSION['banner_5_text'])) {
  $sql_banner_14 = "SELECT * FROM bk_setting WHERE set_id = '14' ";
  $banner_14 = mysqli_query($proj_connect, $sql_banner_14) or die(mysqli_connect_error());
  $row_banner_14 = mysqli_fetch_assoc($banner_14);
  $_SESSION['banner_5_text'] = $row_banner_14['set_detail'];
}

if (!isset($_SESSION['url_banner_5'])) {
  $sql_banner_15 = "SELECT * FROM bk_setting WHERE set_id = '15' ";
  $banner_15_result = mysqli_query($proj_connect, $sql_banner_15) or die(mysqli_connect_error());
  $row_banner_15 = mysqli_fetch_assoc($banner_15_result);
  $_SESSION['url_banner_5'] = $row_banner_15['set_detail'];
}

if (!isset($_SESSION['cancel_time'])) {
  $sql_cancel_time = "SELECT * FROM bk_setting WHERE set_id = '16' ";
  $cancel_time_result = mysqli_query($proj_connect, $sql_cancel_time) or die(mysqli_connect_error());
  $row_cancel_time = mysqli_fetch_assoc($cancel_time_result);
  $_SESSION['cancel_time'] = $row_cancel_time['set_detail'];
}
if (!isset($_SESSION['contact_map'])) {
  $sql_contact_map = "SELECT * FROM bk_setting WHERE set_id = '17' ";
  $contact_map_result = mysqli_query($proj_connect, $sql_contact_map) or die(mysqli_connect_error());
  $row_contact_map = mysqli_fetch_assoc($contact_map_result);
  $_SESSION['contact_map'] = $row_contact_map['set_detail'];
}
if (!isset($_SESSION['contact_address'])) {
  $sql_contact_address = "SELECT * FROM bk_setting WHERE set_id = '18' ";
  $contact_address_result = mysqli_query($proj_connect, $sql_contact_address) or die(mysqli_connect_error());
  $row_contact_address = mysqli_fetch_assoc($contact_address_result);
  $_SESSION['contact_address'] = $row_contact_address['set_detail'];
}
if (!isset($_SESSION['contact_mail'])) {
  $sql_contact_mail = "SELECT * FROM bk_setting WHERE set_id = '19' ";
  $contact_mail_result = mysqli_query($proj_connect, $sql_contact_mail) or die(mysqli_connect_error());
  $row_contact_mail = mysqli_fetch_assoc($contact_mail_result);
  $_SESSION['contact_mail'] = $row_contact_mail['set_detail'];
}
if (!isset($_SESSION['contact_phone'])) {
  $sql_contact_phone = "SELECT * FROM bk_setting WHERE set_id = '20' ";
  $contact_phone_result = mysqli_query($proj_connect, $sql_contact_phone) or die(mysqli_connect_error());
  $row_contact_phone = mysqli_fetch_assoc($contact_phone_result);
  $_SESSION['contact_phone'] = $row_contact_phone['set_detail'];
}
if (!isset($_SESSION['remain_quantity'])) {
  $sql_remain_quantity = "SELECT * FROM bk_setting WHERE set_id = '22' ";
  $remain_quantity_result = mysqli_query($proj_connect, $sql_remain_quantity) or die(mysqli_connect_error());
  $row_remain_quantity = mysqli_fetch_assoc($remain_quantity_result);
  $_SESSION['remain_quantity'] = $row_remain_quantity['set_detail'];
}
