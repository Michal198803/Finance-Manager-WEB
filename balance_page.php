<?php
session_start();
require_once "connect.php";

$user_id = $_SESSION['id'];
mysqli_report(MYSQLI_REPORT_STRICT);

$connect = @new mysqli($host, $db_user, $db_password, $db_name);

if (isset($_POST['period'])) {
    $_SESSION['period'] = $_POST['period'];
    $period = $_POST['period'];

} else {
    $period = 1;
    $_SESSION['period'] = 1;
}
if (isset($_POST['date_begin'])) {
    $date_begin = $_POST['date_begin'];
    $date_end = $_POST['date_end'];
    $period = 4;
}

switch ($period) {

    case 1:
        $query = "SELECT incomes.amount, incomes_category_assigned_to_users.name, incomes.date_of_income, incomes.income_comment FROM finance_manager.incomes LEFT OUTER JOIN finance_manager.incomes_category_assigned_to_users ON incomes.income_category_assigned_to_user_id = incomes_category_assigned_to_users.id WHERE incomes.user_id = '$user_id' AND EXTRACT(YEAR_MONTH FROM incomes.date_of_income) = EXTRACT(YEAR_MONTH FROM current_date) order by incomes.amount desc ";
        $income_result = $connect->query($query);
        break;
    case 2:
        $query = "SELECT incomes.amount, incomes_category_assigned_to_users.name, incomes.date_of_income, incomes.income_comment FROM finance_manager.incomes LEFT OUTER JOIN finance_manager.incomes_category_assigned_to_users ON incomes.income_category_assigned_to_user_id = incomes_category_assigned_to_users.id WHERE incomes.user_id = '$user_id' AND EXTRACT(YEAR_MONTH FROM incomes.date_of_income) = EXTRACT(YEAR_MONTH FROM current_date) - 1 order by incomes.amount desc ";
        $income_result = $connect->query($query);
        break;
    case 3:
        $query = "SELECT incomes.amount, incomes_category_assigned_to_users.name, incomes.date_of_income, incomes.income_comment FROM finance_manager.incomes LEFT OUTER JOIN finance_manager.incomes_category_assigned_to_users ON incomes.income_category_assigned_to_user_id = incomes_category_assigned_to_users.id WHERE incomes.user_id = '$user_id'AND YEAR(incomes.date_of_income) = YEAR(current_date) order by incomes.amount desc ";
        $income_result = $connect->query($query);
        break;

    case 4:
        if (isset($_POST['date_begin'])) {
            $date_begin = $_POST['date_begin'];
            $date_end = $_POST['date_end'];
            $query = "SELECT incomes.amount, incomes_category_assigned_to_users.name, incomes.date_of_income, incomes.income_comment FROM finance_manager.incomes LEFT OUTER JOIN finance_manager.incomes_category_assigned_to_users ON incomes.income_category_assigned_to_user_id = incomes_category_assigned_to_users.id WHERE incomes.user_id = '$user_id' AND   incomes.date_of_income >='$date_begin' AND incomes.date_of_income <='$date_end' order by incomes.amount desc ";
            $income_result = $connect->query($query);
            unset($date_begin);
            unset($date_end);
        }
        break;
}

