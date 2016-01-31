<meta charset="utf-8">
<?
include("../model/api.php");
$word=trim($_REQUEST['w']);
$block=$_REQUEST['block'];
$order=$_REQUEST['ord']; 
$pid=$_REQUEST['c'];
$ord=$pid."_".$order;
$textID="stem".$block;
$punctuations=array(""," ",":",";",".",",","؛","-","(",")","|","[","]","");
echo "<center><h3>$word</h3>";
if(!in_array($word,$punctuations) && !is_numeric($word) && strlen(trim($word))/2 >1)
{
$freq=getFreq($word);
$info=getWordInfo($pid,$order);


?>
<div >
<div><div>
<input type="hidden" id="id<? echo $block;?>" value="<? echo $ord?>">
Frequency: <? echo $freq;?><br/>
							<span class="chkGrp"> <input type="radio" value="Common" name="ent<? echo $block;?>" id="Entity<? echo $block;?>" <? if($info['entity']=="Common") echo "checked";?> /><i class="glyphicon glyphicon-ok" style="padding:1px; margin:1px;color:#6b8e23" dir="ltr"></i></span> 
  <span class="bar">|</span><span class="chkGrp"> <input type="radio" value="Person" name="ent<? echo $block;?>" id="Entity<? echo $block;?>" <? if($info['entity']=="Person") echo "checked";?> /><i class="glyphicon glyphicon-user" style="padding:1px; margin:1px;color:#b22222" dir="ltr"></i></span> 
  <span class="bar">|</span><span class="chkGrp"> <input type="radio" value="Place"  name="ent<? echo $block;?>" id="Entity<? echo $block;?>" <? if($info['entity']=="Place") echo "checked";?> /><i class="glyphicon glyphicon-map-marker" style="padding:1px; margin:1px;color:#5f9ea0" dir="ltr"></i></span> 
  <span class="bar">|</span><span class="chkGrp"> <input type="radio" value="Book"   name="ent<? echo $block;?>" id="Entity<? echo $block;?>" <? if($info['entity']=="Book") echo "checked";?> /><i class="glyphicon glyphicon-book" style="padding:1px; margin:1px;color:#8b7765" dir="ltr"></i></span> 
</center>
</div>
<? 
$q="SELECT * FROM `classic_words` where TRIM(word)='".addslashes($word)."' or TRIM(word)='".addslashes($word)."
'";
$res=$con->query($q);
$morph=array("","");

if($row=$res->fetch_array())
{
	if($row['morph']=="Not Found")	
	  $morph= array('',''); 	
	else
	{
	  if($row['morph']=="") 
	  	  $morph=updateTable($row['word']);	
	  else 
	      $morph=parseXML($row['morph']);    	  
	} 
} else
{
	// try to get it from Buck Walter
  	$morph=getMorph($row['word']);
}
?>
<br/><br /> <span class="subtitle">Word Stem:<span> <br /> 
<? 
echo '<input class="form-control stem" type="text" dir="rtl" id="stem'.$block.'" value="'.$info['stem'].'" >';

if($morph[0]!='')
  echo $morph[0];
else
 echo '<div class="alert alert-danger" role="alert">Not Found</div>'; 
  ?>
</div>

<?
}
?>
