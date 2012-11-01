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
$deets = $_POST['deets'];

//check the OS that user is coming from
$agent = $_SERVER['HTTP_USER_AGENT'];
if(preg_match('/Linux/',$agent)) $os = 'Linux';
elseif(preg_match('/Win/',$agent)) $os = 'Windows';
elseif(preg_match('/Mac/',$agent)) $os = 'Mac';
else $os = 'UnKnown';


//check if user is local

$agent=$_SERVER['REMOTE_ADDR'];
if(preg_match('/192.168/',$agent)) $ip = 'local';
else $ip = 'remote';



$con = mysql_connect("localhost","xbmc","xbmc");
if (!$con)
{
	die('Could not connect: ' . mysql_error());
}

$id = $_GET['id'];

if (isset($id))
{
mysql_select_db("xbmc_videos67", $con);
$sql = "SELECT art.art_id, art.media_id, art.media_type, art.type, art.url, movie.idMovie, movie.c00, movie.c01, movie.c05, movie.c12, movie.c15, movie.c07, movie.c14, movie.c22, movie.idFile, files.idFile, files.strFilename FROM art, movie, files WHERE art.media_id = movie.idMovie AND art.media_type LIKE 'movie' AND art.type LIKE 'thumb' AND movie.idMovie = $id AND movie.idFile = files.idFile ";
$result = mysql_query($sql) or die(mysql_error());
}
else
{
$id = $_POST['id'];
mysql_select_db("xbmc_videos67", $con);
$sql = "SELECT art.art_id, art.media_id, art.media_type, art.type, art.url, movie.idMovie, movie.c00, movie.c01, movie.c05, movie.c12, movie.c15, movie.c07, movie.c14, movie.c22, movie.idFile, files.idFile, files.strFilename FROM art, movie, files WHERE art.media_id = movie.idMovie AND art.media_type LIKE 'movie' AND art.type LIKE 'thumb' AND movie.idMovie = $id AND movie.idFile = files.idFile ";
$result = mysql_query($sql) or die(mysql_error());
}

?>

<html>
<head>
 <title>MediaMonkey Web Interface : Movies</title>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
 <link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>
<div id="container">
    <div id="content">
		<div id="home" name="home1" >
	<table>
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
		//$play = "<a href=\"http://xbmc:0000@192.168.0.7:8080/xbmcCmds/xbmcHttp?command=PlayFile($file_path$file)\"> Play </a>";
		
		if(isset($deets))
		{
			$cmd = "http://xbmc:0000@192.168.0.7:8080/xbmcCmds/xbmcHttp?command=PlayFile(".$deets.")";
			$cmd = file_get_contents("$cmd");
			//echo $deets;
			$play = "Movie playing...$cmd";
		}
		else
		{
			$play= "<form action='{$_SERVER['PHP_SELF']}' method='POST'> <input type='submit' name='pmov' value='Play'> <input type='hidden' name='deets' value='$file_path$file'><input type='hidden' name='id' value='$id'></form>" ;
		}
		
		if ($ip == "local")
		{
			if ($os == "Windows")
			{
				$str = $row['c22'];
				$x = "smb://";
				$y = "file://";
				$str2 = str_replace($x, $y, $str);
				$x = "Q2SERVER";
				$y = $_SERVER['SERVER_ADDR'];
				$str3 = str_replace($x, $y, $str2);
				$link = "<a href=\"".$str3."\">Download</a>";
			}
		}
		elseif ($ip = "remote")
		{
			$link = "Need to be local to download";
		}
		else
		{
			$link = "<a href=\"".$str."\">Download</a>";
		}
		
		;
		echo "<tr><td>";
		$path = _get_hash($src);
		$x = substr($path, 0, 1);
		$array = array("$x", "$path");
		$path = implode("/",$array);	
		echo "<img src='./Thumbnails/$path.jpg' alt='$title' width='250' height='300'/>";
		echo "</td>";
		echo "<td><p>";
		echo "<strong>Title: </strong>$title </br>";
		echo "</br>";
		echo "<strong>Description: </strong> $desc </br>";
		echo "</br>";
		echo "<strong>IMDB Rating: </strong> $rate </br>";
		echo "</br>";
		echo "<strong>Director: </strong> $director </br>";
		echo "</br>";
		echo "<strong>Download (Local only): </strong> $link </br>";
		echo "</br>";
		echo "<strong>Play Movie on XBMC: </strong> $play </br>";
		echo "</br>";
		echo "</p></td>";
		echo "</tr>";
		
	}
	?>
	</table>
			<br />
		</div>
    </div>
    <div class="br"></div>
</div>
</body>
</html>
<?php  
mysql_close($con);
?>