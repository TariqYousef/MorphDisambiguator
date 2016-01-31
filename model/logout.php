<?
session_start();
$_SESSION['userdata']="";
$url="../index.php";
header("Location: $url");
?>