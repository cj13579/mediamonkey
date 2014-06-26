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
	 
	<h2>Shows Downloaded</h2>
	<div class="row">
		<div class="col-md-6"><img width="500" height="350" src="graph_shows_dl.php" class="image-responsive"/></div>
		<div class="col-md-6"><img width="500" height="350" src="graph_user_dl.php" class="image-responsive"/></div>
	</div>
		
	<?php

	$user = $_SESSION["user"];
	if( "$user" == 'chris' )
	{
	
	//do stuff
	$con = mysql_connect("$db_host","$db_user","$db_pass");
	$sql = "SELECT * FROM $db_database.$db_table WHERE med_type = 'tvdl' OR med_type = 'movdl' ORDER BY dttm DESC LIMIT 10;";
    $result = mysql_query($sql) or die(mysql_error());
    $rows = mysql_num_rows($result);
    ?>
    
    <h2>Recent Downloads</h2>
	<div class="table-responsive">
    <table class="table table-striped">
    <tr>
     <tr>
      <th>Download</th>
      <th>User</th>
      <th>Date</th>
      <th>File</th>
	</tr>

	<?
	while($row = mysql_fetch_array($result))
	{
		$uid = $row['user'];
		$date =$row['dttm'];
		$id = $row['stat_id'];
		$file = $row['file'];

				
		echo "<tr>";
		echo "<td align=\"center\">$id</td>";
		echo "<td>$uid</td>";
		echo "<td>$date</td>";
		echo "<td>$file</td>";
		echo "</tr>";
	}

	?>  
    </table>
    </div>

    <h2>Recent Logins</h2>
	<div class="table-responsive">
    <table class="table table-striped">
    <tr>
     <tr>
      <th>User</th>
      <th>Date and Time</th>
      <th>Location</th>
	</tr>   
	 
	<?
	$sql = "SELECT * FROM $db_database.$db_table where type = 'login' ORDER BY dttm DESC LIMIT 20;";
    $result = mysql_query($sql) or die(mysql_error());
    $rows = mysql_num_rows($result);
    
	while($row = mysql_fetch_array($result))
	{
		$uid = $row['user'];
		$date =$row['dttm'];
		$location = $row['file'];

				
		echo "<tr>";
		echo "<td>$uid</td>";
		echo "<td>$date</td>";
		echo "<td>$location</td>";
		echo "</tr>";
	}

	?> 

    </table>
    </div>    
    
    <? 	
    }
    else
    {
    	echo "<h2>Unauthorized</h2><small>You are unauthorized to see this page.</small>";
    }	
    ?>
    
    
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

