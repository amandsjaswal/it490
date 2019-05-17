<?php
session_start();
if(isset($_SESSION['food_id'])){
    unset($_SESSION['title']);
    unset($_SESSION['paypal_hash']);

    header("location:purchase.php?food_id={$_SESSION['food_id']}"); #this is a comment 
}else{
    header("location:logout.php");
}



#hello


