<?php
session_start();

$amount = $_POST['amount'];
$date = $_POST['date'];
$category = $_POST['category'];
$comment = $_POST['comment'];
$user_id = $_SESSION['id'];

if (isset($_POST['amount'])) {
    $validation_correct = true;
}
if (!is_numeric($amount)) {
    $validation_correct = false;
    $_SESSION['error_amount'] = "Amount should contains digits values!";
}
require_once "connect.php";
mysqli_report(MYSQLI_REPORT_STRICT);

$connect = new mysqli($host, $db_user, $db_password, $db_name);

$connect->query("INSERT INTO incomes VALUES (NULL,'$user_id', '$category', '$amount', '$date','$comment')");




$connect->close();

header('Location: add_income_page.php');

