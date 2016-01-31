<?
include("api.php");
$entity=$_REQUEST['en'];
$stem=str_replace("_","=",$_REQUEST['stem']); 

$pid=$_REQUEST['id'];

$pid=explode("_",$pid);
$passageId=$pid[0];
$wordId=$pid[1];

if($wordId!=""){
   $q="update words set stem='".addslashes(trim($stem))."' , entity='".addslashes(trim($entity))."' where passage_id=$passageId and word_order=$wordId";
  if($con->query($q))
  {
  	echo "<center><span class='already_annotated'>".$stem." | ".$entity."</span><br>";
  	echo '<h1 class="glyphicon glyphicon-ok" style="color:green;"></h1> Saved successfully</center>';  
  }	
  else 
    echo '<h1 class="glyphicon glyphicon-remove" style="color:red;"></h1> something went wrong';
}
else
   echo "";?>