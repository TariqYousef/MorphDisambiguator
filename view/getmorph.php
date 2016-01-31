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
$bg="#DDD";
if($info=="" || ($info[4]=="" && $info[4]=="" ))
{
 $bg="#FFF";
$stat=getwordStatistics($word);
$stem_stat=$stat["stem"];
$ent_stat=$stat["entity"];
$ent_sum=array_sum($ent_stat);
 $comm_stat=($ent_stat['Common']*100/$ent_sum);
 $person_stat=($ent_stat['Person']*100/$ent_sum);
 $place_stat=($ent_stat['Place']*100/$ent_sum);
 $book_stat=($ent_stat['Book']*100/$ent_sum);


?>
<div style="background-color:<? echo $bg;?>">
<div><div>
<input type="hidden" id="id<? echo $block;?>" value="<? echo $ord?>">
Frequency: <? echo $freq;?><br/>

  <span class="chkGrp" style="width:50%"> <input type="radio" value="Common" name="ent<? echo $block;?>" id="Entity<? echo $block;?>" checked />
							<i class="glyphicon glyphicon-ok" style="padding:1px; margin:1px;color:#6b8e23" dir="ltr"> </i>
							<? if($comm_stat!="0" && $comm_stat!="") echo number_format($comm_stat, 0, '.', '')."%";?></span> 
  <span class="bar">|</span>
  
  <span class="chkGrp"> <input type="radio" value="Person" name="ent<? echo $block;?>" id="Entity<? echo $block;?>"/>
  <i class="glyphicon glyphicon-user" style="padding:1px; margin:1px;color:#b22222" dir="ltr"></i>
  							<? if($person_stat!="0" && $person_stat!="") echo number_format($person_stat, 0, '.', '')." %";?> </span>  
  							
  							
  <br>
  
  <span class="chkGrp"> <input type="radio" value="Place"  name="ent<? echo $block;?>" id="Entity<? echo $block;?>"/>
  <i class="glyphicon glyphicon-map-marker" style="padding:1px; margin:1px;color:#5f9ea0" dir="ltr"></i>
  							<? if($place_stat!="0" && $place_stat!="") echo number_format($place_stat, 0, '.', '')." %";?>   </span> 
  <span class="bar">|</span>
  
  <span class="chkGrp"> <input type="radio" value="Book"   name="ent<? echo $block;?>" id="Entity<? echo $block;?>"/>
  <i class="glyphicon glyphicon-book" style="padding:1px; margin:1px;color:#8b7765" dir="ltr"></i>
  							<? if($book_stat!="0" && $book_stat!="") echo number_format($book_stat, 0, '.', '')." %";?> 
  </span> 
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
echo '<input class="form-control stem" type="text" dir="rtl" id="stem'.$block.'" value="'.$word.'" >';
echo '<input class="form-control stem" type="text" dir="rtl" id="stem'.$block.'" value="'.$word.'" >';

if(sizeof($stem_stat) > 0){
?>
<hr>
<span class="subtitle">User suggestions:<span> <br /> 
<? 
echo formatStatistics2($stat);
} ?><hr>
<span class="subtitle">Buckwalter suggestions:<span> <br /> 
<? 

if($morph[0]!='')
  echo $morph[0];
else
 echo '<div class="alert alert-danger" role="alert">Not Found</div>'; 
  ?>
</div>

<?
}else{

echo "<span class='already_annotated'>".$info[4]."<br>".$info[5]."</span>";

}
}


?>
