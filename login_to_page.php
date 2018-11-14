<?php

session_start();

if ((!isset($_POST['login'])) || (!isset($_POST['password']))) {
    header('Location: login_page.php');
    exit();
}

require_once "connect.php";

$connect = @new mysqli($host, $db_user, $db_password, $db_name);

if ($connect->connect_errno != 0) {
    echo "Error: " . $connect->connect_errno;
} else {
    $login = $_POST['login'];
    $password = $_POST['password'];

    $login = htmlentities($login, ENT_QUOTES, "UTF-8");


    if ($result = @$connect->query(sprintf("SELECT * FROM users WHERE username='%s' ",
        mysqli_real_escape_string($connect, $login)))) {
        $number_of_users = $result->num_rows;
        if ($number_of_users > 0) {

            $row = $result->fetch_assoc();
            if (password_verify($password, $row['password'])) {
                $user = $row['username'];
                $_SESSION['username'] = $user;
                $_SESSION['id'] = $row['id'];
                unset($_SESSION['error']);

                $result->free_result();
                header('location: home_page.php');
            } else {

                $_SESSION['error'] = '<span style="color:red"> Wrong login or password!</span>';
                header('location: login_page.php');
            }


        } else {

            $_SESSION['error'] = '<span style="color:red"> Wrong login or password!</span>';
            header('location: login_page.php');
        }


    }

    $connect->close();
}