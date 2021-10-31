<?php require_once("Includes/DB.php"); ?>
<?php require_once("Includes/Sessions.php"); ?>
<?php require_once("Includes/Functions.php"); ?>
<?php $Id=$_GET['Id']; ?>
<?php
ConfirmLogin();
$Admin=$_SESSION['AdminName'];
$sql="UPDATE comments SET status='ON' , approvedby='$Admin' WHERE id=:ID";
$stmt=$ConnectingDB->prepare($sql);
$stmt->bindValue(":ID",$Id);
$Execute=$stmt->execute();
if($Execute){
    $_SESSION['SuccessMessage']="Comment approved";
} else {
    $_SESSION['ErrorMessage']="Something went wrong. Comment not approved";
}
redirect_to("Comments.php");
?>