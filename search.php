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

if(isset($_POST['terms']))
{
	$terms = $_POST['terms'];
}

?>
<html>
 <title>Media Monkey</title>
 <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
 <link rel="stylesheet" type="text/css" href="style.css" />
</head>

<body>
<div id="container">
    <div id="content">
    <p><p><p><p><p><p>
    Use the box below to search the movie database. The results will be displayed as front covers of the movies that match your search. To find out detailed information about the movie or to download it, click on the cover.
    <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="finder">
    <input type="text" name="terms">
    <input type="submit" name="search" value="Search">    
    </form>
    <p><p><p><p><p><p><p>
	<table>
	<tr>
<?php

if(isset($terms))
{

$con = mysql_connect("localhost","xbmc","xbmc");

if (!$con)
{
	die('Could not connect: ' . mysql_error());
}

//set limit for number or results
$rc=30;

mysql_select_db("xbmc_videos75", $con);
$sql = "SELECT art.art_id, art.media_id, art.media_type, art.type, art.url, movie.idMovie, movie.c00, movie.c07, movie.c14, movie.c22 FROM art, movie WHERE art.media_id = movie.idMovie AND art.media_type LIKE 'movie' AND art.type LIKE 'poster' AND movie.c00 LIKE '%$terms%' ORDER BY movie.c00";


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
$sql = "SELECT art.art_id, art.media_id, art.media_type, art.type, art.url, movie.idMovie, movie.c00, movie.c07, movie.c14, movie.c22 FROM art, movie WHERE art.media_id = movie.idMovie AND art.media_type LIKE 'movie' AND art.type LIKE 'poster' AND movie.c00 LIKE '%$terms%' ORDER BY movie.c00 $max";

$result = mysql_query($sql) or die(mysql_error());
$rows = mysql_num_rows($result);

$per_row=6;
$split=0;
	
	while($row = mysql_fetch_array($result))
	{
		$id = $row['idMovie'];
		$title = $row['c00'];
		$src = $row['url'];
		
		echo "<td>";
		$path = _get_hash($src);
		$x = substr($path, 0, 1);
		$array = array("$x", "$path");
		$path = implode("/",$array);	
		echo "<a href='moviedetails.php?id=$id'><img src='./Thumbnails/$path.jpg' alt='$title' width='100' height='150' /></a>";
		
		/*echo "<form action='{$_SERVER['PHP_SELF']}' method='get'>";
		echo "<input name=\"$id\" type=\"image\" src=\"$src\" width=\"100\" height=\"150\" >";
		echo "</form>";*/
		echo "</td>";
		
		$split++;   
		if ($split%$per_row==0){
			echo '</tr><tr>';
		}
	}

}
?>
</table>
	<div align="center">
<?php

 // First we check if we are on page one. If we are then we don't need a link to the previous page or the first page so we do nothing. If we aren't then we generate links to the first page, and to the previous page.
 
 if(isset($pagenum))
 {

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
 }

 ?> 
	</div>
	</div>
</div>
</body>

</html>
