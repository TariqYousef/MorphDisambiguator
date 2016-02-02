<!-- navbar -->
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#"><img src="images/logo_dh_wid-300x57.png" height="30"></a>
    </div>
    <div>
      <ul class="nav navbar-nav">
        <li > <a href="#" class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-expanded="false"><i class="glyphicon glyphicon-user" style="color: green"></i> Hi <b style="color:#c83025"><? echo $_SESSION['userdata']['fullname'];?> </b> <span class="caret"></span></a>
        <ul class="dropdown-menu" role="menu">
        <li><a href="#" > Passages: <? echo $_SESSION['userstat']['numOfPassages'];?></a></li> 
        <li><a href="#" > Words: <? echo $_SESSION['userstat']['numOfWords'];?></a></li>   
        </li></ul>
        <li><a href="#" class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-expanded="false"><i class="fa fa-pencil-square-o"></i> Edit Profile <span class="caret"></span></a>
           <ul class="dropdown-menu" role="menu">
           		<li> <a href="#" ><i class="fa fa-info-circle"></i> General Information</a></li>
  		  		<li> <a href="#" ><i class="fa fa-key"></i> Change Password</a></li>
  		  		<li> <a href="#" ><i class="fa fa-gear"></i> Settings </a></li>
  		  		<li> <a href="auth_relation.php" ><i class="glyphicon glyphicon-stats"></i> Statistics </a></li>
  		   </ul>        
        </li>
        <li><a href="#" class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-expanded="false"><i class="glyphicon glyphicon-tasks"></i> Texts  <span class="caret"></span> </a>
           <ul class="dropdown-menu" role="menu">
  		  		<li> <a href="#" ><i class="glyphicon glyphicon-upload"></i> Upload annotated file</a></li>
  		  		<li> <a href="#" ><i class="glyphicon glyphicon-stats"></i> Statistics </a></li>
  		  		<li> -------------</li>
  		  		<li> <a href="#" ><i class="glyphicon glyphicon-stats"></i> Statistics </a></li>
  		  	</ul>
        </li>
        <li><a href="#" ><i class="glyphicon glyphicon-tag"></i> Entities</a></li>       
        <li><a href="model/logout.php"><i class="glyphicon glyphicon-log-out"></i> Logout </a></li>
        <li><a href="#" > </a></li> 
        <li><a href="#" > </a></li> 
        <li><a href="#" > </a></li>                 
  
      </ul>
   

    </div>

  </div>
</nav>    
