<?php
session_start();
include 'local_config.php';
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="./favicon.ico">

    <title>MediaMonkey: Signin</title>

    <!-- Bootstrap core CSS -->
    <link href="./css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="./css/signin.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="container">
    
      	<div class="row" align="center">
        	<div class="col-md-12">
          		<p><img src="./images/monkey/monkey-100.png" alt="MediaMonkey" class="img-rounded"></p>
        	</div>
      	</div>
	
      <form class="form-signin" role="form" action="authenticate.php" method="post">
        <!-- <h3 class="form-signin-heading">Please sign in</h3> -->
        <? if(isset($_SESSION['failuser']))
        {
        	$failuser = $_SESSION['failuser'];
        	echo "<div class=\"alert alert-danger\">Authentication failure</div>";
        }
        ?>
        <? if(isset($_SESSION['tryme']))
        {
        	$failuser = $_SESSION['failuser'];
        	echo "<div class=\"alert alert-warning\">You need to login to see this</div>";
        }
        ?>
        <input name="user" type="username" class="form-control" placeholder="username" required autofocus>
        <input name="pass" type="password" class="form-control" placeholder="Password" required>
        <!-- <label class="checkbox">
          <input type="checkbox" value="remember-me"> Remember me
        </label> -->
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
      </form>

    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
  </body>
</html>

