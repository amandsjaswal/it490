<?php
error_reporting(E_ALL ^ E_NOTICE);
$date=date("d, F Y");
try{
    $db=new PDO('mysql:host=localhost;dbname=spoonacular;charset=utf8','root','');
}
catch(Exception $e){
    echo $e->getMessage();
}