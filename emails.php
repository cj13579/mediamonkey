<?php 
session_start();
include 'local_config.php';
if(!isset($_SESSION["user"]))
{
	$_SESSION['tryme'] = 1;
	header("Location: http://$_SERVER[SERVER_NAME]/$uri/login.php");
	exit;
}




$username = $_SESSION['user'];
if(isset($_GET['email'])){ $email = $_GET['email']; }

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="../../assets/ico/favicon.ico">

    <title>Media Monkey</title>

    <!-- Bootstrap core CSS -->
    <link href="./css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="./css/dashboard.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <!-- Header -->
    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php">Media Monkey</a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="moviemonkey.php">Movies</a></li>
            <li><a href="tvmonkey.php">TV</a></li>
            <li><a href="profile.php">Profile</a></li>
            <li><a href="blog.php">Blog</a></li>
            <li><a href="logout.php">Logout</a></li>
          </ul>
          
          <!-- Search -->
          <!-- <form class="navbar-form navbar-right">
            <input type="text" class="form-control" placeholder="Search...">
          </form> -->
          <!-- End Search -->
          
        </div>
      </div>
    </div>
    <!-- End Header -->

    <!-- Body -->
    <div class="container">
    <p>
    
    <?
	if(isset($_GET['add']))
	{

	$con = mysql_connect("$db_host","$db_user","$db_pass");
	$sql = "UPDATE $db_database.users SET email = \"$email\" WHERE username = \"$username\"; ";
    $result = mysql_query($sql) or die(mysql_error());
    $rows = mysql_num_rows($result);
    
    echo "Email address added.";
	header("Location: http://$_SERVER[SERVER_NAME]/$uri/profile.php");
	exit;    
    
	}

	if(isset($_GET['change']))
	{

	$con = mysql_connect("$db_host","$db_user","$db_pass");
	$sql = "UPDATE $db_database.users SET email = \"$email\" WHERE username = \"$username\"; ";
    $result = mysql_query($sql) or die(mysql_error());
    $rows = mysql_num_rows($result);
    
    echo "Email address added.";
	header("Location: http://$_SERVER[SERVER_NAME]/$uri/profile.php");
	exit;    
    
	}
    
    if( $_GET['type'] == "add" )
    {
    ?>
    <h4>Add Email address</h4>
    <form class="form-inline" role="form" method="GET" action="<?php echo $_SERVER['PHP_SELF']; ?>">
  	<div class="form-group">
   	 	<input type="email" class="form-control" name="email" placeholder="name@example.com">
  	</div>
  	<div class="form-group">
  		<button type="submit" name="add" class="btn btn-default">Add</button>
	</div>
  	</form>    

    <?
    }
    elseif ($_GET['type'] == "change")
    {
    ?>
    <h4>Change Email address</h4>
    <form class="form-inline" role="form" method="GET" action="<?php echo $_SERVER['PHP_SELF']; ?>">
  	<div class="form-group">
   	 	<input type="email" class="form-control" name="email" placeholder="<?php echo $email; ?>">
  	</div>
  	<div class="form-group">
  		<button type="submit" name="change" class="btn btn-default">Change</button>
	</div>
  	</form>    
    
    <?
    }    
    ?>
    
    <p>
  		
  			 	
    </div>
    <!-- End Body -->



    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="./js/bootstrap.min.js"></script>
    <script src="./js/docs.min.js"></script>
  </body>
</html>


