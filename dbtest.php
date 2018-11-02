<?php
/**
 * Created by PhpStorm.
 * User: Michal
 * Date: 20.10.2018
 * Time: 18:16
 */
session_start();
require_once "connect.php";
mysqli_report(MYSQLI_REPORT_STRICT);

$con = mysqli_connect('localhost','root','');
if(!$con)
{
    echo 'blad polaczenia';
}

if(!mysqli_select_db($con,'finance_manager'))
{
    echo'blad logowania do finance';

}

$sql = "INSERT INTO USERS()"