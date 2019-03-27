<?php
session_start();
if(isset($_SESSION)){
    session_destroy();
}
$errors = [];
if(isset($_POST['login'])){
    $email = trim($_POST['email']);
    $pass = trim($_POST['pass']);
    if($email&&$pass){
        require_once "functions.php";
        $hpass = md5($pass);
        if(inDb("SELECT * FROM users WHERE email=?",[$email])){
            $rows = fetch("SELECT * FROM users WHERE email=?",[$email]);
            if($rows[0]["password"]==$hpass){
                session_start();
                $_SESSION['user_id'] = $rows[0]["id"];
                $_SESSION['email']=$rows[0]["email"];
                $_SESSION['username']=$rows[0]["username"];
                $stringToFile = $_SESSION['email'].",".$_SESSION['username'].",".date('m/d/Y h:i:s a', time())."\n";
                writeToFile("login_logs.txt",$stringToFile);
                header("location:select.php");
            }else{
                array_push($errors,"Wrong password");
            }
        }else{
            array_push($errors,"User with that email not found");
        }
    }else{
        array_push($errors,"Please fill all the fields");
    }
}

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
                <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
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
            &nbsp;
            <?php
        }?>
    </div>
</nav>
<div class="container">
    <div class="row">
        <div class="offset-md-3 col-md-6">
            <h3 style="text-align: center;">Login</h3>
            <?php
            if(count($errors)>0){
                foreach ($errors as $error) {
                    ?>
                    <div class="alert alert-danger col-md-12" role="alert" style="text-align: center;">
                        <span><?php echo $error; ?></span>
                    </div>
                    <?php
                }
            }
            ?>
            <form method="post" action="login.php">
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input id="email" name="email" type="email" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input id="password" name="pass" type="password" class="form-control" required>
                </div>
                <div class="form-group">
                    <button class="btn btn-success" type="submit" name="login">Login</button>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>