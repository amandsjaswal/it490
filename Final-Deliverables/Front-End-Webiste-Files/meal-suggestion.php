<?php
session_start();
if($_SESSION['email']){
    require_once "functions.php";
    $menus = ['avocado','chicken','fries','potato','beef','bacon','pork'];
    $url = "http://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
    $host = explode("results.php",$url)[0];
    $_SESSION['host']=$host;
    $img = "./img/img.png";
    $ids = [];
    $food_Id=[];
    $foodInfo=[];

    foreach($menus as $menu){
        array_push($ids,searchMenu($menu)[0]->id);
    }

    $cal = (int)(2000 / 4);

    for($i=count($ids)-1;$i>=0;$i--){
        if(count($food_Id)>4){
            break;
        }
        $current_food = getMenuInfo($ids[$i]);
        $calories = intval($current_food->nutrition->calories);
        if($calories >= $cal-50 && $calories <= $cal+50){
            array_push($food_Id,$ids[$i]);
        }
    }



    foreach ($food_Id as $id){
        array_push($foodInfo,getMenuInfo($id));
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
                    <a class="nav-link" href="select.php">Meal Suggestion<span>(current)</span></a>
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
            <div class="col-md-12">
                <h3>Meal Suggestion</h3>
            </div>

            <?php
            $i=0;
            foreach ($foodInfo as $info){
                $price = rand(10,50);
                ?>
                <div class="col-md-4">
                    <div class="card" style="margin: 10px;">
                        <img class="card-img-top" src="<?php if($info->images[0]==''){ echo $img;}else echo $info->images[0];?>" alt="Card image cap" style="max-height: 200px;">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $info->title;?></h5>
                            <hr>
                            <p class="card-text"><b>Price : </b> $<?php echo $price;?>.00</p>
                            <hr>
                            <ul class="list-group">
                                <li class="list-group-item active"><b>NUTRITION</b></li>
                                <li class="list-group-item">Calories : <?php echo $info->nutrition->calories;?></li>
                                <li class="list-group-item">Fat : <?php echo $info->nutrition->fat;?></li>
                                <li class="list-group-item">Protein : <?php echo $info->nutrition->protein;?></li>
                                <li class="list-group-item">Carbs : <?php echo $info->nutrition->carbs;?></li>
                            </ul>

                            <form action="paypal.php?id=<?php echo $info->id;?>" method="post">
                                <input type="hidden" name="price-<?php echo $info->id;?>" value="<?php echo $price;?>">
                                <input type="hidden" name="calories-<?php echo $info->id;?>" value="<?php echo $info->nutrition->calories;?>">
                                <input type="hidden" name="food_id-<?php echo $info->id;?>" value="<?php echo $info->id;?>">
                                <input type="hidden" name="title-<?php echo $info->id;?>" value="<?php echo $info->title;?>">

                                <div class="form-group">
                                    <button class="btn btn-primary" type="submit" name="purchase">
                                        Purchase
                                    </button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
                <?php
                $i++;
            }
            ?>

        </div>
    </div>
    </body>
    </html>
    <?php
}else{
    header("location:login.php");
}
?>
