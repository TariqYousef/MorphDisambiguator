<? ini_set('display_errors', 1);
require_once("onlineDB.php");

function checkAutherity($user,$pass)
{
 global $con;
 $return="";
 $q="select * from users where username='".addslashes($user)."' and password='".addslashes($pass)."' ";
 $res=$con->query($q);
 if($res=="")
   $return="";
 else if($row=$res->fetch_array())
   $return=$row;  
 //print_r($return);  
 return $return;    
}

function getFreq($word)
{
 global $con;
 $q="select count(*) from words where word='".addslashes($word)."'";
 $res=$con->query($q);
 $row=$res->fetch_array();
 return $row[0];
}

function formatStatistics($data)
{
	$stem=$data["stem"];
	$entity=$data["entity"];
	$output="<div class='statistics'>";
	$sum=array_sum($stem);
	foreach($stem as $k=>$v)
		$output.="<label class='alert alert-success'  dir='rtl'> $k [$v/$sum]</label>";
	
	$sum=array_sum($entity);

	foreach($entity as $k=>$v)
	{
	if($k=="Common") $class="glyphicon glyphicon-ok";
	if($k=="Person") $class="glyphicon glyphicon-user";
	if($k=="Place") $class="glyphicon glyphicon-map-marker";
	if($k=="Book") $class="glyphicon glyphicon-book";
		$output.="<label class='alert alert-info ' > <i class='$class'></i> $k [$v/$sum]</label>";
	}	
    return $output."</div>";
}

function formatStatistics2($data)
{
	$stem=$data["stem"];
	$entity=$data["entity"];
	$output="<div class='statistics'>";
	$sum=array_sum($stem);
	foreach($stem as $k=>$v)
	{
	     $val=number_format(($v/$sum)*100,"0",".","");
		$output.="<label class='alert alert-success'  dir='rtl'> $k [$val%]</label>";
	}	
	return $output."</div>";
}


function getwordStatistics($word)
{
  global $con;
  $return=array();
  // Stemming
  $q="select stem,count(*) as c from words where entity!='' and word='".addslashes(trim($word))."' group by stem order by c DESC";
  $res=$con->query($q);
  while($row=$res->fetch_array())
     $return["stem"][$row[0]]=$row[1];
     
  // Entities
  $q="select entity,count(*) as c from words where entity!='' and word='".addslashes(trim($word))."' group by entity order by c DESC";
  $res=$con->query($q);
  while($row=$res->fetch_array())
     $return["entity"][$row[0]]=$row[1];   

  return $return;
}

function getWordInfo($pid,$order)
{
  global $con;
  $return=array();
  $q="select * from words where passage_id=$pid and word_order=$order";
  $res=$con->query($q);
  if($row=$res->fetch_array())
     $return=$row;
  else
     $return="";
  return $return;

}

function parseXML2($xml)
{
	
	$response=str_replace(array("rdf:","oac:","cnt:"),array("rdf_","oac_","cnt_"),$xml);
	$rdf = new SimpleXMLElement($response);
	$morph=$rdf->oac_Annotation->oac_Body;
	$dropdown='';
	foreach($morph as $k)
	{
		$k=$k->cnt_rest->entry;
		$lemma=$k->dict->hdwd;
		$pofs=$k->dict->pofs;
		$pref=$k->infl->term->pref;
		$st=$k->infl->term->stem;
		$suff=$k->infl->term->suff;
		$temp=array(); 
		if($pref!="") $temp[]=$pref;
		if($st!="") $temp[]=$st;		
		if($suff!="") $temp[]=$suff;
		$stem=implode(" + ",$temp);
		$class="alert-default";
		if($pofs=="verb") $class="alert-info";
		else if($pofs=="noun") $class="alert-danger";
		else if($pofs=="adjective") $class="alert-success";		
		$dropdown.=	'<label class="alert '.$class.' " style="padding:5px 25px; margin:5px;" ><input type="radio" value="Common" name="">  '.$lemma.' | '.$pofs.' | '.$stem.' </label>';	
	}

	return $dropdown;
	
}

function clean_accent($txt)
{
 return str_replace(array("ً","ُ","ٌ","ِ","ٍ","‘","ِ","َ","ّ","ٌ","ْ"),"",$txt);

}

