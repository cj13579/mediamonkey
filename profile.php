<?php 
session_start();
include 'local_config.php';
if(!isset($_SESSION["user"]))
{
	$_SESSION['tryme'] = 1;
	header("Location: http://$_SERVER[SERVER_NAME]/$uri/login.php");
	exit;
}
?>

<?

$username = $_SESSION['user'];
$userfull = $_SESSION['userfull'];
$userfirst = $_SESSION['userfirst'];
$userlast = $_SESSION['userlast'];


if(isset($_POST['subscribe']))
{

	//$showid = $_POST['showid'];
	$showname = $_POST['showname'];

	$con = mysql_connect("$db_host","$db_user","$db_pass");
	$sql = "SELECT * FROM $db_database.$db_table_users WHERE username = \"$username\" AND shows LIKE \"%$showname%\" ;";
	$result = mysql_query($sql) or die(mysql_error());
	$rows = mysql_num_rows($result);
	
	if($rows < 1)
	{
	
		while($row = mysql_fetch_array($result))
		{
			$shows = $row['shows'];
			$showlen = strlen($shows);
		}
	
		if ($showlen > 0)
		{
		$sql = "UPDATE $db_database.$db_table_users SET shows=CONCAT(shows,\",".$showname."\") WHERE username = \"$username\";";
		$result = mysql_query($sql) or die(mysql_error());
		$rows = mysql_num_rows($result);
		}
		else
		{
		$sql = "UPDATE $db_database.$db_table_users SET shows=\"$showname\" WHERE username = \"$username\";";
		$result = mysql_query($sql) or die(mysql_error());
		$rows = mysql_num_rows($result);
		}
		header("Location: http://$_SERVER[SERVER_NAME]/$uri/profile.php");
		exit;
	
	}
	else
	{
		header("Location: http://$_SERVER[SERVER_NAME]/$uri/profile.php?as=$showname");
		exit;
	}
	


}

if(isset($_POST['movsub']))
{

//$showid = $_POST['showid'];
//$showname = $_POST['showname'];

$con = mysql_connect("$db_host","$db_user","$db_pass");
$sql = "UPDATE $db_database.$db_table_users SET movies = 1 WHERE username = \"$username\";";
$result = mysql_query($sql) or die(mysql_error());

header("Location: http://$_SERVER[SERVER_NAME]/$uri/profile.php");
exit;

}

if(isset($_POST['movunsub']))
{

//$showid = $_POST['showid'];
//$showname = $_POST['showname'];

$con = mysql_connect("$db_host","$db_user","$db_pass");
$sql = "UPDATE $db_database.$db_table_users SET movies = 0 WHERE username = \"$username\";";
$result = mysql_query($sql) or die(mysql_error());

header("Location: http://$_SERVER[SERVER_NAME]/$uri/profile.php");
exit;

}

