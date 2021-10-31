<?php require_once("Includes/DB.php"); ?>
<?php require_once("Includes/Functions.php"); ?>
<?php require_once("Includes/Sessions.php"); ?>
<?php
if(isset($_POST["Submit"])){
    $Name=$_POST["CommenterName"];
    $Email=$_POST["CommenterEmail"];
    $Message=$_POST["CommenterThoughts"];
    $nm=$em=$me=true;
    if(strlen($Name)>49 || empty($Name)){
        $nm=false;
        $_SESSION["ErrorMessageT"]="Invalid Name";
    }
    if(!preg_match("/[a-zA-Z0-9._-]{3,}@[a-zA-Z0-9._-]{3,}[.]{1}[a-zA-Z0-9._-]{2,}/",$Email) || empty($Email)){
        $em=false;
        $_SESSION["ErrorMessageC"]="Invalid E-mail format";
    }
    if(strlen($Message)>500 || empty($Message)){
        $me=false;
        $_SESSION["ErrorMessageI"]="Invalid Message";
    }
    if($nm && $em && $me){
        $DateTime=date_time();
        $sql="INSERT INTO comments(datetime,name,email,comment,approvedby,status,post_id) VALUES (:dT,:nM,:eM,:cM,'pending','OFF',:id)";
        $stmt=$ConnectingDB->prepare($sql);
        $stmt->bindValue(':dT',$DateTime);
        $stmt->bindValue(':nM',$Name);
        $stmt->bindValue(':eM',$Email);
        $stmt->bindValue(':cM',$Message);
        $stmt->bindValue(':id',$_GET['Id']);
        $Execute=$stmt->execute();
        if($Execute){
            $_SESSION['SuccessMessage']="Comment added successfully";
        } else {
            $_SESSION["ErrorMessageD"]="Something went wrong";
        }
    }
    $trg="FullPost.php?Id=";
    $trg.=$_GET["Id"];
    redirect_to($trg);
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
    <title>Full Post</title>
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
    <div class="container">
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
                        $iD=$_GET["Id"];
                        if(!isset($iD)){
                            $_SESSION["ErrorMessage"]="Bad Request!";
                            redirect_to("Blog.php");
                        } else {
                            $sql= "SELECT * FROM posts WHERE id=$iD";
                            $stmt=$ConnectingDB->query($sql);
                        }
                    }
                    while($DataRows=$stmt->fetch()){
                        $Id=$DataRows["id"];
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
                                <span style="float:right" class="badge badge-dark text-light">Comments 20</span>
                                <hr>
                                <p class="card-text"><?php echo $Post; ?></p>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="card mt-3">
                        <div class="card-header">Comments</div>
                        <?php 
                            $sql="SELECT * FROM comments WHERE post_id=$iD AND status='ON'";
                            $stmt=$ConnectingDB->query($sql);
                            $i=1;
                            while($DataRows=$stmt->fetch()){
                                if($i!=1) {
                                    echo "<hr>";
                                }
                                $Name=$DataRows['name'];
                                $DateTime=$DataRows['datetime'];
                                $Message=$DataRows['comment'];
                                $i++; ?>
                                <div class="card-body">
                                    <h5 class="card-title"><i class="fas fa-user"></i> <?php echo $Name; ?></h5>
                                    <h6 class="card-subtitle muted"><i class="fas fa-clock"></i> <?php echo $DateTime;?> </h6>
                                    <p class="card-text"><?php echo $Message; ?></p>
                                </div>
                            <?php } 
                            if ($i==1){
                                ?>
                                <div class="card-body">
                                    <p class="card-text">Be the first one who add a comment</p>
                                </div>
                            <?php } ?>
                    </div>
                    <div class="mt-3">
                        <?php echo ErrorMessageP(); ?>
                        <?php echo SuccessMessage(); ?>
                        <form class="" action="FullPost.php?Id=<?php echo $_GET["Id"]; ?>" method="POST">
                            <div class="card mb-3">
                                <div class="card-header">
                                    <h5 class="FieldInfo">Share your thoughts about this post</h5>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                            </div>
                                            <input type="text" class="form-control" placeholder="Name" name="CommenterName">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                            </div>
                                            <input type="email" class="form-control" placeholder="Email" name="CommenterEmail">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <textarea name="CommenterThoughts" class="form-control" rows="6" cols="80"></textarea>
                                    </div>
                                    <div class="">
                                        <button type="submit" name="Submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
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