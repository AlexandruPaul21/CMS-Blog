<?php require_once("Includes/DB.php"); ?>
<?php require_once("Includes/Functions.php"); ?>
<?php require_once("Includes/Sessions.php"); ?>
<?php 
$_SESSION["TrackingURL"]=$_SERVER["PHP_SELF"];
ConfirmLogin();
if(isset($_POST["Submit"])){
    $Category=$_POST["CategoryTitle"];
    $Admin=$_SESSION["AdminName"];
    $DateTime=date_time();
    if(empty($Category)){
        $_SESSION["ErrorMessage"] = "All fields must be filled";
    } elseif(strlen($Category)<3) {
        $_SESSION["ErrorMessage"] = "Category name must have more than 2 caracaters";
    } elseif(strlen($Category)>49) {
        $_SESSION["ErrorMessage"] = "Category name must have less than 50 caracaters";
    }else {
        $sql="INSERT INTO category(title,author,datetime)";
        $sql.="VALUES(:categoryName,:adminName,:dateTime)";
        $stmt=$ConnectingDB->prepare($sql);
        $stmt->bindValue(":categoryName",$Category);
        $stmt->bindValue(":adminName",$Admin);
        $stmt->bindValue("dateTime",$DateTime);
        $Execute=$stmt->execute();
        if($Execute){
            $_SESSION["SuccessMessage"] = "Category with id:". $ConnectingDB->lastInsertId() ." added successfully";
        } else {
            $_SESSION["ErrorMessage"] = "Category failed to add";
        }
    }
    redirect_to("Categories.php");
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
    <title>Categories</title>
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
                    <h1><i class="fas fa-edit text-primary"></i>Manage Categories</h1>
                </div>
            </div>
        </div>
    </header>
    <!--HEADER END-->
    
    <!--Main Area-->
    <section class="container py-2 mb-4">
        <div class="row">
            <div class="offset-lg-1 col-lg-10" style="min-height:717px">
            <?php echo ErrorMessage(); ?>
            <?php echo SuccessMessage(); ?>
            <?php echo WarningMessage(); ?>
            <form class="" action="Categories.php" method="POST">
                <div class="card bg-secondary text-light">
                    <div class="card-header">
                        <h1>Add New Category</h1>
                    </div>
                    <div class="card-body bg-dark">
                        <div class="form-group">
                            <label for="title"><span class="FieldInfo">Category Title:</span> </label>
                            <input class="form-control" type="text" name="CategoryTitle" id="title" placeholder="Type Title Here..." value="">
                        </div>
                        <div class="row">
                            <div class="col-lg-6 mb-2">
                                <a href="Dashboard.php" class="btn btn-warning btn-block"><i class="fas fa-arrow-left"></i> Back To Dashboard</a>
                            </div>
                            <div class="col-lg-6 mb-2">
                                <button type="submit" name="Submit" class="btn btn-success btn-block">
                                    <i class="fas fa-check"></i> Publish
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <h2>Existing Cateogries</h2>
                <table class="table table-stripped table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>No. </th>
                            <th>Category Name</th>
                            <th>Date&Time</th>
                            <th>Author</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $sql="SELECT * FROM category ORDER BY id desc";
                            $Execute=$ConnectingDB->query($sql);
                            $i=0;
                            while($Data=$Execute->fetch()){
                                $i++;
                                $Id=$Data['id'];
                                $Name=$Data['title'];
                                $DateTime=$Data['datetime'];
                                $Author=normalize($Data['author'],20,18);?>
                                <tr>
                                    <td><?php echo $i;?></td>
                                    <td><?php echo $Name;?></td>
                                    <td><?php echo $DateTime;?></td>
                                    <td><?php echo $Author;?></td>
                                    <td>
                                        <a class="btn btn-danger" href="DeleteCategory.php?Id=<?php echo $Id?>">Delete</a>
                                    </td>
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