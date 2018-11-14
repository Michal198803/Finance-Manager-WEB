<?php
session_start();
if (!isset($_SESSION['id']))
    header('Location: login_page.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title>Home page</title>
    <meta name="description" content="Home page"/>
    <meta name="keywords" content="css, login"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="main_style.css" type="text/css"/>

</head>
<body>
<div class="container">
    <div class="col-lg-12">

        <nav class="navbar navbar-inverse">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="#">Finance Manager 1.0</a>
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                            data-target="#bs-navbar-collapse-1" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
                <div class="collapse navbar-collapse" id="bs-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="home_page.html">Home</a></li>
                        <li><a href="add_income_page.php">Add Income</a></li>
                        <li><a href="add_expense_page.php">Add Expense</a></li>
                        <li><a href="balance_page.php">Show balance</a></li>
                        <li><a href="Setup_page.php">Setup </a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Log out</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <script src="https://code.jquery.com/jquery-2.1.4.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    </div>

    <div class="col-lg-12">
        <img src="img/finance.jpg" style="width:100%;">
    </div>
</div>
</body>
</html>