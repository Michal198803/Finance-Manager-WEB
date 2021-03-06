<?php
if (!isset($_SESSION['id']))
    header('Location: login_page.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title>Balance page</title>
    <meta name="description" content="Setup page"/>
    <meta name="keywords" content="css, login"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="main_style.css" type="text/css"/>

</head>
<body>
<div class="container">
    <div class="col-sm-12">

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
                        <li><a href="home_page.php">Home</a></li>
                        <li><a href="add_income_page.php">Add Income</a></li>
                        <li><a href="add_expense_page.php">Add Expense</a></li>
                        <li><a href="balance_page.php">Show balance</a></li>
                        <li class="active"><a href="Setup_page.php">Setup </a></li>
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

    <div class="container">
        <div class="row">

            <div class="col-md-6 col-lg-6" style="padding-top: 25px; float: left; width: 100%">
                <table class="table">
                    <tr>
                        <td>User information</td>
                        <td><a href="*">Edit</a></td>

                    </tr>
                    <tr>
                        <td>Income list</td>
                        <td><a href="*">Edit</a></td>
                    </tr>
                    <tr>
                        <td>Expense list</td>
                        <td><a href="*">Edit</a></td>
                    </tr>
                    <tr>
                        <td>Payment method list</td>
                        <td><a href="*">Edit</a></td>
                    </tr>

                </table>
            </div>
        </div>

    </div>
</div>
</body>
</html>