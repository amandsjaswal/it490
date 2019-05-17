<?php
session_start();
if(isset($_SESSION['email'])){
    $errors = [];
    $day_calories=0;
    $done = false;

    require_once "functions.php";
    //$date=date("d, F Y");
    if(inDb("SELECT * FROM calories WHERE user_id=? AND d_date=?",[$_SESSION['user_id'],date("d, F Y")])){
        $rows = fetch("SELECT * FROM calories WHERE user_id=? AND d_date=?",[$_SESSION['user_id'],date("d, F Y")]);

        foreach ($rows as $row){
            $day_calories += intval($row["calories"]);
        }
    }

    if($day_calories==2000){
        $done = true;
    }

    if(isset($_POST['browse'])){
        $calories = trim($_POST['calories']);
        if($calories){
            if(intval($calories)+$day_calories <= 2000){
                $_SESSION['calories']=$calories;
                header("location:results.php");
            }else{
                array_push($errors,"Calories too high. Enter a value less than <b>".(2000-$day_calories)."</b>");
            }
        }else{
            array_push($errors,"Please enter the calories");
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
                    <a class="nav-link" href="index.php">Home</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="select.php">Select Calories<span>(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="favourite.php">Favourites<span></a>
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
                <div class="col-md-12">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <a style="float: right;" class="btn btn-warning pull-left" href="meal-plan.php">Meal Plan</a>
                        </div>
                        <div class="form-group col-md-6">
                            <a style="float: right;" class="btn btn-primary pull-right" href="featured-content.php">Featured Meals</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-12" style="margin-bottom: 20px;text-align: center;">
                    <h3>Calories Consumed Today</h3>
                    <h4>
                        <span class="label label-success"><?php echo $day_calories;?></span>
                    </h4>
                </div>
                <?php
                if(!$done){
                    ?>
                    <h3 style="text-align: center;">Enter calories</h3>
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
                    <form method="post" action="select.php">
                        <div class="form-group">
                            <label for="calories">Calories</label>
                            <input id="calories" name="calories" type="number" class="form-control" placeholder="e.g 500" required>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <button class="btn btn-success" type="submit" name="browse">Browse</button>
                            </div>
                        </div>

                    </form>
                    <?php
                }else{
                    ?>
                    <h3>
                        You are done for today. You have consumed the maximum allowable calories
                    </h3>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
    </body>
    </html>
<?php
}else{
    header("location:login.php");
}
?>