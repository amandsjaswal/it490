<?php
session_start();
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
        <?php
        if(isset($_SESSION['logged_out'])){
            ?>
            <div class="col-md-12 alert alert-success" style="text-align: center;" role="alert">
                <span><?php echo $_SESSION['logged_out'];?></span>
            </div>
            <?php
            session_destroy();
        }
        ?>
        <?php
        if(isset($_SESSION['reg_success'])){
            ?>
            <div class="col-md-12 alert alert-success" style="text-align: center;" role="alert">
                <span><?php echo $_SESSION['reg_success'];?></span>
            </div>
            <?php
            unset($_SESSION['reg_success']);
        }
        ?>
        <br><br>
        <div class="offset-md-3 col-md-6"  style="text-align: center;">
            <h2>
                Welcome to spoonacular
            </h2>
            <p>
                We are a highly convinient online food store. We deliver food to your door step in time.
            </p>
            <a href="select.php" class="btn btn-lg btn-success">
                Order Food
            </a>
        </div>
    </div>
</div>
</body>
</html>
