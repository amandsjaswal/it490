<?php
session_start();
if(isset($_SESSION['email'])){
    if(isset($_GET['food_id'])){
        $img = "./img/img.png";
        $infos = getMenuInfo($_GET['food_id']);
        $price = rand(10,50);

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
                    <li class="nav-item active">
                        <a class="nav-link" href="purchase.php?food_info=<?php echo $infos[0]->id;?>">Purchase<span>(current)</span></a>
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
                    <div class="card col-md-12">
                        <img class="card-img-top" src="<?php if($infos[0]->images[0]==''){ echo $img;}else echo $infos[0]->images[0];?>" alt="Card image cap" style="max-height: 200px;">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $infos[0]->title;?></h5>
                            <p class="card-text">_</p>
                            <hr>
                            <ul class="list-group">
                                <li class="list-group-item active"><b>NUTRITION</b></li>
                                <li class="list-group-item">Calories : <?php echo $infos[0]->nutrition->calories;?></li>
                                <li class="list-group-item">Fat : <?php echo $infos[0]->nutrition->fat;?></li>
                                <li class="list-group-item">Protein : <?php echo $infos[0]->nutrition->protein;?></li>
                                <li class="list-group-item">Carbs : <?php echo $infos[0]->nutrition->carbs;?></li>
                            </ul>
                            <hr>
                            <p class="card-text"><b>Price : </b> $<?php echo $price;?>.00</p>
                            <hr>
                            <form action="paypal.php" method="post">
                                <input type="hidden" name="price" value="<?php echo $price;?>">
                                <input type="hidden" name="calories" value="<?php echo $infos[0]->nutrition->calories;?>">
                                <input type="hidden" name="food_id" value="<?php echo $infos[0]->id;?>">

                                <div>
                                    <label for="location">Delivery Address</label>
                                    <input type="text" class="form-control" id="location" name="location" required>
                                </div>

                                <div class="form-group">
                                    <button class="btn btn-primary" type="submit" name="purchase">
                                        Purchase
                                    </button>
                                </div>

                            </form>
                        </div>
                    </div>
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