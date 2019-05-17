<?php
session_start();

require_once "vendor/autoload.php";
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

        $price = $_POST['price-'.$_GET['id']];
        $calories = $_POST['calories-'.$_GET['id']];
        $food_id = $_POST['food_id-'.$_GET['id']];
        $title = $_POST['title-'.$_GET['id']];

        $_SESSION['food_id'] = $food_id;

        $api = new ApiContext(
            new OAuthTokenCredential(
                'Aeppz3pjORUjyrXGAPC8zzJMD-6PjBGw5gMYC0MNj-Wq-noZIhq-Kep74bRX2TgA45Snrk8Zv7FkRk_d',
                'EBhnQ4cHxKU2DvXCCI8GEXHXop-TqrxD7EK9w-2FljvMWBvODOxBiZj-jIYxwGpmyBV7qg_sAonphR46'
            )
        );

        $api->setConfig([
            'mode' => 'sandbox',
            'http.ConnectionTimeOut' => '30',
            'log.LogEnabled' => false,
            'log.FileName' => '',
            'log.LogLevel' => 'FINE',
            'validation.level' => 'log',
        ]);


        $payer = new Payer();
        $amount = new Amount();
        $details = new Details();
        $transaction = new Transaction();
        $payment = new Payment();
        $redirecturls = new RedirectUrls();

        //payer
        $payer->setPaymentMethod('paypal');

        //details
        $details->setShipping('0.00')->setTax('0.00')->setSubtotal($price);

        //amount
        $amount->setCurrency('USD')->setTotal($price)->setDetails($details);

        //transaction
        $transaction->setAmount($amount)->setDescription($title);

        //payment
        $payment->setIntent('sale')->setPayer($payer)->setTransactions([$transaction]);

        //redirect urls
        $url = "http://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
        $host = explode("paypal.php",$url)[0];
        $redirecturls->setReturnUrl($host.'success.php')->setCancelUrl($host.'cancel.php');

        $payment->setRedirectUrls($redirecturls);

        try {
            $payment->create($api);
            //generate and store hash
            $hash = md5($payment->getId());
            $_SESSION['paypal_hash'] = $hash;
            $_SESSION['title'] = $title;


            require_once "functions.php";


            if(ExecuteDb("INSERT INTO paypal_transactions(id,user_id,payment_id,hash,price) VALUES (?,?,?,?,?)",[NULL,$_SESSION['user_id'],$payment->getId(),$hash,$price])){
                if($_SESSION['meal_plan']){
                    $row = fetch("SELECT * FROM food_plan WHERE user_id=? AND d_date=?",[$_SESSION['user_id'],date("d, F Y")])[0];
                    $fid = $row["food_id"];
                    $ids = explode(",",$fid);
                    $new_fid = "";
                    foreach ($ids as $id){
                        if(trim($id)!="" && trim($id)!=$food_id){
                            $new_fid .= $id.",";
                        }
                    }
                    if(ExecuteDb("UPDATE food_plan SET food_id=? WHERE user_id=? AND d_date=?",[$new_fid,$_SESSION['user_id'],date("d, F Y")])){
                        unset($_SESSION['meal_plan']);
                    }
                }

                header("location:{$payment->getApprovalLink()}");
            }

        } catch (PayPalConnectionException $e) {
            unset($_SESSION['title']);
            unset($_SESSION['paypal_hash']);
            $_SESSION['paypal_error'] = $e->getMessage();

            header("location:purchase.php?food_id={$food_id}");
        }

    }else{
        header("location:index.php");
    }
}else{
    header("location:index.php");
}