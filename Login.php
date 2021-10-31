<?php require_once("Includes/DB.php"); ?>
<?php require_once("Includes/Functions.php"); ?>
<?php require_once("Includes/Sessions.php"); ?>
<?php 
if(isset($_SESSION["UserName"])){
    $_SESSION["WarningMessage"]="You are already logged in";
    if(isset($_SESSION["TrackingURL"])){
        redirect_to($_SESSION['TrackingURL']);
    } else {
        redirect_to("Dashboard.php");
    }
}
if(isset($_POST['Submit'])){
    $Username=$_POST['Username'];
    $Password=$_POST['Password'];
    if(empty($Username) || empty($Password)){
        $_SESSION['ErrorMessage']="All fields must be field out";
        redirect_to("Login.php");
    } else {
        $Found=LoginAttempt($Username,$Password);
        if($Found){
            $_SESSION["User_Id"]=$Found['id'];
            $_SESSION["UserName"]=$Found['username'];
            $_SESSION["AdminName"]=$Found['aname'];
            $_SESSION["SuccessMessage"]="Welcome ". $Found['aname'];
            if(isset($_SESSION["TrackingURL"])){
                redirect_to($_SESSION['TrackingURL']);
            } else {
                redirect_to("Posts.php");
            }
        } else {
            $_SESSION["ErrorMessage"]="Invalid Username/Password";
            redirect_to("Login.php");
        }
    }
}
?>
<!DOCTYPE>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width" , initial-scale=1.0>
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link rel="stylesheet" href="CSS/style.css">
    <script src="https://kit.fontawesome.com/498d7dfdc9.js" crossorigin="anonymous"></script>
    <title>Login</title>
</head>
<body>
    <div style="height:10px; background-color:#27aae1"></div>
    <!--NAVBAR-->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a href="Blog.php" class="navbar-brand">ALEXSIRBU.COM</a> 
            <button class="navbar-toggler" data-toggle="collapse" data-target="#navbarcollapseCMS">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarcollapseCMS">
            </div>
        </div>
    </nav>
    <!--NAVBAR END-->
    
    <!--HEADER-->
    <header class="bg-dark text-white py-2">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                </div>
            </div>
        </div>
    </header>
    <!--HEADER END-->
    <!--Main Area-->
    <section class="container py-2 mb-4">
        <div class="row">
            <div class="offset-sm-3 col-sm-6" style="min-height:773px">
                <?php
                echo ErrorMessage();
                echo SuccessMessage();
                ?>
                <div class="card text-light bg-secondary">
                    <div class="card-header">
                        <h4>Welcome back!</h4>
                    </div>
                    <div class="card-body bg-dark">
                        <form class="" action="Login.php" method="POST">
                            <div class="form-group">
                                <label for="username"><span class="FieldInfo">Username</span></label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text text-white bg-info"><i class="fas fa-user"></i> </span>
                                    </div>
                                    <input type="text" class="form-control" name="Username" id="username" value="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password"><span class="FieldInfo">Password</span></label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text text-white bg-info"><i class="fas fa-lock"></i> </span>
                                    </div>
                                    <input type="password" class="form-control" name="Password" id="password" value="">
                                </div>
                            </div>
                            <input type="submit" name="Submit" class="btn btn-info btn-block" value="Login">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--End Main Area-->
    <!--FOOTER-->
    <footer class="bg-dark text-white">
        <div class="container">
            <div class="row">
                <div class="col">
                    <p class="lead text-center"> Theme by | Alex Sirbu | <span id="year"></span> &copy; ----All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>
    <!--FOOTER END-->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>
    <script>
        $('#year').text(new Date().getFullYear());
    </script>
</body>
</html>