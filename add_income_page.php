<?php
session_start();
require_once "connect.php";
mysqli_report(MYSQLI_REPORT_STRICT);

$connect = new mysqli($host, $db_user, $db_password, $db_name);
$user_id = $_SESSION['id'];
$category_query = "SELECT * FROM incomes_category_assigned_to_users WHERE user_id = '$user_id' ";
$result = mysqli_query($connect, $category_query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title>Add income</title>
    <meta name="description" content="Add income page"/>
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
                        <li><a href="home_page.php">Home</a></li>
                        <li class="active"><a href="add_income_page.php">Add Income</a></li>
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
    </nav>

    <div class="content_add" style="padding: 15px">
        <form method="post" action="insert_amount.php">

            <div class="form-group">
                <label>
                    Amount:
                </label>
                <input type="number" step="0.01"  value="0" name="amount">
            </div>
            <div class="form-group">
                <label>
                    Date:
                </label>
                <input type="date" id="myDate" value="<?php echo date('Y-m-d'); ?>" name="date">
            </div>
            <div class="form-check">
                <div>
                    <label>
                        Category:
                    </label>
                </div>

                <?php while ($row1 = mysqli_fetch_array($result)):; ?>
                    <input type="radio" name="category" value="<?php echo $row1['id']; ?>"><label
                            style="padding: 10px; font-weight: 100 "><?php echo $row1['name']; ?></label>
                <?php endwhile; ?>

            </div>

            <div class="form-group">
                <label>
                    Comment:
                </label>
                <input type="text" name="comment" id="comment" style="width: 100%;">
            </div>
            <div class="form-group">
                <input type="submit" value="Add income">
                <input type="submit" value="Cancel">
            </div>
        </form>
    </div>
</div>
</div>
</div>
</body>
</html>

