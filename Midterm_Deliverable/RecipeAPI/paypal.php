<?php
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Exception\PayPalConnectionException;
use PayPal\Rest\ApiContext;

if(isset($_SESSION['email'])){
    if(isset($_POST['purchase'])){



        $api = new ApiContext(
            new OAuthTokenCredential(
                '',
                ''
            )
        );




    }else{
        header("location:index.php");
    }
}else{
    header("location:index.php");
}