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

$con = mysql_connect("localhost","xbmc","xbmc");
if (!$con)
{
	die('Could not connect: ' . mysql_error());
}

//set limit for number or results
$rc=30;


mysql_select_db("xbmc_videos67", $con);
$sql = "SELECT tvshow.idShow, tvshow.c00, art.media_type, art.media_id, art.type, art.url FROM art, tvshow WHERE art.media_type LIKE 'tvshow' AND tvshow.idShow = art.media_id AND art.type LIKE 'thumb' ORDER BY tvshow.c00";

$result = mysql_query($sql) or die(mysql_error());
//count results
$rows = mysql_num_rows($result);

//calculate last page
$last = ceil($rows/$rc);

//check if page number is set
$pagenum = $_GET['pagenum'];

if (!(isset($pagenum))) 
{ 
	$pagenum = 1; 
}
if ($pagenum < 1) 
{ 
	$pagenum = 1; 
} 
elseif ($pagenum > $last) 
{ 
	$pagenum = $last; 
} 

	
$max = 'LIMIT ' .($pagenum - 1) * $rc .',' .$rc;
$sql = "SELECT tvshow.idShow, tvshow.c00, art.media_type, art.media_id, art.type, art.url FROM art, tvshow WHERE art.media_type LIKE 'tvshow' AND tvshow.idShow = art.media_id AND art.type LIKE 'thumb' ORDER BY tvshow.c00 $max";

$result = mysql_query($sql) or die(mysql_error());
$rows = mysql_num_rows($result);

?>


<html>
<head>
 <title>TVMonkey Web Interface</title>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
 <link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>
<div id="container">
    <div id="content">
		<div id="home" name="home1" >
		<table>
		<tr>
<?php

$per_row=10;
$split=0;
	
	while($row = mysql_fetch_array($result))
	{
		$id = $row['idShow'];
		$title = $row['c00'];
		$src = $row['url'];
		
		$path = _get_hash($src);
		$x = substr($path, 0, 1);
		$array = array("$x", "$path");
		$path = implode("/",$array);	
		
		echo "<td>";
		echo "<a href='showdetails.php?id=$id'><img src='./Thumbnails/$path.jpg' alt='$title' width='100' height='150' /></a>";
		
		/*echo "<form action='{$_SERVER['PHP_SELF']}' method='get'>";
		echo "<input name=\"$id\" type=\"image\" src=\"$src\" width=\"100\" height=\"150\" >";
		echo "</form>";*/
		echo "</td>";
		
		$split++;   
		if ($split%$per_row==0){
			echo '</tr><tr>';
		}
	}
	?>
	</table>
<?php

 // First we check if we are on page one. If we are then we don't need a link to the previous page or the first page so we do nothing. If we aren't then we generate links to the first page, and to the previous page.

 if ($pagenum == 1) 
 {
	echo "<p>--Page $pagenum of $last-- ";
	$next = $pagenum+1;
	// This shows the user what page they are on, and the total number of pages
	echo "<a href='{$_SERVER['PHP_SELF']}?pagenum=$next'>Next -></a> ";
	echo " ";
	echo " <td><a href='{$_SERVER['PHP_SELF']}?pagenum=$last'>Last ->></a></p> ";
 } 
 elseif ($pagenum == $last) 
 {
	echo "<p><a href='{$_SERVER['PHP_SELF']}?pagenum=1'> <<-First</a> ";
	echo " ";
	$previous = $pagenum-1;
	echo " <a href='{$_SERVER['PHP_SELF']}?pagenum=$previous'> <-Previous</a> ";
	echo "--Page $pagenum of $last-- </p>";
 } 
else 
{
	$next = $pagenum+1;
	echo "<p><a href='{$_SERVER['PHP_SELF']}?pagenum=1'> <<-First</a> ";
	echo " ";
	$previous = $pagenum-1;
	echo " <a href='{$_SERVER['PHP_SELF']}?pagenum=$previous'> <-Previous</a> ";
	// This shows the user what page they are on, and the total number of pages
	echo "--Page $pagenum of $last-- ";
	echo "<a href='{$_SERVER['PHP_SELF']}?pagenum=$next'>Next -></a> ";
	echo " ";
	echo " <td><a href='{$_SERVER['PHP_SELF']}?pagenum=$last'>Last ->></a></p> ";
 } 

 ?> 
		</div>
    </div>
    <div class="br"></div>
</div>
</body>
</html>
<?php  
mysql_close($con);
?>
