<?php
session_start();
if(isset($_SESSION['user_id'])){
    require_once "functions.php";
    if(isset($_GET['food_id'])){
        if(!inDb("SELECT * FROM favourites WHERE food_id=? AND user_id=?",[$_GET['food_id'],$_SESSION['user_id']])){
            if(ExecuteDb("INSERT INTO favourites(id,food_id,user_id) VALUES (?,?,?)",[NULL,$_GET['food_id'],$_SESSION['user_id']])){
                $success = "added to favourites";
            }
        }else{
            $success = "Already Exists in favourites";
        }
    }

    $foodInfo = [];
    $rows = fetch("SELECT * FROM favourites WHERE user_id=?",[$_SESSION['user_id']]);
    foreach ($rows as $row){
        $current_food = getMenuInfo($row["food_id"]);
        array_push($foodInfo,[$current_food->title,$row["food_id"]]);
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
                <li class="nav-item">
                    <a class="nav-link" href="select.php">Order food<span></a>
                </li>
                <li class="nav-item active">
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
                <?php
                if(isset($success)){
                ?>
                    <div class="col-md-12 alert alert-success" role="alert" style="text-align: center;">
                        <span><?php echo $success;?></span>
                    </div>
                <?php
                }
                ?>
                <div class="col-md-12" style="text-align: center;">
                    <h3>Favourites</h3>
                </div>
                <div class="col-md-12">
                    <ul class="list-group">
                    <?php
                        foreach ($foodInfo as $info) {
                            echo "<li class='list-group-item' style='text-align: center;'>{$info[0]} <a href='viewFav.php?food_id={$info[1]}' class='badge badge-success'>View</a></li>";
                        }
                    ?>
                    </ul>
                </div>
            </div>

        </div>
    </div>
    </body>
    </html>
    <?php
}else{
    header("location:logout.php");
}