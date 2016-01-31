<!DOCTYPE html>
<html lang="en">
  <head>
  <? 
	  require_once("assets/meta.php");
	  require_once("assets/js.php");
	  require_once("assets/style.php");
  ?>
  </head>
  <body>
  <div class="container">
    <div class="row">
        <div class="col-sm-6 col-md-4 col-md-offset-4">
            
            <div class="account-wall">
                <h1 class="text-center login-title">Sign in to continue to <br/><b>UGARIT</b> Morphological Disambiguator</h1>
                <? if($_REQUEST['status']=="err"){?>
                <div class="alert alert-danger" role="alert">Invalid username or password</div>
                <?}?>
                <form class="form-signin" action="model/login.php">
                <input type="text" name="user" class="form-control" placeholder="Username" required autofocus>
                <input type="password" name="pass" class="form-control" placeholder="Password" required>
                <button class="btn btn-lg btn-primary btn-block" type="submit">
                    Sign in</button>
                <label class="checkbox pull-left">
                    <input type="checkbox" value="remember-me">
                    Remember me
                </label>
               
                <a href="#" class="pull-right need-help">Need help? </a><span class="clearfix"></span>
                </form>
            </div>
            <a href="#" class="text-center new-account">Create an account </a>
             
        </div>
        
    </div>
</div>

  </body>
</html>  