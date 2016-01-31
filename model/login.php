<? session_start();
require_once("api.php");

// login process
$user=$_REQUEST['user'];
$pass=$_REQUEST['pass'];
$url="../main.php";
$auth=checkAutherity($user,$pass);
//print_r($auth);
if($auth=="")
	$url="../index.php?status=err";
else
{
 $_SESSION['userdata']=$auth;
}
// redirecting
header("Location: $url");
?>