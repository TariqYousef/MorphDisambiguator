<?
// Navigation Bar // Book Table of contents


$q="select title , count(*) from passage group by title order by title";
$tl=$con->query($q);
echo "<ul class='nav nav-list '>";
while($tll=$tl->fetch_array())
{
	echo "<li> <label class='tree-toggler nav-header' dir='ltr' style='color:#515151;font-size:11pt;'><i class='icon-chevron-right'></i> ".$tll[0]." (".$tll[1].") </label>\n<ul class='nav nav-list tree' style='display: none;'>";
	// get titles Level 1
	$q="select titleL1 , count(*) from passage where title='".$tll[0]."' group by titleL1 order by id";
	$res=$con->query($q);
	while($row=$res->fetch_array())
	{
		echo "<li> <label class='tree-toggler nav-header' dir='rtl' style='color:#070'><i class='icon-angle-right'></i> ".$row[0]." (".$row[1].") </label>\n<ul class='nav nav-list tree' style='display: none;'>";
		// get titles Level 2
		// -----------------
		$q="select titleL2 , count(*) from passage where title='".$tll[0]."' and titleL1='".addslashes($row[0])."' group by titleL2 order by id";
		$t2=$con->query($q);
		while($title2=$t2->fetch_array())
		{
		  echo "<li><label class='tree-toggler nav-header' dir='rtl' style='color:#007'>".$title2[0]."(".$title2[1].") </label><ul class='nav nav-list tree' style='display: none;'>";
		  // get Level 3
		  $q="select *  from passage where titleL1='".addslashes($row[0])."' and titleL2='".addslashes($title2[0])."'";
		  $temp=$con->query($q);
		  while($temp2=$temp->fetch_array())
		  {
			echo "<li><label id='lbl".$temp2[0]."' onclick='loadChunk(".$temp2[0].")'> - ".implode(" ",array_slice(explode(" ",$temp2[3]),0,5))." . . .</label></li>";
		  }
		  //
		  echo"</ul></li>";
		}
		// -----------------	
		echo "</ul>";
		echo "</li>";
	
	}
			echo "</ul>";
		echo "</li>";
}
echo "</ul>";
?>