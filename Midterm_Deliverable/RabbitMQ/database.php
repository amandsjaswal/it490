<?php
$connection = mysqli_connect('localhost', 'aj', 'aj123');
if (!$connection){
    die("Database Connection Failed" . mysqli_error($connection));
}
$select_db = mysqli_select_db($connection, 'rabbitMQ');
if (!$select_db){
    die("Database Selection Failed" . mysqli_error($connection));
}
