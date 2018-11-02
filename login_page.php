<?php

session_start();

if ((isset($_SESSION['online'])) && ($_SESSION['online']==true))
{
    header('Location: home_page.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title>Login page</title>
    <meta name="description" content="Login page"/>
    <meta name="keywords" content="css, login"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css" type="text/css"/>

</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-sm-6"><img src="img/finance.jpg" alt="logo" width=97% height=100%
                                   style=" padding-top: 10px; padding-left: 15px"/></div>
        <div class="col-sm-6" style="padding-top: 10px; padding-right: 30px; padding-left: 27px">
            <div id="login" style="width: 100%;height: 100%">

                <form method="post" action="login_to_page.php">

                    <input type="text" name="login" placeholder="login" onfocus="this.placeholder=''"
                           onblur="this.placeholder='login'">

                    <input type="password" name="password" placeholder="password" onfocus="this.placeholder=''"
                           onblur="this.placeholder='password'">

                    <input type="submit" value="Log in">

                </form>
                <?php
                if(isset($_SESSION['error']))
                    echo $_SESSION['error'];
                ?>
            </div>
        </div>

    </div>
</div>
</body>
</html>