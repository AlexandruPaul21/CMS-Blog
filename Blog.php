<?php require_once("Includes/DB.php"); ?>
<?php require_once("Includes/Functions.php"); ?>
<?php require_once("Includes/Sessions.php"); ?>
<!DOCTYPE>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width" , initial-scale=1.0>
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link rel="stylesheet" href="CSS/style.css">
    <script src="https://kit.fontawesome.com/498d7dfdc9.js" crossorigin="anonymous"></script>
    <title>Blog Page</title>
</head>
<body>
    <div style="height:10px; background-color:#27aae1"></div>
    <!--NAVBAR-->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container py-0">
            <a href="#" class="navbar-brand">ALEXSIRBU.COM</a> 
            <button class="navbar-toggler" data-toggle="collapse" data-target="#navbarcollapseCMS">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarcollapseCMS">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item"><a href="Blog.php" class="nav-link">Home</a></li>
                <li class="nav-item"><a href="#" class="nav-link">About Us</a></li>
                <li class="nav-item"><a href="Blog.php" class="nav-link">Blog</a></li>
                <li class="nav-item"><a href="#" class="nav-link">Contact Us</a></li>
                <li class="nav-item"><a href="#" class="nav-link">Features</a></li>

            </ul>
            <ul class="navbar-nav ml-auto py-1">
                <form class="form-inline d-none d-sm-block" action="Blog.php">
                    <div class="form-group">
                        <input class="form-control mr-2" type="text" name="Search" placeholder="Search..." value="">
                        <button class="btn btn-primary" name="SearchButton">Go</button>
                    </div>
                </form>
            </ul>
            </div>
        </div>
    </nav>
    <!--NAVBAR END-->
    
    <!--HEADER-->
    <div class="container mt-2">
        <?php echo ErrorMessage(); ?>
        <div class="row mt-4">
            <!--Main Area-->
            <div class="col-sm-8">
                <h1>This is a blog</h1>
                <h1 class="lead">Designed by Alex</h1>
                <?php
                    if(isset($_GET["SearchButton"])){
                        $Search=$_GET["Search"];
                        $sql="SELECT * FROM posts WHERE
                        datetime LIKE :searcH
                        OR title LIKE :searcH
                        OR category LIKE :searcH
                        OR post LIKE :searcH ORDER BY id desc";
                        $stmt=$ConnectingDB->prepare($sql);
                        $stmt->bindValue(':searcH','%'.$Search.'%');
                        $stmt->execute();
                    } else {
                        $sql= "SELECT * FROM posts ORDER BY id DESC";
                        $stmt=$ConnectingDB->query($sql);
                    }
                    while($DataRows=$stmt->fetch()){
                        $Id=$DataRows["id"];
                        $sql1="SELECT * FROM comments WHERE post_id=$Id";
                        $var=$ConnectingDB->query($sql1);
                        $com=0;
                        while($Data=$var->fetch()){
                            if($Data["status"]=="ON"){
                                $com=$com+1;
                            }
                        }
                        $Title=$DataRows["title"];
                        $Category=$DataRows["category"];
                        $DateTime=$DataRows["datetime"];
                        $Author=$DataRows["author"];
                        $Image=$DataRows["image"];
                        $Post=$DataRows["post"];?>
                        <div class="card">
                            <img src="Uploads/<?php echo $Image; ?>" style="max-height:450px" class="img-fluid card-img-top">
                            <div class="card-body">
                                <h4 class="card-title"><?php echo $Title; ?></h4>
                                <small class="text-muted">Written by <?php echo $Author; ?> on <?php echo $DateTime; ?></small>
                                <span style="float:right" class="badge badge-dark text-light">Comments <?php echo $com; ?></span>
                                <hr>
                                <p class="card-text"><?php echo normalize($Post,50,48); ?></p>
                                <a href="FullPost.php?Id=<?php echo $Id; ?>" style="float:right">
                                    <span class="btn btn-info">Read More >></span>
                                </a>
                            </div>
                        </div>
                    <?php } ?>
            </div>
            <!--Side Area-->
            <div class="col-sm-4">
            </div>
        </div>
    </div>
    <!--HEADER END-->
    <br>
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