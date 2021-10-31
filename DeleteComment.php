<?php require_once("Includes/DB.php"); ?>
<?php require_once("Includes/Sessions.php"); ?>
<?php require_once("Includes/Functions.php"); ?>
<?php $Id=$_GET['Id']; ?>
<?php
ConfirmLogin();
$sql="DELETE FROM comments WHERE id=:ID";
$stmt=$ConnectingDB->prepare($sql);
$stmt->bindValue(":ID",$Id);
$Execute=$stmt->execute();
if($Execute){
    $_SESSION["ErrorMessage"]="Comment Deleted";
} else {
    $_SESSION["ErrorMessage"]="Something went wrong. Try again";
}
redirect_to("Comments.php");
?>