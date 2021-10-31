<?php require_once("Includes/DB.php"); ?>
<?php require_once("Includes/Functions.php"); ?>
<?php require_once("Includes/Sessions.php"); ?>
<?php
$_SESSION["TrackingURL"]=$_SERVER["PHP_SELF"];
ConfirmLogin();
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
    <title>MyProfile</title>
</head>
<body>
    <div style="height:10px; background-color:#27aae1"></div>
    <!--NAVBAR-->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a href="#" class="navbar-brand">ALEXSIRBU.COM</a> 
            <button class="navbar-toggler" data-toggle="collapse" data-target="#navbarcollapseCMS">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarcollapseCMS">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item"><a href="MyProfile.php" class="nav-link"><i class="fas fa-user text-success"></i> My Profile</a></li>
                <li class="nav-item"><a href="Dashboard.php" class="nav-link">Dashboard</a></li>
                <li class="nav-item"><a href="Posts.php" class="nav-link">Posts</a></li>
                <li class="nav-item"><a href="Categories.php" class="nav-link">Categories</a></li>
                <li class="nav-item"><a href="Admins.php" class="nav-link">Manage Admins</a></li>
                <li class="nav-item"><a href="Comments.php" class="nav-link">Comments</a></li>
                <li class="nav-item"><a href="Blog.php?page=1" class="nav-link">Live Blog</a></li>

            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item"><a href="Logout.php" class="nav-link">Logout <i class="fas fa-sign-out-alt text-danger"></i></a></li>
            </ul>
            </div>
        </div>
    </nav>
    <!--NAVBAR END-->
    
    <!--HEADER-->
    <header class="bg-dark text-white py-2">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1><i class="far fa-address-card" style="color:blue"></i> <?php echo $_SESSION["AdminName"];?>'s profile</h1>
                </div>
            </div>
        </div>
    </header>
    <!--HEADER END-->
    <?php 
        $var=$_SESSION["UserName"];
        $sql="SELECT * FROM admins WHERE username='$var'";
        $stmt=$ConnectingDB->query($sql);
        $Data=$stmt->fetch();
    ?>
    <section class="container py-2 mb-1" style="min-height:80%">
        <?php echo SuccessMessage(); ?>
        <div class="row">
            <div class="col-lg-3">
            <div class="card mb-2">
                <div class="card-body">
                    <img src="Uploads/<?php echo $Data["image"] ?>" alt="ProfilePhoto" class="card-img square mb-1">
                    <h6>Admin since: <?php echo date_formater($Data["datetime"])?></h6>
                </div>
            </div>
            <a href="EditAdmin.php"><button class="btn btn-primary" style="width:100%;">Edit</button></a>
            </div>
            <div class="col-lg-9">
                <div class="card">
                    <div class="card-header">General Information</div>
                    <?php 
                        if($Data["image"]=="user.png"){
                            $customized=false;
                            ?>
                            <div class="alert alert-warning mt-1 ml-1 mr-1">
                                You haven't customized your profile yet! Click the edit button to do it now!
                            </div>
                       <?php }  else { ?>
                    <div class="card-body">
                        <h5 style="color:grey;"><i class="fas fa-birthday-cake"></i> Birth Date <br></h5>
                        <h5 style="color:#363636;margin-left:25px;"><?php echo f($Data["datan"]);?></h5><br>
                        <h5 style="color:grey;"><i class="fas fa-venus-mars"></i> Gender <br></h5>
                        <h5 style="color:#363636;margin-left:25px;"><?php echo adam($Data["sex"]);?></h5><br>
                        <h5 style="color:grey;"><i class="fas fa-phone-alt"></i> Contact Number <br></h5>
                        <h5 style="color:#363636;margin-left:25px;"><?php echo $Data["telefon"]?></h5><br>
                        <h5 style="color:grey;"><i class="fas fa-envelope-square"></i> E-mail Address <br></h5>
                        <h5 style="color:#363636;margin-left:25px;"><?php echo $Data["email"]?></h5><br>
                        <h5 style="color:grey;"><i class="fas fa-address-card"></i> House Location <br></h5>
                        <h5 style="color:#363636;margin-left:25px;"><?php echo $Data["adresa"]?></h5><br>
                        <h5 style="color:grey;"><i class="fas fa-info"></i> Description <br></h5>
                        <h5 style="color:#363636;margin-left:25px;"><p style="text-indent:5%;"><?php echo $Data["bio"]?></p></h5><br>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </section>
    <!--FOOTER-->
    <div class="bg-dark text-white footer">
        <div class="container">
            <div class="row">
                <div class="col">
                    <p class="lead text-center"> Theme by | Alex Sirbu | <span id="year"></span> &copy; ----All rights reserved.</p>
                </div>
            </div>
        </div>
    </div>
    <!--FOOTER END-->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>
    <script>
        $('#year').text(new Date().getFullYear());
    </script>
</body>
</html>