function parseXML($xml)
{
	global $ord,$textID;
	$response=str_replace(array("rdf:","oac:","cnt:"),array("rdf_","oac_","cnt_"),$xml);
	$rdf = new SimpleXMLElement($response);
	$morph=$rdf->oac_Annotation->oac_Body;
	$dropdown='';
	$partOfSpeech=array();
	foreach($morph as $k)
	{
		$k=$k->cnt_rest->entry;
		$lemma=$k->dict->hdwd;
		$pofs=$k->dict->pofs;
		$pref=clean_accent($k->infl->term->pref);
		$st=clean_accent($k->infl->term->stem);
		$suff=clean_accent($k->infl->term->suff);
		$temp=array(); 
		if(trim($pref)!="") $temp[]=$pref;
		if(trim($st)!="") $temp[]=$st;		
		if(trim($suff)!="") $temp[]=$suff;
		$temp=implode(" = ",$temp);
		$stem[$temp]++;
		$partOfSpeech[$pofs]++;
		$class="alert-default";
		//if($pofs=="verb") $class="alert-info";
		//else if($pofs=="noun") $class="alert-danger";
		//else if($pofs=="adjective") $class="alert-success";		
		
	}
	arsort($stem);
	$counter=0;
	foreach($stem as $k=>$v)
	{
	 if($counter==0) $checked="checked"; else $checked=""; 
	 $counter++;
     $dropdown.='<label class="alert alert-default label_radio"> <input type="radio" onclick="setValue(\''.$k.'\',\''.$textID.'\')" value="Common" name="st'.$ord.'" '.$checked.'>  '.$k.' </label>';	
	}
	
	//==========================
	$dp='';
	arsort($partOfSpeech);//    print_r($partOfSpeech);
	$counter=0;
	foreach($partOfSpeech as $k=>$v)
	{
	 if($counter==0) $checked="checked"; else $checked=""; 
	 $counter++;
     $dp.='<label class="alert alert-default " style="padding:5px 15px; margin:5px;" dir="rtl" > <input type="radio" value="Common" name="stem'.$ord.'" '.$checked.'>  '.$k.' </label>';	
	}
	return array($dropdown,$dp);
	
}

function updateTable($word)
{
 global $con;
 $url="http://services.perseids.org/bsp/morphologyservice/analysis/word?engine=aramorph&lang=ara&word=";
 $xml=file_get_contents($url.$word);
 // check oac:body
 $pos=strpos($xml,'oac:Body');
 $query="";
 if ($pos === false) 
 { 
   $query="update classic_words set morph='Not Found' where word='".addslashes($word)."'"; 
   $con->query($query);
   return array('','');  }
 else
 {   
   $query="update classic_words set morph='".addslashes($xml)."' where word='".addslashes($word)."'";
   $con->query($query);
   return parseXML($xml);
 }  
}


function getMorph($word)
{
 global $con,$textId;
 $url="http://services.perseids.org/bsp/morphologyservice/analysis/word?engine=aramorph&lang=ara&word=";
 $xml=file_get_contents($url.$word);
 // check oac:body
 $pos=strpos($xml,'oac:Body');
 $query="";
 if ($pos === false) 
 { 
   $query="insert into classic_words values ('','".addslashes($word)."',0,'Not Found','')"; 
   $con->query($query);
   return array('',''); }
 else
 {   
   $query="insert into classic_words values ('','".addslashes($word)."',0,'".addslashes($xml)."','')"; 
   $con->query($query);
   return parseXML($xml);
 }  
}


//*******************************************************
// get user statitics: #Passages , Words count			*
// Input: User's Id										*
//*******************************************************
function getUserStatistics($userId)
{
 global $con;
 // get number of passages
 $q="select count(*) from passage where userid=$userId";
 $return['numOfPassages']=$con->query($q)->fetch_array()[0];
 // get number of words
 $q="SELECT count(word) FROM words,passage where words.passage_id = passage.id and passage.userid=$userId ";
 $return['numOfWords']=$con->query($q)->fetch_array()[0];
 
 return $return;
}

//*******************************************************
// save User Login Information to DB					*
// Input: User's id, user's ip 							*
//*******************************************************
function saveUserLoginInformation($userId,$ip)
{
 global $con;
 $q="update users set ip='".$ip."' , lastlogin=now() where id=$userId";
 $con->query($q);
}
//******************************************************

//*******************************************************
// get user statitics: #Passages , Words count			*
// Input: User's Id										*
//*******************************************************
function getUserTextLevel1($userId)
{
 global $con;
 $q="select title , count(*) from passage where userid=$userId group by title order by title";
 $tl=$con->query($q);
 $i=0;
 while($row=$tl->fetch_array())
 {
  $return[$i]=$row;
  $i++;
 }
 return $return;
}


?>