<?php
session_start();

$amount = $_POST['amount'];
$date = $_POST['date'];
$payment = $_POST['payment'];
$category = $_POST['category'];
$comment = $_POST['comment'];
$user_id = $_SESSION['id'];


require_once "connect.php";
mysqli_report(MYSQLI_REPORT_STRICT);

$connect = new mysqli($host, $db_user, $db_password, $db_name);

$connect->query("INSERT INTO finance_manager.expenses VALUES (NULL,'$user_id', '$category','$payment','$amount', '$date','$comment')");




$connect->close();

header('Location: add_expense_page.php');

