<?php require_once("Includes/DB.php"); ?>
<?php require_once("Includes/Functions.php"); ?>
<?php require_once("Includes/Sessions.php"); ?>
<?php 
$_SESSION["TrackingURL"]=$_SERVER["PHP_SELF"];
ConfirmLogin();
?>
<?php 
    $var=$_SESSION["UserName"];
    $sql="SELECT * FROM admins WHERE username='$var'";
    $stmt=$ConnectingDB->query($sql);
    $Data=$stmt->fetch();
?>
<?php
if(isset($_POST["Submit"])){
    $Target1='Uploads/'.$Data["image"];
    $T=$C=$I=$D=$A=$B=$E=false;
    if(empty($_POST['BirthDate'])){
        $_SESSION['ErrorMessageT']="Please enter your birthdate";
    } else {
        $T=true;
    }
    $T=true;
    if(empty($_POST['Gender'])){
        $_SESSION['ErrorMessageC']="Please select your gender";
    } else {
        $C=true;
    }
    if(empty($_FILES["Image"]["name"])){
        if($Data['image']=="user.png") $_SESSION['ErrorMessageI']="A profile picture is mandatory";
    } else {
        $I=true;
    }
    if(empty($_POST['Number'])){
        $_SESSION['ErrorMessageD']="Please verify your phone number";
    } else {
        $D=true;
    }
    if(!preg_match("/[a-zA-Z0-9._-]{3,}@[a-zA-Z0-9._-]{3,}[.]{1}[a-zA-Z0-9._-]{2,}/",$_POST['Email']) || empty($_POST['Email'])){
        $_SESSION['ErrorMessageA']="Please verify your e-mail address";
    } else {
        $A=true;
    }
    if(empty($_POST['Address'])){
        $_SESSION['ErrorMessageB']="Please enter your address";
    } else {
        $B=true;
    }
    if(empty($_POST['Description'])){
        $_SESSION['ErrorMessageE']="Please enter your description";
    } else {
        $E=true;
    }
    
    if($T && $C && $I && $D && $A && $B && $E){
        $Target="Uploads/".basename($_FILES['Image']['name']);
        $var=$_SESSION['UserName'];
        $dta=$_POST['BirthDate'];
        $sx=$_POST['Gender'];
        $img=$_FILES['Image']['name'];
        $phone=$_POST['Number'];
        $eml=$_POST['Email'];
        $adr=$_POST['Address'];
        $bio=$_POST['Description'];
        $sql="UPDATE admins SET datan='$dta' , sex='$sx' , image='$img' , telefon='$phone' , email='$eml' , adresa='$adr' , bio='$bio' WHERE username='$var'";
        /*$stmt=$ConnectingDB->prepare($sql);
        $stmt->bindValue(":data",$_POST['BirthDate']);
        $stmt->bindValue(":sx",$_POST['Gender']);
        $stmt->bindValue(":img",$_FILES['Image']['name']);
        $stmt->bindValue(":tel",$_POST['Number']);
        $stmt->bindValue(":eml",$_POST['Email']);
        $stmt->bindValue(":adr",$_POST['Address']);
        $stmt->bindValue(":bo",$_POST['Description']);*/
        $Execute=$ConnectingDB->query($sql);
        if($Data['image']!='user.png'){
            unlink($Target1);
        }
        move_uploaded_file($_FILES["Image"]["tmp_name"],$Target);
        if($Execute){
            $_SESSION['SuccessMessage']="Your profile was updated";
            redirect_to("MyProfile.php");
        } else {
            $_SESSION['ErrorMessageT']="Something went wrong! Please try again.";
            redirect_to("EditAdmin.php");
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
    <title>Edit Profile</title>
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
                    <h1><i class="fas fa-user-edit text-primary"></i> Edit your profile</h1>
                </div>
            </div>
        </div>
    </header>
    <!--HEADER END-->
    <section class="container py-2 mb-1" style="min-height:80%">
        <div class="row">
            <div class="col-lg-12">
                <?php echo ErrorMessageP(); ?>
                <form class="" action="EditAdmin.php" method="POST" enctype="multipart/form-data">
                    <div class="card bg-secondary text-light">
                        <div class="card-body bg-dark">
                            <div class="form-group">
                                <label for="BirthDate"><span class="FieldInfo">Birth Date</span></label>
                                <input class="form-control" id="BirthDate" type="date" name="BirthDate" value="<?php echo $Data['datan']?>" min="1900-01-01" max="2021-12-31">
                            </div>
                            <div class="form-group">
                                <label for="Gender"><span class="FieldInfo">Gender</span></label>
                                <select class="form-control" id="Gender" name="Gender">
                                    <option value="">Choose your gender</option>
                                    <option value="M">Male</option>
                                    <option value="F">Female</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <?php if($Data['image']!='user.png'){?><span class="FieldInfo">Existing Image:</span> <img src="Uploads/<?php echo $Data['image']; ?>" class="mb-2"  width="80px" height="100px"><br><?php }?>
                                <div class="custom-file">
                                    <input class="custom-file-input" type="File" name="Image" id="imageSelect" value="">
                                    <label for="imageSelect" class="custom-file-label">Select Profile Picture</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="Number"><span class="FieldInfo">Contact Number</span></label>
                                <input class="form-control" id="Number" type="text" name="Number" value="<?php echo $Data['telefon']?>">
                            </div>
                            <div class="form-group">
                                <label for="Email"><span class="FieldInfo">E-mail</span></label>
                                <input class="form-control" id="Email" type="text" name="Email" value="<?php echo $Data['email']?>">
                            </div>
                            <div class="form-group">
                                <label for="Address"><span class="FieldInfo">Address</span></label>
                                <input type="text" class="form-control" id="Address" name="Address" value="<?php echo $Data['adresa']?>">
                            </div>
                            <div class="form-group">
                                <label for="Description"><span class="FieldInfo">Description</span></label>
                                <textarea class="form-control" id="Description" name="Description" rows="8" cols="80"><?php echo $Data['bio']?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 mt-2">
                            <button type="submit" name="Submit" class="btn btn-success btn-block">
                                <i class="fas fa-check"></i> Finish
                            </button>
                        </div>
                    </div>
                </form>
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