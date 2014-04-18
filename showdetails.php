<?php 
session_start();
if(!isset($_SESSION["user"]))
{
	$_SESSION['tryme'] = 1;
	header("Location: http://$_SERVER[SERVER_NAME]/mm/login.php");
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

if(isset($_GET['id'])){$id = $_GET['id'];}
if(isset($_GET['title'])){$title = $_GET['title'];}
if(isset($_GET['season'])){$season = $_GET['season'];}else{$season = 1;}

if (isset($season))
{
$db = mysql_select_db("xbmc_videos75", $con);
$sql = "SELECT * from episodeview WHERE strTitle LIKE \"$title\" AND c12 = \"$season\" ORDER BY c13";
$sql2 = "SELECT COUNT(DISTINCT c12) as NumSeries from episodeview WHERE strTitle LIKE \"$title\" ";
$result = mysql_query($sql) or die(mysql_error());
$result2 = mysql_query($sql2) or die(mysql_error());
$x = 1;
}

if (!isset($x))
{
$db = mysql_select_db("xbmc_videos75", $con);
$sql = "SELECT * from episodeview WHERE strTitle LIKE \"$title\" AND c12 = \"$season\" ORDER BY c13";
$sql2 = "SELECT COUNT(DISTINCT c12) as NumSeries from episodeview WHERE strTitle LIKE \"$title\" ";
$result = mysql_query($sql) or die(mysql_error());
$result2 = mysql_query($sql2) or die(mysql_error());
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
    
    <?php
    if(!isset($season)){$season = 1; }
    ?>
    
    <p></p>
    
    	<div class="row">
    		<div class="col-md-3"><b>Show: </b><? echo "$title"; echo " <b>Season: </b> $season";?> </div>
    		<div class="col-md-6" align="right">Select Season: </div>
    		<div class="col-md-2">
    		<form role="form" method="get" action="showdetails.php">
    		<?php
    		echo "<input type=\"hidden\" name=\"id\" value=\"".$id."\">";
			echo "<input type=\"hidden\" name=\"title\" value=\"".$title."\">";
    		?>
    		<select class="form-control" name="season">
    		<?php
    		while($row = mysql_fetch_array($result2))
			{
				$numseries = $row['NumSeries'];
				echo $numseries;
				for ($i = 1; $i <= $numseries ; $i++)
				{
					echo "<option>$i</option>";
				}
			}
    		?>
			</select>
			</div>
			<div class="col-md-1"><button type="submit" class="btn btn-default">Go</button></div>
			</form>
    	</div>
		<!-- Main jumbotron for a primary marketing message or call to action -->
	<form role="form" method="post" action="downloads.php" />
<!--
	<table class="table">
	<tr>
		<th>Episode</th>
		<th>IMDB Rating</th>
		<th>Description</th>
		<th>Channel</th>
		<th>Air Date</th>
		<th></th>
	</tr>
	-->

<p></p>	

<div class="row">
  <div class="col-md-2"><b>Episode</div>
  <div class="col-md-2">Title</div>
  <div class="col-md-2">IMDB Rating</div>
  <!-- <div class="col-md-2">Description</div> -->
  <div class="col-md-2">Channel</div>
  <div class="col-md-2">Air Date</div>
  <div class="col-md-2"></b></div>
</div>
<?php
	
	while($row = mysql_fetch_array($result))
	{
		$id = $row['idShow'];
		$title = $row['c00'];
		$epid = $row['c13'];
		$season = $row['c12'];
		$desc = $row['c01'];
		$channel = $row['strStudio'];
		$score = floatval($row['c03']);
		$airdate = $row['c05'];
		$str = $row['strPath'];
		$file = $row['strFileName'];
		$x = "smb://Q2SERVER";
		$y = ".";
		$str2 = str_replace($x, $y, $str);
		$str3 = $str2.$file;

		
		;
		echo "<div class=\"row\">";
		//echo "<td></td>";
		echo "<div class=\"col-md-2\">$epid</div>";
		echo "<div class=\"col-md-2\">$title</div>";
		echo "<div class=\"col-md-2\">$score</div>";
		//echo "<div class=\"col-md-2\">$desc</div>";
		echo "<div class=\"col-md-2\">$channel</div>";
		echo "<div class=\"col-md-2\">$airdate</div>";
		echo "<div class=\"col-md-2\">";
		echo "<input type=\"hidden\" name=\"dl\" value=\"1\">";
		echo "<input type=\"hidden\" name=\"download\" value=\"".$str3."\">";
		echo "<input type=\"hidden\" name=\"type\" value=\"tvdl\">";
		echo "<input type=\"hidden\" name=\"file\" value=\"".$file."\">";
		echo "<input type=\"hidden\" name=\"id\" value=\"".$id."\">";
		echo "<input type=\"submit\" name=\"submit\" value=\"Download\">";
		echo "</form>";
		echo "</div>";
		echo "</div>";
		
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

