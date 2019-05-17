<?php
session_start();
require_once "vendor/autoload.php";
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;

if(isset($_SESSION['paypal_hash'])){
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


    $payerId = $_GET['PayerID'];

    //getPayment Id from database
    require_once "functions.php";
    $paymentID = fetch("SELECT * FROM paypal_transactions WHERE hash=?",[$_SESSION['paypal_hash']])[0]['payment_id'];

    //get the paypal payment
    $payment = Payment::get($paymentID, $api);

    $execution = new PaymentExecution();
    $execution->setPayerId($payerId);

    //execute paypal payment
    $payment->execute($execution, $api);


    //update transaction
    if(ExecuteDb("UPDATE paypal_transactions SET complete=? WHERE payment_id=?",[1,$paymentID])){
        //update purchased table
        if(ExecuteDb("INSERT INTO purchases(id,user_id,food_id) VALUES (?,?,?)",[NULL,$_SESSION['user_id'],$_SESSION['food_id']])){
            unset($_SESSION['paypal_hash']);
            ?>
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <title>Title</title>
                <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
                <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
                <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
            </head>
            <body>
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <a class="navbar-brand" href="index.php" style="color: #b6b6b6;">Spoonacular</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <a class="nav-link active" href="index.php">Home <span class="sr-only">(current)</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="select.php">Order food<span></a>
                        </li>
                    </ul>
                    <?php if(isset($_SESSION['email'])){
                        ?>
                        <a href="logout.php" class="btn btn-danger">Logout</a>
                        &nbsp;
                        <?php
                    }else{
                        ?>
                        <a href="login.php" class="btn btn-primary">Login</a>
                        &nbsp;
                        <a href="register.php" class="btn btn-secondary">Register</a>
                        <?php
                    }?>
                </div>
            </nav>
            <div class="container">
                <div class="row">
                    <div class="offset-md-3 col-md-6"  style="text-align: center;">
                        <div class="alert alert-success" role="alert" style="text-align: center;">
                            <span>Paypal payment successful</span>
                        </div>
                        <h2>
                            Set delivery location
                        </h2>
                        <form action="complete.php" method="post">
                            <div class="form-group">
                                <label for="location">Location</label>
                                <input name="location" id="location" type="text" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-success" type="submit" name="complete">
                                    Submit
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            </body>
            </html>
            <?php
        }
    }

}else{
    header("location:logout.php");
}