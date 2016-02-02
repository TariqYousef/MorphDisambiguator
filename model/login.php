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
 $userId=$auth['id'];
 $_SESSION['userdata']=$auth;
 $_SESSION['userstat']=getUserStatistics($userId);
 // Save User's Login information (ip + login date)
 saveUserLoginInformation($userId,$_SERVER['REMOTE_ADDR']);
}
// redirecting
header("Location: $url");
?>