switch ($period) {

    case 1:
        $query = "SELECT expenses.amount, payment_methods_assigned_to_users.name, expenses.date_of_expense, expenses_category_assigned_to_users.name name2, expenses.expense_comment FROM finance_manager.expenses LEFT OUTER JOIN finance_manager.expenses_category_assigned_to_users ON expenses.expense_category_assigned_to_user_id = expenses_category_assigned_to_users.id LEFT OUTER JOIN finance_manager.payment_methods_assigned_to_users ON expenses.payment_method_assigned_to_user_id = payment_methods_assigned_to_users.id WHERE expenses.user_id = '$user_id' AND EXTRACT(YEAR_MONTH FROM expenses.date_of_expense) = EXTRACT(YEAR_MONTH FROM current_date) order by expenses.amount desc ";
        $expenses_category_number = ("SELECT expenses_category_assigned_to_users.name name ,SUM(expenses.amount) count FROM finance_manager.expenses LEFT OUTER JOIN finance_manager.expenses_category_assigned_to_users ON expenses.expense_category_assigned_to_user_id = expenses_category_assigned_to_users.id where expenses.user_id = '$user_id' AND EXTRACT(YEAR_MONTH FROM expenses.date_of_expense) = EXTRACT(YEAR_MONTH FROM current_date) GROUP BY expenses_category_assigned_to_users.name");
        $result_expenses_category_number = mysqli_query($connect, $expenses_category_number);
        $expense_result = $connect->query($query);
        break;
    case 2:
        $query = "SELECT expenses.amount, payment_methods_assigned_to_users.name, expenses.date_of_expense, expenses_category_assigned_to_users.name name2, expenses.expense_comment FROM finance_manager.expenses LEFT OUTER JOIN finance_manager.expenses_category_assigned_to_users ON expenses.expense_category_assigned_to_user_id = expenses_category_assigned_to_users.id LEFT OUTER JOIN finance_manager.payment_methods_assigned_to_users ON expenses.payment_method_assigned_to_user_id = payment_methods_assigned_to_users.id WHERE expenses.user_id = '$user_id'  AND EXTRACT(YEAR_MONTH FROM expenses.date_of_expense) = EXTRACT(YEAR_MONTH FROM current_date) -1 order by expenses.amount desc";
        $expenses_category_number = ("SELECT expenses_category_assigned_to_users.name name ,SUM(expenses.amount) count FROM finance_manager.expenses LEFT OUTER JOIN finance_manager.expenses_category_assigned_to_users ON expenses.expense_category_assigned_to_user_id = expenses_category_assigned_to_users.id where expenses.user_id = '$user_id' AND EXTRACT(YEAR_MONTH FROM expenses.date_of_expense) = EXTRACT(YEAR_MONTH FROM current_date) - 1 GROUP BY expenses_category_assigned_to_users.name");
        $result_expenses_category_number = mysqli_query($connect, $expenses_category_number);
        $expense_result = $connect->query($query);
        break;
    case 3:
        $query = "SELECT expenses.amount, payment_methods_assigned_to_users.name, expenses.date_of_expense, expenses_category_assigned_to_users.name name2, expenses.expense_comment FROM finance_manager.expenses LEFT OUTER JOIN finance_manager.expenses_category_assigned_to_users ON expenses.expense_category_assigned_to_user_id = expenses_category_assigned_to_users.id LEFT OUTER JOIN finance_manager.payment_methods_assigned_to_users ON expenses.payment_method_assigned_to_user_id = payment_methods_assigned_to_users.id WHERE expenses.user_id = '$user_id' AND YEAR(expenses.date_of_expense) = YEAR(current_date) order by expenses.amount desc";
        $expenses_category_number = ("SELECT expenses_category_assigned_to_users.name name ,SUM(expenses.amount) count FROM finance_manager.expenses LEFT OUTER JOIN finance_manager.expenses_category_assigned_to_users ON expenses.expense_category_assigned_to_user_id = expenses_category_assigned_to_users.id  WHERE expenses.user_id = '$user_id' AND YEAR(expenses.date_of_expense) = YEAR(current_date) GROUP BY expenses_category_assigned_to_users.name");
        $result_expenses_category_number = mysqli_query($connect, $expenses_category_number);
        $expense_result = $connect->query($query);
        break;

    case 4:
        if (isset($_POST['date_begin'])) {
            $date_begin = $_POST['date_begin'];
            $date_end = $_POST['date_end'];
            $query = "SELECT expenses.amount, payment_methods_assigned_to_users.name, expenses.date_of_expense, expenses_category_assigned_to_users.name name2, expenses.expense_comment FROM finance_manager.expenses LEFT OUTER JOIN finance_manager.expenses_category_assigned_to_users ON expenses.expense_category_assigned_to_user_id = expenses_category_assigned_to_users.id LEFT OUTER JOIN finance_manager.payment_methods_assigned_to_users ON expenses.payment_method_assigned_to_user_id = payment_methods_assigned_to_users.id WHERE expenses.user_id = '$user_id' AND   expenses.date_of_expense >='$date_begin' AND expenses.date_of_expense <='$date_end' order by expenses.amount desc";
            $expenses_category_number = ("SELECT expenses_category_assigned_to_users.name name ,SUM(expenses.amount) count FROM finance_manager.expenses LEFT OUTER JOIN finance_manager.expenses_category_assigned_to_users ON expenses.expense_category_assigned_to_user_id = expenses_category_assigned_to_users.id  WHERE expenses.user_id = '$user_id' AND   expenses.date_of_expense >='$date_begin' AND expenses.date_of_expense <='$date_end' GROUP BY expenses_category_assigned_to_users.name");
            $result_expenses_category_number = mysqli_query($connect, $expenses_category_number);

            $expense_result = $connect->query($query);
        }

        break;
}


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
            <form method="POST" action="balance_page.php">

                <?php
                if (isset($_POST['period'])) {

                    if ($_POST['period'] == 4) {
                        echo "<form method=\"POST\" action=\"balance_page.php\">
<div class=\"col-xs-12 col-md-3 col-lg-3\" style=\"float: left; padding-right: 3%\">
                    <label>
                        Custom begin date:
                    </label>
                    <input type=\"date\" value=\"<?php echo date('Y-m-d'); ?>\" name=\"date_begin\">
                    <label>
                        Custom end date:
                    </label>
                    <input type=\"date\" value=\"<?php echo date('Y-m-d'); ?>\" name=\"date_end\">
                       <input type=\"submit\" value=\"apply\">
                </div></form>";
                    }
                }
                ?>

                <div class="col-xs-12 col-md-3 col-lg-3" style="float: right; padding-right: 3%">

                    <label>Please select period: </label>
                    <select name="period">
                        <option name="period" value="1">Current month</option>
                        <option name="period" value="2">Last month</option>
                        <option name="period" value="3">This year</option>
                        <option name="period" value="4">Custom</option>
                    </select>
                    <input type="submit" class="btn btn-primary btn-xs" value="show balance">
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
                if (isset($income_result) or isset($_POST['date_begin'])) {

                    while ($row1 = $income_result->fetch_assoc()) {
                        echo "<tr><td>" . $row1['amount'] . "</td><td>" . $row1['name'] . "</td><td>" . $row1['date_of_income'] . "</td><td>" . $row1['income_comment'] . "</td></tr>";

                        if (!isset($_SESSION['incomes_count'])) {
                            $_SESSION['incomes_count'] = 0;
                        }

                        $_SESSION['incomes_count'] += $row1['amount'];
                    }
                    echo "</table>";
                    $connect->close();
                }
                ?>
            </table>

        </div class="row" style="float: left
        ;
            width: 100%">

        <div class="col-md-6 col-lg-6" style="float: left; width: 100%">
            <label><?php
                echo "Your income is: " . $_SESSION['incomes_count'] . " PLN";
                ?> </label>
        </div>
    </div>
    <div class="row">

        <div class="col-md-6 col-lg-6" style="padding-top: 25px; float: left; width: 100%">
            <table class="table">
                <tr>
                    <th>Amount</th>
                    <th>Payment method</th>
                    <th>Date</th>
                    <th>Category</th>
                    <th>Comment</th>
                </tr>

                <?php

                if (isset($expense_result) or isset($_POST['date_begin'])) {
                    while ($row1 = $expense_result->fetch_assoc()) {

                        if (!isset($_SESSION['expenses_count'])) {
                            $_SESSION['expenses_count'] = 0;
                        }

                        echo "<tr><td>" . $row1['amount'] . "</td><td>" . $row1['name'] . "</td><td>" . $row1['date_of_expense'] . "</td><td>" . $row1['name2'] . "</td><td>" . $row1['expense_comment'] . "</td></tr>";
                        $_SESSION['expenses_count'] += $row1['amount'];
                    }
                    echo "</table>";
                }
                ?>

            </table>
        </div class="row">

        <div class="col-md-6 col-lg-6">
            <label><?php
                echo "Your income is: " . $_SESSION['expenses_count'] . " PLN";
                ?></label>
        </div>
    </div>
</div class="row">

<div class="col-md-6 col-lg-6">
    <?php
    $_SESSION['balance'] = $_SESSION['incomes_count'] - $_SESSION['expenses_count'];
    if ($_SESSION['balance'] > 0) {
        echo '<label style="color:green">' . "Your balance is: " . $_SESSION['balance'] . " PLN" . " Your balance is positive! Keep it up !" . "</label>";
    } else
        echo '<label style="color:red">' . "Your balance is: " . $_SESSION['balance'] . " PLN" . " Your balance is negative! Organise better your budget !" . "</label>";

    $_SESSION['incomes_count'] = 0;
    $_SESSION['expenses_count'] = 0;
    $_SESSION['balance'] = 0;
    ?>
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