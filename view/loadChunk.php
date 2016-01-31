<? 
include("../model/api.php");
$q="select * from passage where id=".$_REQUEST['id'];
$res=$con->query($q)->fetch_array();
//echo $res[3];



//echo "<br>=============================<br>";

$res=tokenizeSentence($res[3]);
$temp=array();
foreach($res[0] as $k=>$val)
{
 $temp[$k]['word']=$res[0][$k];
 $temp[$k]['stem']="";
 $temp[$k]['entity']="";
 }
$_SESSION['current_chunk']=$temp;
echo str_replace("  "," ",implode(" ",$res[0]));
/*
echo "<pre>";
print_r($_SESSION['current_chunk']);
echo "</pre>";
*/
function tokenizeSentence($txt)
{
 $txt=str_replace('،',',',$txt);
 $txt=str_replace('؛',';',$txt);

 $returnValue = preg_split('/[\\s,:;.\[\]]+/',$txt,-1, PREG_SPLIT_NO_EMPTY);
 preg_match_all('/[\\s,:;.\[\]]+/',$txt, $matches, PREG_PATTERN_ORDER);

 $counter=0;
 $ret=array();
 $distinct=array();
 $capitals=array();
 for($i=0;$i<sizeof($returnValue);$i++)
 {
  $ret[$counter]=$returnValue[$i];
  $distinct[$returnValue[$i]]++;
  $counter++;

  if($matches[0][$i]!=" ") 
  {
   $ret[$counter]=$matches[0][$i];
   $counter++;
  }
 }
 return array($ret,$distinct,$capitals);
}

?>