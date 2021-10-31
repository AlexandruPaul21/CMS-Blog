<?php require_once("Includes/DB.php"); ?>
<?php require_once("Includes/Functions.php"); ?>
<?php require_once("Includes/Sessions.php"); ?>
<?php 
$_SESSION["TrackingURL"]=$_SERVER["PHP_SELF"];
ConfirmLogin();
$PostId=$_GET['Id'];
$sql="SELECT * FROM posts WHERE id=$PostId";
$stmt=$ConnectingDB->query($sql);
while($DataRows=$stmt->fetch()){
    $TitleU=$DataRows['title'];
    $CategoryU=$DataRows['category'];
    $ImageU=$DataRows['image'];
    $PostU=$DataRows['post'];
}
$Target1="Uploads/$ImageU";
if(isset($_POST["Submit"])){
    $DateTime=date_time();
    $Admin="Alex";
    $tit=$ctg=$img=$pst=false;
    if(empty($_POST["PostTitle"])){
        $_SESSION["ErrorMessageT"]="Post Title Missing";
    } elseif(strlen($_POST["PostTitle"])<3){
        $_SESSION["ErrorMessageT"]="Please Enter a longer title";
    } else {
        $tit=true;
    }
    if(empty($_POST["Category"])){
        $_SESSION["ErrorMessageC"]="Please select a category";
    } else {
        $ctg=true;
    }
    if(empty($_POST["PostDescription"])){
        $_SESSION["ErrorMessageD"]="Post Description Missing";
    } elseif(strlen($_POST["PostDescription"])<20){
        $_SESSION["ErrorMessageD"]="Please Enter a longer description (min. 20 ch)";
    } elseif(strlen($_POST["PostDescription"])>10000){
        $_SESSION["ErrorMessageD"]="Please Enter a shorter description (max. 10000 ch)";
    } else {
        $pst=true;
    }
    if($tit && $ctg && $pst){
        $Title=$_POST["PostTitle"];
        $Cate=$_POST["Category"];
        $Img=$_FILES["Image"]["name"];
        $Target="Uploads/".basename($_FILES["Image"]["name"]);
        $Desc=$_POST["PostDescription"];
        if (!empty($Img)){
            unlink($Target1);
            move_uploaded_file($_FILES["Image"]["tmp_name"],$Target);
            $sql="UPDATE posts SET title='$Title' , category='$Cate' , image='$Img' , post='$Desc' WHERE id=$PostId";
        } else {
            $sql="UPDATE posts SET title='$Title' , category='$Cate' , post='$Desc' WHERE id=$PostId";
        }
        $Execute=$ConnectingDB->query($sql);
        if($Execute){
            $_SESSION["SuccessMessage"]="Post edited successfully";
        } else {
            $_SESSION["ErrorMessageT"]="Something went wrong. Try again";
        }
    } 
    redirect_to("Posts.php");
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
    <title>Edit Post</title>
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
                    <h1><i class="fas fa-edit text-primary"></i>Edit Post</h1>
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
            <?php echo SuccessMessage(); ?>
            <?php echo WarningMessage(); ?>
            <form class="" action="EditPost.php?Id=<?php echo $PostId; ?>" method="POST" enctype="multipart/form-data">
                <div class="card bg-secondary text-light">
                    <div class="card-body bg-dark">
                        <div class="form-group">
                            <label for="title"><span class="FieldInfo">Post Title:</span> </label>
                            <input class="form-control" type="text" name="PostTitle" id="title" value="<?php echo $TitleU; ?>">
                        </div>
                        <div class="form-group">
                            <span class="FieldInfo">Existing Category:</span> <?php echo $CategoryU; ?><br>
                            <label for="CategoryTitle"><span class="FieldInfo">Choose Category:</span> </label>
                            <select class="form-control" id="CategoryTitle" name="Category">
                                <option value="">Select a category</option>
                                <?php
                                    $sql="SELECT id,title FROM category";
                                    $stmt=$ConnectingDB->query($sql);
                                    while($DataRows=$stmt->fetch()){
                                        $Id =$DataRows['id'];
                                        $Cat=$DataRows['title'];?>
                                        <option><?php echo $Cat; ?></option>
                                    <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <span class="FieldInfo">Existing Image:</span> <img src="Uploads/<?php echo $ImageU; ?>" class="mb-2"  width="170px" height="70px"><br>
                            <div class="custom-file"><input class="custom-file-input" type="File" name="Image" id="imageSelect" value="">
                            <label for="imageSelect" class="custom-file-label">Select Image</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="Post"><span class="FieldInfo">Post:</span></label>
                            <textarea class="form-control" id="Post" name="PostDescription" rows="8" cols="80">
                                <?php echo $PostU; ?>
                            </textarea>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 mb-2">
                                <a href="Dashboard.php" class="btn btn-warning btn-block"><i class="fas fa-arrow-left"></i> Back To Dashboard</a>
                            </div>
                            <div class="col-lg-6 mb-2">
                                <button type="submit" name="Submit" class="btn btn-success btn-block">
                                    <i class="fas fa-check"></i> Edit
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
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