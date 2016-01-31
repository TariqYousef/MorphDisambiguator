<? 
session_start();
if($_SESSION['userdata']=="")
	header("Location: index.php");
//print_r($_SESSION['userdata']);
include("model/onlineDB.php"); ?>
<!DOCTYPE html>
<html lang="en">
  <head>

  <? 
	  require_once("assets/meta.php");
	  require_once("assets/js.php");
	  require_once("assets/style.php");
  ?>
  </head>

  <body style="font-family: 'Roboto Condensed', sans-serif;background-color:#515151;height:100%">

<div style="background-color:#FFFFFF;width:95%; margin:auto;border-radius: 15px;">      
        <!-- Wrapper Class for Responsive Footer -->
<div class="wrapper left" style=" margin:auto">
<!-- navbar -->
<? include("view/navbar.php");?>
<!-- END NAVBAR -->
<div class="row"  style="height:500px; padding:5px;width:100%;margin:auto">

<!-- Start of The narrow div -->  
  <div class="col-xs-5 col-md-3">
    <!-- Start Fragments -->   
 <div class="panel panel-default">
      <div class="panel-heading" style="background-color:#c83025;color:#FFF">
        <div class="panel-title">Table Of Contents </div>
        
      </div>
      <div class="panel-body" id="nav" style="overflow-y: scroll; overflow-x: hidden; height: 800px">      
      <? include('view/side_nav.php');?>

      </div>
</div>

</div>
<!-- End of The narrow div -->  

<!-- The wide div -->
  <div class="col-xs-13 col-md-9">
      <!-- Start of text--> 

         <div class="panel panel-default">
      <div class="panel-heading" style="background-color:#515151;color:#FFF">
        <div class="panel-title" id="title" style="text-align: right;" > </div>        
      </div>
      <div class="panel-body" id="nav" style="overflow-y: scroll; overflow-x: hidden;">      
		<div id="MainText" class="mainText "> </div>
		</div>
	</div>	
	  <!-- Silder -->
	<div id="slider_div">
		<center>
			<input id="ex6" type="text" data-slider-min="0" data-slider-max="1" data-slider-step="1" tooltip="hide" data-slider-value="6" dir="rtl"> 	
		</center>	
	</div>
	<!-- End silder -->

         <div class="panel panel-default">
      <div class="panel-heading" >
        <div class="panel-title" style="padding:0;">
 <button type="button" class="btn btn-success" onclick="save()"> <span class="glyphicon glyphicon-floppy-disk"></span> Save </button>
 <button type="button" class="btn btn-info" onclick="editall()"> <i class='fa fa-pencil-square-o' ></i> Edit All </button>
 
  <button type="button" class="btn btn-default" onclick="next()" >  <i class='glyphicon glyphicon-chevron-left' ></i> Next </button>
  <button type="button" class="btn btn-default" onclick="prev()" > Previous <i class='glyphicon glyphicon-chevron-right' ></i>  </button>
  
</div>        
      </div>
            <div class="panel-body" id="nav" style="overflow-y: scroll; overflow-x: hidden;">  
<!-- Zoom Text -->
<div id="ZoomText" class="zoomText"> 
<div class="container-fluid">
	<div class="row">
		<div class="col-xs-4 col-md-2" id="w1" dir="ltr"></div>
		<div class="col-xs-4 col-md-2" id="w2" dir="ltr"></div>
		<div class="col-xs-4 col-md-2" id="w3" dir="ltr"></div>
		<div class="col-xs-4 col-md-2" id="w4" dir="ltr"></div>
		<div class="col-xs-4 col-md-2" id="w5" dir="ltr"></div>
		<div class="col-xs-4 col-md-2" id="w6" dir="ltr"></div>
	</div>
</div>
</div>
<!--End Zoom Text-->
</div>

  
  </div>
<!-- End of The wide div -->  


      </div>



</div>

<div>



<!-- End -->

   <div class="push"> </div>
</div>
  
  
   <div id="footer" style="border-radius: 5px;">
   		<font size="2" color="#888">Alexander von Humboldt-Lehrstuhl f&uuml;r Digital Humanities - Creative Commons Attribution-ShareAlike 4.0 International License &#169;	2015 </font>            
   	</div>
    
    
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
                <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
				<script type='text/javascript' src="js/jquery.min.js"></script>
				<script type='text/javascript' src="js/bootstrap-slider.js"></script>
                <script language="javascript">
var NumberOfWords=6;


function next()
{
console.log(currentValue+" :::: "+currentText);
InterfaceGenerator(currentText,currentValue-1);



}

function prev()
{
console.log(currentValue+" :::: "+currentText);
InterfaceGenerator(currentText,currentValue+1);
}



