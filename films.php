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
<?php

if(isset($_GET['prev_direc']))
{
	$directory = $_GET['prev_direc'];
}

if(isset($_POST['directory']))
{
	$directory = $_POST['directory'];
	$prev_direc = $_POST['prev_direc'];
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
    <div class="container-fluid">
			<p>
			<p> Use the buttons to navigate through the folders. When you get to the files you will be able to download them using the link. If the file is MP4 2 streaming options will be available to watch straight from your browser however this only works on some browsers.
			<p>
			<?php
			
			if(!isset($directory))
			{
				$directory = 'Films';
				$scanned_dir = array_diff(scandir($directory), array('..', '.','.AppleDesktop','.AppleDouble','.AppleDBFile','.AppleDB'));		
				echo "<table>";
				echo "<tr>";
				echo "<td><p><b>Directory/File Name</td><td></td><td></td>";
				echo "</tr>";
				foreach ($scanned_dir as $value) 
				{
					if (is_dir("$directory/$value"))
					{
						$a = "$directory/$value";
						#echo "Directory : $value <br>";
						echo "<tr>";
						echo "<td>";
							echo "<form method=\"post\" action=\"".$_SERVER['PHP_SELF']."\" />";
							echo "<input type=\"hidden\" name=\"directory\" value=\"".$a."\">";
							echo "<input type=\"hidden\" name=\"prev_direc\" value=\"Films\">";
							echo "<input type=\"submit\" name=\"submit\" value=\"$value\">";
							echo "</form>";
						echo "</td>";
						echo "</tr>";
						#echo "<a href=\"$directory/$value\">$value</a>	<br>";
					}
					else
					{
						#echo "File : $value <br>";
					}
				}
				echo "</table>";
			}
			else
			{
				$directory = "$directory";
				$scanned_dir = array_diff(scandir($directory), array('..', '.','.AppleDesktop','.AppleDouble','.AppleDBFile','.AppleDB'));	
				echo "<table>";	
				echo "<tr>";
				if(isset($prev_direc))
				{
					echo "<td><p><b>Back to: <a href=\"films.php?prev_direc=$prev_direc\">$prev_direc</a></td><td></td><td></td>";
				}
				echo "</tr>";
				echo "<tr>";
				echo "<td><p><b>Directory/File Name</td><td></td><td></td>";
				echo "</tr>";
				foreach ($scanned_dir as $value) 
				{
					if (is_dir("$directory/$value"))
					{
						$a = "$directory/$value";
						#echo "Directory : $value <br>";
						echo "<tr>";
						echo "<td>";
							echo "<form method=\"post\" action=\"".$_SERVER['PHP_SELF']."\" />";
							echo "<input type=\"hidden\" name=\"directory\" value=\"".$a."\">";
							echo "<input type=\"hidden\" name=\"prev_direc\" value=\"".$directory."\">";
							echo "<input type=\"submit\" name=\"submit\" value=\"$value\">";
							echo "</form>";
						echo "</td>";
						echo "</tr>";
						#echo "<a href=\"$directory/$value\">$value</a>	<br>";
					}
					else
					{
						if (preg_match("/\.(avi|mp4|mkv|m4v)/",$value))
						{
							$b = "$directory/$value";
							echo "<table style=\"vertical-align:bottom\">";
							echo "<tr>";
							echo "<td valign=\"bottom\">";
								echo "<p>$value";
							echo "</td>";
							echo "<td>";
								echo "<p>";
								echo "<form method=\"post\" action=\"downloads.php\" />";
								echo "<input type=\"hidden\" name=\"dl\" value=\"1\">";
								echo "<input type=\"hidden\" name=\"download\" value=\"".$b."\">";
								echo "<input type=\"hidden\" name=\"file\" value=\"".$value."\">";
								echo "<input type=\"hidden\" name=\"type\" value=\"movdl\">";
								echo "<input type=\"submit\" name=\"submit\" value=\"Download\">";
								echo "</form>";
							echo "</td>";
							echo "<td></td>";
							if (preg_match("/\.(mp4)/",$value))
							{
								echo "<td>";
									echo "<p>";
									echo "<form method=\"post\" action=\"downloads.php\" />";
									echo "<input type=\"hidden\" name=\"download\" value=\"".$b."\">";
									echo "<input type=\"hidden\" name=\"stream\" value=\"1\">";
									echo "<input type=\"hidden\" name=\"file\" value=\"".$value."\">";
									echo "<input type=\"hidden\" name=\"type\" value=\"movst1\">";
									echo "<input type=\"submit\" name=\"submit\" value=\"Stream (inline)\">";
									echo "</form>";
								echo "</td>";
							}
							if (preg_match("/\.(mp4)/",$value))
							{
								echo "<td>";
									echo "<p>";
									echo "<form method=\"post\" action=\"downloads.php\" target=\"_blank\"/>";
									echo "<input type=\"hidden\" name=\"download\" value=\"".$b."\">";
									echo "<input type=\"hidden\" name=\"stream\" value=\"2\">";
									echo "<input type=\"hidden\" name=\"file\" value=\"".$value."\">";
									echo "<input type=\"hidden\" name=\"type\" value=\"movst2\">";
									echo "<input type=\"submit\" name=\"submit\" value=\"Stream (new window)\">";
									echo "</form>";
								echo "</td>";
							}
							echo "</tr>";						
						}
					}
				}
				echo "</table>";
			}
			?>
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