if(isset($_POST['tvunsub']))
{

//$showid = $_POST['showid'];
$showname = $_POST['showname'];

$con = mysql_connect("$db_host","$db_user","$db_pass");
$sql = "UPDATE $db_database.$db_table_users SET shows = REPLACE(shows, \",".$showname."\", '') WHERE username = \"$username\";";
$result = mysql_query($sql) or die(mysql_error());
$rows = mysql_num_rows($result);
if ($rows == 0)
{
$sql = "UPDATE $db_database.$db_table_users SET shows = REPLACE(shows, \"".$showname.",\", '') WHERE username = \"$username\";";
$result = mysql_query($sql) or die(mysql_error());
$rows = mysql_num_rows($result);
}
if ($rows == 0)
{
$sql = "UPDATE $db_database.$db_table_users SET shows = REPLACE(shows, \"".$showname."\", '') WHERE username = \"$username\";";
$result = mysql_query($sql) or die(mysql_error());
$rows = mysql_num_rows($result);
}


header("Location: http://$_SERVER[SERVER_NAME]/$uri/profile.php");
exit;

}



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
    <p>
		<!-- Main jumbotron for a primary marketing message or call to action -->
		
      	<!-- Example row of columns -->
      	<div class="row">

        	<div class="col-md-2">
         	 	<p><img src="./images/monkey/monkey-100.png" alt="tv" class="img-rounded"></p>
      		</div>
      		<div class="col-md-10">
         	 	<?

         	 	
				$con = mysql_connect("$db_host","$db_user","$db_pass");
				$sql = "SELECT * FROM $db_database.$db_table_users ;";
  				$result = mysql_query($sql) or die(mysql_error());
  				$rows = mysql_num_rows($result);
    			
         	 	?>
         	 	<p><b>Full Name:</b> <? echo "$userfull";?></p>
         	 	<p><b>Username:</b> <? echo "$username";?></p>
         	 	<p><b>Email:</b>
         	 	<? 
				while($row = mysql_fetch_array($result))
				{
					if($row['username'] == $username)
					{
						$email = $row['email'];
						if(strlen($email) > 0)
						{
							echo "$email <button class=\"btn btn-default\" type=\"submit\"><a href=\"emails.php?type=change&email=$email\">Change</a></button>";
						}
						else
						{
							echo "No email address. <button class=\"btn btn-default\" type=\"submit\"><a href=\"emails.php?type=add\">Add</a></button>";
						}
					}
    			}         	 	
         	 	?>
         	 	</p>        	 	
         	 	
      		</div>	
      	</div>
      	<hr />     	 	
      	<div class="row">
      		<h2>Subscriptions</h2>
      		<p>Use the following form to subscribe to TV shows and movies. When you are subscribed you will be emailed when a new episode of that show or a new movie is added to the library. Just save your email address in the section above.</p>
      	<div class="alert alert-info">You can register for TV shows and Movies but this functionality is not yet fully automated!</div>
      	</div>
      	
      	<div class="row">
      	
      	<div class="col-md-6">
      	<h4>TV</h4>
      	<form class="form-inline" role="form" method="POST" action="profile.php">
      	<div class="form-group">
      	<select class="form-control" name="showname">
    		<?
    		$con = mysql_connect("localhost","xbmc","xbmc");
    		if (!$con)
    		{
       			die('Could not connect: ' . mysql_error());
    		}
    		$sql = "SELECT DISTINCT * FROM tvshowview GROUP BY c12 ORDER BY c00";
    		
    		mysql_select_db("$xbmc_db_database", $con);
    		$result = mysql_query($sql) or die(mysql_error());
   			$rows = mysql_num_rows($result);
    		
    		while($row = mysql_fetch_array($result))
			{
				$show = $row['c00'];
				$id = $row['idShow'];
				echo "<option value=\"".$show."\">".$show."</option>";
				//echo "<input type=\"hidden\" name=\"showid\" value=\"".$id."\">";
				//echo "<input type=\"hidden\" name=\"showname\" value=\"".$show."\">";
			}
    		
    		?>
    	</select>
  		</div>
  		<div class="form-group">
  			<button type="submit" name="subscribe" class="btn btn-default">Subscribe</button>
		</div>
		</form>
      	</div>
      	
      	<div class="col-md-6">
      	<h4>Movies</h4>
		<?
			$con = mysql_connect("$db_host","$db_user","$db_pass");
			$sql = "SELECT * FROM $db_database.$db_table_users where username like \"$username\" and shows not like \"\" OR movies = 1 ";
    		$result = mysql_query($sql) or die(mysql_error());
    		$rows = mysql_num_rows($result);
		
    		while($row = mysql_fetch_array($result))
			{
				$shows = $row['shows'];
				$movies = $row['movies'];
				$len = strlen($shows);
				$split = explode(",",$shows);
				//echo $len;
			}  
		
		if ($movies == 0)
		{
		?>
      	<form class="form-inline" role="form" method="POST" action="profile.php">
  		<div class="form-group">
  			<button type="submit" name="movsub" class="btn btn-default">Subscribe</button>
		</div>
		</form>
		
		<?
		}
		else
		{
		?>
      	<form class="form-inline" role="form" method="POST" action="profile.php">
  		<div class="form-group">
  			<button type="submit" name="movunsub" class="btn btn-default">Un-Subscribe</button>
		</div>
		</form>		
		<?
		}
		?>
      	<!--
		
		-->
		<!-- end column -->
      	</div>
      	
      	
      	<!-- end row -->
      	</div>

      	<div class="row">
      	<p></p>
      	</div>

      	<div class="row">
		<div class="col-md-6">

    		<?
			$con = mysql_connect("$db_host","$db_user","$db_pass");
			$sql = "SELECT * FROM $db_database.$db_table_users where username like \"$username\" and shows not like \"\" OR movies = 1 ";
    		$result = mysql_query($sql) or die(mysql_error());
    		$rows = mysql_num_rows($result);
		
    		while($row = mysql_fetch_array($result))
			{
				$shows = $row['shows'];
				$movies = $row['movies'];
				$len = strlen($shows);
				$split = explode(",",$shows);
				//echo $len;
			}    		

			if ( $len > 0)
			{
				echo "<table class=\"table\">";
				for ($i=0; $i<count($split); $i++)
				{
						echo "<tr>";
      					echo "<td><form class=\"form-inline\" role=\"form\" method=\"POST\" action=\"profile.php\" >";
						echo "$split[$i]";
						echo "</td>";
  						echo "<td>";
  						echo "<input type=\"hidden\" name=\"showname\" value=\"".$split[$i]."\" >";
  						echo "<button type=\"submit\" name=\"tvunsub\" class=\"btn btn-default\">Un-Subscribe</button>";
						echo "</form></td>";
						echo "</tr>";
				}
				echo "</table>";

			}
			else
			{
				echo "<div class=\"alert alert-warning\">You're not subscribed to any shows!</div>";
			}
 			?> 		
		
		</div>
		
		<div class="col-md-6">

		<?	

			if ( $movies == 1)
			{
				echo "<div class=\"alert alert-success\">You're subscribed to Movies!</div>";
			}
			else
			{
				echo "<div class=\"alert alert-warning\">You silly monkey. You're not subscribed to Movies!</div>";
				$not = 1;
			}
		?>
		<!--

		-->
		
		</div>
		
      	</div>
    	<hr />
    	<p>
      	<div class="row">
      	
      	<div class="col-md-6">
      		<h3>Feedback</h3>
      		<p><button class="btn btn-default" type="submit"><a href="feedback.php">Submit Feedback</a></button></p>
      	</div>
      	
      	<div class="col-md-6">
      	<h3>Version</h3>
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
      	echo "Media Monkey version: ".$history[$row]['hash'];
      	echo "<br />";
      	echo "Published: ".$history[$row]['date'];;
      	?>
      	</p>
      	</div>	
      	
      	</div>      
		
      	<!-- </row>    -->
	<p></p>
  		
  			 	
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


