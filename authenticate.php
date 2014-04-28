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

    <title>Media Monkey</title>

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

	<?php
	if(isset($_POST['user'])){$username = $_POST['user']; } else{ echo "<p>username not set</p>";}
	if(isset($_POST['pass'])){$password = $_POST['pass']; } else{ echo "<p>password not set</p>"; }
	
	
	if (pam_auth($username, $password, &$error))
	{
    	$_SESSION["user"] = $username ;
    	$_SESSION["password"] = $password;
    	header("Location: http://$_SERVER[SERVER_NAME]/$uri/index.php");
		exit;
    	//echo "<p>Welcome $username</p>"; // SUCCESS!!!
	}
	else
	{
    	$_SESSION["failuser"] = $username ;
    	header("Location: http://$_SERVER[SERVER_NAME]/$uri/login.php");
		exit;
    	//echo "<p>PAM Said: $error. Get outa here!</p>"; // FAILURE :(
	}
	
	?>

    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
  </body>
</html>