function editall()
{
 string=currentText.split(' ').slice(Start,Start+NumberOfWords)
 console.log(string); 
 // show the loading icon
 for(i=1;i<=NumberOfWords;i++)
	 $("#w"+i).html("<img src='images/loading_42.gif'>");
	 // create the table
 for(i=0;i< NumberOfWords;i++)
	if(string.length > i)  $("#w"+(NumberOfWords-i)).load('view/getmorph2.php?block='+i+'&c='+ChunkId+'&ord='+(Start+i)+'&w='+string[i]); else  $("#w"+(NumberOfWords-i)).html("");

}


function save()
{
	for(i=0;i<NumberOfWords;i++)
	{
	 var b=NumberOfWords-i;
	 var id=$( "#id"+i ).val();
	 var en=$("input[name='ent"+i+"']:checked").val();
	 var stem=""+$( "#stem"+i ).val(); console.log(stem);
	 //$("#w"+b).load("<img src='images/loading_42.gif'>");
	 var link="model/saveWord.php?id="+id+"&en="+en+"&stem="+stem.replace(/\b=\b/gi,"_").split(' ').join('');console.log(link);
	 if(id!="undefined" && id!="")
		$("#w"+b).load(link);
	}
	// TODO : move one step to left    
}

function InterfaceGenerator(Data,St)
{
	currentValue=St;
	Start=SliderMaxValue-St;
	if(Start!=LastMove || Data!=previousText)
	{
	 LastMove=Start;
	 previousText=Data;

	 NumberOfWords=6;
	 Start=Start*NumberOfWords;
 
	 highlightText(Start);
 
	 // show the loading icon
	 for(i=1;i<=NumberOfWords;i++)
		 $("#w"+i).html("<img src='images/loading_42.gif'>");

	 // split the string
	 string=Data.split(' ').slice(Start,Start+NumberOfWords)

	 // create the table
	 for(i=0;i< NumberOfWords;i++)
		if(string.length > i)  $("#w"+(NumberOfWords-i)).load('view/getmorph.php?block='+i+'&c='+ChunkId+'&ord='+(Start+i)+'&w='+string[i]); else  $("#w"+(NumberOfWords-i)).html("");
	 }
}

var currentText="";
var previousText="";				
var Start;
var currentValue;
var LastMove;	
var DATA;		
var SliderMaxValue=0;
var NumberOfWords=6;
var slider = new Slider("#ex6");
var ChunkId=1;
var prevChunk=0;
var currentChunk=1;


function highlightText(Start)
{
data=currentText;
		var mainText=data.split(' ').slice(0,Start).join(' ')+ "<span class='highlight'> "+
			data.split(' ').slice(Start,Start+NumberOfWords).join(' ') +" </span>"+ data.split(' ').slice(Start+NumberOfWords).join(' ');
            $("#MainText").html(mainText);	 

}


function loadChunk(i)
{
     prevChunk=currentChunk;
     currentValue=0;
    // deal with previous chunk
    $("#lbl"+prevChunk).addClass("NoClass");
     
    // deal with current chunk
    currentChunk=i;
    $("#lbl"+currentChunk).addClass("highlight");
 
 	ChunkId=i;
 	 $("#title").load("view/getChunkPath.php?id="+i);
    $("#MainText").load("view/loadChunk.php?id="+i, function (data){
		currentText=data;
		console.log(""+data.split(' ').length+"/"+NumberOfWords);
		SliderMaxValue=Math.ceil(data.split(' ').length/NumberOfWords);
		console.log(SliderMaxValue);
		
		InterfaceGenerator(data,SliderMaxValue);
		
		// Highlight
		Start=0;
		/*
		var mainText=data.split(' ').slice(0,Start).join(' ')+ "<span class='highlight'> "+
			data.split(' ').slice(Start,Start+NumberOfWords).join(' ') +" </span>"+ data.split(' ').slice(Start+NumberOfWords).join(' ');
            $("#MainText").html(mainText);	 */
        highlightText(Start);    
        // Highlight end    
		

		
		$("#slider_div").load("view/slider.php?max="+SliderMaxValue,function(data){
		
		slider = new Slider("#ex6");
		
		slider.on("slide", function(slideEvt) {
		    currentValue=slideEvt;
			Data=currentText;
			Start=NumberOfWords*(SliderMaxValue-slideEvt);
			//currentValue=Start;
			var mainText=Data.split(' ').slice(0,Start).join(' ')+ "<span class='highlight'> "+
			Data.split(' ').slice(Start,Start+NumberOfWords).join(' ') +" </span>"+ Data.split(' ').slice(Start+NumberOfWords).join(' ');
            $("#MainText").html(mainText);	    
		});	
		slider.on("slideStop", function(slideEvt) {
		currentValue=slideEvt;
	        InterfaceGenerator(currentText,slideEvt);      
		});	

		}); 
	});
}


// Without JQuery
$(document).ready(function() {
	$('label.tree-toggler').click(function () {
		$(this).parent().children('ul.tree').toggle(300);
	});	
		var NumberOfWords=6;
		loadChunk(1);

});

function setValue(a,v)
{
$( "#"+v ).val(""+a);

}



                </script>
  </body>
</html>