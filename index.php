<!DOCTYPE html>
<html lang="en">
  <head>
  <? 
	  require_once("assets/meta.php");
	  require_once("assets/js.php");
	  require_once("assets/style.php");
  ?>
  <style>
  body{
  background: url("images/Ugarit_Corbel.jpg") no-repeat center center fixed; 
  -webkit-background-size: cover;
  -moz-background-size: cover;
  -o-background-size: cover;
  background-size: cover;
  height: 100%; opacity: 0.85;filter: alpha(opacity=85);
  }
  </style>
  </head>
  <body>
  <div class="container">
    <div class="row">
        <div class="col-sm-6 col-md-4 col-md-offset-4">
            
            <div class="account-wall" style="background-color:#FFF;">
            <img  src="images/UgLogo.png"          style="margin:auto"           alt="">
                <h1 class="text-center login-title">Sign in to continue to <br/><b>UGARIT</b> Morphological Disambiguator</h1>
                
                <? if($_REQUEST['status']=="err"){?>
                <div class="alert alert-danger" role="alert">Invalid username or password</div>
                <?}?>
                <form class="form-signin" action="model/login.php">
                <input type="text" name="user" class="form-control" placeholder="Username" required autofocus>
                <input type="password" name="pass" class="form-control" placeholder="Password" required>
                <button class="btn btn-lg btn-default btn-block" type="submit">
                    Sign in</button>
                <label class="checkbox pull-left">
                    <input type="checkbox" value="remember-me">
                    Remember me
                </label>
               
                <a href="#" class="pull-right need-help">Create an account </a>
                <span class="clearfix"></span>
                </form>
            </div>
            
             
        </div>
        
    </div>
</div>

  </body>
</html>  