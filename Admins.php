<?php require_once("Includes/DB.php"); ?>
<?php require_once("Includes/Functions.php"); ?>
<?php require_once("Includes/Sessions.php"); ?>
<?php 
$_SESSION["TrackingURL"]=$_SERVER["PHP_SELF"];
ConfirmLogin();
if(isset($_POST["Submit"])){ //T C I D
    $Admin=$_SESSION["AdminName"];
    $DateTime=date_time();
    $User=$_POST['Username'];
    if(empty($_POST['Name'])){
        $Name=user_to_name($User);
        $norm=true;
    } else {
        $norm=false;
        $Name=$_POST['Name'];
    }
    $Password=$_POST['Password'];
    $CPassword=$_POST['ConfirmPassword'];
    $nm=$em=$ps=true;
    if(!preg_match("/^[A-Za-z .]*$/",$Name)){
        $nm=false;
        $_SESSION['ErrorMessageC']="Invalid Name(only characters allowed)";
    } 
    if(empty($User) || empty($Password) || empty($CPassword)){
        $em=false;
        $_SESSION['ErrorMessageT']="All fields must be filled";
    }
    if($Password!=$CPassword){
        $ps=false;
        $_SESSION['ErrorMessageI']="Passwords does not match";
    }
    $us=true;
    if(existsUsername($User)){
        $us=false;
        $_SESSION['ErrorMessageD']="Username alerdy used";
    }
    if($nm && $em && $ps && $us){
        $sql="INSERT INTO admins(datetime,username,password,aname,addedby) VALUES(:dateTime,:user,:pass,:an,:add)";
        $stmt=$ConnectingDB->prepare($sql);
        $stmt->bindValue(':dateTime',$DateTime);
        $stmt->bindValue(':user',$User);
        $stmt->bindValue(':pass',$Password);
        $stmt->bindValue(':an',$Name);
        $stmt->bindValue(':add',$Admin);
        $Execute=$stmt->execute();
        if($Execute){
            if($norm){
                $_SESSION["WarningMessage"]="Admin name was automatically set to username";
            }
            $_SESSION['SuccessMessage']="Admin added successfully";
        } else {
            $_SESSION['ErrorMessageT']="Something went wrong. Try again";
        }
    }
    redirect_to("Admins.php");
}
?>
<!DOCTYPE>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width" , initial-scale=1.0>
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://kit.fontawesome.com/498d7dfdc9.js" crossorigin="anonymous"></script>
    <title>Admin Page</title>
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
                    <h1><i class="fas fa-user"></i>Manage Admins</h1>
                </div>
            </div>
        </div>
    </header>
    <!--HEADER END-->
    
    <!--Main Area-->
    <section class="container py-2 mb-4">
        <div class="row">
            <div class="offset-lg-1 col-lg-10" style="min-height:717px">
            <?php echo ErrorMessageP(); ?>
            <?php echo ErrorMessage(); ?>
            <?php echo SuccessMessage(); ?>
            <?php echo WarningMessage(); ?>
            <form class="" action="Admins.php" method="POST">
                <div class="card bg-secondary text-light">
                    <div class="card-header">
                        <h1>Add New Admin</h1>
                    </div>
                    <div class="card-body bg-dark">
                        <div class="form-group">
                            <label for="username"><span class="FieldInfo">Username:</span> </label>
                            <input class="form-control" type="text" name="Username" id="username" placeholder="Type Username here..." value="">
                        </div>
                        <div class="form-group">
                            <label for="Name"><span class="FieldInfo">Name:</span> </label>
                            <input class="form-control" type="text" name="Name" id="name" value="">
                            <small class="text-danger muted">*Optional</small>
                        </div>
                        <div class="form-group">
                            <label for="Password"><span class="FieldInfo">Password:</span> </label>
                            <input class="form-control" type="password" name="Password" id="password" value="">
                        </div>
                        <div class="form-group">
                            <label for="ConfirmPassword"><span class="FieldInfo">Confirm Password:</span> </label>
                            <input class="form-control" type="password" name="ConfirmPassword" id="ConfirmPassword" value="">
                        </div>
                        <div class="row">
                            <div class="col-lg-6 mb-2">
                                <a href="Dashboard.php" class="btn btn-warning btn-block"><i class="fas fa-arrow-left"></i> Back To Dashboard</a>
                            </div>
                            <div class="col-lg-6 mb-2">
                                <button type="submit" name="Submit" class="btn btn-success btn-block">
                                    <i class="fas fa-check"></i> Add
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <h2>Existing Admins</h2>
                <table class="table table-stripped table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>No. </th>
                            <th>Admin Name</th>
                            <th>Date&Time</th>
                            <th>Added by</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $sql="SELECT * FROM admins ORDER BY id desc";
                            $Execute=$ConnectingDB->query($sql);
                            $i=0;
                            while($Data=$Execute->fetch()){
                                $i++;
                                $Id=$Data['id'];
                                $Name=$Data['username'];
                                $DateTime=$Data['datetime'];
                                $Author=normalize($Data['addedby'],20,18);?>
                                <tr>
                                    <td><?php echo $i;?></td>
                                    <td><?php echo $Name;?></td>
                                    <td><?php echo $DateTime;?></td>
                                    <td><?php echo $Author;?></td>
                                    <?php if($Name!="Alex21") {?>
                                    <td>
                                        <a class="btn btn-danger" href="DeleteAdmin.php?Id=<?php echo $Id?>">Delete</a>
                                    </td>
                                    <?php } ?>
                                </tr>
                            <?php 
                            }  
                            ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
    <!--EndMain Area-->

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