<?php 
session_start();
include 'local_config.php';
if(!isset($_SESSION["user"]))
{
	header("Location: http://$_SERVER[SERVER_NAME]/$uri/login.php");
	exit;
}
?>

<?

$user = $_SESSION["user"];

$userinfo = posix_getpwnam("$user");
$split = explode(",", $userinfo[gecos]);
$_SESSION['userfull'] = $split[0];
$split = explode(" ", $_SESSION['userfull']);
$_SESSION['userfirst'] = $split[0];
$userfirst = $_SESSION['userfirst'];
$_SESSION['userlast'] = $split[1];
$userlast = $_SESSION['userlast'];




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
		<!-- Main jumbotron for a primary marketing message or call to action -->
		<p></p>
		
		
		<!-- New MM Jumbo -->

		<div class="jumbotron">
			<div class="container">
				<p>When a new movie has been downloaded MM will email you! Want that?<br /> Click the button below to go to your profile, add your email address and subscribe to movies.</p>
				<p><a class="btn btn-primary btn-lg" href="profile.php" role="button">My Profile&raquo;</a></p>
			</div>
		</div>

		<!-- End New MM jumbo -->
		

      	<!-- Example row of columns -->
      	<div class="row" align="center">
      		<div class="col-md-3">
      		</div>
        	<div class="col-md-3">
          		<p><img src="./images/film_reel/film_reel-100.png" alt="Reel" class="img-rounded"></p>
          		<p><a class="btn btn-default" href="moviemonkey.php" role="button">Movies &raquo;</a></p>
        	</div>
        	<div class="col-md-3">
         	 	<p><img src="./images/tv_show/tv_show-100.png" alt="tv" class="img-rounded"></p>
          		<p><a class="btn btn-default" href="tvmonkey.php" role="button">TV Shows &raquo;</a></p>
       		</div>
      		<div class="col-md-3">
      		</div>
        	<!-- <div class="col-md-4">
          		<p><img src="./images/opened_folder/opened_folder-100.png" alt="folders" class="img-rounded"></p>
          		<p><a class="btn btn-default" href="folders.php" role="button">View folders &raquo;</a></p>
        	</div> -->
      	</div>
      	
      	<!--
      	<div class="col-md-12">
      	<p>
      	<?
		$dir = ".";
		$output = array();
		chdir($dir);
		exec("git log --abbrev-commit",$output);
		$history = array();
		foreach($output as $line)
		{
		    if(strpos($line, 'commit')===0)
		    {
				if(!empty($commit))
				{
		    	array_push($history, $commit);	
		    	unset($commit);
				}
			$commit['hash']   = substr($line, strlen('commit'));
   		 	}
    		else if(strpos($line, 'Author')===0)
    		{
				$commit['author'] = substr($line, strlen('Author:'));
    		}
    		else if(strpos($line, 'Date')===0)
    		{
				$commit['date']   = substr($line, strlen('Date:'));
    		}
    		else
    		{		
				$commit['message']  .= $line;
    		}
		}      	
      	echo "MM version: ".$history[$row]['hash'];
      	echo "<br />";
      	echo "Published: ".$history[$row]['date'];;
      	?>
      	</p>
      	</div>   
      	
      	--> 
      	
    <!-- End Body -->      	
    </div>




    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="./js/bootstrap.min.js"></script>
    <script src="./js/docs.min.js"></script>
  </body>
</html>

