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
    <title>Comments</title>
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
                    <h1><i class="fas fa-comments text-warning"></i> Comments</h1>
                </div>
            </div>
        </div>
    </header>
    <!--HEADER END-->
    <section class="container py-2 mb-4">
        <div class="row">
            <div class="col-lg-12">
                <?php echo ErrorMessage(); ?>
                <?php echo SuccessMessage(); ?>
                <?php echo WarningMessage(); ?>
                <h2>Un-approved Comments</h2>
                <table class="table table-stripped table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>No. </th>
                            <th>Name</th>
                            <th>Date&Time</th>
                            <th>Comment</th>
                            <th>Action</th>
                            <th>Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $sql="SELECT * FROM comments WHERE status='OFF' ORDER BY id desc";
                            $Execute=$ConnectingDB->query($sql);
                            $i=0;
                            while($Data=$Execute->fetch()){
                                $i++;
                                $Id=$Data['id'];
                                $Post_Id=$Data['post_id'];
                                $Name=$Data['name'];
                                $DateTime=$Data['datetime'];
                                $Comment=normalize($Data['comment'],20,18);?>
                                <tr>
                                    <td><?php echo $i;?></td>
                                    <td><?php echo $Name;?></td>
                                    <td><?php echo $DateTime;?></td>
                                    <td><?php echo $Comment;?></td>
                                    <td>
                                        <a class="btn btn-success col-lg-5" href="ApproveComment.php?Id=<?php echo $Id?>">Approve</a>
                                        <a class="btn btn-danger col-lg-4" href="DeleteComment.php?Id=<?php echo $Id?>">Delete</a>
                                    </td>
                                    <td><a class="btn btn-primary" href="FullPost.php?Id=<?php echo $Post_Id; ?>" target="_blank">Live preview</a></td>
                                </tr>
                            <?php 
                            }  
                            ?>
                    </tbody>
                </table>
                <?php
                if($i==0){
                    ?>
                    <div class="card card-body">
                    <p class="card-text">No comments to be approved</p>
                    </div>
                <?php } ?>
                <h2>Approved Comments</h2>
                <table class="table table-stripped table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>No. </th>
                            <th>Name</th>
                            <th>Date&Time</th>
                            <th>Comment</th>
                            <th>Action</th>
                            <th>Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $sql="SELECT * FROM comments WHERE status='ON' ORDER BY id desc";
                            $Execute=$ConnectingDB->query($sql);
                            $i=0;
                            while($Data=$Execute->fetch()){
                                $i++;
                                $Id=$Data['id'];
                                $Post_Id=$Data['post_id'];
                                $Name=$Data['name'];
                                $DateTime=$Data['datetime'];
                                $Comment=normalize($Data['comment'],20,18);?>
                                <tr>
                                    <td><?php echo $i;?></td>
                                    <td><?php echo $Name;?></td>
                                    <td><?php echo $DateTime;?></td>
                                    <td><?php echo $Comment;?></td>
                                    <td>
                                        <a class="btn btn-warning col-lg-5" href="DisapproveComment.php?Id=<?php echo $Id?>">Inactivate</a>
                                        <a class="btn btn-danger col-lg-4" href="DeleteComment.php?Id=<?php echo $Id?>">Delete</a>
                                    </td>
                                    <td><a class="btn btn-primary" href="FullPost.php?Id=<?php echo $Post_Id; ?>" target="_blank">Live preview</a></td>
                                </tr>
                            <?php 
                            }  
                            ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
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