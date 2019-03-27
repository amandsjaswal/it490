<?php
session_start();
require_once "functions.php";
$stringToFile = $_SESSION['email'].",".$_SESSION['username'].",".date('m/d/Y h:i:s a', time())."\n";
writeToFile("logout_logs.txt",$stringToFile);
session_destroy();
session_start();
$_SESSION['logged_out'] = "Successfully logged out";
header("location:index.php");