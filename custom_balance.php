<?php
session_start();
require_once "connect.php";

$user_id = $_SESSION['id'];
mysqli_report(MYSQLI_REPORT_STRICT);

$connect = new mysqli($host, $db_user, $db_password, $db_name);

$expenses_category_number = ("SELECT expenses_category_assigned_to_users.name name ,count(expenses_category_assigned_to_users.name) count FROM finance_manager.expenses LEFT OUTER JOIN finance_manager.expenses_category_assigned_to_users ON expenses.expense_category_assigned_to_user_id = expenses_category_assigned_to_users.id where expenses.user_id = '$user_id' GROUP BY expenses_category_assigned_to_users.name");

$result_expenses_category_number = mysqli_query($connect, $expenses_category_number);

$user_id = $_SESSION['id'];

$connect = @new mysqli($host, $db_user, $db_password, $db_name);

$date_begin = $_POST['date_begin'];
$date_end = $_POST['date_end'];

$query = "SELECT incomes.amount, incomes_category_assigned_to_users.name, incomes.date_of_income, incomes.income_comment FROM finance_manager.incomes LEFT OUTER JOIN finance_manager.incomes_category_assigned_to_users ON incomes.income_category_assigned_to_user_id = incomes_category_assigned_to_users.id WHERE incomes.user_id = '$user_id' AND   incomes.date_of_income >=$date_begin AND incomes.date_of_income <=$date_end";

$income_result = $connect->query($query);

$query = "SELECT expenses.amount, payment_methods_assigned_to_users.name, expenses.date_of_expense, expenses_category_assigned_to_users.name name2, expenses.expense_comment FROM finance_manager.expenses LEFT OUTER JOIN finance_manager.expenses_category_assigned_to_users ON expenses.expense_category_assigned_to_user_id = expenses_category_assigned_to_users.id LEFT OUTER JOIN finance_manager.payment_methods_assigned_to_users ON expenses.payment_method_assigned_to_user_id = payment_methods_assigned_to_users.id WHERE expenses.user_id = '$user_id' AND   expences.date_of_expence >=$date_begin AND expences.date_of_expence <=$date_end";



$expense_result = $connect->query($query);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title>Balance page</title>
    <meta name="description" content="Balance page"/>
    <meta name="keywords" content="css, login"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="main_style.css" type="text/css"/>


    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {'packages': ['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Expenses', 'Expenses number'],
                <?php
                while ($row1 = mysqli_fetch_array($result_expenses_category_number)) {
                    echo "['" . $row1["name"] . "', " . $row1["count"] . "],";
                }
                ?>
            ]);
            var options = {
                pieHole: 0.1,
            };
            var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
            chart.draw(data, options);
        }
    </script>

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
                        <li class="active"><a href="balance_page.php">Show balance</a></li>
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

    <div class="container">



        <div class="row">

            <div class="col-xs-12 col-md-3 col-lg-3" style="float: right; padding-right: 3%">

                <form class="form-inline" method="POST" action="balance_page.php">
                    <div>
                    <label> Custom begin date: </label>

                    <input type="date"  value="<?php echo date('Y-m-d'); ?>" name="date_begin">
                    </div>
                <div>
                    <label> Custom end date: </label>

                    <input type="date"  value="<?php echo date('Y-m-d'); ?>" name="date_end">
                </div>
                    <input type="submit" class="btn btn-primary btn-xs"  value="show balance">
                </form>
            </div>
            <div class="col-md-6 col-lg-6" style="padding-top: 25px; float: left; width: 100%">
                <table class="table">
                    <tr>
                        <th>Amount</th>
                        <th>Category</th>
                        <th>Date</th>
                        <th>Comment</th>
                    </tr>
                    <?php
                    if(isset($period)) {
                        while ($row1 = $income_result->fetch_assoc()) {
                            echo "<tr><td>" . $row1['amount'] . "</td><td>" . $row1['name'] . "</td><td>" . $row1['date_of_income'] . "</td><td>" . $row1['income_comment'] . "</td></tr>";
                        }
                        echo "</table>";
                        $connect->close();
                    }
                    ?>
                </table>

            </div>


        </div>

        <div class="row" style="height: 100px">
        </div>

        <div class="row">

            <div class="col-md-6 col-lg-6" style=" width: 100%">
                <table class="table">
                    <tr>
                        <th>Amount</th>
                        <th>Payment method</th>
                        <th>Date</th>
                        <th>Category</th>
                        <th>Comment</th>
                    </tr>

                    <?php

                    if(isset($period)){
                        while ($row1 = $expense_result->fetch_assoc()) {
                            echo "<tr><td>" . $row1['amount'] . "</td><td>" . $row1['name'] . "</td><td>" . $row1['date_of_expense'] . "</td><td>" . $row1['name2'] . "</td><td>" . $row1['expense_comment'] . "</td></tr>";
                        }
                        echo "</table>";
                    }
                    ?>


                </table>
            </div>
            <div class="col-md-6 col-lg-6">
                <label style="padding-left: 10px">Your balance is: </label>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 ">
                <div id="donutchart"
                     style="position: relative; height:40vh; width:80vw; padding-top: 40px; float: left"></div>

                <canvas id="chart"></canvas>
            </div>

        </div>
    </div>

</div>
</div>
</body>
</html>