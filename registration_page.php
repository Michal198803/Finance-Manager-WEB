<?php
session_start();

if (isset($_POST['email'])) {
    $validation_correct = true;
    $login = $_POST['login'];
    if ((strlen($login) < 3) || (strlen($login) > 20)) {
        $validation_correct = false;
        $_SESSION['error_login'] = "Name should contains from 3 to 20 chars";
    }

    if (ctype_alnum($login) == false) {
        $validation_correct = false;
        $_SESSION['error_login'] = "Name should contains only letters and numbers (without polish chars)";
    }
    $email = $_POST['email'];
    $emailB = filter_var($email, FILTER_SANITIZE_EMAIL);

    if ((filter_var($emailB, FILTER_VALIDATE_EMAIL) == false) || ($emailB != $email)) {
        $validation_correct = false;
        $_SESSION['error_email'] = "Please set correct email address";
    }
    $password = $_POST['password'];


    if ((strlen($password) < 8) || (strlen($password) > 20)) {
        $validation_correct = false;
        $_SESSION['error_password'] = "Password should contains from  8 to 20 chars!";
    }

    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    $_SESSION['fr_nick'] = $login;
    $_SESSION['fr_email'] = $email;
    $_SESSION['fr_haslo1'] = $password;

    require_once "connect.php";
    mysqli_report(MYSQLI_REPORT_STRICT);

    try {
        $connect = new mysqli($host, $db_user, $db_password, $db_name);

        if ($connect->connect_errno != 0) {
            throw new Exception(mysqli_connect_errno());
        } else {

            $result_email = $connect->query("SELECT id FROM finance_manager.users WHERE email='$email'");

            if (!$result_email) throw new Exception($connect->error);

            $number_of_emails = $result_email->num_rows;
            if ($number_of_emails > 0) {
                $result_ok = false;
                $_SESSION['e_email'] = "There is exists email assigned to this email address!";
            }

            $list_of_users = $connect->query("SELECT id FROM finance_manager.users ORDER BY id DESC LIMIT 1 ");

            $user_id_array = $list_of_users->fetch_assoc();

            $user_id = $user_id_array['id'] + 1;

            $result_email = $connect->query("SELECT id FROM finance_manager.users WHERE username='$login'");
            $category_result = $connect->query("SELECT incomes_category_default.name FROM finance_manager.incomes_category_default");
            $payment_method_result = $connect->query("SELECT payment_methods_default.name FROM finance_manager.payment_methods_default");
            $expenses_list_result = $connect->query("SELECT expenses_category_default.name FROM finance_manager.expenses_category_default");

            if (!$result_email) throw new Exception($connect->error);

            $number_of_the_same_nick_name = $result_email->num_rows;
            if ($number_of_the_same_nick_name > 0) {
                $validation_correct = false;
                $_SESSION['e_nick'] = "There is exists user with the same name.Please select another one !";
            }

            if ($validation_correct == true) {


                if ($connect->query("INSERT INTO finance_manager.users VALUES (NULL, '$login', '$password_hash', '$email')")) {

                    while ($row1 = mysqli_fetch_array($category_result))
                    {
                        $category_to_insert = $row1['name'];
                        @$connect->query("INSERT INTO finance_manager.incomes_category_assigned_to_users(incomes_category_assigned_to_users.id,incomes_category_assigned_to_users.user_id,incomes_category_assigned_to_users.name) values (null,'$user_id','$category_to_insert')");
                    }

                    while ($row1 = mysqli_fetch_array($payment_method_result))
                    {
                        $payment_method = $row1['name'];
                        @$connect->query("INSERT INTO finance_manager.payment_methods_assigned_to_users(payment_methods_assigned_to_users.id,payment_methods_assigned_to_users.user_id,payment_methods_assigned_to_users.name) values (null,'$user_id','$payment_method')");
                    }
                    while ($row1 = mysqli_fetch_array( $expenses_list_result))
                    {
                        $expenses_list = $row1['name'];
                        @$connect->query("INSERT INTO finance_manager.expenses_category_assigned_to_users(expenses_category_assigned_to_users.id,expenses_category_assigned_to_users.user_id,expenses_category_assigned_to_users.name) values (null,'$user_id','$expenses_list')");
                    }

                    $_SESSION['registration_ok'] = true;
                    header('Location: login_page.php');

                } else {
                    throw new Exception($connect->error);
                }
            }
            $connect->close();
        }
    } catch (Exception $e) {
        echo '<span style="color:red;">Server error!</span>';
        echo '<br />Developer information: ' . $e;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title>Application registration</title>
    <meta name="description" content="Login page"/>
    <meta name="keywords" content="css, login"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css" type="text/css"/>

<body>
</head>
<div class="container">
    <div class="row">
        <div class="col-sm-6"><img src="img/finance.jpg" alt="logo" width=97% height=100%
                                   style=" padding-top: 10px; padding-left: 15px"/></div>
        <div class="col-sm-6" style="padding-top: 10px; padding-right: 30px; padding-left: 27px">
            <div id="login" style="width: 100%;height: 100%">
                <form method="post">

                    <input type="text" placeholder="login" name="login" onfocus="this.placeholder=''"
                           onblur="this.placeholder='login'">
                    <?php
                    if (isset($_SESSION['error_login'])) {
                        echo '<div class = "error">' . $_SESSION['error_login'] . '</div>';
                        unset($_SESSION['error_login']);
                    }
                    ?>

                    <input type="password" name="password" placeholder="password" onfocus="this.placeholder=''"
                           onblur="this.placeholder='password'">
                    <?php
                    if (isset($_SESSION['error_password'])) {
                        echo '<div class = "error">' . $_SESSION['error_password'] . '</div>';
                        unset($_SESSION['error_password']);
                    }
                    ?>
                    <input type="text" placeholder="email" name="email" onfocus="this.placeholder=''"
                           onblur="this.placeholder='email'">
                    <?php
                    if (isset($_SESSION['error_email'])) {
                        echo '<div class = "error">' . $_SESSION['error_email'] . '</div>';
                        unset($_SESSION['error_email']);
                    }
                    ?>
                    <input type="submit" value="Sign me up">
                </form>
            </div>
        </div>

    </div>
</div>
</body>
</html>
