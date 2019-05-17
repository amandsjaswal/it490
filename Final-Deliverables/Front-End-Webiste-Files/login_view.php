<?php
if(isset($result)){

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Say It Right</title>
    <link rel="stylesheet" href="http://harr.uta.cloud/WDM/Project2/css/sayitright.css">
</head>
<body>

<div id="wrapper">
    <div id="header">
        <div id="left">
            <a href="http://harr.uta.cloud/WDM/Project2/index.php">
                <img src="http://harr.uta.cloud/WDM/Project2/images/logo.png" height="50px" alt="SAY IT RIGHT">
            </a>
        </div>
        <div id="right">
            <ul>
                <li><a href="">Home</a></li>
                <li><a href="">About Us</a></li>
                <li><a href="">Blog</a></li>
                <li><a href="">Buy from us</a></li>
                <li><a href="">Contact</a></li>
                <li><a href="">Sign Up</a></li>
                <li><a class="active" href="">Login</a></li>
            </ul>
        </div>
    </div>
    <div id="header-ext" class="home-banner">
        <div>
            <span>Home &roarr; Login</span>
            <h1>Login</h1>
        </div>
    </div>
    <div id="bod" style="top:150px;display: flex;justify-content: center;align-items: center;color: #aaaaaa;">
        <?php
        if(isset($result)){
            print_r($result);
        }
        ?>
        <div class="div8 shadow">
            <div class="contain">
                <?php
                if(isset($_SESSION['errors'])) {
                    ?>
                    <h3 style="color: red"><?php echo $_SESSION['errors'];?></h3>
                    <?php
                    unset($_SESSION['errors']);
                }
                ?>
                <?php
                    if(isset($_SESSION['error'])){
                        ?>
                        <span style="color: red">**<?php echo $_SESSION['error']; ?>**</span>
                        <?php
                        unset($_SESSION['error']);
                    }
                ?>
                <form action="<?php echo site_url('login/login')?>" method="POST">
                    <div class="pull-left" style="padding: 5px;width: 100%;">
                        <input class="text-input div6" type="email" name="email" placeholder="Enter Email">
                        <input class="text-input div6" type="password" name="password" placeholder="Enter Password">
                        <input class="text-input div6" type="text" name="role" value="user" placeholder="role" hidden="hidden">

                        <div class="div12" style="display: flex;justify-content: center;align-items: center;color: #aaaaaa;margin-top: 20px;">
                            <button class="btn" name="submit" style="margin-bottom: 20px;">Login</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>

    <div id="footer">
        <div style="min-height: 50px">

        </div>
        <div id="footer-text">
            <hr style="border: 1px solid #aaa;">
            <p>
                Copyright &copy; 2019 All rights reserved | This web is made with &hearts; by <b><a href="https://play.google.com/store/apps/developer?id=DiazApps">DiazApps</a></b>
            </p>
        </div>

    </div>
</div>

</body>
</html>