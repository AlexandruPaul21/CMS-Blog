<?php require_once("Includes/DB.php"); ?>
<?php require_once("Includes/Functions.php"); ?>
<?php require_once("Includes/Sessions.php"); ?>
<?php $_SESSION["TrackingURL"]=$_SERVER["PHP_SELF"]; ?>
<?php ConfirmLogin(); ?>
<!DOCTYPE>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width" , initial-scale=1.0>
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link rel="stylesheet" href="CSS/style.css">
    <script src="https://kit.fontawesome.com/498d7dfdc9.js" crossorigin="anonymous"></script>
    <title>Posts</title>
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
                    <h1><i class="fas fa-blog text-primary"></i>Blog Posts</h1>
                </div>
                <div class="col-lg-3 mb-2">
                    <a href="AddNewPost.php" class="btn btn-primary btn-block">
                        <i class="fas fa-edit"></i> Add New Post
                    </a>
                </div>
                <div class="col-lg-3 mb-2">
                    <a href="Categories.php" class="btn btn-info btn-block">
                        <i class="fas fa-folder-plus"></i> Add New Category
                    </a>
                </div>
                <div class="col-lg-3 mb-2">
                    <a href="Admins.php" class="btn btn-warning btn-block">
                        <i class="fas fa-user-plus"></i> Add New Admin
                    </a>
                </div>
                <div class="col-lg-3 mb-2">
                    <a href="Comments.php" class="btn btn-success btn-block">
                        <i class="fas fa-check"></i> Approve Comments
                    </a>
                </div>
            </div>
        </div>
    </header>
    <!--HEADER END-->
    
    <!--Main Area-->
    <section class="container py-2 mb-4">
        <div class="row">
            <div class="col-lg-12" style="min-height:717px">
                <?php echo ErrorMessageP(); ?>
                <?php echo SuccessMessage(); ?>
                <?php echo WarningMessage(); ?>
                <table class="table table-striped table-hover">
                    <thead class="thead-dark">
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Date & Time</th>
                        <th>Author</th>
                        <th>Banner</th>
                        <th>Comments</th>
                        <th>Action</th>
                        <th>Live Preview</th>
                    </tr>
                    </thead>
                    <?php
                        $i=0;
                        $sql="SELECT * FROM posts";
                        $stmt=$ConnectingDB->query($sql);
                        while($DataRows=$stmt->fetch()){
                            $Id=$DataRows["id"];
                            $sql1="SELECT * FROM comments WHERE post_id=$Id";
                            $var=$ConnectingDB->query($sql1);
                            $com0=0;
                            $com1=0;
                            while($Data=$var->fetch()){
                                if($Data["status"]=="ON") $com1=$com1+1;
                                else $com0=$com0+1;
                            }
                            $Title=normalize($DataRows["title"],20,15);
                            $Category=normalize($DataRows["category"],8,8);
                            $DateTime=$DataRows["datetime"];
                            $Author=normalize($DataRows["author"],8,6);
                            $i=$i+1;
                            $Image=$DataRows["image"];
                            $Post=$DataRows["post"];?>
                            <tbody>
                            <tr>
                                <td><?php echo $i        ?></td>
                                <td><?php echo $Title    ?></td>
                                <td><?php echo $Category ?></td>
                                <td><?php echo $DateTime ?></td>
                                <td><?php echo $Author   ?></td>
                                <td><img src="Uploads/<?php echo $Image    ?>" width="100px" height="50px"></td>
                                <td><div class="card-deck">
                                        <a href="Comments.php" style="text-decoration:none">
                                        <div class="card bg-danger ml-0">
                                            <div class="card-body text-center"><p class="card-text" style="color:white"><?php echo "$com0";?></p></div>
                                        </div>
                                        </a>
                                        <a href="Comments.php" style="text-decoration:none">
                                        <div class="card bg-success ml-0">
                                            <div class="card-body text-center"><p class="card-text" style="color:white"><?php echo "$com1";?></p></div>
                                        </div>
                                        </a>
                                    </div>
                                <td>
                                    <a href="EditPost.php?Id=<?php echo $Id; ?>"><span class="btn btn-warning">Edit</span></a>
                                    <a href="DeletePost.php?Id=<?php echo $Id; ?>"><span class="btn btn-danger">Delete</span></a>
                                </td>
                                <td>
                                    <a href="FullPost.php?Id=<?php echo $Id; ?>" target="_blank"><span class="btn btn-primary">Live Preview</span></a>           
                                </td>
                            </tr>
                            </tbody>
                        <?php } ?>
                </table>
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