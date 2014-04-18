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
  
<?php
function _get_hash($file_path)
{
   $chars = strtolower($file_path);
   $crc = 0xffffffff;

   for ($ptr = 0; $ptr < strlen($chars); $ptr++)
   {
      $chr = ord($chars[$ptr]);
      $crc ^= $chr << 24;

      for ((int) $i = 0; $i < 8; $i++)
      {
         if ($crc & 0x80000000)
         {
            $crc = ($crc << 1) ^ 0x04C11DB7;
         }
         else
         {
            $crc <<= 1;
         }
      }
   }

   // Syst? d'exploitation en 64 bits ?
   if (strpos(php_uname('m'), '_64') !== false)
   {
      //Formatting the output in a 8 character hex
      if ($crc>=0)
      {
         $hash = sprintf("%16s",sprintf("%x",sprintf("%u",$crc)));
      }
      else
      {
         $source = sprintf('%b', $crc);
         $hash = "";
         while ($source <> "")
         {
            $digit = substr($source, -4);
            $hash = dechex(bindec($digit)) . $hash;
            $source = substr($source, 0, -4);
         }
      }
      $hash = substr($hash, 8);
   }
   else
   {
      //Formatting the output in a 8 character hex
      if ($crc>=0)
      {
         $hash = sprintf("%08s",sprintf("%x",sprintf("%u",$crc)));
      }
      else
      {
         $source = sprintf('%b', $crc);
         $hash = "";
         while ($source <> "")
         {
            $digit = substr($source, -4);
            $hash = dechex(bindec($digit)) . $hash;
            $source = substr($source, 0, -4);
         }
      }
   }

   return $hash;
}
//$deets = $_POST['deets'];

//check the OS that user is coming from
//$agent = $_SERVER['HTTP_USER_AGENT'];
//if(preg_match('/Linux/',$agent)) $os = 'Linux';
//elseif(preg_match('/Win/',$agent)) $os = 'Windows';
//elseif(preg_match('/Mac/',$agent)) $os = 'Mac';
//else $os = 'UnKnown';


//check if user is local

//$agent=$_SERVER['REMOTE_ADDR'];
//if(preg_match('/192.168/',$agent)) $ip = 'local';
//else $ip = 'remote';

$con = mysql_connect("localhost","xbmc","xbmc");
if (!$con)
{
	die('Could not connect: ' . mysql_error());
}

$id = $_GET['id'];

if (isset($id))
{
mysql_select_db("xbmc_videos75", $con);
$sql = "SELECT art.art_id, art.media_id, art.media_type, art.type, art.url, movie.idMovie, movie.c00, movie.c01, movie.c05, movie.c12, movie.c15, movie.c07, movie.c14, movie.c22, movie.idFile, files.idFile, files.strFilename FROM art, movie, files WHERE art.media_id = movie.idMovie AND art.media_type LIKE 'movie' AND art.type LIKE 'poster' AND movie.idMovie = $id AND movie.idFile = files.idFile ";
$result = mysql_query($sql) or die(mysql_error());
}
else
{
$id = $_POST['id'];
mysql_select_db("xbmc_videos75", $con);
$sql = "SELECT art.art_id, art.media_id, art.media_type, art.type, art.url, movie.idMovie, movie.c00, movie.c01, movie.c05, movie.c12, movie.c15, movie.c07, movie.c14, movie.c22, movie.idFile, files.idFile, files.strFilename FROM art, movie, files WHERE art.media_id = movie.idMovie AND art.media_type LIKE 'movie' AND art.type LIKE 'poster' AND movie.idMovie = $id AND movie.idFile = files.idFile ";
$result = mysql_query($sql) or die(mysql_error());
}

?>

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
		<!-- Main jumbotron for a primary marketing message or call to action -->
	<form role="form" method="post" action="downloads.php" />
	<table class="table">
	<tr></tr>
<?php

	while($row = mysql_fetch_array($result))
	{
		$id = $row['idMovie'];
		$title = $row['c00'];
		$desc = $row['c01'];
		$rate = round($row['c05'], 1);
		
		$year = $row['c07'];
		$genre = $row['c14'];
		$director = $row['c15'];
		$src = $row['url'];
		$file_path = $row['c22'];
		$file = $row['strFilename'];
		
		$needle = "stack";
		$pos = strpos($file,$needle);
		
		if ($pos !== false) {
			
			$file = str_replace("stack://smb://Q2SERVER/Films/","","$file");
		
		}

		$serv = "192.168.0.4/test";
		$str = $row['c22'];
		$x = "smb://Q2SERVER";
		$y = ".";
		$str2 = str_replace($x, $y, $str);
		$str3 = $str2.$file;
				
		$link = "";

		echo "<tr><td>";
		$path = _get_hash($src);
		$x = substr($path, 0, 1);
		$array = array("$x", "$path");
		$path = implode("/",$array);	
		echo "<img src=\"./Thumbnails/$path.jpg\" alt=\"$title\" height=\"180\" width=\"133\" />";
		echo "</td>";
		echo "<td><p>";
		echo "<table class='table'><tr>";
		echo "<td><strong>Title: </strong>$title</td><td><strong>IMDB Rating: 	</strong> $rate </td><td><strong>Director: </strong> $director </td>";
		echo "</tr></table>";
		echo "<strong>Description: </strong> $desc </br>";
		echo "</br>";
		echo "<strong>Download: </strong> ";
		echo "<input type=\"hidden\" name=\"dl\" value=\"1\">";
		echo "<input type=\"hidden\" name=\"download\" value=\"".$str3."\">";
		echo "<input type=\"hidden\" name=\"type\" value=\"movdl\">";
		echo "<input type=\"hidden\" name=\"file\" value=\"".$file."\">";
		echo "<input type=\"hidden\" name=\"id\" value=\"".$id."\">";
		echo "<input type=\"submit\" name=\"submit\" value=\"Download\">";
		echo "</br>";
		echo "</br>";
		echo "</tr>";
		
	}
	?>
	</form>
	</table>
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

