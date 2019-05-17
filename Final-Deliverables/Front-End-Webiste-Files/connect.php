<?php
error_reporting(E_ALL ^ E_NOTICE);
$date=date("d, F Y");
try{
    $db=new PDO('mysql:host=192.168.1.11;dbname=spoonacular;charset=utf8','karm','User@8642');
}
catch(Exception $e){
    echo $e->getMessage();
}
