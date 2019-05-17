<?php
session_start();
if(isset($_SESSION['email'])){
    if(isset($_GET['food_id'])){

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
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="select.php">Select Calories</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="select.php">Results</span></a>
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

                <div class="offset-md-3 col-md-6">
                    <?php
                    if(isset($_SESSION['paypal_error'])){
                        ?>
                        <div class="alert alert-danger col-md-12" role="alert" style="text-align: center;">
                            <span><?php echo $_SESSION['paypal_error']; ?></span>
                        </div>
                        <?php
                        unset($_SESSION['paypal_error']);
                        unset($_SESSION['food_id']);
                    }
                    if(isset($_SESSION['paypal_cancel'])){
                        ?>
                        <div class="alert alert-success col-md-12" role="alert" style="text-align: center;">
                            <span><?php echo $_SESSION['paypal_cancel']; ?></span>
                        </div>
                        <?php
                        unset($_SESSION['paypal_cancel']);
                        unset($_SESSION['food_id']);
                    }

                    ?>
                </div>

            </div>
        </div>
        </body>
        </html>
        <?php
    }else{
        header("location:results.php");
    }
}else{
    header("location:login.php");
}