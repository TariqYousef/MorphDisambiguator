<?

include("../model/api.php");
$q="select * from passage where id=".$_REQUEST['id'];
$res=$con->query($q)->fetch_array();
echo "<span dir='rtl'><i class='fa fa-newspaper-o'></i> ".$res['title']." <i class='icon-chevron-left'></i> ".$res['titleL1']." <i class='icon-chevron-left'></i> ".$res['titleL2']." </span>";
?>